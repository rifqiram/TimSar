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
        $user = $request->user();

        if (! $user) {
            return $this->errorResponse('Unauthenticated.', 401);
        }

        return $this->successResponse([
            'user' => new UserResource($user),
        ], 'Data user berhasil diambil.');
    }

    public function updateProfile(\App\Http\Requests\UpdateProfileRequest $request)
    {
        $user = $request->user();

        if (! $user) {
            return $this->errorResponse('Unauthenticated', 401);
        }

        $data = $request->validated();

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'no_telp' => $data['no_telp'],
            'alamat' => $data['alamat'],
        ]);

        return $this->successResponse([
            'user' => new UserResource($user),
        ], 'Profil berhasil diperbarui');
    }

    public function logout(Request $request)
    {
        if ($request->user()) {
            $this->authService->revokeCurrentToken($request->user());
        }

        return $this->successResponse(null, 'Logout berhasil.');
    }
}
