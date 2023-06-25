<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PostRepositoryInterface;


class PostController extends Controller
{
    protected $postRepository;
    public function __construct(PostRepositoryInterface $postRepositoryInterface){
       $this->postRepository = $postRepositoryInterface;
    }
    public function getPostByFollowingId(){

        return $this->postRepository->getPostByFollowingId();
    }
}
