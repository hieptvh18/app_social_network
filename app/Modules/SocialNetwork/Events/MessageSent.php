<?php

namespace Modules\SocialNetwork\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\SocialNetwork\Models\Message;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $from;
    public $roomId;

    public function __construct(Message $message, User $user,$roomId)
    {
        $this->message = $message;
        $this->from = $user; // ng gui
        $this->roomId = $roomId; // ng gui
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chatroom.'.$this->roomId),
        ];
    }

    public function broadcastAs(){
        return 'MessageSent';
    }
}
