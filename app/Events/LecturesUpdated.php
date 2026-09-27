<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LecturesUpdated implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public array $scheduleIds;

    public function __construct(int|array $scheduleIds)
    {
        $this->scheduleIds = is_array($scheduleIds)
            ? $scheduleIds
            : [$scheduleIds];
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('lectures'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'lectures.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'schedule_ids' => $this->scheduleIds,
        ];
    }
}
