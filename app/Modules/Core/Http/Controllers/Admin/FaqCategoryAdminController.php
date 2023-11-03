<?php

namespace Modules\Core\Http\Controllers\Admin;

use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Modules\Core\Services\Admin\FaqCategoryService;
use Modules\Core\Http\Requests\FaqCategoryCreateRequest;
use Modules\Core\Http\Requests\FaqCategoryUpdateRequest;

/**
 * @group Module Core
 *
 * APIs for managing endpoint core
 *
 * @subgroup Faq Category Management
 * @subgroupDescription FaqCategoryAdminController
 */
class FaqCategoryAdminController extends ApiController
{

    protected $faqCateService;
    public function __construct(FaqCategoryService $faqCateService)
    {
        $this->faqCateService = $faqCateService;
    }
    /**
     * Get List Faq Categories
     *
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->faqCateService->getList($request);
        return $this->json($data, 200);
    }

    /**
     * Create Faq Category
     *
     * Store a newly created resource in storage.
     * @param FaqCategoryCreateRequest $request
     * @return Response
     */
    public function store(FaqCategoryCreateRequest $request)
    {
        $created = $this->faqCateService->create($request);
        $data = [
            'message' => __('core::message.faqcategory.create_success'),
            'data' => $created
        ];
        return $this->json($data);
    }

    /**
     * Find Faq Category
     *
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->faqCateService->find($id);
        return $this->json(['data' => $data]);
    }

    /**
     * Update Faq Category
     *
     * Update the specified resource in storage.
     * @param FaqCategoryUpdateRequest $request
     * @param int $id
     * @return Response
     */
    public function update(FaqCategoryUpdateRequest $request, $id)
    {
        $updated = $this->faqCateService->update($request, $id);
        $data = [
            'message' => __('core::message.faqcategory.update_success'),
            'data' => $updated
        ];
        return $this->json($data);
    }

    /**
     * Delete Faq Category
     *
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $deleted = $this->faqCateService->delete($id);
        $data = [
            'message' => __('core::message.faqcategory.delete_success'),
        ];
        return $this->json($data);
    }
}
