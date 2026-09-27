<?php

namespace App\Http\Controllers;

use App\Events\LecturesUpdated ;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainerLectureController extends Controller
{
    public function index()
    {
        $trainerId = auth()->id();

        $lectures = DB::table('schedules as s')
            ->leftJoin('rooms as r', 'r.id', '=', 's.room_id')
            ->leftJoin('courses as c', 'c.id', '=', 's.course_id')
            ->leftJoin('batches as b', 'b.id', '=', 's.batch_id')
            ->leftJoin('trainee_sections as ts', 'ts.id', '=', 's.trainee_section_id')

           
            ->where('s.trainer_id', $trainerId)

           
            ->whereDate('s.date', today())

           
            ->whereNull('s.deleted_at')

           
            ->whereNotIn('s.status', [
                // 'cancelled',
                'finished',
            ])

            ->select(
                's.id as schedule_id',
                's.date',
                's.start_time',
                's.end_time',
                's.status',
                's.delivery_mode',
                's.online_link',

                'r.id as room_id',
                'r.room_code',

                'c.id as course_id',
                'c.course_code',
                'c.name as course_name',

                'b.id as batch_id',
                'b.batch_code',
                'b.batch_name',

                'ts.id as trainee_section_id',
                'ts.section_code',
                'ts.section_name',
                'ts.trainee_count'
            )

            ->orderBy('s.start_time')
            ->get();

        return view('trainer.lectures.index', [
            'lectures' => $lectures,
        ]);
    }

    public function updateStatus(
        Request $request,
        int $scheduleId
    ) {

        $request->validate([

            'status' => [
                'required',
                'in:not_started,in_progress,finished,cancelled',
            ],

        ]);

        $trainerId = auth()->id();

        $lecture = DB::table('schedules')

            ->where(
                'id',
                $scheduleId
            )

            ->where(
                'trainer_id',
                $trainerId
            )

            ->first();

        if (! $lecture) {

            return response()->json([

                'message' => 'Lecture not found.',

            ], 404);
        }

        if ($lecture->status === 'finished') {

            return response()->json([

                'message' => 'Finished lecture cannot be changed.',

            ], 422);
        }

        if (
            $request->status === 'in_progress'
        ) {

            $startAt = Carbon::parse(
                $lecture->date.
                ' '.
                $lecture->start_time
            );

            if (now()->lt($startAt)) {

                return response()->json([

                    'message' => 'Lecture has not started yet.',

                ], 422);
            }
        }

        DB::table('schedules')

            ->where(
                'id',
                $scheduleId
            )

            ->where(
                'trainer_id',
                $trainerId
            )

            ->update([

                'status' => $request->status,

                'updated_at' => now(),

            ]);

        broadcast(
            new LecturesUpdated (
                $scheduleId          
            )
        )->toOthers();

        return response()->json([

            'message' => 'Lecture status updated successfully.',

            'status' => $request->status,

        ]);
    }

    public function attendance($scheduleId)
    {
        $lecture = DB::table('schedules')
            ->where('id', $scheduleId)
            ->where('trainer_id', auth()->id())
            ->first();

        if (! $lecture) {
            abort(404);
        }

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

            a.id AS attendance_id,
            a.status AS attendance_status,
            a.check_in,
            a.check_out

        FROM trainees t

        LEFT JOIN trainee_sections ts
            ON t.trainee_section_id = ts.id

        LEFT JOIN attendances a
            ON a.trainee_id = t.id
            AND a.schedule_id = ?
            AND a.deleted_at IS NULL

        WHERE t.trainee_section_id = ?

        ORDER BY t.first_name_en
    ";

        $attendance = DB::select($query, [
            $scheduleId,
            $lecture->trainee_section_id,
        ]);

        return view('trainer.lectures.attendance', [
            'attendance' => $attendance,
            'lecture' => $lecture,
            'scheduleId' => $scheduleId,
        ]);
    }

    public function updateAttendance(Request $request, $scheduleId, $traineeId)
    {
        $request->validate([
            'status' => [
                'required',
                'in:present,absent,late,excused',
            ],
        ]);

        $lecture = DB::table('schedules')
            ->where('id', $scheduleId)
            ->where('trainer_id', auth()->id())
            ->first();

        if (! $lecture) {
            abort(404);
        }

        $trainee = DB::table('trainees')
            ->where('id', $traineeId)
            ->where(
                'trainee_section_id',
                $lecture->trainee_section_id
            )
            ->first();

        if (! $trainee) {
            abort(404);
        }

        $existing = DB::table('attendances')
            ->where('schedule_id', $scheduleId)
            ->where('trainee_id', $traineeId)
            ->first();

        if ($existing) {

            DB::table('attendances')
                ->where('id', $existing->id)
                ->update([
                    'status' => $request->status,
                    'check_in' => $request->status === 'present'
                        ? now()
                        : $existing->check_in,
                    'deleted_at' => null,
                    'updated_at' => now(),
                ]);

        } else {

            DB::table('attendances')->insert([
                'schedule_id' => $scheduleId,
                'trainee_id' => $traineeId,
                'trainee_section_id' => $lecture->trainee_section_id,
                'status' => $request->status,
                'check_in' => $request->status === 'present'
                    ? now()
                    : null,
                'check_out' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Attendance updated successfully',
        ]);
    }
}
