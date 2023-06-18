<?php
namespace App\Repositories;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
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
}