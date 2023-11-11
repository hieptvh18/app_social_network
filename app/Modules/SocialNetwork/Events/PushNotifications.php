<?php

namespace Modules\SocialNetwork\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PushNotifications implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $currentUserId;

    protected $avatar;

    protected $notifiOfUserId;

    protected $message;

    protected $id;

    protected $created_at;

    public function __construct($currentUserId,$message, $avatar,$notifiOfUserId,$id,$created_at)
    {
        $this->currentUserId = $currentUserId;
        $this->notifiOfUserId = $notifiOfUserId;
        $this->message = $message;
        $this->avatar = $avatar;
        $this->id = $id;
        $this->created_at = $created_at;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // get current channel = current user login ID
        return [
            new PrivateChannel('notifications.'.$this->notifiOfUserId),
        ];
    }

    public function broadcastWith():array
    {
        return [
            'id'=>$this->id,
            'current_user'=>$this->currentUserId,
            'notifiOfUserId'=>$this->notifiOfUserId,
            'message'=>$this->message,
            'avatar'=>$this->avatar,
            'created_at'=>$this->created_at
        ];
    }

    public function broadcastAs(): string
    {
        return 'PushNotifications';
    }
}
