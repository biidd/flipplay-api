<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul'               => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('media', 'judul')->ignore($this->route('media')),
            ],
            'jenis'               => ['sometimes', 'required', 'in:video,digital_reading'],
            'genre'               => ['sometimes', 'required', 'string', 'max:100'],
            'pembuat'             => ['nullable', 'string', 'max:255'],
            'tahun_rilis'         => ['nullable', 'integer', 'min:1900', 'max:2030'],
            'durasi_atau_halaman' => ['nullable', 'integer', 'min:1'],
            'deskripsi'           => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul media tidak boleh dikosongkan.',
            'judul.unique'   => 'Judul media sudah digunakan oleh media lain.',
            'jenis.in'       => 'Jenis media harus bernilai video atau digital_reading.',
            'genre.required' => 'Genre media tidak boleh dikosongkan.',
        ];
    }
}
