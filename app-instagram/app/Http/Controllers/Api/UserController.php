<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Throwable;

class UserController extends Controller
{
    // get user by username
    public function getUserByUsername(Request $request){
        try{
            $user = User::where('username',$request->username)->first();
            if($request->username && $user){
                return response()->json([
                    'data'=>$user,
                    'message'=>'Get user data by username success',
                    'success'=>true,
                ]);
            }
            return response()->json([
                'data'=>[],
                'message'=>'User not found!',
                'success'=>false,
            ]);
        }catch(Throwable $e){
            return response()->json([
                'data'=>[],
                'message'=>'Get user by username fail!! '.$e->getMessage(),
                'success'=>false,
            ]);
        }
    }

    // update user profile
    public function update(Request $request){
        try{
            if($request->username && User::where('username',$request->username)->exist()){
                $user = User::where('username',$request->username)->first();
                $user->fill($request->all());
                $userSave = $user->save();
                if($userSave){
                    return response()->json([
                        'success'=>true,
                        'data'=>$userSave,
                        'message'=>'Update profile success'
                    ]);
                }
                return response()->json([
                    'success'=>false,
                    'data'=>[],
                    'message'=>'User not found!'
                ]);
            }
            return response()->json([
                'success'=>false,
                'data'=>[],
                'message'=>'Params is invalid!'
            ]);
        }catch(Throwable $e){
            return response()->json([
                'success'=>false,
                'data'=>[],
                'message'=>'Update profile fail'
            ]);
        }
    }

    // search
    public function searchUser(Request $request){
        $username = $request->username;
        if($username){
            try{
                $user = User::where('username',$username)->first();

                if($user){
                    return response()->json([
                        "success" => true,
                        "data"=>$user,
                        "message"=>"Get success user!"
                    ]);
                }

                return response()->json([
                    "success" => true,
                    "data"=>[],
                    "message"=>"User not found!"
                ]);
            }catch(Throwable $e){
                report($e->getMessage());
                return response()->json([
                    "success" => false,
                    "data"=>[],
                    "message"=> $e->getMessage()
                ]);
            }

        }
        return response()->json([
            "success" => false,
                    "data"=>[],
                    "message"=>"Params fail!"
        ]);
    }

    // follow user...
    public function fllowUser(){

    }

    public function unFollowUser(){
        
    }
    
}
