<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserCollectionController extends Controller
{
    // GET /api/users
    public function indexUsers(): AnonymousResourceCollection
    {
        return UserResource::collection(User::all());
    }

    // POST /api/users
    public function storeUser(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $user = User::create($validated);

        return response()->json([
            'message' => 'Pengguna berhasil dibuat.',
            'data'    => new UserResource($user),
        ], 201);
    }

    // GET /api/users/{user}/collection
    public function showCollection(User $user): UserResource
    {
        $user->load('media');

        return new UserResource($user);
    }

    // POST /api/users/{user}/collection
    public function addToCollection(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'media_id' => ['required', 'integer', 'exists:media,id'],
        ], [
            'media_id.required' => 'ID media wajib diisi.',
            'media_id.integer'  => 'ID media harus berupa angka.',
            'media_id.exists'   => 'Media tidak ditemukan di sistem.',
        ]);

        $mediaId = $validated['media_id'];

        // Skenario gagal: mencegah penambahan media yang sama dua kali ke koleksi user
        if ($user->media()->where('media_id', $mediaId)->exists()) {
            return response()->json([
                'message' => 'Media tersebut sudah ada di dalam koleksi pengguna.',
            ], 422);
        }

        $user->media()->attach($mediaId);
        $user->load('media');

        return response()->json([
            'message' => 'Media berhasil ditambahkan ke koleksi pengguna.',
            'data'    => new UserResource($user),
        ], 201);
    }

    // DELETE /api/users/{user}/collection/{media}
    public function removeFromCollection(User $user, Media $media): JsonResponse
    {
        if (! $user->media()->where('media_id', $media->id)->exists()) {
            return response()->json([
                'message' => 'Media tidak ditemukan di dalam koleksi pengguna ini.',
            ], 404);
        }

        $user->media()->detach($media->id);

        return response()->json([
            'message' => 'Media berhasil dihapus dari koleksi pengguna.',
        ]);
    }
}
