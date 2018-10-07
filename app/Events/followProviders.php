<?php

namespace App\Events;

use App\Http\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class followProviders implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $provider;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($provider)
    {
        //
        $this->provider=$provider;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('followProvidersChannel');
    }
}
