<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\SocialNetwork\Http\Controllers\ChatController;
use Modules\SocialNetwork\Http\Controllers\UserController;
use Modules\SocialNetwork\Http\Controllers\PostController;
use Modules\SocialNetwork\Http\Controllers\CommentController;
use Modules\SocialNetwork\Http\Controllers\NotificationController;
use Modules\SocialNetwork\Http\Controllers\StoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(
    [
        'prefix' => 'v1'
    ],
    function () {
        Route::group([
            'middleware' => 'auth:sanctum'
        ],function (){
            // change password
            Route::put('/user/change-pass', [UserController::class, 'changePassword']);
            // search user by username
            Route::get('/user/search', [UserController::class, 'searchUser'])->name('searchUser');
            // get user by username
            Route::get('/user/get-user', [UserController::class, 'getUserByUsername'])->name('getUserByUsername');
            // get user by id
            Route::get('/user/{id}', [UserController::class, 'getUserById'])->name('getUserById');
            // get list user followed
            Route::get('/message/users', [UserController::class, 'getFriendsUser'])->name('getFriendsUser');
            // update profile user
            Route::put('/user/update', [UserController::class, 'update'])->name('updateUser');
            // following user
            Route::post('/user/following', [UserController::class, 'followUser'])->name('followUser');
            // un follow user
            Route::post('/user/unfollow', [UserController::class, 'unFollowUser'])->name('unFollowUser');
            // upload avatar
            Route::post('/user/upload-avatar', [UserController::class, 'uploadAvatar'])->name('uploadAvatar');

            // show posts of following user
            Route::get('/posts/get-by-following', [PostController::class, 'getPostByFollowingId'])->name('getPost');
            // save post
            Route::post('/posts/save', [PostController::class, 'savePost'])->name('savePost');
            Route::delete('/posts/{id}', [PostController::class, 'delete'])->name('deletePost');
            // get post by id
            Route::get('/posts/{id}', [PostController::class, 'getById'])->name('getById');
            // action like post
            Route::post('/post/{id}/like', [PostController::class, 'likePost'])->name('likePost');

            // comment api
            Route::get('/comments/post/{id}', [CommentController::class, 'fetchComments']);
            Route::post('/comments/post/save', [CommentController::class, 'saveComment']);
            Route::delete('/comments/delete/{id}',[CommentController::class,'delete']);

            // recommend follow
            Route::get('recommend-follows', [UserController::class, 'recommendFollow'])->name('recommend-follows');

            // handle chat
            Route::get('/chat/fetch-message/{receiver}',[ChatController::class,'fetchMessage']);
            Route::post('/chat/save',[ChatController::class,'saveMessage']);

            // notifications
            Route::get('/notifications',[NotificationController::class,'fetchNotifications']);
            Route::put('/notifications/{id}',[NotificationController::class,'updateNotification']);
            Route::get('/fetch-notification/count-unread',[NotificationController::class,'countUnread']);
            Route::post('/notification/save',[NotificationController::class,'saveNotification']);
            Route::delete('/notification/delete/{id}',[NotificationController::class,'delete']);

            // story
            Route::get('/list-story-active',[StoryController::class,'fetchListStoryIsActive']);
            Route::get('/story/{id}',[StoryController::class,'findStory']);
            Route::get('/fetch-my-story',[StoryController::class,'fetchMyStories']);
            Route::post('/story/save',[StoryController::class,'storeStory']);
            Route::delete('/story/soft-delete/{id}',[StoryController::class,'softDeleteStory']);
            Route::delete('/story/force-delete/{id}',[StoryController::class,'forceDeleteStory']);
        });
    });
