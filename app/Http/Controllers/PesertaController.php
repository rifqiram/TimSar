<?php

namespace App\Http\Controllers;

use App\Http\Resources\PesertaResource;
use App\Http\Resources\PendaftaranResource;
use App\Models\Peserta;
use Illuminate\Http\Request;
use App\Http\Requests\StorePesertaRequest;
use App\Http\Requests\UpdatePesertaRequest;

class PesertaController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->authorizeAdmin($request)) {
            return $response;
        }

        return $this->successResponse(PesertaResource::collection(Peserta::latest()->paginate($this->perPage)), 'Data peserta berhasil diambil');
    }

    public function store(StorePesertaRequest $request)
    {
        if ($response = $this->authorizeAdmin($request)) {
            return $response;
        }

        $data = $request->validated();

        $peserta = Peserta::create($data);

        return $this->successResponse(new PesertaResource($peserta), 'Peserta berhasil dibuat', 201);
    }

    public function show(Request $request, Peserta $peserta)
    {
        if ($response = $this->authorizeAdmin($request)) {
            return $response;
        }
        return $this->successResponse(new PesertaResource($peserta), 'Detail peserta berhasil diambil');
    }

    public function update(UpdatePesertaRequest $request, Peserta $peserta)
    {
        if ($response = $this->authorizeAdmin($request)) {
            return $response;
        }

        $data = $request->validated();

        $peserta->update($data);

        return $this->successResponse(new PesertaResource($peserta), 'Peserta berhasil diperbarui');
    }

    public function destroy(Request $request, Peserta $peserta)
    {
        if ($response = $this->authorizeAdmin($request)) {
            return $response;
        }

        if ($peserta->pendaftarans()->exists()) {
            return $this->errorResponse('Masih ada pendaftaran peserta', 400);
        }

        $peserta->delete();

        return $this->successResponse(null, 'Peserta berhasil dihapus');
    }

    public function riwayat(Peserta $peserta)
    {
        return $this->paginatedResponse(
            PendaftaranResource::collection($peserta->pendaftarans()->with('pelatihan.mentor')->latest()->paginate($this->perPage)),
            'Riwayat pelatihan berhasil diambil'
        );
    }
}
