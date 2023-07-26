<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileUploadRequest;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Http\Requests\UserRequest;
use App\Http\Requests\FollowUserRequest;
use App\Models\Follow;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class UserController extends Controller
{

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepository = $userRepositoryInterface;
    }

    /**
     * get user by username
     */
    public function getUserByUsername(Request $request)
    {
        return $this->userRepository->getUserByUsername($request->username);
    }

        /**
     * get user by id
     */
    public function getUserById($id)
    {
        return $this->userRepository->getUserById($id);
    }

    /**
     * get user by username
     */
    public function getFriendsUser()
    {
        return $this->userRepository->getFriendsUser();
    }

    /**
     * update user profile
     * @method PUT
     */
    public function update(UserRequest $request)
    {
        return $this->userRepository->updateUserById($request);
    }

    /**
     * search
     */
    public function searchUser(Request $request)
    {
        return $this->userRepository->findUserByUsername($request->username);
    }

    /**
     * handle following & count follwer
     */
    public function followUser(FollowUserRequest $request)
    {
        return $this->userRepository->follow($request->user_id, $request->following_id);
    }

    public function unFollowUser(Request $request)
    {
        return $this->userRepository->unFollow($request->user_id, $request->following_id);
    }

    public function uploadAvatar(FileUploadRequest $request){
        return $this->userRepository->uploadAvatar($request);
    }

    public function recommendFollow(){

        return $this->userRepository->recommendFollow();
    }

    public function changePassword(Request $request){
        return $this->userRepository->updatePassword($request->oldPass,$request->newPass);
    }
}
