<?php

namespace Modules\SocialNetwork\Services;

use App\Http\Controllers\Api\AbstractApi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\SocialNetwork\Models\Message;
use Modules\SocialNetwork\Models\Room;
use Modules\SocialNetwork\Events\MessageSent;

class ChatService extends AbstractApi
{
    public function saveMessage(Request $request)
    {
        try {
            $sender = auth()->id();
            $reciever = request()->get('receiver');
            $message = request()->get('message');
            $user = auth()->user();

            // check or save room
            $roomExist = DB::selectOne('select id from rooms where (`from` = ? and `to` = ?) or (`to` = ? and `from` = ?)', [$sender, $reciever, $sender, $reciever]);

            if (!$roomExist) {
                $room = new Room();
                $room->from = $sender;
                $room->to = (int)$reciever;
                $room->save();
            } else {
                $room = DB::selectOne('select id from rooms where (`from` = ? and `to` = ?) or (`to` = ? and `from` = ?)', [$sender, $reciever, $sender, $reciever]);
            }

            // save to messages
            $message = new Message();
            $message->message = request()->get('message', '');
            $message->from = $sender;
            $message->to = (int)$reciever;
            $message->room_id = $room->id;
            $message->save();

            // broadcast to envent -> response to frontend
            broadcast(new MessageSent($message, $user, $room->id))->toOthers();

            return ['message' => $message->load('from'), 'success' => true];
        } catch (Exception $e) {
            report($e->getMessage());
            return $this->respError([], 'save message fail: ' . $e->getMessage());
        }
    }

    public function fetchMessage($reciever)
    {
        try {
            // GET MESSAGE of current user and to -> dua theo user id hien tai
            $currentRoomId = DB::selectOne('select id from rooms where (`from` = ? and `to` = ?) or (`to` = ? and `from` = ?)', [auth()->id(), $reciever, auth()->id(), $reciever]);

            if (!$currentRoomId) {
                return $this->respError(['list_message'=>[]]);
            }

            $messages = Message::select('messages.*')->with('from')->with('to')
                ->join('rooms', 'messages.room_id', '=', 'rooms.id')
                ->where('room_id', $currentRoomId->id)
                ->get();

            return $this->respSuccess(['list_message'=>$messages]);
        } catch (\Throwable $e) {
            report($e->getMessage());
            return $this->respError(false,'Have an error when fetch message! '.$e->getMessage());
        }
    }

    /**
     * Fetch friend chated, follow, guest-chat, sort order by send message
     */
    public function fetchListFriends(){

    }
}
