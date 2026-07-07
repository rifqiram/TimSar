<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePendaftaranRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'peserta_id' => 'sometimes|required|exists:tabel_peserta,id',
            'pelatihan_id' => 'sometimes|required|exists:tabel_pelatihan,id',
            'tanggal_daftar' => 'sometimes|required|date',
            'status' => 'sometimes|required|string|max:50',
        ];
    }
}
