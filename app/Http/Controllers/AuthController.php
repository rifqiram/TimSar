<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return $this->errorResponse('Email atau password salah', 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return $this->successResponse([
            'token' => $token,
            'user' => new UserResource($user),
        ], 'Login berhasil');
    }

    public function me(Request $request)
    {
        // Bypass data user login: jika kosong karena tanpa middleware, ambil user pertama (levy danendra)
        $user = $request->user() ?? User::first();

        return $this->successResponse([
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
    }

    public function logout(Request $request)
    {
        $request->user()?->currentAccessToken()?->delete();

        return $this->successResponse(null, 'Logout berhasil');
    }
}