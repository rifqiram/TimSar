<?php

namespace App\Http\Controllers;

use App\Http\Resources\PelatihanResource;
use App\Models\Pelatihan;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\GetRekomendasiRequest;

class RekomendasiController extends Controller
{
    public function index(GetRekomendasiRequest $request)
    {
        $data = $request->validated();

        $peserta = Peserta::with('keahlians')->findOrFail($data['peserta_id']);
        $pesertaKeahlianIds = $peserta->keahlians->pluck('id')->all();

        $pelatihanTerdaftarIds = $peserta->pendaftarans()->pluck('pelatihan_id')->all();

        $cacheKey = 'rekomendasi_peserta_' . $peserta->id;
        $rekomendasi = Cache::remember($cacheKey, 3600, function () use ($pesertaKeahlianIds, $pelatihanTerdaftarIds) {
            return Pelatihan::with(['mentor', 'keahlians.kategori'])
                ->where('is_active', true)
                ->whereNotIn('id', $pelatihanTerdaftarIds)
                ->get()
                ->map(function (Pelatihan $pelatihan) use ($pesertaKeahlianIds) {
                    $keahlianPelatihan = $pelatihan->keahlians;
                    $matched = $keahlianPelatihan->whereIn('id', $pesertaKeahlianIds)->values();
                    $missing = $keahlianPelatihan->whereNotIn('id', $pesertaKeahlianIds)->values();
                    $total = max($keahlianPelatihan->count(), 1);

                    return [
                        'pelatihan' => new PelatihanResource($pelatihan),
                        'matched_skills' => $matched->pluck('nama')->values(),
                        'missing_skills' => $missing->pluck('nama')->values(),
                        'match_count' => $matched->count(),
                        'gap_count' => $missing->count(),
                        'score' => round(($matched->count() / $total) * 100, 2),
                    ];
                })
                ->sortByDesc('score')
                ->values();
        });

        return $this->successResponse($rekomendasi, 'Rekomendasi pelatihan berhasil diambil');
    }
}
