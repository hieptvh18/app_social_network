<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Http\Requests\UserRequest;
use App\Http\Requests\FollowUserRequest;
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
     * update user profile
     * @method PUT
     */
    public function update(UserRequest $request)
    {
        return $this->userRepository->updateUserById($request);
    }

    /**
     * check exist customer by username
     */
    public function checkExistUsername(Request $request)
    {
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
        return $this->userRepository->follow($request->user_id,$request->following_id);
    }

    public function unFollowUser(FollowUserRequest $request)
    {
        return $this->userRepository->unFollow($request->user_id,$request->following_id);
    }
}
