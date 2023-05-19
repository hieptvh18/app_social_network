<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Throwable;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    // login with username && password
    public function loginUsername(Request $request)
    {
        try {
            $credentials = request(['email', 'password']);
            if(!Auth::attempt($credentials)){
                return response()->json(['message'=>'Auth fail!'],Response::HTTP_UNAUTHORIZED);
            }

            // ok
            $user = Auth::user();

            $token = $user->createToken('token')->plainTextToken;

            $cookie = cookie('jwtlogin',$token,60 * 24); //1 day

            return response()->json([
                'status'=>'ok',
                'token'=>$token,
                'message'=>'Auth success!'
                ],200)->withCookie($cookie);
        } catch (\Throwable $e) {
            report($e);
            return response()->json(['status'=>'fail','error'=>$e->getMessage()]);
        }
    }

    // login with google


    // register post
    public function registerPost(Request $request)
    {
        $dataResponse = ['status' => true, 'data' => [], 'message' => ""];

        if (!$request->username || !$request->email || !$request->password) {
            return response()->json([
                'status' => false,
                'message' => 'Data is not valid!',
                'data' => $request->all()
            ]);
        }

        try {
            $userExistEmail = User::where('email', $request->email)->first();
            $userExistUsername = User::where('username', $request->username)->first();

            if ($userExistEmail) {
                $dataResponse['status'] = false;
                $dataResponse['message'] = 'Email exist customer!';
                return response()->json($dataResponse);
            }

            if ($userExistUsername) {
                $dataResponse['status'] = false;
                $dataResponse['message'] = 'Username exist customer!';
                return response()->json($dataResponse);
            }

            $model = new User();
            $model->fill($request->all());
            $model->password = Hash::make($request->password);
            $model->save();

            $dataResponse['data'] = $request->all();
            $dataResponse['message'] = 'Register success!';
            return response()->json($dataResponse);
        } catch (Throwable $e) {
            report($e);
            $dataResponse['status'] = false;
            $dataResponse['message'] = 'Error: ' . $e->getMessage();
            return response()->json($dataResponse);
        }
    }

    // get info user logginIn
    public function getUser(Request $request)
    {
        return Auth::user();
    }
}
