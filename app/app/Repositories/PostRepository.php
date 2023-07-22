<?php

namespace App\Repositories;

use App\Models\Follow;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\LikePost;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostRepository extends AbstractApi implements PostRepositoryInterface
{
    public function getPostByFollowingId()
    {
        try{
            $userId = Auth::id();

            $followingList = Follow::where('user_id', $userId)->get('following_id');
    
            $posts = Post::query()
                ->whereIn('user_id', $followingList)
                ->orWhere('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->with(
                    [
                        'images' => function ($query) {
                            $query->select('id', 'image', 'post_id');
                        },
                        'author' => function ($query) {
                            $query->select('id', 'username', 'avatar');
                        }
                    ]
                )
                ->withCount('comments')
                ->get();
    
            if ($posts->isEmpty()) {
                return $this->respError([],'No posts found from the users you are following.');
            }
    
            foreach ($posts as $post) {
                $post->likes;
            }
    
            return $this->respSuccess(['data'=>$posts],'Get posts success');
        }catch(\Throwable $e){
            $this->respError([],'Something went wrong when fetch posts of friend! '.$e->getMessage());
        }
    }

    public function save($request)
    {
        if (!$request->captions && !$request->images) {
            return $this->respError(['data'=>$request->all()],'Data is not valid!');
        }
        try {
            // lưu post
            $post = new Post();
            $post->user_id = Auth::id();
            $post->captions = $request->captions;
            $post->save();

            if (!empty($request->images)) {
                foreach ($request->images as $image) {
                    $postImg = new PostImage();
                    $postImg->post_id = $post->id;
                    $postImg->image = $image;
                    $postImg->save();
                }
            }
           
            return $this->respSuccess(['data'=>$post,'Create post success!']);
        } catch (\Throwable $th) {
            report($th);
            return $this->respError([],'Something went wrong when save post! '.$th->getMessage());
        }
    }

    public function getById($postId)
    {
        try {
            if (!$postId) {
                return $this->respError([],'Missing param postId!');
            }

            $post = Post::find($postId);
            $data = [
                'contents' => [
                    'id' => $post->id,
                    'captions' => $post->captions,
                    'created_at' => $post->created_at->format('Y-m-d'),
                    'updated_at' => $post->updated_at->format('Y-m-d'),
                ],
                'author' => [
                    'username' => $post->author->name,
                    'avatar' => $post->author->avatar,
                ],
                'images' => $post->images
            ];
            $this->respSuccess(['data'=>$data],'Get post by id success!');
        } catch (\Throwable $e) {
            $this->respError([],'Something went wrong when get post by id! '.$e->getMessage());
        }
    }

    public function likePost($userId, $postId)
    {
        try {
            $isLiked = LikePost::where('user_id', $userId)
                ->where('post_id', $postId)
                ->exists();
            if ($isLiked) {
                // reset like
                LikePost::where('user_id', $userId)
                    ->where('post_id', $postId)
                    ->delete();

                $this->respSuccess([],'unLike');
            }

            $likePost = new LikePost();
            $likePost->user_id = $userId;
            $likePost->post_id = $postId;
            $likePost->save();

            $this->respSuccess(['data'=>$likePost],'like');
        } catch (\Throwable $e) {
            report($e->getMessage());
            $this->respError([],'Something went wrong when like! '.$e->getMessage());
        }
    }
}
