<?php

namespace Modules\Core\Http\Controllers\Admin;

use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Modules\Core\Services\Admin\BlogCategoryService;
use Modules\Core\Http\Requests\BlogCategoryCreateRequest;
use Modules\Core\Http\Requests\BlogCategoryUpdateRequest;

/**
 * @group Module Core
 *
 * APIs for managing endpoint core
 *
 * @subgroup Blog Category Management
 * @subgroupDescription BlogCategoryAdminController
 */
class BlogCategoryAdminController extends ApiController
{

    protected $blogCategoryService;
    public function __construct(BlogCategoryService $blogCategoryService)
    {
        $this->blogCategoryService = $blogCategoryService;
    }
    /**
     * Get List Blog Categories
     *
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->blogCategoryService->getList($request);
        return $this->json($data, 200);
    }

    /**
     * Create Blog Category
     *
     * Store a newly created resource in storage.
     * @param BlogCategoryCreateRequest $request
     * @return Response
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        $created = $this->blogCategoryService->create($request);
        $data = [
            'message' => __('core::message.blogcategory.create_success'),
            'data' => $created
        ];
        return $this->json($data);
    }

    /**
     * Find Blog Category
     *
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->blogCategoryService->find($id);
        return $this->json(['data' => $data]);
    }

    /**
     * Update Blog Category
     *
     * Update the specified resource in storage.
     * @param BlogCategoryUpdateRequest $request
     * @param int $id
     * @return Response
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        $updated = $this->blogCategoryService->update($request, $id);
        $data = [
            'message' => __('core::message.blogcategory.update_success'),
            'data' => $updated
        ];
        return $this->json($data);
    }

    /**
     * Delete Blog Category
     *
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $deleted = $this->blogCategoryService->delete($id);
        $data = [
            'message' => __('core::message.blogcategory.delete_success'),
        ];
        return $this->json($data);
    }
}
