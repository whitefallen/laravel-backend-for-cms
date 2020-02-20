<?php

namespace App\Events;

use App\Models\Format;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventEntity
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    public $eventType;

    /**
     * Create a new event instance.
     *
     * @param Model $_model
     * @param string $_eventType
     */
    public function __construct(Model $_model, string $_eventType)
    {
        $this->data = $_model;
        $this->eventType = $_eventType;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
