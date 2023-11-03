<?php

namespace Modules\Core\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Controllers\ApiController;
use Modules\Core\Http\Requests\InfoMissionCreateRequest;
use Modules\Core\Http\Requests\InfoMissionUpdateRequest;
use Modules\Core\Services\Admin\InfoMissionAdminService;

/**
 * @group Module Core
 *
 * APIs for managing endpoint core
 *
 * @subgroup Info Mission Management
 * @subgroupDescription InfoMissionAdminController
 */
class InfoMissionAdminController extends ApiController
{

    protected $infoMissionAdminService;
    public function __construct(InfoMissionAdminService $infoMissionAdminService)
    {
        $this->infoMissionAdminService = $infoMissionAdminService;
    }
    /**
     * Danh sách thông tin nhiệm vụ
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->infoMissionAdminService->getList($request);
        return $this->json($data, 200);
    }

    /**
     * Tạo thông tin nhiệm vụ
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(InfoMissionCreateRequest $request)
    {
        $item = $this->infoMissionAdminService->create($request);
        $data = [
            'message' => __('core::message.info_mission.create_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Chi tiết thông tin nhiệm vụ
     *
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->infoMissionAdminService->find($id)->load(['mission_gift']);
        return $this->json(['data' => $data]);
    }

    /**
     * Sửa thông tin nhiệm vụ
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(InfoMissionUpdateRequest $request, $id)
    {
        $item = $this->infoMissionAdminService->update($request, $id);
        $data = [
            'message' => __('core::message.info_mission.update_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Xóa thông tin nhiệm vụ
     *
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = $this->infoMissionAdminService->delete($id);
        $data = [
            'message' => __('core::message.info_mission.delete_success'),
        ];
        return $this->json($data);
    }
}
