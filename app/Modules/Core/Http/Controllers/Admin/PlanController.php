<?php

namespace Modules\Core\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Knuckles\Scribe\Attributes\Group;
use Modules\Core\Http\Requests\PlanCreateRequest;
use Modules\Core\Http\Requests\PlanUpdateRequest;
use Modules\Core\Services\PlanService;


/**
 * @group Module Core
 *
 * APIs for managing endpoint core
 *
 * @subgroup Plan Management
 * @subgroupDescription PlanController
 */

class PlanController extends Controller
{

    protected $planService;

    public function __construct(PlanService $planService)
    {
        $this->planService = $planService;
    }
    /**
     * Get List Plan
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->planService->getList($request);
        return response()->json($data);
    }

    /**
     * Create Plan
     *
     * Store a newly created resource in storage.
     * @param PlanCreateRequest $request
     * @return Response
     */
    public function store(PlanCreateRequest $request)
    {
        $item = $this->planService->create($request);
        return response()->json([
            'data' => $item
        ]);
    }

    /**
     * Find Plan
     *
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {

        $item = $this->planService->find($id);
        // $item = $this->planService->activePlanByUser($id);
        return response()->json(['data' => $item]);
    }

    /**
     * Update Plan
     *
     * Update the specified resource in storage.
     * @param PlanUpdateRequest $request
     * @param int $id
     * @return Response
     */
    public function update(PlanUpdateRequest $request, $id)
    {
        $item = $this->planService->update($request, $id);
        return response()->json([
            'data' => $item
        ]);
    }

    /**
     * Delete Plan
     *
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $deleted = $this->planService->delete($id);
        return response()->json(['data' => $deleted]);
    }
}
