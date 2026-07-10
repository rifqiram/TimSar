<?php

namespace App\Http\Controllers;

use App\Http\Resources\PendaftaranResource;
use App\Models\Pendaftaran;
use App\Models\Pelatihan; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StorePendaftaranRequest;
use App\Http\Requests\StoreUserPendaftaranRequest;
use App\Http\Requests\UpdatePendaftaranRequest;
use Illuminate\Support\Facades\Auth; 

class PendaftaranController extends Controller
{

    // Menampilkan halaman form pendaftaran dengan data dropdown
    public function create()
    {
        $pelatihans = Pelatihan::with('mentor')->where('is_active', true)->latest()->get();
        return view('user.training.index', compact('pelatihans')); 
    }

    // Memproses data pendaftaran dari form web
    public function storeUser(StoreUserPendaftaranRequest $request)
    {
        $request->validated();

        $pesertaId = Auth::id();

        if (!$pesertaId) {
            return redirect()->back()->with('error', 'Gagal: Silakan login terlebih dahulu.');
        } 

        // Cek apakah user sudah daftar pelatihan yang sama sebelumnya
        $exists = Pendaftaran::where('peserta_id', $pesertaId)
            ->where('pelatihan_id', $request->pelatihan_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Gagal: Kamu sudah terdaftar di pelatihan ini!');
        }

        // Simpan ke database
        Cache::forget('rekomendasi_peserta_' . $pesertaId);
        Pendaftaran::create([
            'peserta_id' => $pesertaId,
            'pelatihan_id' => $request->pelatihan_id,
            'tanggal_daftar' => now(),
            'status' => 'terdaftar'
        ]);

        return redirect()->back()->with('success', 'Mantap! Pendaftaran pelatihan berhasil dilakukan.');
    }

    public function index(Request $request)
    {
        if ($response = $this->authorizeAdmin($request)) {
            return $response;
        }

        return $this->paginatedResponse(
            PendaftaranResource::collection(Pendaftaran::with(['peserta', 'pelatihan.mentor'])->latest()->paginate($this->perPage)),
            'Data pendaftaran berhasil diambil'
        );
    }

    public function store(StorePendaftaranRequest $request)
    {
        if ($response = $this->authorizeAdmin($request)) {
            return $response;
        }

        $data = $request->validated();

        $exists = Pendaftaran::where('peserta_id', $data['peserta_id'])
            ->where('pelatihan_id', $data['pelatihan_id'])
            ->exists();

        if ($exists) {
            return $this->errorResponse('Peserta sudah terdaftar pada pelatihan ini', 409);
        }

        $data['tanggal_daftar'] = $data['tanggal_daftar'] ?? now();
        $data['status'] = $data['status'] ?? 'terdaftar';

        Cache::forget('rekomendasi_peserta_' . $data['peserta_id']);
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

    public function update(UpdatePendaftaranRequest $request, Pendaftaran $pendaftaran)
    {
        if ($response = $this->authorizeAdmin($request)) {
            return $response;
        }

        $data = $request->validated();

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
    public function daftarPelatihan()
    {
    $pendaftarans = Pendaftaran::with([
        'peserta',
        'pelatihan.mentor'
    ])->get();

    return view('user.training.daftar', compact('pendaftarans'));
    }
}