<?php

namespace Modules\Core\Listeners;

use Carbon\Carbon;
use App\Gamify\Points\PointExamMission;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Core\Events\CheckExamMission;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckExamMissionListener
{
    use InteractsWithQueue;
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
     * @param  object  $event
     * @return void
     */
    public function handle(CheckExamMission $event)
    {
        $type = $event->type;
        $exam = $event->exam;
        // if ($type === 'viewed') {
        $missions = $exam->userMissions()->where(
            [
                // 'method_reward_point_type' => 'VIEWED',
                'method_reward_point_type' => strtoupper($type),
                'status' => 'DOING',
                ['percent_complete', '<', 100],
                'method_approval_type' => 'AUTO'
            ]
        )->get();
        foreach ($missions as $mission) {
            $activityLogs = $exam->activities()->where([
                'log_name' => 'exam',
                'event' => $type,
                ['causer_id', '<>', $mission->user_id]
            ])->whereNotNull('causer_id')->groupBy('causer_id')
                ->whereBetween('created_at', [$mission->created_at, $mission->finished_time ? $mission->finished_time : Carbon::now()])->get();
            $percent = ($activityLogs->count() / $mission->reward_point_condition_number) * 100;
            if ($percent < 100) {
                $mission->update([
                    'percent_complete' => round($percent, 2)
                ]);
            } elseif ($percent >= 100) {
                $mission->update([
                    'percent_complete' => 100,
                ]);
                $mission->done();
            }
        }
        // }
    }
}
