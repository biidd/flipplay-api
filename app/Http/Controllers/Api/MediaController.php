<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MediaController extends Controller
{
    // GET /api/media?judul=...&jenis=...
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Media::query();

        if ($request->filled('judul')) {
            $query->where('judul', 'like', '%' . $request->query('judul') . '%');
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->query('jenis'));
        }

        return MediaResource::collection($query->latest()->get());
    }

    // POST /api/media
    public function store(StoreMediaRequest $request): JsonResponse
    {
        $media = Media::create($request->validated());

        return response()->json([
            'message' => 'Media berhasil ditambahkan ke sistem FlipPlay.',
            'data'    => new MediaResource($media),
        ], 201);
    }

    // GET /api/media/{media}
    public function show(Media $media): MediaResource
    {
        $media->load('users');

        return new MediaResource($media);
    }

    // PATCH/PUT /api/media/{media}
    public function update(UpdateMediaRequest $request, Media $media): JsonResponse
    {
        $media->update($request->validated());

        return response()->json([
            'message' => 'Data media berhasil diperbarui.',
            'data'    => new MediaResource($media),
        ]);
    }

    // DELETE /api/media/{media}
    public function destroy(Media $media): JsonResponse
    {
        $media->delete();

        return response()->json([
            'message' => 'Media berhasil dihapus dari sistem.',
        ]);
    }
}
