<?php

namespace App\Http\Controllers;

use App\Services\LectureService;

class LectureController extends Controller
{
    public function __construct(
        private readonly LectureService $lectureService
    ) {}

    public function index()
    {
        return view(
            'lectures',
            $this->lectureService->getDashboardData()
        );
    }

    public function data()
    {
        $dashboard = $this->lectureService->getDashboardData();

        $lectures = $dashboard['lectures'];
        $availableRooms = $dashboard['availableRooms'];
        $attendanceBySchedule = $this->lectureService->attendanceByScheduleIds(
            $lectures->pluck('schedule_id')->all()
        );

        return response()->json([
            'lectures_html' => view('partials.lectures-grid', [
                'lectures' => $lectures,
            ])->render(),

            'rooms_html' => view('partials.room-grid', [
                'availableRooms' => $availableRooms,
            ])->render(),

            'lectures_count' => $lectures->count(),
            'rooms_count' => $availableRooms->count(),
            'available_trainers_count' => $dashboard['availableTrainerCount'],
            'total_count' => $lectures->count() +
                $availableRooms->count(),
            'attendance_by_schedule' => (object) $attendanceBySchedule,
        ]);
    }

    public function attendance($scheduleId)
    {
        $attendance = $this->lectureService
            ->attendanceQuery($scheduleId);

        return response()->json([
            'data' => $attendance,
        ]);
    }
}
