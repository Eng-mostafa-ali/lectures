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

class EndLectureJob implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $scheduleIds;

    public int $uniqueFor = 86400;

    public function __construct(int|array $scheduleIds)
    {
        $this->scheduleIds = is_array($scheduleIds)
            ? $scheduleIds
            : [$scheduleIds];
    }

    public function uniqueId(): string
    {
        $scheduleIds = array_map('intval', $this->scheduleIds);
        sort($scheduleIds);

        return implode('-', $scheduleIds);
    }

    public function handle(): void
    {
        $schedules = DB::table('schedules')
            ->whereIn('id', $this->scheduleIds)
            ->whereIn('status', ['cancelled', 'in_progress'])
            ->get();

        foreach ($schedules as $schedule) {
            DB::table('schedules')
                ->where('id', $schedule->id)
                ->whereIn('status', ['cancelled', 'in_progress'])
                ->update([
                    'status' => 'finished',
                    'updated_at' => now(),
                ]);
        }

        if ($schedules->isNotEmpty()) {
            event(
                new LecturesUpdated($schedules->pluck('id')->all())
            );
        }
    }
}
