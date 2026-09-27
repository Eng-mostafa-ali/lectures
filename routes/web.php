<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use Pusher\Pusher;

use App\Jobs\TestQueueJob;

use App\Events\PusherTestEvent;

use App\Http\Controllers\LectureController;
use App\Http\Controllers\TrainerLectureController;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.store');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| Lectures
|--------------------------------------------------------------------------
*/

Route::get('/lectures', [
    LectureController::class,
    'index'
])->name('lectures.index');

Route::get('/lectures/data', [
    LectureController::class,
    'data'
])->name('lectures.data');


/*
|--------------------------------------------------------------------------
| Start Lecture
|--------------------------------------------------------------------------
*/

Route::post(
    '/lectures/{scheduleId}/start',
    [LectureController::class, 'startLecture']
)->name('lectures.start');


/*
|--------------------------------------------------------------------------
| Lecture Attendance
|--------------------------------------------------------------------------
*/

Route::get(
    '/lectures/{scheduleId}/attendance',
    [LectureController::class, 'attendance']
)->name('lectures.attendance');










Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Teacher Lectures
    |--------------------------------------------------------------------------
    |
    | GET
    | /teacher/lectures
    |
    */

    Route::get(
        '/teacher/lectures',
        [TrainerLectureController::class, 'index']
    )->name('teacher.lectures');


    /*
    |--------------------------------------------------------------------------
    | Update Lecture Status
    |--------------------------------------------------------------------------
    |
    | PATCH
    | /teacher/lectures/{scheduleId}/status
    |
    */

    Route::patch(
        '/trainer/lectures/{scheduleId}/status',
        [TrainerLectureController::class, 'updateStatus']
    )->name('trainer.lectures.status');


    /*
    |--------------------------------------------------------------------------
    | Attendance
    |--------------------------------------------------------------------------
    |
    | GET
    | /teacher/lectures/{scheduleId}/attendance
    |
    */

    Route::get(
        '/teacher/lectures/{scheduleId}/attendance',
        [TrainerLectureController::class, 'attendance']
    )->name('teacher.lectures.attendance');


    /*
    |--------------------------------------------------------------------------
    | Update Student Attendance
    |--------------------------------------------------------------------------
    |
    | PATCH
    | /teacher/lectures/{scheduleId}/attendance/{traineeId}
    |
    */

    Route::patch(
        '/teacher/lectures/{scheduleId}/attendance/{traineeId}',
        [TrainerLectureController::class, 'updateAttendance']
    )->name('teacher.lectures.attendance.update');

});

