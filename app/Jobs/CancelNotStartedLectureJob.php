<?php

namespace App\Jobs;

use App\Events\LecturesUpdated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CancelNotStartedLectureJob implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $uniqueFor = 86400;

    public function __construct(
        public int $scheduleId
    ) {}

    public function uniqueId(): string
    {
        return (string) $this->scheduleId;
    }

    public function handle(): void
    {
        $schedule = DB::table('schedules')->where('id', $this->scheduleId)->first();

        if (! $schedule) {
            return;
        }

        if ($schedule->status !== 'not_started') {
            return;
        }

        DB::table('schedules')->where('id', $this->scheduleId)->update([
            'status' => 'cancelled',
        ]);

        Event(new LecturesUpdated($this->scheduleId));

    }
}
