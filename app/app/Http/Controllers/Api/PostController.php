<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepositoryInterface){
       $this->postRepository = $postRepositoryInterface;
    }

    public function getPostByFollowingId(){

        return $this->postRepository->getPostByFollowingId();
    }

    public function savePost(Request $request){

        return $this->postRepository->save($request);
    }

    public function getById($postId){
        return $this->postRepository->getById($postId);
    }
}
