<?php

namespace App\Repositories;

use App\Models\Follow;
use App\Models\Post;
use App\Models\PostImage;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class PostRepository implements PostRepositoryInterface
{
    public function getPostByFollowingId()
    {
        $userId = Auth::id();

        // Lấy danh sách người mà người dùng đang theo dõi
        $followingList = Follow::where('user_id', $userId)->get('following_id');

        // Kiểm tra nếu danh sách người đang theo dõi rỗng
        if ($followingList->isEmpty()) {
            return response()->json([
                'data' => [],
                'message' => 'You are not following anyone.',
                'success' => false,
            ]);
        }

        // Lấy danh sách bài viết từ những người mà người dùng đang theo dõi hoặc từ chính người dùng đang đăng nhập
        $posts = Post::whereIn('user_id', $followingList)
            ->orWhere('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Kiểm tra nếu danh sách bài viết rỗng
        if ($posts->isEmpty()) {
            return response()->json([
                'data' => [],
                'message' => 'No posts found from the users you are following.',
                'success' => false,
            ]);
        }

        return response()->json([
            'data' => $posts,
            'message' => 'Get post success',
            'success' => true,
        ]);
    }

    public function save($request)
    {
        $dataResponse = ['status' => true, 'data' => [], 'message' => ""];
        if (!$request->captions || !$request->tags) {
            return response()->json([
                'status' => false,
                'message' => 'Data is not valid!',
                'data' => $request->all()
            ]);
        }
        try {
            // lưu post
            $post = new Post();
            $post->user_id = Auth::id();
            $post->captions = $request->input('captions');
            $post->tags = $request->input('tags');
            $post->save();

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $filename = $image->store('images'); // Lưu ảnh vào thư mục "storage/app/images"
                    $postImg = new PostImage();
                    $postImg->post_id = $post->id;
                    $postImg->image = $filename;
                    $postImg->save();
                }
            }
            $dataResponse['data'] = $request->all();
            $dataResponse['message'] = 'Create post success!';
            return response()->json($dataResponse);
        } catch (\Throwable $th) {
            report($th);
            $dataResponse['status'] = false;
            $dataResponse['message'] = 'Error: ' . $th->getMessage();
            return response()->json($dataResponse);
        }
    }
}
