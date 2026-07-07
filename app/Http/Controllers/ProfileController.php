<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Requirement 2: Data profil diambil langsung dari database
    public function edit()
    {
        // Mengambil data user yang sedang login saat ini
        $user = Auth::user(); 
        
        // Mengarahkan ke file view di folder resources/views/user/profile.blade.php
        return view('user.profile', compact('user'));
    }

    // Requirement 5: Pastikan perubahan data tersimpan ke database
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi inputan (sesuaikan nama kolom dengan yang ada di databasemu)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            // 'no_telp' => 'nullable|string|max:15', // Buka komen ini jika ada field no telepon
            // 'alamat' => 'nullable|string', // Buka komen ini jika ada field alamat
        ]);

        // Mengubah data objek user sesuai inputan
        $user->name = $request->name;
        $user->email = $request->email;
        // $user->no_telp = $request->no_telp;
        // $user->alamat = $request->alamat;

        // Menyimpan ke database
        $user->save();

        return redirect()->back()->with('success', 'Data profil berhasil diperbarui!');
    }
}