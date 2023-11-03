<?php

namespace Modules\Core\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Controllers\ApiController;
use Modules\Core\Http\Requests\BizappCreateRequest;
use Modules\Core\Http\Requests\BizappUpdateRequest;
use Modules\Core\Services\Admin\BizappAdminService;

/**
 * @group Module Core
 *
 * APIs for managing endpoint core
 *
 * @subgroup Bizapp Management
 * @subgroupDescription BizappAdminController
 */
class BizappAdminController extends ApiController
{
    protected $bizappAdminService;
    public function __construct(BizappAdminService $bizappAdminService)
    {
        $this->bizappAdminService = $bizappAdminService;
    }

   /**
     * Get List bizapp
     *
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->bizappAdminService->getList($request);
        return $this->json($data, 200);
    }

    /**
     * Create bizapp
     *
     * Store a newly created resource in storage.
     * @param BizappCreateRequest $request
     * @return Response
     */
    public function store(BizappCreateRequest $request)
    {
        $created = $this->bizappAdminService->create($request);
        $data = [
            'message' => __('core::message.bizapp.create_success'),
            'data' => $created
        ];
        return $this->json($data);
    }

    /**
     * Find bizapp
     *
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->bizappAdminService->find($id);
        return $this->json(['data' => $data]);
    }

    /**
     * Update Blog
     *
     * Update the specified resource in storage.
     * @param BizappUpdateRequest $request
     * @param int $id
     * @return Response
     */
    public function update(BizappUpdateRequest $request, $id)
    {
        $item = $this->bizappAdminService->update($request, $id);
        $data = [
            'message' => __('core::message.bizapp.update_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Delete Blog
     *
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $deleted = $this->bizappAdminService->delete($id);
        $data = [
            'message' => __('core::message.bizapp.delete_success'),
        ];
        return $this->json($data);
    }
}
