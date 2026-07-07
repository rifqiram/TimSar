<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMentorRequest extends FormRequest
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
            'nama' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:tabel_mentor,email,' . $this->route('mentor')->id,
            'telepon' => 'nullable|string|max:50',
            'keahlian' => 'nullable|string|max:255',
        ];
    }
}
