<?php

namespace Modules\Core\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;
use Modules\Core\Services\Admin\BlogService;
use Modules\Core\Http\Requests\BlogCreateRequest;
use Modules\Core\Http\Requests\BlogUpdateRequest;

/**
 * @group Module Core
 *
 * APIs for managing endpoint core
 *
 * @subgroup Blog Management
 * @subgroupDescription BlogAdminController
 */
class BlogAdminController extends ApiController
{

    protected $blogService;
    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }
    /**
     * Get List Blog
     *
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->blogService->getList($request);
        return $this->json($data, 200);
    }

    /**
     * Create Blog
     *
     * Store a newly created resource in storage.
     * @param BlogCreateRequest $request
     * @return Response
     */
    public function store(BlogCreateRequest $request)
    {
        $created = $this->blogService->create($request);
        $data = [
            'message' => __('core::message.blog.create_success'),
            'data' => $created
        ];
        return $this->json($data);
    }

    /**
     * Find Blog
     *
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->blogService->find($id)->load(['categories', 'tags']);
        return $this->json(['data' => $data]);
    }

    /**
     * Update Blog
     *
     * Update the specified resource in storage.
     * @param BlogUpdateRequest $request
     * @param int $id
     * @return Response
     */
    public function update(BlogUpdateRequest $request, $id)
    {
        $updated = $this->blogService->update($request, $id);
        $data = [
            'message' => __('core::message.blog.update_success'),
            'data' => $updated
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
        $deleted = $this->blogService->delete($id);
        $data = [
            'message' => __('core::message.blog.delete_success'),
        ];
        return $this->json($data);
    }
}
