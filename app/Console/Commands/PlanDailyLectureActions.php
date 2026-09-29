<?php

namespace App\Console\Commands;

use App\Jobs\CancelNotStartedLectureJob;
use App\Jobs\EndLectureJob;
use App\Jobs\GetAttendanceJob;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PlanDailyLectureActions extends Command
{
    protected $signature = 'lectures';

    protected $description = 'Plan automatic actions for today\'s lectures';

    public function handle(): int
    {
        // هجيب كل المحاضرات اللي هتتعامل النهاردة
        $timestamp = now()->toDateTimeString();
        $today = today()->toDateString();
        $scheduleGroups = DB::select(
            "SELECT
                CONCAT(`date`, ' ', start_time) AS start_at,
                DATE_ADD(CONCAT(`date`, ' ', start_time), INTERVAL 10 MINUTE) AS attendance_at,
                DATE_ADD(CONCAT(`date`, ' ', start_time), INTERVAL 15 MINUTE) AS auto_cancel_at,
                CONCAT(`date`, ' ', end_time) AS end_at,
                GROUP_CONCAT(id) AS schedule_ids,
                COUNT(*) AS lecture_count
            FROM schedules
            WHERE `date` = ?
                AND deleted_at IS NULL
                AND status NOT IN (?, ?)
            GROUP BY `date`, start_time, end_time",
            [$today, 'finished', 'cancelled']
        );
        // وبعدين هعمل حفظ للمجموعات دي في جدول lecture_groups و lecture_group_schedules
        $groupsToDispatch = $this->saveGroups($scheduleGroups, $timestamp);
        $this->dispatchGroupJobs($groupsToDispatch);

        $this->info('Prepared and dispatched jobs for today\'s lectures.');

        return self::SUCCESS;
    }

    private function saveGroups(array $scheduleGroups, string $timestamp): array
    {
        // الفنكشن دي بتاخد كل المجموعات اللي هتتعامل النهاردة وبتحفظها في جدول lecture_groups و lecture_group_schedules
        // هبدا transaction عشان لو حصل أي حاجة غلط نقدر نرجع كل حاجة زي ما كانت
        return DB::transaction(function () use ($scheduleGroups, $timestamp): array {
            $members = [];
            $savedGroups = [];
             // هعمل loop على كل مجموعة من المحاضرات اللي هتتعامل النهاردة
            foreach ($scheduleGroups as $scheduleGroup) {
                $groupTimes = [
                    'start_at' => $scheduleGroup->start_at,
                    'end_at' => $scheduleGroup->end_at,
                ];
                 // هحفظ المجموعة دي في جدول lecture_groups لو مش موجودة قبل كده
                DB::table('lecture_groups')->insertOrIgnore([
                    'start_at' => $groupTimes['start_at'],
                    'end_at' => $groupTimes['end_at'],
                    'attendance_at' => $scheduleGroup->attendance_at,
                    'auto_cancel_at' => $scheduleGroup->auto_cancel_at,
                    'lecture_count' => $scheduleGroup->lecture_count,
                    'attendance_processed' => false,
                    'auto_cancel_processed' => false,
                    'auto_finish_processed' => false,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);
                // هجيب السجل بتاع المجموعة دي من جدول lecture_groups عشان أعرف الـ id بتاعها
                $groupRecord = DB::table('lecture_groups')
                    ->where($groupTimes)
                    ->first([
                        'id',
                        'attendance_processed',
                        'auto_cancel_processed',
                        'auto_finish_processed',
                    ]);
               // لو السجل موجود هعمل update للحقول اللي ممكن تكون اتغيرت
                DB::table('lecture_groups')
                    ->where('id', $groupRecord->id)
                    ->update([
                        'attendance_at' => $scheduleGroup->attendance_at,
                        'auto_cancel_at' => $scheduleGroup->auto_cancel_at,
                        'lecture_count' => $scheduleGroup->lecture_count,
                        'updated_at' => $timestamp,
                    ]);
                  // بعد كده هحفظ كل المحاضرات اللي في المجموعة دي في جدول lecture_group_schedules
                $savedGroups[] = [
                    'id' => (int) $groupRecord->id,
                    'attendance_at' => $scheduleGroup->attendance_at,
                    'auto_cancel_at' => $scheduleGroup->auto_cancel_at,
                    'end_at' => $scheduleGroup->end_at,
                    'attendance_processed' => (bool) $groupRecord->attendance_processed,
                    'auto_cancel_processed' => (bool) $groupRecord->auto_cancel_processed,
                    'auto_finish_processed' => (bool) $groupRecord->auto_finish_processed,
                ];
                 // هعمل loop على كل المحاضرات اللي في المجموعة دي عشان أحفظها في جدول lecture_group_schedules
                foreach (explode(',', $scheduleGroup->schedule_ids) as $scheduleId) {
                    $members[] = [
                        'lecture_group_id' => $groupRecord->id,
                        'schedule_id' => (int) $scheduleId,
                        'planned_start_at' => $scheduleGroup->start_at,
                        'planned_end_at' => $scheduleGroup->end_at,
                        'outcome' => 'pending',
                        'created_at' => $timestamp,
                        'updated_at' => $timestamp,
                    ];
                }
            }
             // بعد ما خلصت حفظ كل المجموعات والمحاضرات هعمل upsert للجدول lecture_group_schedules عشان أتأكد إن كل المحاضرات موجودة في الجدول
            if ($members !== []) {
                DB::table('lecture_group_schedules')->upsert(
                    $members,
                    ['schedule_id'],
                    [
                        'lecture_group_id',
                        'planned_start_at',
                        'planned_end_at',
                        'updated_at',
                    ]
                );
            }

            return $savedGroups;
        });
    }

    private function dispatchGroupJobs(array $groups): void
    {
        // الفنكشن دي بتاخد كل المجموعات اللي اتخزنت وبتعمل dispatch للـ jobs الخاصة بكل مجموعة
        foreach ($groups as $group) {

        // هنادي الجوب ده عشان احدث نسبه الحضور عند كل محاضره بعد 10 دقايق من بدأها 
            if (! $group['attendance_processed']) {
                $job = GetAttendanceJob::dispatch($group['id']);
                $dueAt = Carbon::parse($group['attendance_at']);

                if ($dueAt->isFuture()) {
                    $job->delay($dueAt);
                }
            }
            // هنادي الجوب ده عشان ألغي أي محاضره لسه متبدأتش بعد 15 دقيقه من بدأها
            if (! $group['auto_cancel_processed']) {
                $job = CancelNotStartedLectureJob::dispatch($group['id']);
                $dueAt = Carbon::parse($group['auto_cancel_at']);

                if ($dueAt->isFuture()) {
                    $job->delay($dueAt);
                }
            }
            // هشوف وقت النهايه بتاعت المحاضره وبعدين اعملها انهاء لو وقت نهايتها جه وهي لسه شغاله
            if (! $group['auto_finish_processed']) {
                $job = EndLectureJob::dispatch($group['id']);
                $dueAt = Carbon::parse($group['end_at']);

                if ($dueAt->isFuture()) {
                    $job->delay($dueAt);
                }
            }
        }
    }
}
