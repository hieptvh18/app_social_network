<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



// api authen account
Route::prefix('v1')->group(function () {
    Route::post('accounts/register', [AuthController::class, 'registerPost'])->middleware('guest')->name('register');
    Route::post('accounts/login', [AuthController::class, 'loginUsername'])->middleware('guest')->name('login');

    Route::middleware('auth:sanctum')->group(function () {
        // get user data
        Route::get('/accounts/user', [AuthController::class, 'getUser'])->name('getUser');
        // logout
        Route::post('/accounts/logout', [AuthController::class, 'logout'])->name('logout');
        // change password
        Route::put('/user/change-pass', [UserController::class, 'changePassword']);
        // serahc user by username
        Route::get('/user/search', [UserController::class, 'searchUser'])->name('searchUser');
        // get user by username
        Route::get('/user/get-user', [UserController::class, 'getUserByUsername'])->name('getUserByUsername');
         // get user by id
         Route::get('/user/{id}', [UserController::class, 'getUserById'])->name('getUserById');
        // get list user followed
        Route::get('/list-friend-user', [UserController::class, 'getFriendsUser'])->name('getFriendsUser');
        // update profile user
        Route::put('/user/update', [UserController::class, 'update'])->name('updateUser');
        // following user
        Route::post('/user/following', [UserController::class, 'followUser'])->name('followUser');
        // un follow user
        Route::post('/user/unfollow', [UserController::class, 'unFollowUser'])->name('unFollowUser');
        // upload avatar
        Route::post('/user/upload-avatar', [UserController::class, 'uploadAvatar'])->name('uploadAvatar');

        // show posts of following user
        Route::get('/posts/get_by_following', [PostController::class, 'getPostByFollowingId'])->name('getPost');
        // save post
        Route::post('/posts/save', [PostController::class, 'savePost'])->name('savePost');
        // get post by id
        Route::get('/posts/{id}', [PostController::class, 'getById'])->name('getById');
        // action like post
        Route::post('/post/like', [PostController::class, 'likePost'])->name('likePost');

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
        Route::get('/notification/{userId}',[NotificationController::class,'fetchNotifications']);
        Route::get('/fetch-notification/count-unread',[NotificationController::class,'countUnread']);
        Route::post('/notification/save',[NotificationController::class,'saveNotification']);
        Route::delete('/notification/delete/{id}',[NotificationController::class,'delete']);

    });
});
