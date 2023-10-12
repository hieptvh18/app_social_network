<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Throwable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserRegisterRequest;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * login with username && password
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginUsername(Request $request)
    {
        try {
            $credentials = request(['username', 'password']);
            if (!Auth::attempt($credentials)) {
                return response()->json(['status' => 'fail', 'message' => 'Username or password invalid!', 'data' => []], Response::HTTP_UNAUTHORIZED);
            }
            // ok
            $user = Auth::user();

            $token = $user->createToken('token')->plainTextToken;

            $cookie = cookie('jwtlogin', $token, 60 * 24); //1 day

            return response()->json([
                'status' => 'ok',
                'data' => [
                    'token' => $token,
                    'data' => $user
                ],
                'message' => 'Auth success!'
            ], 200)->withCookie($cookie);
        } catch (\Throwable $e) {
            report($e);
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    /**
     * register post
     * @param UserRegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerPost(UserRegisterRequest $request)
    {
        return $this->authService->create($request);
    }

    /**
     * get info user logginIn
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser(Request $request)
    {
        try {
            $data = Auth::user();

            return response()->json([
                'data' => $data,
                'success' => true,
                'message' => "Get user data success!"
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'data' => [],
                'success' => false,
                'message' => "Get user data fail! " . $e->getMessage()
            ]);
        }
    }

    /**
     * logout
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        return $this->authService->logout($request);
    }
}
