<?php

namespace App\Http\Controllers;

use App\Http\Resources\KategoriResource;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Requests\StoreKategoriRequest;
use App\Http\Requests\UpdateKategoriRequest;

class KategoriController extends Controller
{
    public function index()
    {
        return $this->successResponse(KategoriResource::collection(Kategori::latest()->paginate($this->perPage)), 'Data kategori berhasil diambil');
    }

    public function store(StoreKategoriRequest $request)
    {
        if ($response = $this->authorizeAdmin($request)) {
            return $response;
        }

        $data = $request->validated();

        $kategori = Kategori::create($data);

        return $this->successResponse(new KategoriResource($kategori), 'Kategori berhasil dibuat', 201);
    }

    public function show(Request $request, Kategori $kategori)
    {
        if ($response = $this->authorizeAdmin($request)) {
            return $response;
        }
        return $this->successResponse(new KategoriResource($kategori), 'Detail kategori berhasil diambil');
    }

    public function update(UpdateKategoriRequest $request, Kategori $kategori)
    {
        if ($response = $this->authorizeAdmin($request)) {
            return $response;
        }

        $data = $request->validated();

        $kategori->update($data);

        return $this->successResponse(new KategoriResource($kategori), 'Kategori berhasil diperbarui');
    }

    public function destroy(Request $request, Kategori $kategori)
    {
        if ($response = $this->authorizeAdmin($request)) {
            return $response;
        }

        if ($kategori->keahlians()->exists()) {
            return $this->errorResponse('Kategori masih memiliki keahlian', 400);
        }

        $kategori->delete();

        return $this->successResponse(null, 'Kategori berhasil dihapus');
    }
}
