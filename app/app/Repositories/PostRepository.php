<?php
namespace App\Repositories;

use App\Models\Follow;
use App\Models\Post;
use App\Models\PostImage;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class PostRepository implements PostRepositoryInterface
{
    public function getPostByFollowingId(){
        $followingId = Auth::id();
        $followingList = Follow::where('following_id',$followingId)->get('user_id');
        $array = $followingList->map(function ($item) {
            return $item->getAttributes();
        })->all();

        $posts = Post::whereIn('user_id',$array)->get();
        if ($posts) {
            return response()->json([
                'data' => $posts,
                'message' => 'Get post success',
                'success' => true,
            ]);
        }
        return response()->json([
            'data' => [],
            'message' => 'Post not found!',
            'success' => false,
        ]);
    }

    public function save($request){
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
?>
