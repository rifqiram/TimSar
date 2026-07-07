<?php

namespace App\Http\Controllers;

use App\Http\Resources\KeahlianResource;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\UpdateProfilKeahlianRequest;

class ProfilKeahlianController extends Controller
{
    public function show(Peserta $peserta)
    {
        return $this->paginatedResponse(
            KeahlianResource::collection($peserta->keahlians()->with('kategori')->paginate($this->perPage)),
            'Profil keahlian peserta berhasil diambil'
        );
    }

    public function update(UpdateProfilKeahlianRequest $request, Peserta $peserta)
    {
        $data = $request->validated();

        $sync = collect($data['keahlian'])->mapWithKeys(function ($item) {
            return [$item['id'] => ['level' => $item['level'] ?? null]];
        })->all();

        $peserta->keahlians()->sync($sync);

        return $this->paginatedResponse(
            KeahlianResource::collection($peserta->keahlians()->with('kategori')->paginate($this->perPage)),
            'Profil keahlian peserta berhasil diperbarui'
        );
    }
}
