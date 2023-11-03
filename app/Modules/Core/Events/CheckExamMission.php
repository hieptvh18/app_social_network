<?php

namespace Modules\Core\Events;

use Illuminate\Queue\SerializesModels;

class CheckExamMission
{
    use SerializesModels;

    public $exam;
    public $type;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($exam, $type)
    {
        $this->exam = $exam;
        $this->type = $type;
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
