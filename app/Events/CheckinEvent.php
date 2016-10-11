<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CheckinEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $name_list;
    // protected $channel;

    /**
     * Create a new event instance.
     *
     * @param  string $token
     * @param  string $channel
     * @return void
     */
    public function __construct($name_list)
    {
        $this->name_list = $name_list;
        // $this->channel = $channel;
    }

    /**
     * Get the channels the event should be broadcast on.
     * 返回所需广播的频道
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['checkin-channel'];
    }

}
