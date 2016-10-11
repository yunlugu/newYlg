<?php

namespace App\Listeners;

use App\Events\CheckinEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckinListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CheckinEvent  $event
     * @return void
     */
    public function handle(CheckinEvent $event)
    {
        //
    }
}
