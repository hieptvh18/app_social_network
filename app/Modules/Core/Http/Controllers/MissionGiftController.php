<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;
use Modules\Core\Services\MissionGiftPublicService;

/**
 * @group Module Core
 *
 * APIs for managing public mission gifts
 *
 * @subgroup Public mission gift Management
 * @subgroupDescription MissionGiftController
 */
class MissionGiftController extends ApiController
{
    protected $missionGiftPublicService;
    public function __construct(MissionGiftPublicService $missionGiftPublicService)
    {
        $this->missionGiftPublicService = $missionGiftPublicService;
    }
    /**
     * Danh sách phần thưởng đổi quà
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->missionGiftPublicService->getList($request);
        return $this->json($data, 200);
    }

    /**
     * Đổi thưởng
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function giftExchange(Request $request)
    {
        $data = $this->missionGiftPublicService->userGiftExchange($request);
        return $this->json(['success' => $data]);
    }

    /**
     * Thông báo admin đổi thưởng tiền mặt
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function notifyMissionGifMoney(Request $request)
    {
        $data = $this->missionGiftPublicService->notifyMissionGifMoney($request);
        return $this->json(['success' => $data]);
    }

}
