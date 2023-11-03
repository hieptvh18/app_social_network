<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Services\CustomerFeedbackPublicService;

/**
 * @group Module Core
 * APIs for CustomerFeedbackPublic
 *
 *
 * @subgroup public phản hồi của khách hàng 
 * @subgroupDescription Class CustomerFeedbackAdminController.
 * @package namespace Modules\Core\Http\Controllers\Admin;
 */ 

class CustomerFeedbackPublicController extends ApiController
{
    protected $customerFeedbackPublicService;

    public function __construct(CustomerFeedbackPublicService $customerFeedbackPublicService)
    {
        $this->customerFeedbackPublicService = $customerFeedbackPublicService;
    }

    /**
     * danh sách công khai phản hồi khách hàng 
     * 
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $data = $this->customerFeedbackPublicService->getList($request);
        return $this->json($data);
    }
}
