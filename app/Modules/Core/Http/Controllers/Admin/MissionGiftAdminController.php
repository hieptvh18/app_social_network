<?php

namespace Modules\Core\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;
use Modules\Core\Http\Requests\MissionGiftCreateRequest;
use Modules\Core\Http\Requests\MissionGiftUpdateRequest;
use Modules\Core\Services\Admin\HistoryGiftAdminService;
use Modules\Core\Services\Admin\MissionGiftAdminService;

/**
 * @group Module Core
 *
 * APIs for managing endpoint core
 *
 * @subgroup Mission Gift Management
 * @subgroupDescription MissionGiftAdminController
 */
class MissionGiftAdminController extends ApiController
{

    protected $missionGiftAdminService;
    protected $historyGiftAdminService;
    public function __construct(MissionGiftAdminService $missionGiftAdminService, HistoryGiftAdminService $historyGiftAdminService)
    {
        $this->missionGiftAdminService = $missionGiftAdminService;
        $this->historyGiftAdminService = $historyGiftAdminService;
    }
    /**
     * Get List Mission Gift
     *
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->missionGiftAdminService->getList($request);
        return $this->json($data, 200);
    }

    /**
     * Create Mission Gift
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(MissionGiftCreateRequest $request)
    {
        $created = $this->missionGiftAdminService->create($request);
        $data = [
            'message' => __('core::message.mission_gift.create_success'),
            'data' => $created
        ];
        return $this->json($data);
    }

    /**
     * Find Miss
     *
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->missionGiftAdminService->find($id);
        return $this->json(['data' => $data]);
    }

    /**
     * Update Mission Gift
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(MissionGiftUpdateRequest $request, $id)
    {
        $updated = $this->missionGiftAdminService->update($request, $id);
        $data = [
            'message' => __('core::message.mission_gift.update_success'),
            'data' => $updated
        ];
        return $this->json($data);
    }

    /**
     * Delete Mission Gift
     *
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $deleted = $this->missionGiftAdminService->delete($id);
        $data = [
            'message' => __('core::message.mission_gift.delete_success'),
        ];
        return $this->json($data);
    }

    /**
     * Admin xem lịch sử đổi quà
     *
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function histories(Request $request)
    {
        $data = $this->historyGiftAdminService->getList($request);
        return $this->json($data, 200);
    }

    /**
     * Admin xem lịch sử nhận quà
     *
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function promotionGiftHistories(Request $request)
    {
        $data = $this->historyGiftAdminService->promotionGiftHistories($request);
        return $this->json($data, 200);
    }

    /**
     * Admin thay đổi trạng thái đổi quà tiền mặt
     *
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function changeStatusHistoryGift(Request $request, $id)
    {
        $data = $this->historyGiftAdminService->changeStatusHistoryGift($request, $id);
        return $this->json(['success' => $data], 200);
    }

}
