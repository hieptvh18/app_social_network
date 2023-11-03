<?php

namespace Modules\Core\Listeners;

use Illuminate\Support\Str;
use Modules\Quiz\Models\ExamConfig;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Core\Events\CreateExamConfigEvent;

class CreateExamConfig
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param CreateExamConfigEvent $event
     * @return void
     */
    public function handle(CreateExamConfigEvent $event)
    {
        $exam = $event->data;
        if($exam->status == 'PRIVATE'){
            ExamConfig::create([
                'exam_id' => $exam->id,
                'has_password' => true,
                'password' => Str::random(8),
                'is_allow_share_group' => false
            ]);
        }

    }
}
