<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Throwable;
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
        try {
            if ($request->username && User::where('username', $request->username)->exists()) {
                $user = User::where('username', $request->username)->first();
                $user->username = $request->username;
                $user->email = $request->email;
                $user->bio = $request->bio;
                $user->phone = $request->phone;
               
                $userSave = $user->save();
                if ($userSave) {
                    return response()->json([
                        'success' => true,
                        'data' => $user,
                        'message' => 'Update profile success'
                    ]);
                }
                return response()->json([
                    'success' => false,
                    'data' => [],
                    'message' => 'User not found!'
                ]);
            }
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Params is invalid!'
            ]);
        } catch (Throwable $e) {
            report($e->getMessage());
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Update profile fail! ' . $e->getMessage()
            ]);
        }
    }

    // check exist username when customer update->change username
    public function checkExistUsername(Request $request){

    }

    // search
    public function searchUser(Request $request)
    {
        try {
            if(!$request->username){
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "message" => "Params username is required!"
                ]);
            }
            $user = User::select('id','name','email','username','avatar')->where('username','like', $request->username.'%')->get();

            if ($user) {
                return response()->json([
                    "success" => true,
                    "data" => $user,
                    "message" => "Get success user!"
                ]);
            }

            return response()->json([
                "success" => true,
                "data" => [],
                "message" => "User not found!"
            ]);
        } catch (Throwable $e) {
            report($e->getMessage());
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => $e->getMessage()
            ]);
        }
    }

    // follow user...
    public function fllowUser()
    {
    }

    public function unFollowUser()
    {
    }
}
