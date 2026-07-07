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
        // Bypass data user login: jika kosong karena tanpa middleware, ambil user pertama (levy danendra)
        $user = $request->user() ?? User::first();

        return $this->successResponse([
<<<<<<< HEAD
            'user' => new UserResource($user),
        ], 'Data user berhasil diambil');
    }

    public function updateProfile(Request $request)
    {
        // BYPASS AUTHENTICATION UNTUK TESTING:
        // Jika request->user() kosong, cari user berdasarkan email inputan atau ambil user pertama
        $user = $request->user() ?? User::where('email', $request->email)->first() ?? User::first();

        if (! $user) {
            return $this->errorResponse('User tidak ditemukan', 404);
        }

        // Validasi input data profil (menggunakan tabel_users sesuai register)
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:tabel_users,email,' . $user->id,
            'no_telp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        // Update data ke database tabel_users
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'no_telp' => $data['no_telp'],
            'alamat' => $data['alamat'],
        ]);

        // Mengembalikan response sukses dengan format standar kelompokmu
        return $this->successResponse([
            'user' => new UserResource($user),
        ], 'Profil berhasil diperbarui');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:tabel_users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'sometimes|in:admin,user,pencari_kerja',
        ]);

        $requestedRole = $data['role'] ?? 'user';
        $role = in_array($requestedRole, ['user', 'pencari_kerja'], true) ? 'user' : 'user';

        if ($request->user()?->role === 'admin' && $requestedRole === 'admin') {
            $role = 'admin';
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $role,
            'api_token' => \Illuminate\Support\Str::random(60),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return $this->successResponse([
            'token' => $token,
            'user' => new UserResource($user),
        ], 'Register berhasil', 201);
=======
            'user' => new UserResource($request->user()),
        ], 'Data user berhasil diambil.');
>>>>>>> origin/main
    }

    public function logout(Request $request)
    {
        if ($request->user()) {
            $this->authService->revokeCurrentToken($request->user());
        }

        return $this->successResponse(null, 'Logout berhasil.');
    }
}