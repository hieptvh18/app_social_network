<?php
namespace App\Repositories;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Throwable;

class UserRepository implements UserRepositoryInterface
{
    
    public function getUserByUsername($username){
        try {
            if ($username && User::where('username', $username)->exists()) {
                $user = User::where('username', $username)->first();
                // $user->countPosts = count($user->posts);
                $user->posts;
                return response()->json([
                    'data' => $user,
                    'message' => 'Get user data by username success',
                    'success' => true,
                ]);
            }
            return response()->json([
                'data' => [],
                'message' => 'User not found!',
                'success' => false,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'data' => [],
                'message' => 'Get user by username fail!! ' . $e->getMessage(),
                'success' => false,
            ]);
        }
    }    

    public function updateUserByUsername($request){
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

    public function findUserByUsername($username){
        try {
            if(!$username){
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "message" => "Params username is required!"
                ]);
            }
            $user = User::select('id','name','email','username','avatar')->where('username','like', $username.'%')->get();

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
}