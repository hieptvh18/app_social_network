<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentRepository implements CommentRepositoryInterface
{
    public function fetchComments($postId)
    {
        try {
            $comments = Comment::where('post_id', $postId)
                ->with(['user'])
                ->get();
            return response()->json([
                'success' => true,
                'message' => 'Fetch messages success!',
                'comments' => $comments
            ]);
        } catch (Exception $e) {
            report($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Fetch messages fail! '.$e->getMessage(),
                'comments' => []
            ]);
        }
    }

    public function saveComment($request)
    {
        try{
            $comment = new Comment();
            $comment->fill($request->all());
            $comment->save();
            
            return response()->json([
                'success'=>true,
                'message'=>'save message success',
                'comment'=>['id'=>$comment->id,'message'=>$comment->message]
            ]);
        }catch(Exception $e){
            report($e->getMessage());
            return response()->json([
                'success'=>false,
                'message'=>'save message fail! '.$e->getMessage(),
                'comment'=>[]
            ]);
        }
    }
}
