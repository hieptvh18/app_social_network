<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=>'required|exists:users,id',
            'username' => ['required', Rule::unique('users', 'username')->ignore(request()->username, 'username')],
            'email'=>'required|email'
        ], [
            'unique' => 'Username is exist!',
            'exists' => 'Not found user ID in database!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'request data' => $request->all(),
                'errors' => $validator->errors(),
                'message'=> 'Validate fails!',
                'success'=> false
            ]);
        }

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

    // follow user...
    public function followUser()
    {
    }

    public function unFollowUser()
    {
    }
}
