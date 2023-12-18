<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FollowUserNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // user que vai receber notificacao
    public $user_id;
    public $sender_id;
    public $sender_name;
    public $notification_id;

    /**
     * Create a new event instance.
     */
    public function __construct($user_id, $sender_id, $sender_name, $notification_id)
    {
        $this->user_id = $user_id;
        $this->sender_id = $sender_id;
        $this->sender_name = $sender_name;
        $this->notification_id = $notification_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('follow-user' . $this->user_id);
    }

    public function broadcastAs()
    {
        return 'notification';
    }
}
