<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $notification_id;

    /**
     * Create a new event instance.
     */
    public function __construct($notification_id,$message)
    {
        $this->notification_id = $notification_id;
        $this->message = $message;
    }

    // You should specify the name of the channel created in Pusher.
    public function broadcastOn() {
        return 'NewsCore';
    }

    // You should specify the name of the generated notification.
    public function broadcastAs() {
        return 'notification';
    }

}
