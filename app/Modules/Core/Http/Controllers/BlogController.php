<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Services\BlogService;
use App\Http\Controllers\ApiController;
use Modules\Core\Models\Blog;
use Modules\Core\Services\BlogCategoryService;

/**
 * @group Module Core
 *
 * APIs for managing endpoint core
 *
 * @subgroup Blog Public Management
 * @subgroupDescription BlogController
 */
class BlogController extends ApiController
{
    protected $blogService, $blogCategoryService;
    public function __construct(BlogService $blogService, BlogCategoryService $blogCategoryService)
    {
        $this->blogService = $blogService;
        $this->blogCategoryService = $blogCategoryService;
    }

    /**
     * Danh sách tin tức nổi bật
     *
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function getListFeatured(Request $request)
    {
        $data = $this->blogService->getListBlogFeatured($request);
        return $this->json(['blogs' => $data], 200);
    }

    /**
     * Danh sách danh mục, tin tức trên trang chủ
     *
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function categoryBlogHomepage(Request $request)
    {
        $data = $this->blogCategoryService->categoryBlogShowHomepage($request);
        return $this->json(['categories' => $data], 200);
    }

    /**
     * Danh sách tin tức xem nhiều
     *
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function mostViewBlogs(Request $request)
    {
        $data = $this->blogService->mostViewBlog($request);
        return $this->json(['data' => $data], 200);
    }

    /**
     * Chi tiết tin tức
     *
     * Show the specified resource.
     * @param string $alias
     * @return Response
     */
    public function showBlogByAlias($alias)
    {
        $data = $this->blogService->findPublicBlog($alias);
        return $this->json(['data' => $data], 200);
    }

    /**
     * Get SEO tin tức
     *
     * Show the specified resource
     * @param string $alias
     * @return Response
     */
    public function getBlogMetaSeo($alias)
    {
        $data = Blog::select('id', 'alias', 'meta_title', 'meta_description', 'meta_keyword', 'meta_url', 'image_thumbnail')->where('alias', $alias)->firstOrFail();
        return $this->json(['data' => $data], 200);
    }

    /**
     * Danh sách tin tức theo danh mục
     *
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function blogByCategory(Request $request)
    {
        $data = $this->blogService->getBlogByCategory($request);
        return $this->json($data, 200);
    }

    /**
     * Chi tiết danh mục tin tức
     *
     * Show the specified resource.
     * @param string $alias
     * @return Response
     */
    public function blogCategoryByAlias($alias)
    {
        $data = $this->blogCategoryService->findCategoryByAlias($alias);
        return $this->json(['data' => $data], 200);
    }

    /**
     * Danh sách bài viết liên quan
     *
     * Display a listing of the resource.
     * @param int $blog_id
     * @return Response
     */
    public function replatedBlogs($blog_id)
    {
        $data = $this->blogService->getRelatedBlog($blog_id);
        return $this->json(['data' => $data], 200);
    }
}
