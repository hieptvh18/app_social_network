<?php

namespace Modules\Core\Services\Admin;

use App\Exceptions\ApiException;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\Core\Models\Plan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class AdminPlanSubscriptionService
{
    public function activePlanByAdmin(Request $request)
    {
        try {
            $user = User::find($request->user_id);
            if($user->status === 'BLOCKED'){
                throw new ApiException('Tài khoản này đã bị khóa', 500);
            }
            $plan_subscription = $user->planSubscription('vip');
            if ($plan_subscription) {
                throw new ApiException('Tài khoản này là tài khoản vip', 500);
            } else {
                $plan = Plan::where('slug', 'vip')->first();
                $user_plan_subscription = $user->newPlanSubscription('vip', $plan);
                $user_plan_subscription->update([
                    'starts_at' => Carbon::now(),
                    'ends_at' => Carbon::now()->addDays(30)
                ]);
                $plan_features = $plan->features;
                foreach ($plan_features as $plan_feature) {
                    $plan_feature->usage()->create([
                        'subscription_id' => $user_plan_subscription->id,
                        'feature_id' => $plan_feature->id,
                        'used' => 0
                    ]);
                }
            }
            return $user_plan_subscription;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
