<?php
namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
    public function getPostByFollowingId($following_id){
        $posts = Post::where('user_id',$following_id)->get();
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

}
?>
