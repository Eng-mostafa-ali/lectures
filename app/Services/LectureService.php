<?php

namespace App\Services;

use App\Jobs\CancelNotStartedLectureJob;
use App\Jobs\EndLectureJob;
use App\Jobs\GetAttendanceJob;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class LectureService
{
    public function getTodayDashboard(Collection $items): Collection
    {
        return $items->map(function ($item) {
            if ($item->item_type === 'available_room') {
                $item->room_code = $item->room_code ?? 'No Room';
                $item->room_label = $item->room_code;

                return $item;
            }

            $start = Carbon::parse(
                $item->date.' '.$item->start_time
            );

            $end = Carbon::parse(
                $item->date.' '.$item->end_time
            );

            $traineeCount = (int) ($item->trainee_count ?? 0);
            $presentCount = (int) ($item->present_count ?? 0);

            $attendancePercentage = $traineeCount > 0
                ? round(($presentCount / $traineeCount) * 100, 1)
                : 0;

            $attendanceProgress = min(
                100,
                max(0, $attendancePercentage)
            );

            $deliveryMode = strtolower(
                trim($item->delivery_mode ?? '')
            );

            $isOnline = $deliveryMode === 'online';

            $roomLabel = $isOnline
                ? 'Online Lecture'
                : ($item->room_code ?? 'No Room');

            $item->status = $item->status ?? '';
            $item->delivery_mode = $item->delivery_mode ?? '';
            $item->room_code = $item->room_code ?? '';
            $item->online_link = $item->online_link ?? '';
            $item->course_name = $item->course_name ?? '-';
            $item->course_code = $item->course_code ?? '-';
            $item->batch_name = $item->batch_name ?? '-';
            $item->batch_code = $item->batch_code ?? '-';
            $item->section_name = $item->section_name ?? '-';
            $item->section_code = $item->section_code ?? '-';
            $item->trainer_name = $item->trainer_name ?? '-';

            $item->start_datetime = $start->format('Y-m-d H:i:s');
            $item->end_datetime = $end->format('Y-m-d H:i:s');
            $item->start_formatted = $start->format('h:i A');
            $item->end_formatted = $end->format('h:i A');
            $item->aria_label = $roomLabel
                .' · '
                .$item->start_formatted
                .' to '
                .$item->end_formatted;

            $item->trainee_count = $traineeCount;
            $item->present_count = $presentCount;
            $item->absent_count = (int) ($item->absent_count ?? 0);
            $item->late_count = (int) ($item->late_count ?? 0);
            $item->excused_count = (int) ($item->excused_count ?? 0);
            $item->attendance_percentage = $attendancePercentage;
            $item->attendance_percentage_formatted = number_format(
                $attendancePercentage,
                1
            );
            $item->attendance_progress = $attendanceProgress;
            $item->is_online = $isOnline;
            $item->room_label = $roomLabel;

            return $item;
        });
    }

    public function getTodayLecturesAndRooms()
    {
        $query = "
        SELECT 
            'lecture' AS item_type,

            s.id AS schedule_id, 
            s.delivery_mode,

            r.id AS room_id,
            r.room_code,

            s.date,
            s.start_time,
            s.end_time,
            s.status,
            s.online_link,

            u.id AS trainer_id,
            CONCAT(u.first_name, ' ', u.last_name) AS trainer_name,

            c.id AS course_id,
            c.course_code,
            c.name AS course_name,

            b.id AS batch_id,
            b.batch_code,
            b.batch_name,

            ts.id AS trainee_section_id,
            ts.section_code,
            ts.section_name,
            ts.trainee_count,

            COUNT(
                CASE 
                    WHEN a.status = 'present' 
                    THEN 1 
                END
            ) AS present_count,

            COUNT(
                CASE 
                    WHEN a.status = 'absent' 
                    THEN 1 
                END
            ) AS absent_count,

            COUNT(
                CASE 
                    WHEN a.status = 'late' 
                    THEN 1 
                END
            ) AS late_count,

            COUNT(
                CASE 
                    WHEN a.status = 'excused' 
                    THEN 1 
                END
            ) AS excused_count

        FROM schedules s

        LEFT JOIN rooms r
            ON s.room_id = r.id
            AND r.deleted_at IS NULL

        LEFT JOIN users u
            ON s.trainer_id = u.id

        LEFT JOIN courses c
            ON s.course_id = c.id

        LEFT JOIN batches b
            ON s.batch_id = b.id

        LEFT JOIN trainee_sections ts
            ON s.trainee_section_id = ts.id

        LEFT JOIN attendances a
            ON s.id = a.schedule_id
            AND a.deleted_at IS NULL

        WHERE s.date = CURRENT_DATE()

            AND s.deleted_at IS NULL

            AND s.status NOT IN (
                
                'finished'
            )

            AND (
                s.status <> 'cancelled'
                OR s.end_time >= CURRENT_TIME()
            )

        GROUP BY
            s.id,
            s.delivery_mode,
            r.id,
            r.room_code,
            s.date,
            s.start_time,
            s.end_time,
            s.status,
            s.online_link,
            u.id,
            u.first_name,
            u.last_name,
            c.id,
            c.course_code,
            c.name,
            b.id,
            b.batch_code,
            b.batch_name,
            ts.id,
            ts.section_code,
            ts.section_name,
            ts.trainee_count

        UNION ALL

        SELECT 
            'available_room' AS item_type,

            NULL AS schedule_id,
            NULL AS delivery_mode,

            r.id AS room_id,
            r.room_code,

            NULL AS date,
            NULL AS start_time,
            NULL AS end_time,
            NULL AS status,
            NULL AS online_link,

            NULL AS trainer_id,
            NULL AS trainer_name,

            NULL AS course_id,
            NULL AS course_code,
            NULL AS course_name,

            NULL AS batch_id,
            NULL AS batch_code,
            NULL AS batch_name,

            NULL AS trainee_section_id,
            NULL AS section_code,
            NULL AS section_name,
            NULL AS trainee_count,

            NULL AS present_count,
            NULL AS absent_count,
            NULL AS late_count,
            NULL AS excused_count

        FROM rooms r

        WHERE r.status = 'active'

            AND r.deleted_at IS NULL

            AND NOT EXISTS (

                SELECT 1

                FROM schedules s

                WHERE s.room_id = r.id

                    AND s.date = CURRENT_DATE()

                    AND s.deleted_at IS NULL

                    AND s.status NOT IN (
                        
                        'finished'
                    )

                    AND s.delivery_mode IN (
                        'onsite',
                        'hybrid'
                    )
            )
    ";

        $items = DB::select($query);
        $this->scheduleLectureJobs($items);

        return $items;
    }

    public function attendanceQuery($scheduleId)
    {
        $query = "
        SELECT
            t.id AS trainee_id,
            t.academic_number,

            CONCAT(
                COALESCE(t.first_name_en, ''),
                ' ',
                COALESCE(t.father_name_en, ''),
                ' ',
                COALESCE(t.grand_father_name_en, ''),
                ' ',
                COALESCE(t.family_name_en, '')
            ) AS trainee_name,

            ts.section_code,
            ts.section_name,

            a.status,
            a.check_in,
            a.check_out

        FROM attendances a

        INNER JOIN trainees t
            ON a.trainee_id = t.id

        LEFT JOIN trainee_sections ts
            ON a.trainee_section_id = ts.id

        WHERE a.schedule_id = ?
            AND a.status = 'absent'
            AND a.deleted_at IS NULL

        ORDER BY t.first_name_en
    ";

        return DB::select($query, [$scheduleId]);
    }

    public function attendanceByScheduleIds(array $scheduleIds): array
    {
        $scheduleIds = array_values(array_unique(array_map('intval', $scheduleIds)));

        if ($scheduleIds === []) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($scheduleIds), '?'));

        $query = "
            SELECT
                a.schedule_id,
                t.id AS trainee_id,
                t.academic_number,
                CONCAT(
                    COALESCE(t.first_name_en, ''),
                    ' ',
                    COALESCE(t.father_name_en, ''),
                    ' ',
                    COALESCE(t.grand_father_name_en, ''),
                    ' ',
                    COALESCE(t.family_name_en, '')
                ) AS trainee_name,
                ts.section_code,
                ts.section_name,
                a.status,
                a.check_in,
                a.check_out
            FROM attendances a
            INNER JOIN trainees t
                ON a.trainee_id = t.id
            LEFT JOIN trainee_sections ts
                ON a.trainee_section_id = ts.id
            WHERE a.schedule_id IN ($placeholders)
                AND a.status = 'absent'
                AND a.deleted_at IS NULL
            ORDER BY a.schedule_id, t.first_name_en
        ";

        $attendanceBySchedule = [];

        foreach (DB::select($query, $scheduleIds) as $row) {
            $scheduleId = (string) $row->schedule_id;
            unset($row->schedule_id);
            $attendanceBySchedule[$scheduleId][] = $row;
        }

        return $attendanceBySchedule;
    }

    private function scheduleLectureJobs($items): void
    {
        $endGroups = [];
        foreach ($items as $item) {

            if ($item->item_type !== 'lecture') {
                continue;
            }

            if (! $item->schedule_id) {
                continue;
            }

            if (! $item->date || ! $item->start_time || ! $item->end_time) {
                continue;
            }

            $startAt = Carbon::parse(
                $item->date.' '.$item->start_time
            );

            $endAt = Carbon::parse(
                $item->date.' '.$item->end_time
            );

            $endTime = $endAt->format('Y-m-d H:i:s');
            $endGroups[$endTime][] = (int) $item->schedule_id;

            $cancelAt = $startAt->copy()->addMinutes(15);

            if ($cancelAt->isFuture()) {
                CancelNotStartedLectureJob::dispatch(
                    $item->schedule_id
                )->delay($cancelAt);
            }

            $getAttendance = $startAt->copy()->addMinutes(10);

            if ($getAttendance->isFuture()) {
                GetAttendanceJob::dispatch(
                    $item->schedule_id
                )->delay($getAttendance);
            }

        }

        foreach ($endGroups as $endTime => $scheduleIds) {
            $endAt = Carbon::parse($endTime);
            $endJob = EndLectureJob::dispatch($scheduleIds);

            if ($endAt->isFuture()) {
                $endJob->delay($endAt);
            }
        }
    }

    public function getDashboardData(): array
    {
        $items = collect(
            $this->getTodayLecturesAndRooms()
        );

        $dashboard = $this->getTodayDashboard($items);

        return [
            'dashboardDate' => now()->format('Y-m-d'),

            'lectures' => $dashboard
                ->where('item_type', 'lecture')
                ->values(),

            'availableRooms' => $dashboard
                ->where('item_type', 'available_room')
                ->values(),
        ];
    }
}
