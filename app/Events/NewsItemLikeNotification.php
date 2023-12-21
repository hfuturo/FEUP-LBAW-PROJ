<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
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
    public $sender_id;
    public $sender_name;

    /**
     * Create a new event instance.
     */
    public function __construct($user_id, $post_id, $post_name, $notification_id, $sender_id, $sender_name)
    {
        $this->user_id = $user_id;
        $this->post_id = $post_id;
        $this->post_name = $post_name;
        $this->notification_id = $notification_id;
        $this->sender_id = $sender_id;
        $this->sender_name = $sender_name;
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
