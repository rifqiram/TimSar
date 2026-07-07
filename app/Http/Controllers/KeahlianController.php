<?php

namespace App\Http\Controllers;

use App\Http\Resources\KeahlianResource;
use App\Models\Keahlian;
use Illuminate\Http\Request;
use App\Http\Requests\StoreKeahlianRequest;
use App\Http\Requests\UpdateKeahlianRequest;

class KeahlianController extends Controller
{
    public function index()
    {
        return $this->successResponse(KeahlianResource::collection(Keahlian::with('kategori')->latest()->paginate($this->perPage)), 'Data keahlian berhasil diambil');
    }

    public function store(StoreKeahlianRequest $request)
    {
        if ($response = $this->authorizeAdmin($request)) {
            return $response;
        }

        $data = $request->validated();

        $keahlian = Keahlian::create($data);

        return $this->successResponse(new KeahlianResource($keahlian->load('kategori')), 'Keahlian berhasil dibuat', 201);
    }

    public function show(Request $request, Keahlian $keahlian)
    {
        if ($response = $this->authorizeAdmin($request)) {
            return $response;
        }
        return $this->successResponse(new KeahlianResource($keahlian->load('kategori')), 'Detail keahlian berhasil diambil');
    }

    public function update(UpdateKeahlianRequest $request, Keahlian $keahlian)
    {
        if ($response = $this->authorizeAdmin($request)) {
            return $response;
        }

        $data = $request->validated();

        $keahlian->update($data);

        return $this->successResponse(new KeahlianResource($keahlian->load('kategori')), 'Keahlian berhasil diperbarui');
    }

    public function destroy(Request $request, Keahlian $keahlian)
    {
        if ($response = $this->authorizeAdmin($request)) {
            return $response;
        }

        if ($keahlian->pelatihans()->exists() || $keahlian->pesertas()->exists()) {
            return $this->errorResponse('Keahlian masih digunakan', 400);
        }

        $keahlian->delete();

        return $this->successResponse(null, 'Keahlian berhasil dihapus');
    }
}
