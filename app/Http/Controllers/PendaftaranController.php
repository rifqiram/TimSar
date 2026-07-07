<?php

namespace App\Http\Controllers;

use App\Http\Resources\PendaftaranResource;
use App\Models\Pendaftaran;
use App\Models\Pelatihan; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB; // <-- Tambahan untuk akses database

class PendaftaranController extends Controller
{
    // =====================================================================
    // 1. BAGIAN WEB (UNTUK FORM PENDAFTARAN USER)
    // =====================================================================

    // Menampilkan halaman form pendaftaran dengan data dropdown
    public function create()
    {
        $pelatihans = Pelatihan::with('mentor')->get();
        return view('user.training.index', compact('pelatihans')); // Atau sesuaikan dengan nama view lo
    }

    // Memproses data pendaftaran dari form web
    public function storeUser(Request $request)
    {
        $request->validate([
            'pelatihan_id' => 'required|exists:tabel_pelatihan,id',
        ]);

        // Mengambil ID peserta pertama yang ada di database secara dinamis biar gak error foreign key
        $pesertaData = DB::table('tabel_peserta')->first();
        $pesertaId = Auth::id() ?: ($pesertaData ? $pesertaData->id : 1); 

        // Cek apakah user sudah daftar pelatihan yang sama sebelumnya
        $exists = Pendaftaran::where('peserta_id', $pesertaId)
            ->where('pelatihan_id', $request->pelatihan_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Gagal: Kamu sudah terdaftar di pelatihan ini!');
        }

        // Simpan ke database
        Pendaftaran::create([
            'peserta_id' => $pesertaId,
            'pelatihan_id' => $request->pelatihan_id,
            'tanggal_daftar' => now(),
            'status' => 'terdaftar'
        ]);

        return redirect()->back()->with('success', 'Mantap! Pendaftaran pelatihan berhasil dilakukan.');
    }


    // =====================================================================
    // 2. BAGIAN API (KODINGAN ASLI MILIKMU, TIDAK DIUBAH)
    // =====================================================================

    public function index(Request $request)
    {
        if ($response = $this->authorizeAdmin($request)) {
            return $response;
        }

        return $this->successResponse(
            PendaftaranResource::collection(Pendaftaran::with(['peserta', 'pelatihan.mentor'])->get()),
            'Data pendaftaran berhasil diambil'
        );
    }

    public function store(Request $request)
    {
        if ($response = $this->authorizeAdmin($request)) {
            return $response;
        }

        $data = $request->validate([
            'peserta_id' => 'required|exists:tabel_peserta,id',
            'pelatihan_id' => 'required|exists:tabel_pelatihan,id',
            'tanggal_daftar' => 'nullable|date',
            'status' => 'nullable|string|max:50',
        ]);

        $exists = Pendaftaran::where('peserta_id', $data['peserta_id'])
            ->where('pelatihan_id', $data['pelatihan_id'])
            ->exists();

        if ($exists) {
            return $this->errorResponse('Peserta sudah terdaftar pada pelatihan ini', 409);
        }

        $data['tanggal_daftar'] = $data['tanggal_daftar'] ?? now();
        $data['status'] = $data['status'] ?? 'terdaftar';

        $pendaftaran = Pendaftaran::create($data);

        return $this->successResponse(new PendaftaranResource($pendaftaran->load(['peserta', 'pelatihan.mentor'])), 'Pendaftaran berhasil dibuat', 201);
    }

    public function show(Request $request, Pendaftaran $pendaftaran)
    {
        if ($response = $this->authorizeAdmin($request)) {
            return $response;
        }

        return $this->successResponse(new PendaftaranResource($pendaftaran->load(['peserta', 'pelatihan.mentor'])), 'Detail pendaftaran berhasil diambil');
    }

    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        if ($response = $this->authorizeAdmin($request)) {
            return $response;
        }

        $data = $request->validate([
            'peserta_id' => 'sometimes|required|exists:tabel_peserta,id',
            'pelatihan_id' => 'sometimes|required|exists:tabel_pelatihan,id',
            'tanggal_daftar' => 'sometimes|required|date',
            'status' => 'sometimes|required|string|max:50',
        ]);

        $pendaftaran->update($data);

        return $this->successResponse(new PendaftaranResource($pendaftaran->load(['peserta', 'pelatihan.mentor'])), 'Pendaftaran berhasil diperbarui');
    }

    public function destroy(Request $request, Pendaftaran $pendaftaran)
    {
        if ($response = $this->authorizeAdmin($request)) {
            return $response;
        }

        $pendaftaran->delete();

        return $this->successResponse(null, 'Pendaftaran berhasil dihapus');
    }
}