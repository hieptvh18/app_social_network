<?php

namespace Modules\SocialNetwork\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\SocialNetwork\Http\Requests\FileUploadRequest;
use Modules\SocialNetwork\Http\Requests\FollowUserRequest;
use Modules\SocialNetwork\Http\Requests\UserSaveRequest;
use Modules\SocialNetwork\Services\UserService;

class UserController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * get user by username
     */
    public function getUserByUsername(Request $request)
    {
        return $this->userService->getUserByUsername($request->username);
    }

    /**
     * get user by id
     */
    public function getUserById($id)
    {
        return $this->userService->getUserById($id);
    }

    /**
     * get user by username
     */
    public function getFriendsUser()
    {
        return $this->userService->getFriendsUser();
    }

    /**
     * update user profile
     * @method PUT
     */
    public function update(UserSaveRequest $request)
    {
        return $this->userService->updateUserById($request);
    }

    /**
     * search
     */
    public function searchUser(Request $request)
    {
        return $this->userService->findUserByUsername($request->username);
    }

    /**
     * handle following & count follwer
     */
    public function followUser(FollowUserRequest $request)
    {
        return $this->userService->follow($request->user_id, $request->following_id);
    }

    public function unFollowUser(Request $request)
    {
        return $this->userService->unFollow($request->user_id, $request->following_id);
    }

    public function uploadAvatar(FileUploadRequest $request){
        return $this->userService->uploadAvatar($request);
    }

    public function recommendFollow(){

        return $this->userService->recommendFollow();
    }

    public function changePassword(Request $request){
        return $this->userService->updatePassword($request->oldPass,$request->newPass);
    }
}
