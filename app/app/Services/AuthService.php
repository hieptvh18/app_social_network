<?php

namespace App\Services;

use App\Http\Controllers\Api\AbstractApi;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\SocialNetwork\Events\EventUserRegisterAccount;
use Throwable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class AuthService extends AbstractApi
{
    public function create($request)
    {
        if (!$request->username || !$request->name || !$request->email || !$request->password) {
            return $this->respError(['data'=>$request->all()],'Data is not valid!');
        }
        DB::beginTransaction();
        try {
            $userExistEmail = User::where('email', $request->email)->first();
            $userExistUsername = User::where('username', $request->username)->first();

            if ($userExistEmail) {
                return $this->respError(false,'Email exist customer!');
            }

            if ($userExistUsername) {
                return $this->respError(false,'Username exist customer!');
            }

            $model = new User();
            $model->fill($request->all());
            $model->password = Hash::make($request->password);
            $model->save();

            DB::commit();
            event(new EventUserRegisterAccount($model));

            return $this->respSuccess(['data'=>$request->all()],'Register success!');
        } catch (Throwable $e) {
            DB::rollBack();
            report($e);
            return $this->respError(false,'Something wrong! '.$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function logout($request)
    {
        try {
            $cookie = Cookie::forget('jwtlogin');
            $request->user()->currentAccessToken()->delete();
            return response()->json(['status' => 'ok', 'message' => 'Logout success!']);
        } catch (Throwable $e) {
            report($e->getMessage());
            return response()->json(['status' => 'fail', 'message' => 'Logout fail!'],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
