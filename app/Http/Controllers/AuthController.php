<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        // Pengecekan Rate Limiting
        $request->authenticate();

        $credentials = $request->only('email', 'password');
        
        $user = $this->authService->attemptLogin($credentials);

        if (! $user) {
            RateLimiter::hit($request->throttleKey());
            return $this->errorResponse('Email atau password salah.', 401);
        }

        RateLimiter::clear($request->throttleKey());

        $token = $this->authService->generateToken($user);

        return $this->successResponse([
            'token' => $token,
            'user' => new UserResource($user),
        ], 'Login berhasil.');
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        
        $user = $this->authService->registerUser($data, $request->user());

        $token = $this->authService->generateToken($user);

        return $this->successResponse([
            'token' => $token,
            'user' => new UserResource($user),
        ], 'Registrasi berhasil.', 201);
    }

    public function me(Request $request)
    {
        return $this->successResponse([
            'user' => new UserResource($request->user()),
        ], 'Data user berhasil diambil.');
    }

    public function logout(Request $request)
    {
        if ($request->user()) {
            $this->authService->revokeCurrentToken($request->user());
        }

        return $this->successResponse(null, 'Logout berhasil.');
    }
}
