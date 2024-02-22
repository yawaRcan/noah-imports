<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public $notifiable;

    public $eventName;

    public $template;

    public $shortCodes;

    /**
     * Create a new event instance.
     */
    public function __construct($template = null, $shortCodes = [],$user = null , $notifiable = null , $eventName = null)
    {
        $this->template = $template;

        $this->shortCodes = $shortCodes;
        
        $this->user = $user;

        $this->notifiable = $notifiable;
        
        $this->eventName = $eventName;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
