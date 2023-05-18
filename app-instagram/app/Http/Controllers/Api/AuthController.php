<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Throwable;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // login with username && password
    public function loginUsername(Request $request){
        try{
            if($request->username){
                $user = User::where('username',$request->username)->first();
                if($user && Auth::attempt()){

                } 
            }
        }catch(\Throwable $e){
            report($e);
            return response()->json([]);
        }
    }

    // login with google
    

    // register post
    public function registerPost(Request $request){
        try{
            
        }catch(Throwable $e){
            report($e);
            return response()->json([]);
        }
    }
}
