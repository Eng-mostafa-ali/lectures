<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;

class LectureCardStatusTest extends TestCase
{
    public function test_lecture_card_status_and_attendance_visibility_match_business_rules(): void
    {
        $notStarted = $this->lectureItem('not_started', '2026-09-27', '09:00:00', '10:00:00', 12, 3);
        $cancelled = $this->lectureItem('cancelled', '2026-09-27', '09:00:00', '10:00:00', 12, 3);
        $inProgress = $this->lectureItem('in_progress', '2026-09-27', '08:00:00', '10:00:00', 12, 6);

        $notStartedHtml = view('partials.lecture-card', ['item' => $notStarted])->render();
        $cancelledHtml = view('partials.lecture-card', ['item' => $cancelled])->render();
        $inProgressHtml = view('partials.lecture-card', ['item' => $inProgress])->render();

        $this->assertStringNotContainsString('Attendance', $notStartedHtml);
        $this->assertStringNotContainsString('Attendance', $cancelledHtml);
        $this->assertStringContainsString('Attendance', $inProgressHtml);
    }

    private function lectureItem(string $status, string $date, string $startTime, string $endTime, int $traineeCount, int $presentCount): object
    {
        $start = Carbon::parse($date.' '.$startTime);
        $end = Carbon::parse($date.' '.$endTime);

        $attendancePercentage = $traineeCount > 0 ? round(($presentCount / $traineeCount) * 100, 1) : 0;

        return (object) [
            'item_type' => 'lecture',
            'schedule_id' => 1,
            'status' => $status,
            'start_datetime' => $start->format('Y-m-d H:i:s'),
            'end_datetime' => $end->format('Y-m-d H:i:s'),
            'start_formatted' => $start->format('h:i A'),
            'end_formatted' => $end->format('h:i A'),
            'room_label' => 'Room A',
            'course_code' => 'CS101',
            'trainer_name' => 'John Smith',
            'trainer_id' => 10,
            'section_code' => 'A1',
            'attendance_percentage' => $attendancePercentage,
            'attendance_percentage_formatted' => number_format($attendancePercentage, 1),
            'attendance_progress' => min(100, max(0, $attendancePercentage)),
            'delivery_mode' => 'onsite',
            'room_code' => 'Room A',
            'online_link' => '',
            'course_name' => 'Computer Science',
            'batch_name' => 'Batch 1',
            'batch_code' => 'B1',
            'section_name' => 'Section A',
            'trainee_count' => $traineeCount,
            'present_count' => $presentCount,
            'absent_count' => $traineeCount - $presentCount,
            'late_count' => 0,
            'excused_count' => 0,
            'aria_label' => 'Room A · '.$start->format('h:i A').' to '.$end->format('h:i A'),
        ];
    }
}
