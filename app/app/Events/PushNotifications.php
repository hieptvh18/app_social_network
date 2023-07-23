<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PushNotifications implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $currentUserId;

    protected $notifiOfUserId;

    protected $message;
    
    protected $id;

    protected $created_at;

    public function __construct($currentUserId,$message,$notifiOfUserId,$id,$created_at)
    {   
        $this->currentUserId = $currentUserId;
        $this->notifiOfUserId = $notifiOfUserId;
        $this->message = $message;
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
            new PrivateChannel('notifications'),
        ];
    }

    public function broadcastWith():array
    {
        return [
            'id'=>$this->id,
            'current_user'=>$this->currentUserId,
            'notifiOfUserId'=>$this->notifiOfUserId,
            'message'=>$this->message,
            'created_at'=>$this->created_at
        ];
    }
}
