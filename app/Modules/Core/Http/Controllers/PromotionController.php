<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;
use Modules\Core\Models\Blog;
use Modules\Core\Services\PromotionService;

/**
 * @group Module Core
 *
 * APIs for managing endpoint core
 *
 * @subgroup Promotion Public Management
 * @subgroupDescription PromotionController
 */
class PromotionController extends ApiController
{
    protected $promotionService;
    public function __construct(PromotionService $promotionService)
    {
        $this->promotionService = $promotionService;
    }

    /**
     * Danh sách chương trình khuyến mại
     *
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function getListPromotion(Request $request)
    {
        $data = $this->promotionService->getListPromotion($request);
        return $this->json(['data' => $data], 200);
    }


    /**
     * Chi tiết chương trình khuyến mại
     *
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function showPromotion($id)
    {
        $data = $this->promotionService->find($id);
        return $this->json(['data' => $data], 200);
    }

    /**
     * Tham gia chương trình khuyến mại
     *
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function joinPromotion($id)
    {
        $data = $this->promotionService->joinPromotion($id);
        return $this->json(['data' => $data], 200);
    }

}
