<?php

namespace App\Listeners;

use App\Events\followProviders;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderEventListener
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
     * @param  followProviders  $event
     * @return void
     */
    public function handle(followProviders $event)
    {
        //
    }
}
