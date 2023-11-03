<?php

namespace Modules\Core\Listeners;

use App\Models\User;
use Modules\Core\Models\Plan;
use Modules\Quiz\Models\Exam;
use Illuminate\Support\Carbon;
use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Log;
use Modules\Core\Models\HistoryGift;
use Modules\Core\Models\RewardPoint;
use App\Gamify\Points\PointExamMission;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use Modules\Core\Events\UserDoneGiftExchangeEvent;
use Modules\Core\Notifications\UserDatabaseNotification;

class UserMissionDoneListener
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
    public function handle($event)
    {
        $mission = $event->mission;
        if ($mission->apply_entity_type === 'EXAM') { // áp dụng cho đề thi
            $this->givePointExam($mission);
        }
        if ($mission->apply_entity_type === 'USER') {
            Notification::send($mission->user, new UserDatabaseNotification($mission->user, 'mission-done', $mission->name));
            if ($mission->reward_type === 'REWARD_POINT') {
                $this->givePointPromotion($mission);
            }
            if($mission->reward_type === 'GIFT'){
                $this->giftPromotion($mission);
            }
        }

    }

    public function givePointExam($user_mission)
    {
        try {
            $exam = Exam::find($user_mission->entity_typeable_id);
            $allowMethodTypes = ['SHARE', 'VIEWED', 'DOWNLOAD'];
            // Log::channel('mission')->info('mission ===>', $user_mission->toArray());
            // Log::channel('mission')->info('allowMethodTypes ==> ' . in_array($user_mission->method_reward_point_type, $allowMethodTypes));
            if (in_array($user_mission->method_reward_point_type, $allowMethodTypes)) {
                givePoint(new PointExamMission($exam, $user_mission->reward_point), $user_mission->user);
                return true;
            }
        } catch (ApiException $e) {
            throw $e;
        }
    }

    public function givePointPromotion($user_mission)
    {
        try {
            $user = $user_mission->user;
            $user_reward_point = RewardPoint::where('user_id', $user->id)->first();
            $user_reward_point->increment('reward_point', $user_mission->reward_point);
            $user->increment('reputation', $user_mission->reward_point);
            HistoryGift::create([
                'gift_result' => $user_mission->reward_point .' '.'point',
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'missison_type' => 'PROMOTION'
            ]);
            return true;
        } catch (ApiException $e) {
            throw $e;
        }
    }

    public function giftPromotion($user_mission){
        try {
            $data = [
                'user' => $user_mission->user,
                'mission_gift' => $user_mission->mission_gift,
                'is_promotion_gift' => true
            ];
            event(new UserDoneGiftExchangeEvent($data));

            return true;
        } catch (ApiException $e) {
            throw $e;
        }
    }
}
