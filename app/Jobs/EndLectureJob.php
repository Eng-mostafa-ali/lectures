<?php

namespace App\Jobs;

use App\Events\LecturesUpdated;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class EndLectureJob implements ShouldBeUnique, ShouldQueue
{
    use Queueable;

    public int $uniqueFor = 86400;

    public function __construct(public int $groupId) {}

    public function uniqueId(): string
    {
        return 'lecture-group-finish-'.$this->groupId;
    }

    public function handle(): void
    {
        // هجيب الجروب اللي الـ Job شغالة عليه
        $group = DB::table('lecture_groups')
            ->where('id', $this->groupId)
            ->first();

        // هخرج لو الجروب مش موجود أو اتعالج قبل كده
        if (! $group || $group->auto_finish_processed) {
            return;
        }

        // هخلي تحديث المحاضرات وتفاصيلها يحصلوا مع بعض
        $updatedScheduleIds = DB::transaction(function (): array {
            $timestamp = now()->toDateTimeString();
            $updatedIds = [];

            // هجيب المحاضرات اللي لسه in_progress ومواعيدها مطابقة للخطة
            foreach ($this->getSchedulesToFinish() as $scheduleId) {
                // هتأكد تاني إن المحاضرة لسه شغالة قبل ما أخليها finished
                $updated = DB::table('schedules')
                    ->where('id', $scheduleId)
                    ->where('status', 'in_progress')
                    ->whereNull('deleted_at')
                    ->update([
                        'status' => 'finished',
                        'updated_at' => $timestamp,
                    ]);

                if ($updated) {
                    $updatedIds[] = $scheduleId;
                    $this->recordScheduleAsFinished($scheduleId, $timestamp);
                }
            }

            $this->markAutoFinishProcessed($timestamp);

            return $updatedIds;
        });

        if ($updatedScheduleIds !== []) {
            // هنا هبعت إيفنت بكل المحاضرات اللي خلصت
            event(new LecturesUpdated($updatedScheduleIds));
        }
    }

    private function getSchedulesToFinish(): array
    {
        // هختار محاضرات الجروب اللي لسه شغالة ومواعيدها ما اتغيرتش
        return DB::table('lecture_group_schedules as lgs')
            ->join('schedules as s', 's.id', '=', 'lgs.schedule_id')
            ->where('lgs.lecture_group_id', $this->groupId)
            ->where('s.status', 'in_progress')
            ->whereNull('s.deleted_at')
            ->whereRaw("CONCAT(s.date, ' ', s.start_time) = lgs.planned_start_at")
            ->whereRaw("CONCAT(s.date, ' ', s.end_time) = lgs.planned_end_at")
            ->pluck('s.id')
            ->map(static fn ($scheduleId): int => (int) $scheduleId)
            ->all();
    }

    private function recordScheduleAsFinished(int $scheduleId, string $timestamp): void
    {
        // هسجل وقت انتهاء المحاضرة ونتيجتها في جدول التفاصيل
        DB::table('lecture_group_schedules')
            ->where('lecture_group_id', $this->groupId)
            ->where('schedule_id', $scheduleId)
            ->update([
                'actual_end_at' => $timestamp,
                'outcome' => 'finished',
                'updated_at' => $timestamp,
            ]);
    }

    private function markAutoFinishProcessed(string $timestamp): void
    {
        // هعلم الجروب إنه اتعالج عشان جوب الإنهاء ما تتكررش
        DB::table('lecture_groups')
            ->where('id', $this->groupId)
            ->where('auto_finish_processed', false)
            ->update([
                'auto_finish_processed' => true,
                'updated_at' => $timestamp,
            ]);
    }
}
