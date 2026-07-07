<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Fillable(['name', 'email', 'password', 'api_token', 'role', 'no_telp', 'alamat'])]
#[Hidden(['password', 'remember_token', 'api_token'])]
class User extends Authenticatable
{
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';
    const ROLE_PENCARI_KERJA = 'pencari_kerja';

    protected $table = 'tabel_users';

    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}