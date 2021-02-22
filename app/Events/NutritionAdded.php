<?php

namespace App\Events;

use App\Models\Nutrition;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NutritionAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $nutritions;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->nutritions = Nutrition::all();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('nutritions');
    }
}
