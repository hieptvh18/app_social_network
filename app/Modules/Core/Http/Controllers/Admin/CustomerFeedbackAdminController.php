<?php

namespace Modules\Core\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Requests\CustomerFeedbackCreateRequest;
use Modules\Core\Http\Requests\CustomerFeedbackUpdateRequest;
use Modules\Core\Services\Admin\CustomerFeedbackAdminService;

/**
 * @group Module Core
 * APIs for CustomerFeedback
 *
 *
 * @subgroup admin quản lí phản hồi của khách hàng 
 * @subgroupDescription Class CustomerFeedbackAdminController.
 * @package namespace Modules\Core\Http\Controllers\Admin;
 */

class CustomerFeedbackAdminController extends ApiController
{
    protected $customerFeedbackAdminService;

    public function __construct(CustomerFeedbackAdminService $customerFeedbackAdminService)
    {
        $this->customerFeedbackAdminService = $customerFeedbackAdminService;
    }
    /**
     * Danh sách phản hồi của khách hàng 
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->customerFeedbackAdminService->getList($request);
        return $this->json($data);
    }

    /**
     * Thêm phản hồi của khách hàng 
     *
     * Store a newly created resource in storage.
     * @param CustomerFeedbackCreateRequest $request
     * @return Response
     */
    public function store(CustomerFeedbackCreateRequest $request)
    {
        
        $item = $this->customerFeedbackAdminService->create($request);
        $data = [
            'message' => __('core::message.customer_feedback.create_success'),
            'data' => $item
        ];
        return $this->json($data);
    }
    
    /**
     * Chi tiết phản hồi của khách hàng 
     *
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->customerFeedbackAdminService->find($id);
        return $this->json(['data' => $data]);
    }

    /**
     * Cập nhật phản hồi của khách hàng 
     *
     * Update the specified resource in storage.
     * @param CustomerFeedbackUpdateRequest $request
     * @param int $id
     * @return Response
     */
    public function update(CustomerFeedbackUpdateRequest $request, $id)
    {
        $item = $this->customerFeedbackAdminService->update($request, $id);
        $data = [
            'message' => __('core::message.customer_feedback.updated_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Xóa phản hồi của khách hàng  
     *
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $deleted = $this->customerFeedbackAdminService->delete($id);
        $data = [
            'message' => __('core::message.customer_feedback.deleted_success'),
            'deleted' => $deleted
        ];
        return $this->json($data);
    }
}
