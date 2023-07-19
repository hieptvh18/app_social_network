<?php

namespace App\Repositories;

use App\Models\Follow;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\LikePost;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;

class PostRepository implements PostRepositoryInterface
{
    public function getPostByFollowingId()
    {
        $userId = Auth::id();

        // Lấy danh sách người mà người dùng đang theo dõi
        $followingList = Follow::where('user_id', $userId)->get('following_id');

        // Lấy danh sách bài viết từ những người mà người dùng đang theo dõi hoặc từ chính người dùng đang đăng nhập
        $posts = Post::whereIn('user_id', $followingList)
            ->orWhere('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->with(['author'])
            ->get();

        // Kiểm tra nếu danh sách bài viết rỗng
        if ($posts->isEmpty()) {
            return response()->json([
                'data' => [],
                'message' => 'No posts found from the users you are following.',
                'success' => false,
            ]);
        }

        // handle data res
        if(count($posts)){
            foreach($posts as $post){
                $post->likes;
                $post->images;
            }
        }

        return response()->json([
            'data' => $posts,
            'message' => 'Get post success',
            'success' => true,
        ]);
    }

    public function save($request)
    {
        $dataResponse = ['success' => true, 'data' => [], 'message' => ""];
        if (!$request->captions && !$request->images) {
            return response()->json([
                'success' => false,
                'message' => 'Data is not valid!',
                'data' => $request->all()
            ]);
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
            $dataResponse['data'] = $request->all();
            $dataResponse['message'] = 'Create post success!';
            return response()->json($dataResponse);
        } catch (\Throwable $th) {
            report($th);
            $dataResponse['success'] = false;
            $dataResponse['message'] = 'Error: ' . $th->getMessage();
            return response()->json($dataResponse);
        }
    }

    public function getById($postId){
        try{
            if(!$postId){
                return response()->json([
                    'success'=>false,
                    'message'=>'Missing param postId!',
                    'data'=>[]
                ]);
            }

            $post = Post::find($postId);
            return response()->json([
                'success'=>true,
                'message'=>'Get post by id success!',
                'data'=>[
                    'contents'=>[
                        'id'=>$post->id,
                        'captions'=>$post->captions,
                        'created_at'=>$post->created_at->format('Y-m-d'),
                        'updated_at'=>$post->updated_at->format('Y-m-d'),
                    ],
                    'author'=> [
                        'username'=>$post->author->name,
                        'avatar'=>$post->author->avatar,
                    ],
                    'images'=>$post->images
                ]
            ]);
        }catch(\Exception $e){
            return response()->json([
                'success'=>false,
                'message'=>'Get post by id fail!',
                'data'=>[]
            ]);
        }
    }

    public function likePost($userId, $postId)
    {
        try{
            $isLiked = LikePost::where('user_id',$userId)
                    ->where('post_id',$postId)
                    ->exists();
            if($isLiked){
                // reset like
                LikePost::where('user_id',$userId)
                ->where('post_id',$postId)
                ->delete();

                return response()->json([
                    'success'=>true,
                    'message'=>'unLike',
                    'data'=>[]
                ]);
            }

             $likePost = new LikePost();
             $likePost->user_id = $userId;
             $likePost->post_id = $postId;
             $likePost->save();

             return response()->json([
                'success'=>true,
                'message'=>'like',
                'data'=>$likePost
             ]);
        }catch(Exception $e){
            report($e->getMessage());
            return response()->json([
                'success'=>false,
                'message'=>'Like post fail: '.$e->getMessage(),
                'data'=>[]
            ]);
        }
    }
}
