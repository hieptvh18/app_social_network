<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\PostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    protected $postRepository;
    public function __contruct(PostRepositoryInterface $postRepositoryInterface){
       $this->postRepository = $postRepositoryInterface;
    }
    public function getPostByFollowingId(){
        // $followingId = Auth::id();
        // $followingList = Follow::where('following_id',$followingId)->get('user_id');
        // $array = $followingList->map(function ($item) {
        //     return $item->getAttributes();
        // })->all();

        // $posts = Post::whereIn('user_id',$array)->get();
        // if ($posts) {
        //     return response()->json([
        //         'data' => $posts,
        //         'message' => 'Get post success',
        //         'success' => true,
        //     ]);
        // }
        // return response()->json([
        //     'data' => [],
        //     'message' => 'Post not found!',
        //     'success' => false,
        // ]);
            return $this->postRepository->getPostByFollowingId();
    }
}
