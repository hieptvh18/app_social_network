<?php

namespace Modules\Core\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Core\Models\UserMission;

class UserMissionDoneEvent
{
    use SerializesModels;

    public $mission;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(UserMission $userMission)
    {
        $this->mission = $userMission;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
