<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\PushNotifications;

class CommentRepository extends AbstractApi implements CommentRepositoryInterface
{
    public function fetchComments($postId)
    {
        try {
            $comments = Comment::where('post_id', $postId)
                ->with(['user'])
                ->get();
            
                return $this->respSuccess(['comments'=>$comments],'Fetch comment success!');
        } catch (Exception $e) {
            report($e->getMessage());
            
            return $this->respError([],'Fetch comments fail! '.$e->getMessage());
        }
    }

    public function saveComment($request)
    {
        try{
            $comment = new Comment();
            $comment->fill($request->all());
            $comment->save();

            // save notification
            
            // broadcast to envent -> response to frontend
            broadcast(new PushNotifications($comment->post_id));
            
            $dataResp = ['id'=>$comment->id,'message'=>$comment->message,'created_at'=>date_format($comment->created_at,'Y M d H:i')];
           
            return $this->respSuccess(['comment'=>$dataResp],'Save comment success!');
        }catch(Exception $e){
            report($e->getMessage());
            return $this->respError([],'save comment fail! '.$e->getMessage());
        }
    }
}
