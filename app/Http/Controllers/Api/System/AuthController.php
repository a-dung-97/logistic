<?php

namespace App\Http\Controllers\Api\System;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\MeResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('username', 'password');

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['message' => 'Thông tin đăng nhập không hợp lệ'], 401);
        }
        if (!auth()->user()->active) {
            return Response::error('Tài khoản chưa được kích hoạt');
        }
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        return new MeResource(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
        ]);
    }
    public function changePassword(ChangePasswordRequest $request)
    {
        if (!Hash::check($request->old_password, auth()->user()->password))
            return Response::error('Mật khẩu cũ không đúng');
        auth()->user()->update(['password' => Hash::make($request->password)]);
        return ['message' => 'OK'];
    }
}
