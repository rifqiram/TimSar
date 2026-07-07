<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendaftaranController; // <-- Tambahan untuk memanggil Controller kita
use Illuminate\Support\Facades\Route;

Route::redirect('/admin', '/admin/login');
Route::view('/admin/login', 'admin.Auth.login')->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::view('/admin/dashboard', 'admin.Dashboard.dashboard')->name('admin.dashboard');
Route::view('/user/login', 'user.Auth.login')->name('user.login');
Route::view('/user/register', 'user.Auth.register')->name('user.register');

// User Routes
// User Routes (Middleware dilepas di web karena auth menggunakan localStorage JS)
Route::prefix('user')->name('user.')->group(function () {
    Route::view('/dashboard', 'user.dashboard.index')->name('dashboard');
    Route::view('/profile', 'user.profile.index')->name('profile');
    
    // UBAH INI: Diarahkan ke Controller agar bisa mengambil data $pelatihans dari database
    Route::get('/training', [PendaftaranController::class, 'create'])->name('training');
    
    // TAMBAH INI: Rute untuk memproses dan menyimpan data form pendaftaran
    Route::post('/pendaftaran/store', [PendaftaranController::class, 'storeUser'])->name('pendaftaran.store');
    
    Route::view('/recommendation', 'user.recommendation.index')->name('recommendation');
});

Route::view('/admin/pelatihan/create', 'admin.Pelatihan.pelatihan-create')->name('admin.pelatihan.create');
Route::view('/admin/pelatihan/edit', 'admin.Pelatihan.pelatihan-edit')->name('admin.pelatihan.edit');
Route::view('/admin/mentor/create', 'admin.Mentor.mentor-create')->name('admin.mentor.create');
Route::view('/admin/mentor/edit', 'admin.Mentor.mentor-edit')->name('admin.mentor.edit');
Route::view('/admin/peserta/create', 'admin.Peserta.peserta-create')->name('admin.peserta.create');
Route::view('/admin/peserta/edit', 'admin.Peserta.peserta-edit')->name('admin.peserta.edit');
Route::view('/admin/peserta/riwayat', 'admin.Peserta.peserta-riwayat')->name('admin.peserta.riwayat');
Route::view('/admin/pendaftaran/create', 'admin.Pendaftaran.pendaftaran-create')->name('admin.pendaftaran.create');

Route::redirect('/', '/user/login');