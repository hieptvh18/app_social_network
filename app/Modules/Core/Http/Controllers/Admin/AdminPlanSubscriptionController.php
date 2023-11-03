<?php

namespace Modules\Core\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;
use Modules\Core\Services\Admin\BlogService;
use Modules\Core\Http\Requests\BlogCreateRequest;
use Modules\Core\Http\Requests\BlogUpdateRequest;
use Modules\Core\Services\Admin\AdminPlanSubscriptionService;

/**
 * @group Module Core
 *
 * APIs for managing endpoint core
 *
 * @subgroup AdminPlanSubscription Management
 * @subgroupDescription AdminPlanSubscriptionController
 */
class AdminPlanSubscriptionController extends ApiController
{

    protected $adminPlanSubscriptionService;
    public function __construct(AdminPlanSubscriptionService $adminPlanSubscriptionService)
    {
        $this->adminPlanSubscriptionService = $adminPlanSubscriptionService;
    }
    /**
     * Active Plan Subscription By Admin
     *
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function ActivePlanSubscriptionByAdmin(Request $request)
    {
        $plan_subscription = $this->adminPlanSubscriptionService->activePlanByAdmin($request);
        $data = [
            'message' => 'Bạn đã đăng kí vip thành công',
            'data' => $plan_subscription
        ];
        return $this->json($data, 200);
    }
}
