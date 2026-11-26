<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'judul'               => $this->judul,
            'jenis'               => $this->jenis,
            'genre'               => $this->genre,
            'pembuat'             => $this->pembuat,
            'tahun_rilis'         => $this->tahun_rilis,
            'durasi_atau_halaman' => $this->durasi_atau_halaman,
            'deskripsi'           => $this->deskripsi,
            'users'               => UserResource::collection($this->whenLoaded('users')),
            'created_at'          => $this->created_at?->toISOString(),
            'updated_at'          => $this->updated_at?->toISOString(),
        ];
    }
}
