<?php

namespace Modules\SocialNetwork\Services;

use App\Http\Controllers\Api\AbstractApi;
use Exception;
use Modules\SocialNetwork\Models\Comment;
use Modules\SocialNetwork\Models\Notifications;
use Modules\SocialNetwork\Events\PushNotifications;
use Symfony\Component\HttpFoundation\Response;

class CommentService extends AbstractApi
{
    public function fetchComments($postId)
    {
        try {
            $comments = Comment::where('post_id', $postId)
                ->with(['user'])
                ->get();

            return $this->respSuccess(['comments' => $comments], 'Fetch comment success!');
        } catch (Exception $e) {
            report($e->getMessage());

            return $this->respError([], 'Fetch comments fail! ' . $e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function saveComment($request)
    {
        try {
            $comment = new Comment();
            $comment->fill($request->all());
            $comment->save();

            // save notification
            $notifi = $this->saveNotification($comment);
            if($notifi){
                // broadcast to event -> response to frontend
                broadcast(new PushNotifications($comment->user_id, $notifi->message, $comment->post->author->avatar, $notifi->user_id, $notifi->id,$notifi->created_at))->toOthers();
            }

            $dataResp = ['id' => $comment->id, 'message' => $comment->message, 'created_at' => $comment->created_at];

            return $this->respSuccess(['comment' => $dataResp], 'Save comment success!');
        } catch (Exception $e) {
            report($e->getMessage());
            return $this->respError([], 'save comment fail! ' . $e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function saveNotification($comment)
    {
        try{
            // check if current user as author -> ignore
            if(auth()->id() == $comment->post->user_id){
                return false;
            }

            $postDetailUrl = env('APP_FULL_URL').'/post/'.$comment->post->id;

            $notifi = new Notifications();
            $notifi->user_id = $comment->post->user_id;
            $message = '<a href="'.$postDetailUrl.'">'.$comment->user->name . ' commented to your post - ' . '"<b>' . substr($comment->post->captions, 0, 30) . '</b>"'.'</a>';
            $notifi->message = $message;

            $notifi->save();

            return $notifi;
        }catch(\Throwable $e){
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
            return $this->respError([], 'Delete comment fail! ' . $e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
