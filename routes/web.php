<?php

use App\Http\Controllers\CouchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LibraryController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'overview'])
        ->name('dashboard');

    Route::get('/couches', [CouchController::class, 'overview'])
        ->name('couches');

    Route::get('/couches/new', [CouchController::class, 'new'])
        ->name('couches.new');

    Route::post('/couches/new', [CouchController::class, 'create']);

    Route::get('/couches/{room_uuid}', [CouchController::class, 'view'])
        ->name('couch');


    Route::get('/couches/{room_uuid}/select', [CouchController::class, 'selection'])
        ->name('couch.select');

    Route::post('/couches/{room_uuid}/select', [CouchController::class, 'select']);

    Route::post('/couches/{room_uuid}/regenerate', [CouchController::class, 'regenerate'])
        ->name('couch.regenerate');

    Route::post('/couches/{room_uuid}/play', [CouchController::class, 'play']);

    Route::post('/couches/{room_uuid}/pause', [CouchController::class, 'pause']);

    Route::get('/library', [LibraryController::class, 'overview'])
        ->name('library');

    Route::get('/media/{file_uuid}', [LibraryController::class, 'media_serve'])
        ->name('media');

    Route::post('/media-upload', [LibraryController::class, 'media_upload'])
        ->name('media-upload');
});
