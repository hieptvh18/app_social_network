<?php
namespace App\Repositories;

use App\Models\Follow;
use App\Models\Post;
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

}
?>
