<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Core\Services\PlanService;
use App\Http\Controllers\ApiController;

/**
 * @group Module Core
 *
 * APIs for user plans core
 *
 * @subgroup User Api
 * @subgroupDescription UserPlanController
 */
class UserPlanController extends ApiController
{
    protected $planService;

    public function __construct(PlanService $planService)
    {
        $this->planService = $planService;
    }

    public function currentPlan()
    {
        $user = auth()->user();
        $planSubscription = $user->planSubscription('vip');
        if (!$planSubscription) {
            abort(404, 'Tài khoản chưa đăng ký VIP');
        }
        $data = [
            'id' => $planSubscription->id,
            'name' => $planSubscription->name,
            'plan_id' => $planSubscription->plan_id,
            'starts_at' => $planSubscription->starts_at,
            'ends_at' => $planSubscription->ends_at,
            'is_active' => $planSubscription->active()
        ];

        return $this->json(['data' => $data]);
    }
}
