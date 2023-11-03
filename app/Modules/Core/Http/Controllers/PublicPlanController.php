<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Core\Services\PlanService;
use App\Http\Controllers\ApiController;
use Illuminate\Contracts\Support\Renderable;

/**
 * @group Module Core
 *
 * APIs for public plans core
 *
 * @subgroup Public Api
 * @subgroupDescription PublicPlanController
 */
class PublicPlanController extends ApiController
{
    protected $planService;

    public function __construct(PlanService $planService)
    {
        $this->planService = $planService;
    }

    /**
     * Get Public Plans
     *
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user_type = $request->query('user_type', 'STUDENT');
        $bizapp = $request->query('bizapp', 'EDUQUIZ');
        $data = $this->planService->getPublicPlans($user_type, $bizapp);
        return $this->json(['data' => $data], 200);
    }

    // public function registerPlan(Request $request)
    // {

    //     // $data = $this->planService->activePlanByUser($request);
    //     $subscription = auth()->user()->planSubscription('main');
    //     // $subscription->cancel(true);
    //     // dd(auth()->user()->subscribedTo(1));
    //     // $subscription->recordFeatureUsage('listings');
    //     // dd($subscription->getFeatureRemainings('listings'));
    //     return $this->json(['data' => $subscription]);
    // }

    public function currentPlan(){
        $data=$this->planService->getCurrentPlan();
        return $this->json(['data'=>$data]);
    }
}
