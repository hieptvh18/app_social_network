<?php

namespace Modules\Core\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;
use Modules\Core\Services\Admin\BlogTagService;
use Modules\Core\Http\Requests\BlogTagCreateRequest;
use Modules\Core\Http\Requests\BlogTagUpdateRequest;

/**
 * @group Module Core
 *
 * APIs for managing endpoint core
 *
 * @subgroup Blog Tag Management
 * @subgroupDescription BlogTagAdminController
 */
class BlogTagAdminController extends ApiController
{

    protected $blogTagService;
    public function __construct(BlogTagService $blogTagService)
    {
        $this->blogTagService = $blogTagService;
    }
    /**
     * Get List Blog Tag
     *
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->blogTagService->getList($request);
        return $this->json($data, 200);
    }

    /**
     * Create Blog Tag
     *
     * Store a newly created resource in storage.
     * @param BlogTagCreateRequest $request
     * @return Response
     */
    public function store(BlogTagCreateRequest $request)
    {
        $created = $this->blogTagService->create($request);
        $data = [
            'message' => __('core::message.blog_tag.create_success'),
            'data' => $created
        ];
        return $this->json($data);
    }

    /**
     * Find Blog Tag
     *
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->blogTagService->find($id);
        return $this->json(['data' => $data]);
    }

    /**
     * Update Blog Tag
     *
     * Update the specified resource in storage.
     * @param BlogTagUpdateRequest $request
     * @param int $id
     * @return Response
     */
    public function update(BlogTagUpdateRequest $request, $id)
    {
        $updated = $this->blogTagService->update($request, $id);
        $data = [
            'message' => __('core::message.blog_tag.update_success'),
            'data' => $updated
        ];
        return $this->json($data);
    }

    /**
     * Delete Blog Tag
     *
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $deleted = $this->blogTagService->delete($id);
        $data = [
            'message' => __('core::message.blog_tag.delete_success'),
        ];
        return $this->json($data);
    }
}
