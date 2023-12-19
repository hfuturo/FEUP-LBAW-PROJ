<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewCommentNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id;
    public $post_id;
    public $post_title;
    public $notification_id;

    /**
     * Create a new event instance.
     */
    public function __construct($user_id, $post_id, $post_title, $notification_id)
    {
        $this->user_id = $user_id;
        $this->post_id = $post_id;
        $this->post_title = $post_title;
        $this->notification_id = $notification_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('new-comment' . $this->user_id);
    }

    public function broadcastAs()
    {
        return 'new-comment';
    }
}
