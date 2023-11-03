<?php

namespace Modules\Core\Listeners;

use App\Models\User;
use Carbon\Carbon;
use Modules\Core\Models\Plan;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use Modules\Core\Notifications\NotifyActivePlan;
use Modules\Order\Notifications\AdminCancelledOrderNotification;
use Modules\Order\Events\OrderServiceChangeStatusAfter;

class AfterActivePlan
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
     * @param  OrderServiceChangeStatusAfter  $event
     * @return void
     */
    public function handle(OrderServiceChangeStatusAfter $event)
    {
        $order = $event->order;
        if ($order->status == 'completed') {
            $items = $order->items;
            $qty = $items->quantity;
            $plan_id = $order->items->product_id;
            $plan = Plan::find($plan_id);
            $user = User::find($order->customer->user_id);
            if($user->planSubscription('vip')){
                $plan_subscription = $user->planSubscription('vip');
                $plan_subscription->update([
                    'ends_at' => Carbon::parse($plan_subscription->ends_at)->addMonths($qty)
                ]);
            }else{
                $plan_subscription = $user->newPlanSubscription('vip', $plan);
                $plan_subscription->update([
                    'starts_at' => Carbon::now(),
                    'ends_at' => Carbon::now()->addMonths($qty)
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

            Notification::send($user, new NotifyActivePlan($order, $plan_subscription));
            return $plan_subscription;
        }
        if ($order->status == 'cancelled') {
            $user = User::find($order->customer->user_id);
            Notification::send($user, new AdminCancelledOrderNotification($order));
        }
    }
}
