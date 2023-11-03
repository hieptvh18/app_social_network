<?php

namespace Modules\Core\Listeners;

use Carbon\Carbon;
use Modules\Core\Models\Plan;
use App\Exceptions\ApiException;
use Modules\Core\Models\HistoryGift;
use Modules\Core\Models\RewardPoint;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use Modules\Core\Events\UserDoneGiftExchangeEvent;
use Modules\Auth\Models\Sanctum\PersonalAccessToken;

class UserDoneGiftExchangeListener
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
     * @param  UserDoneGiftExchangeEvent  $event
     * @return void
     */
    public function handle(UserDoneGiftExchangeEvent $event)
    {
        $user = $event->data['user'];
        $mission_gift = $event->data['mission_gift'];
        $exchange_point = $mission_gift->exchange_point;

        if($mission_gift->type == 'MONEY'){
            $user->decrement('reputation', $exchange_point);
            $user_reward_point = RewardPoint::where('user_id', $user->id)->first();
            $user_reward_point->decrement('reward_point', $exchange_point);
        }else{
            $mission_gift->decrement('exchange_qty');
            if (isset($event->data['is_promotion_gift'])) {
                return $this->giftPromotion($user);
            } else {
                return $this->giftExam($user, $exchange_point);
            }
        }

    }

    public function giftPromotion($user)
    {
        return  $this->reductionPoint($user);
    }

    public function giftExam($user, $exchange_point)
    {
        $user->decrement('reputation', $exchange_point);
        $user_reward_point = RewardPoint::where('user_id', $user->id)->first();
        $user_reward_point->decrement('reward_point', $exchange_point);
        return $this->reductionPoint($user);
    }

    public function reductionPoint($user)
    {
        try {
            $plan_subscription = $user->planSubscription('vip');

            if ($plan_subscription) {
                $ends_at = Carbon::parse($plan_subscription->ends_at);
                $plan_subscription->update([
                    'ends_at' => $ends_at->addDays(30)
                ]);
            } else {
                $plan = Plan::where('slug', 'vip')->first();
                $plan_subscription = $user->newPlanSubscription('vip', $plan);
                $plan_subscription->update([
                    'starts_at' => Carbon::now(),
                    'ends_at' => Carbon::now()->addDays(30)
                ]);
                $plan_features = $plan->features;
                foreach ($plan_features as $plan_feature) {
                    $plan_feature->usage()->create([
                        'subscription_id' => $plan_subscription->id,
                        'feature_id' => $plan_feature->id,
                        'used' => 0
                    ]);
                }
            }

            return true;
        } catch (ApiException $e) {
            throw $e;
        }
    }
}
