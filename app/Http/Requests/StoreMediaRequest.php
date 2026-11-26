<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul'               => ['required', 'string', 'max:255', 'unique:media,judul'],
            'jenis'               => ['required', 'in:video,digital_reading'],
            'genre'               => ['required', 'string', 'max:100'],
            'pembuat'             => ['nullable', 'string', 'max:255'],
            'tahun_rilis'         => ['nullable', 'integer', 'min:1900', 'max:2030'],
            'durasi_atau_halaman' => ['nullable', 'integer', 'min:1'],
            'deskripsi'           => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul media wajib diisi.',
            'judul.unique'   => 'Judul media sudah terdaftar dan tidak boleh duplikat.',
            'jenis.required' => 'Jenis media wajib diisi.',
            'jenis.in'       => 'Jenis media harus bernilai video atau digital_reading.',
            'genre.required' => 'Genre media wajib diisi.',
        ];
    }
}
