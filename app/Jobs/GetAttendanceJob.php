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

    
    public function __construct(public int $scheduleId) {}

    public function uniqueId(): string
    {
        return (string) $this->scheduleId;
    }

   
    public function handle(): void
    {

        $schedule = DB::table('schedules')->where('id', $this->scheduleId)->first();
        if ($schedule->status !== 'not_started') {
            return;
        }
        event(
            new LecturesUpdated(
                $this->scheduleId
            )
        );
    }
}
