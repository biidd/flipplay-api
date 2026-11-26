<?php

use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\UserCollectionController;
use Illuminate\Support\Facades\Route;

// CRUD Standar Entitas Media
Route::apiResource('media', MediaController::class)->parameters([
    'media' => 'media',
]);

// Pengguna & Custom Actions Koleksi Media Pengguna
Route::get('users', [UserCollectionController::class, 'indexUsers']);
Route::post('users', [UserCollectionController::class, 'storeUser']);
Route::get('users/{user}/collection', [UserCollectionController::class, 'showCollection']);
Route::post('users/{user}/collection', [UserCollectionController::class, 'addToCollection']);
Route::delete('users/{user}/collection/{media}', [UserCollectionController::class, 'removeFromCollection']);
