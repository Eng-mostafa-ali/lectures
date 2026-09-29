<?php

namespace App\Jobs;

use App\Events\LecturesUpdated;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class CancelNotStartedLectureJob implements ShouldBeUnique, ShouldQueue
{
    use Queueable;

    public int $uniqueFor = 86400;

    public function __construct(public int $groupId) {}

    public function uniqueId(): string
    {
        return 'lecture-group-cancel-'.$this->groupId;
    }

    public function handle(): void
    {
        // هجيب الجروب اللي الـ Job شغالة عليه
        $group = DB::table('lecture_groups')
            ->where('id', $this->groupId)
            ->first();

        // هخرج لو الجروب مش موجود أو اتعالج قبل كده
        if (! $group || $group->auto_cancel_processed) {
            return;
        }

        // هخلي تحديث المحاضرة وتفاصيلها يحصلوا مع بعض
        $updatedScheduleIds = DB::transaction(function (): array {
            $timestamp = now()->toDateTimeString();
            $updatedIds = [];

            // هجيب المحاضرات اللي لسه not_started ومواعيدها زي وقت التخطيط
            foreach ($this->getSchedulesToAutoCancel() as $scheduleId) {
                // هتأكد تاني إنها لسه not_started عشان ما الغيش محاضرة بدأها المدرب
                $updated = DB::table('schedules')
                    ->where('id', $scheduleId)
                    ->where('status', 'not_started')
                    ->whereNull('deleted_at')
                    ->update([
                        'status' => 'cancelled',
                        'updated_at' => $timestamp,
                    ]);

                if ($updated) {
                    $updatedIds[] = $scheduleId;

                    // هسجل وقت الإلغاء ونتيجته في تفاصيل المحاضرة.
                    $this->markScheduleAutoCancelled($scheduleId, $timestamp);
                }
            }

            // هعلم الجروب إنه اتعالج عشان الـ Job ما تتكررش
            $this->markAutoCancelProcessed($timestamp);

            return $updatedIds;
        });

        if ($updatedScheduleIds !== []) {
            // هنا انا ببعت ايفنت بكل المحاضرات اللي اتلغت
            event(new LecturesUpdated($updatedScheduleIds));
        }
    }

    private function getSchedulesToAutoCancel(): array
    {
        // هختار محاضرات الجروب اللي مواعيدها ما اتغيرتش ولسه not_started
        return DB::table('lecture_group_schedules as lgs')
            ->join('schedules as s', 's.id', '=', 'lgs.schedule_id')
            ->where('lgs.lecture_group_id', $this->groupId)
            ->where('s.status', 'not_started')
            ->whereNull('s.deleted_at')
            ->whereRaw("CONCAT(s.date, ' ', s.start_time) = lgs.planned_start_at")
            ->whereRaw("CONCAT(s.date, ' ', s.end_time) = lgs.planned_end_at")
            ->pluck('s.id')
            ->map(fn ($scheduleId) => (int) $scheduleId)
            ->all();
    }

    private function markScheduleAutoCancelled(int $scheduleId, string $timestamp): void
    {
        // هسجل وقت الإلغاء ونتيجته في تفاصيل المحاضرة
        DB::table('lecture_group_schedules')
            ->where('lecture_group_id', $this->groupId)
            ->where('schedule_id', $scheduleId)
            ->update([
                'cancelled_at' => $timestamp,
                'outcome' => 'auto_cancelled',
                'updated_at' => $timestamp,
            ]);
    }

    private function markAutoCancelProcessed(string $timestamp): void
    {
        // هعلم الجروب إنه اتعالج عشان الإلغاء ما يتكررش
        DB::table('lecture_groups')
            ->where('id', $this->groupId)
            ->where('auto_cancel_processed', false)
            ->update([
                'auto_cancel_processed' => true,
                'updated_at' => $timestamp,
            ]);
    }
}
