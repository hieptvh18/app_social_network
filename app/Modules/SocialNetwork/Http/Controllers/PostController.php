<?php

namespace Modules\SocialNetwork\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\SocialNetwork\Services\PostService;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
       $this->postService = $postService;
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
