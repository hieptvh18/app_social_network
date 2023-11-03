<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Services\ActivityLogService;

/**
 * @group Module Core
 *
 * APIs for activity log core
 *
 * @subgroup Lịch sử hoạt động
 * @subgroupDescription ActivityLogController
 */
class ActivityLogController extends ApiController
{
    protected $activityLogService;

    /**
     * Class constructor.
     */
    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    /**
     * getListByAdmin
     *
     * Display a listing of the resource.
     * @return Renderable
     */
    public function getListByAdmin(Request $request)
    {
        $data = $this->activityLogService->getList($request);
        return $this->json($data);
    }
}
