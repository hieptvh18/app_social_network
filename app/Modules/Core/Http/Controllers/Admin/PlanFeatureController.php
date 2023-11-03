<?php

namespace Modules\Core\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Http\Requests\PlanFeatureCreateRequest;
use Modules\Core\Http\Requests\PlanFeatureUpdateRequest;
use Modules\Core\Services\Admin\PlanFeatureService;

/**
 * @group Module Core
 *
 * APIs for managing endpoint core
 *
 * @subgroup PlanFeature Management
 * @subgroupDescription PlanFeatureController
 */
class PlanFeatureController extends ApiController
{

    protected $planFeatureService;

    public function __construct(PlanFeatureService $planFeatureService)
    {
        $this->planFeatureService = $planFeatureService;
    }

    /**
     * Lấy danh sách feature
     *
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $data = $this->planFeatureService->getList($request);
        return $this->json($data, 200);
    }

    /**
     * Thêm mới feature
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(PlanFeatureCreateRequest $request)
    {
        $created = $this->planFeatureService->create($request);
        $data = [
            'data' => $created
        ];
        return $this->json($data);
    }

    /**
     * Lấy chi tiết feature
     *
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $data = $this->planFeatureService->find($id);
        return $this->json(['data' => $data]);
    }

    /**
     * Cập nhật feature
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(PlanFeatureUpdateRequest $request, $id)
    {
        $updated = $this->planFeatureService->update($request, $id);
        $data = [
            'data' => $updated
        ];
        return $this->json($data);
    }

    /**
     * Xoá feature
     *
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $deleted = $this->planFeatureService->delete($id);
        $data = [
            'deleted' => $deleted
        ];
        return $this->json($data);
    }
}
