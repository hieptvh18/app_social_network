<?php

namespace Modules\Core\Http\Controllers\Admin;

use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Modules\Core\Services\Admin\FaqService;
use Modules\Core\Http\Requests\FaqCreateRequest;
use Modules\Core\Http\Requests\FaqUpdateRequest;

/**
 * @group Module Core
 *
 * APIs for managing endpoint core
 *
 * @subgroup Faq Management
 * @subgroupDescription FaqAdminController
 */
class FaqAdminController extends ApiController
{
    protected $faqService;
    public function __construct(FaqService $faqService)
    {
        $this->faqService = $faqService;
    }
    /**
     * Get List Faq
     *
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->faqService->getList($request);
        return $this->json($data, 200);
    }

    /**
     * Create Faq
     *
     * Store a newly created resource in storage.
     * @param FaqCreateRequest $request
     * @return Response
     */
    public function store(FaqCreateRequest $request)
    {
        $created = $this->faqService->create($request);
        $data = [
            'message' => __('core::message.faq.create_success'),
            'data' => $created
        ];
        return $this->json($data);
    }

    /**
     * Find Faq
     *
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->faqService->find($id)->load('category');
        return $this->json(['data' => $data]);
    }

    /**
     * Update Faq
     *
     * Update the specified resource in storage.
     * @param FaqUpdateRequest $request
     * @param int $id
     * @return Response
     */
    public function update(FaqUpdateRequest $request, $id)
    {
        $updated = $this->faqService->update($request, $id);
        $data = [
            'message' => __('core::message.faq.update_success'),
            'data' => $updated
        ];
        return $this->json($data);
    }

    /**
     * Delete Faq
     *
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $deleted = $this->faqService->delete($id);
        $data = [
            'message' => __('core::message.faq.delete_success'),
        ];
        return $this->json($data);
    }
}
