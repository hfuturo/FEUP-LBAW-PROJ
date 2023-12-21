<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewCommentLikeNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id;
    public $comment_id;
    public $post_name;
    public $post_id;
    public $sender_id;
    public $notification_id;
    public $sender_name;

    /**
     * Create a new event instance.
     */
    public function __construct($user_id, $comment_id, $post_name, $post_id, $sender_id, $sender_name, $notification_id)
    {
        $this->user_id = $user_id;
        $this->comment_id = $comment_id;
        $this->post_name = $post_name;
        $this->sender_id = $sender_id;
        $this->sender_name = $sender_name;
        $this->notification_id = $notification_id;
        $this->post_id = $post_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('comment-vote' . $this->user_id);
    }

    public function broadcastAs()
    {
        return 'comment-vote';
    }
}
