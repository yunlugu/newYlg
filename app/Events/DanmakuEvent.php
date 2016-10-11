<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DanmakuEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $danmaku;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($danmaku)
    {
        $this->danmaku = $danmaku;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['danmaku-channel'];
    }
}
