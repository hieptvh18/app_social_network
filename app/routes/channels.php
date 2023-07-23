<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Post;
/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// channel chat 1-1
Broadcast::channel('chatroom.{id}', function ($user, $id) {
    return true;
});

// channel notifi
Broadcast::channel('notifications', function ($user) {
    //  check if current user comment your post -> not authen
    // if(Post::where('user_id',auth()->id())
    //         ->where('post_id',$postId)->exists()){
    //     return false;
    // }

    return true;
});

