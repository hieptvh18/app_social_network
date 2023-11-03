<?php

namespace Modules\Core\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Controllers\ApiController;
use Modules\Core\Http\Requests\ReportMissionRequest;
use Modules\Core\Services\Admin\UserMissionAdminService;

/**
 * @group Module Core
 *
 * APIs for managing endpoint core
 *
 * @subgroup Admin User Mission Management
 * @subgroupDescription UserMissionAdminController
 */
class UserMissionAdminController extends ApiController
{

    protected $userMissionAdminService;
    public function __construct(UserMissionAdminService $userMissionAdminService)
    {
        $this->userMissionAdminService = $userMissionAdminService;
    }
    /**
     * Danh sách nhiệm vụ đã được user nhận
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->userMissionAdminService->getList($request);
        return $this->json($data, 200);
    }

    /**
     * Phê duyệt nhiệm vụ
     *
     * Show the specified resource.
     * @param Request $request
     * @return Response
     */
    public function approveMission(Request $request)
    {
        $data = $this->userMissionAdminService->approveMission($request);
        return $this->json(['data' => $data]);
    }

    /**
     * từ chối phê duyệt nhiệm vụ
     *
     * Show the specified resource.
     * @param Request $request
     * @return Response
     */
    public function refusedApproveMission(Request $request)
    {
        $data = $this->userMissionAdminService->refusedApproveMission($request);
        return $this->json(['data' => $data]);
    }

    // /**
    //  * Update the specified resource in storage.
    //  * @param Request $request
    //  * @param int $id
    //  * @return Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     $item = $this->userMissionAdminService->update($request, $id);
    //     $data = [
    //         'message' => __('core::message.user_mission.update_success'),
    //         'data' => $item
    //     ];
    //     return $this->json($data);
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  * @param int $id
    //  * @return Response
    //  */
    // public function destroy($id)
    // {
    //     $item = $this->userMissionAdminService->delete($id);
    //     $data = [
    //         'message' => __('core::message.user_mission.delete_success'),
    //     ];
    //     return $this->json($data);
    // }
}
