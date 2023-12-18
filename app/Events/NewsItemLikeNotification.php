<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewsItemLikeNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id;
    public $post_id;
    public $post_name;
    public $notification_id;

    /**
     * Create a new event instance.
     */
    public function __construct($user_id, $post_id, $post_name, $notification_id)
    {
        $this->user_id = $user_id;
        $this->post_id = $post_id;
        $this->post_name = $post_name;
        $this->notification_id = $notification_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('news-item-vote' . $this->user_id);
    }

    public function broadcastAs()
    {
        return 'news-item-vote';
    }
}
