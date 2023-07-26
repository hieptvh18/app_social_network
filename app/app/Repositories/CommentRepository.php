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
                'message' => 'Fetch comment success!',
                'comments' => $comments
            ]);
        } catch (Exception $e) {
            report($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Fetch comment fail! '.$e->getMessage(),
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

            // save notification
            $notifi = $this->saveNotification($comment);
            logger('notiis '.$notifi);
            if($notifi){
                // broadcast to event -> response to frontend
                broadcast(new PushNotifications($comment->user_id, $notifi->message, $comment->post->author->avatar, $notifi->user_id, $notifi->id,$notifi->created_at))->toOthers();
            }

            $dataResp = ['id' => $comment->id, 'message' => $comment->message, 'created_at' => date_format($comment->created_at, 'Y M d H:i')];

            return $this->respSuccess(['comment' => $dataResp], 'Save comment success!');
        } catch (Exception $e) {
            report($e->getMessage());
            return $this->respError([], 'save comment fail! ' . $e->getMessage());
        }
    }

    private function saveNotification($comment)
    {
        try{
            // check if current user as author -> ignore
            if(auth()->id() == $comment->post->user_id){
//                return false;
            }

            $notifi = new Notifications();
            $notifi->user_id = $comment->post->user_id;
            $notifi->message = $comment->user->name . ' commented to your post - <a href="#">View detail</a> - ' . '"' . substr($comment->post->captions, 0, 30) . '"';
            $notifi->save();

            return $notifi;
        }catch(\Throwable $e){
            logger('notierrrrr ==========='.$e->getMessage());
            report($e->getMessage());
            return false;
        }
    }

    public function delete($id)
    {
        try {
            Comment::destroy($id);
            return $this->respSuccess([], 'Delete success comment');
        } catch (\Throwable $e) {
            report($e->getMessage());
            return response()->json([
                'success'=>false,
                'message'=>'save comment fail! '.$e->getMessage(),
                'comment'=>[]
            ]);
        }
    }
}
