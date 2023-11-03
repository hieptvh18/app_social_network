<?php

namespace Modules\Core\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Models\RewardPoint;
use App\Http\Controllers\ApiController;
use Modules\Core\Services\UserMissionService;
use Modules\Core\Http\Requests\ReportMissionRequest;

/**
 * @group Module Core
 *
 * APIs for managing user missions
 *
 * @subgroup User mission Management
 * @subgroupDescription UserMissionController
 */
class UserMissionController extends ApiController
{
    protected $userMissionService;
    public function __construct(UserMissionService $userMissionService)
    {
        $this->userMissionService = $userMissionService;
    }
    /**
     * Danh sách nhiệm vụ đã nhận
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->userMissionService->getList($request);
        return $this->json($data, 200);
    }


    /**
     * Báo cáo kết quả nhiệm vụ user
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function reportMission(ReportMissionRequest $request)
    {
        $item = $this->userMissionService->reportMissionUser($request);
        $data = [
            'data' => $item
        ];
        return $this->json($data);
    }


    /**
     * User xem điểm thưởng
     *
     * @param Request $request
     * @return Response
     */
    public function getMyPoint(Request $request)
    {
        $user = auth()->user();
        $user_reward_point = RewardPoint::select('reward_point')->where('user_id', $user->id)->first();
        $reward_point = $user_reward_point->reward_point;
        $data = [
            'points' => $reward_point
        ];
        return $this->json($data);
    }
}
