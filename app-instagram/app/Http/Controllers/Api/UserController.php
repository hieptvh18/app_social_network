<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Throwable;

class UserController extends Controller
{
    // update user profile
    public function update(Request $request){

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
