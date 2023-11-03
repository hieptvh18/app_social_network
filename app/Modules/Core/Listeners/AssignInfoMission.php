<?php

namespace Modules\Core\Listeners;

use Carbon\Carbon;
use Modules\Core\Models\InfoMission;
use Modules\Core\Models\UserMission;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Core\Events\AfterUserCreatedExam;
use Modules\Core\Events\CreateExamConfigEvent;

class AssignInfoMission
{
    // use InteractsWithQueue;

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
     * @param  AfterUserCreatedExam  $event
     * @return void
     */
    public function handle(AfterUserCreatedExam $event)
    {
        // $user = auth()->user();
        $info_mission_fields = ['id as info_mission_id', 'name', 'description', 'assign_user_type', 'apply_entity_type', 'method_reward_point_type', 'reward_point_condition_number', 'method_approval_type', 'reward_point', 'expired_time_type', 'expired_time_after', 'created_at', 'guilde_report_description', 'apply_start_date', 'apply_end_date'];
        $info_missions = InfoMission::select($info_mission_fields)->where([
            ['assign_user_type', 'AUTO'],
            ['apply_entity_type', 'EXAM'],
            ['is_active', true],
            ['apply_start_date', '<=', Carbon::now()],
            ['apply_end_date', '>=', Carbon::now()]

        ])
            ->orWhere([
                ['assign_user_type', 'AUTO'],
                ['apply_entity_type', 'EXAM'],
                ['is_active', true],
                ['apply_start_date', '<=', Carbon::now()],
                ['apply_end_date', null]

            ])
            ->whereIn('method_reward_point_type', ['SHARE', 'VIEWED', 'DOWNLOAD'])
            ->get();
            // die('xxx');
        $info_missions = $info_missions->toArray();
        foreach ($info_missions as $info_mission) {
            $user_mission = new UserMission();
            $finished_time = null;
            if ($info_mission['expired_time_after'] !== null) {
                if ($info_mission['expired_time_type'] === 'DAY') {
                    $day = $info_mission['expired_time_after'];
                    $finished_time = Carbon::parse($event->data->created_at)->timezone('Asia/Ho_Chi_Minh')->addDays($day);
                }
                if ($info_mission['expired_time_type'] === 'HOUR') {
                    $hour = $info_mission['expired_time_after'];
                    $finished_time = Carbon::parse($event->data->created_at)->timezone('Asia/Ho_Chi_Minh')->addHours($hour);
                }
                if ($info_mission['expired_time_type'] === 'MINUTE') {
                    $minute = $info_mission['expired_time_after'];
                    $finished_time = Carbon::parse($event->data->created_at)->timezone('Asia/Ho_Chi_Minh')->addMinutes($minute);
                }
            } else {
                $finished_time = null;
            }
            unset($info_mission['apply_start_date']);
            unset($info_mission['apply_end_date']);

            $user_mission->forceFill(array_merge($info_mission, [
                'user_id' => $event->data->created_by,
                'info_mission_id' => $info_mission['info_mission_id'],
                'entity_typeable_id' => $event->data->id,
                'entity_typeable_type' => $event->data->getMorphClass(),
                'finished_time' => $finished_time,
                'status' => 'DOING',
                'created_at' => now()
            ]))->save();
            // $event->data->entity_types()->save($user_mission);
        }
        event(new CreateExamConfigEvent($event->data));
    }
}
