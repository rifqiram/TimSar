<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        $id = $request->query('id');

        $peserta = $id ? Peserta::find($id) : new Peserta();

        if (!$peserta) {
            $peserta = new Peserta();
        }

        return view('user.data_diri', compact('peserta'));
    }

    public function storeOrUpdate(Request $request)
    {
        // 1. Validasi Input Terbaru
        // Menambahkan 'keahlian' ke dalam validasi agar datanya ditangkap
        $request->validate([
            'nama'     => 'required|string|max:255',
            'umur'     => 'required|integer|min:5',
            'email'    => 'required|email|max:255',
            'telepon'  => 'required|string|max:20',
            'keahlian' => 'required|string', // WAJIB TAMBAHKAN INI
        ]);

        // 2. Ambil ID dari hidden input
        $id = $request->input('id');

        // 3. Proses Create atau Update data ke database
        $peserta = Peserta::updateOrCreate(
            ['id' => $id], 
            [
                'nama'     => $request->nama,
                'umur'     => $request->umur,
                'email'    => $request->email,
                'telepon'  => $request->telepon,
                'keahlian' => $request->keahlian, // WAJIB TAMBAHKAN INI AGAR TERSIMPAN
            ]
        );

        return redirect()->route('user.profile', ['id' => $peserta->id])->with('success', 'Data diri berhasil disimpan!');
    }
}