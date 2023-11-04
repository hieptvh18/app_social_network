<?php

namespace Modules\SocialNetwork\Services;

use App\Http\Controllers\Api\AbstractApi;
use Illuminate\Support\Facades\Auth;
use Modules\SocialNetwork\Models\Follow;
use Modules\SocialNetwork\Models\Post;
use Modules\SocialNetwork\Models\PostImage;
use Modules\SocialNetwork\Repositories\PostRepository;
use Symfony\Component\HttpFoundation\Response;

class PostService extends AbstractApi
{
    protected $baseRepository;

    public function __construct(PostRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
    }

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
                        },
                        'likers'
                    ]
                )
                ->withCount(['comments'])
                ->get();

            if ($posts->isEmpty()) {
                return $this->respError([],'No posts found from the users you are following.');
            }

            return $this->respSuccess(['data'=>$posts],'Get posts success');
        }catch(\Throwable $e){
            return $this->respError([],'Something went wrong when fetch posts of friend! '.$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
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
            return $this->respError([],'Something went wrong when save post! '.$th->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getById($postId)
    {
        try {
            if (!$postId) {
                return $this->respError([],'Missing param postId!');
            }

            $post = $this->baseRepository->with(['likers','comments'=>function($q){
                                $q->with('user');
                            }])
                    ->where('id',$postId)->first();

                    $data = [
                'id'=>$post->id,
                'caption'=>$post->captions,
                'comments'=> $post->comments,
                'likers'=> $post->likers,
                'contents' => [
                    'id' => $post->id,
                    'captions' => $post->captions,
                ],
                'author' => [
                    'username' => $post->author->name,
                    'avatar' => $post->author->avatar,
                ],
                'images' => $post->images,
                'created_at'=>$post->created_at
            ];
            return $this->respSuccess(['data'=>$data],'Get post by id success!');
        } catch (\Throwable $e) {
            return $this->respError([],'Something went wrong when get post by id! '.$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function likePost($postId)
    {
        try {
            $user = auth()->user();
            $post = $this->baseRepository->find($postId);
            $user->toggleLike($post);

            return $this->respSuccess(['data'=>'data'],'like');
        } catch (\Throwable $e) {
            report($e->getMessage());
            return $this->respError([],'Something went wrong when like! '.$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
