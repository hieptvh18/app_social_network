<?php

namespace App\Services;

use App\Http\Controllers\Api\AbstractApi;
use App\Models\SocialAccount;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class SocialAuthService extends AbstractApi
{
    
    public function __construct()
    {
        
    }

    public function handleProviderCallback($provider)
    {
        try{
            $user = Socialite::driver($provider)->stateless()->user();
            $appUser = User::whereEmail($user->email)->first();
    
            if(!$appUser){
                // create new user 
                $appUser = User::create([
                    'name'=>$user->name,
                    'email'=>$user->email,
                    'password'=>bcrypt(uniqid()),
                    'username'=>uniqid()
                ]);
    
                $socialAccount = SocialAccount::create([
                    'user_id'=>$appUser->id,
                    'provider_user_id'=>$user->id,
                    'provider'=>$provider
                ]);
            }else{
                // check social account & save
                $socialAccount = $appUser->socialAccounts()->where('provider',$provider)->first();
    
                if(!$socialAccount){
                    $socialAccount = SocialAccount::create([
                        'user_id'=>$appUser->id,
                        'provider_user_id'=>$user->id,
                        'provider'=>$provider
                    ]);
                }
            }
    
            // res token login
            $token = $appUser->createToken('token')->plainTextToken;
    
            $cookie = cookie('jwtlogin', $token, 60 * 24); //1 day
    
            return response()->json([
                'success' => true,
                'data' => [
                    'token' => $token,
                    'data' => $user
                ],
                'message' => 'Auth success!'
            ], 200)->withCookie($cookie);
    
            
        }catch(\Throwable $e){
            report($e->getMessage());
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Auth fail!'
            ], 500);
        }
    }
}
