<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserController extends Controller
{

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepository = $userRepositoryInterface;
    }

    // get user by username
    public function getUserByUsername(Request $request)
    {
        return $this->userRepository->getUserByUsername($request->username);
    }

    // update user profile
    public function update(Request $request)
    {
       return $this->userRepository->updateUserByUsername($request);
    }

    // check exist username when customer update->change username
    public function checkExistUsername(Request $request){

    }

    // search
    public function searchUser(Request $request)
    {
        return $this->userRepository->findUserByUsername($request->username);
    }

    // follow user...
    public function followUser()
    {
    }

    public function unFollowUser()
    {
    }
}
