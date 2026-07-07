<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthService
{
    public function attemptLogin(array $credentials): ?User
    {
        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return null;
        }

        return $user;
    }

    public function generateToken(User $user, string $tokenName = 'api-token'): string
    {
        // Hapus token lama jika hanya ingin 1 device aktif (opsional)
        // $user->tokens()->where('name', $tokenName)->delete();
        
        return $user->createToken($tokenName)->plainTextToken;
    }

    public function registerUser(array $data, ?User $currentUser = null): User
    {
        $requestedRole = $data['role'] ?? 'user';
        
        // Aturan default: Hanya bisa mendaftar sebagai 'user'
        $role = in_array($requestedRole, ['user', 'pencari_kerja'], true) ? 'user' : 'user';

        // Hanya admin yang sedang login yang bisa membuat user dengan role 'admin'
        if ($currentUser && $currentUser->role === 'admin' && $requestedRole === 'admin') {
            $role = 'admin';
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']), // Pastikan dihash jika di model belum otomatis dihash (meski di casts sudah ada)
            'role' => $role,
            'api_token' => Str::random(60), // Backward compatibility untuk sistem token lama
        ]);
    }

    public function revokeCurrentToken(User $user): void
    {
        $user->currentAccessToken()?->delete();
    }
}
