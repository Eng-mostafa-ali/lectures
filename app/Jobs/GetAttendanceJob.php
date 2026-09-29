<?php

namespace App\Jobs;

use App\Events\LecturesUpdated;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class GetAttendanceJob implements ShouldBeUnique, ShouldQueue
{
    use Queueable;

    public int $uniqueFor = 86400;

    public function __construct(public int $groupId) {}

    public function uniqueId(): string
    {
        return 'lecture-group-attendance-'.$this->groupId;
    }

    public function handle(): void
    {
        // هجيب الجروب اللي الـ Job شغالة عليه
        $group = DB::table('lecture_groups')
            ->where('id', $this->groupId)
            ->first();

        // هخرج لو الجروب مش موجود أو اتبعتله تحديث الحضور قبل كده
        if (! $group || $group->attendance_processed) {
            return;
        }

        // هعلم الجروب إنه اتعالج وهجيب المحاضرات اللي لسه مواعيدها زي الخطة
        $scheduleIds = DB::transaction(function (): array {
            $this->markAttendanceUpdateProcessed(now()->toDateTimeString());

            return $this->getGroupLectureIdsForRefresh();
        });

        if ($scheduleIds !== []) {
            // هبعت إيفنت واحدة بكل محاضرات الجروب عشان الداشبورد يتحدث
            event(new LecturesUpdated($scheduleIds));
        }
    }

    private function getGroupLectureIdsForRefresh(): array
    {
        // هجيب المحاضرات اللي شغالة ومواعيدها ما اتغيرتش
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

    private function markAttendanceUpdateProcessed(string $timestamp): void
    {
        // هعلم الجروب إنه اتعالج عشان الإيفنت ما يتبعتش تاني
        DB::table('lecture_groups')
            ->where('id', $this->groupId)
            ->where('attendance_processed', false)
            ->update([
                'attendance_processed' => true,
                'updated_at' => $timestamp,
            ]);
    }
}
