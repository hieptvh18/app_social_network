<?php

namespace Modules\Core\Services;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Modules\Core\Models\PlanFeature;
use Modules\Order\Services\OrderService;
use Modules\Core\Repositories\PlanRepository;

class PlanService extends BaseService
{

    protected $orderService;

    public function __construct(PlanRepository $repository, OrderService $orderService)
    {
        $this->baseRepository = $repository;
        $this->orderService = $orderService;
    }
    // Admin
    public function create(Request $request)
    {
        try {
            $data = $request->all();
            DB::beginTransaction();
            $plan = $this->baseRepository->create($data);
            $features = array_map(function ($feature) {
                return new PlanFeature($feature);
            }, $data['features']);
            $plan->features()->saveMany($features);
            DB::commit();
            return $plan;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    // Dashboard Admin
    public function getListUserPlanExpired()
    {
        $this->limit = request()->query('size') ?? 12;
        $users_plan_expried = User::with('planSubscriptions')->whereHas('planSubscriptions', function ($query) {
            $query->whereBetween('ends_at', [Carbon::now(), Carbon::now()->addDays(7)]);
        })->paginate($this->limit);
        return $users_plan_expried;
    }

    //user public

    public function getCurrentPlan()
    {
        $user = auth()->user();
        // $plan_id = $user->planSubscription('main')->plan_id;
        // $plan = $this->baseRepository->find($plan_id);
        return $user->planSubscription('vip');
    }

    public function getPublicPlans($user_type = 'STUDENT', $bizapp = 'EDUQUIZ')
    {

        $data = $this->baseRepository->where([
            'user_type' => $user_type,
            'bizapp' => $bizapp,
            'is_active' => true
        ])->get();
        return $data;
    }
}
