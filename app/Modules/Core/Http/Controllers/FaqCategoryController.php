<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;
use Modules\Core\Services\FaqCategoryService;

/**
 * @group Module Core
 *
 * APIs for managing endpoint core
 *
 * @subgroup Public Api
 * @subgroupDescription PlanController
 */
class FaqCategoryController extends ApiController
{

    protected $faqCateService;
    public function __construct(FaqCategoryService $faqCateService)
    {
        $this->faqCateService = $faqCateService;
    }
    /**
     * Get Faq Categories
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = $this->faqCateService->getFaqCate();
        return $this->json(['data' => $data], 200);
    }


    /**
     * Get Faq By Category
     *
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function faqByCate($id)
    {
        $data = $this->faqCateService->getFaqByCate($id);
        return $this->json(['data' => $data]);
    }
}
