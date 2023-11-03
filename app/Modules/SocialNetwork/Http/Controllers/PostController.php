<?php

namespace Modules\SocialNetwork\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\SocialNetwork\Repositories\PostRepository;
use Modules\SocialNetwork\Services\PostService;

class PostController extends Controller
{
    protected $postService;

    protected $baseRepository;

    public function __construct(
        PostService $postService,
        PostRepository $baseRepository
    )
    {
       $this->postService = $postService;
       $this->baseRepository = $baseRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPostByFollowingId(){
        return $this->postService->getPostByFollowingId();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function savePost(Request $request){
        return $this->postService->save($request);
    }

        /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id){
        return $this->baseRepository->delete($id);
    }

    /**
     * @param $postId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getById($postId){
        return $this->postService->getById($postId);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function likePost($id){
        return $this->postService->likePost($id);
    }
}
