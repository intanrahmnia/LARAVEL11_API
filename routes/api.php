<?php

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(Authenticate::using('sanctum'));

//posts
Route::apiResource('/posts', App\Http\Controllers\Api\PostController::class);

Route::post('/persegi', [App\Http\Controllers\Api\PersegiController::class,
    'hitungPersegi']);

Route::post('/persegipanjang', [App\Http\Controllers\Api\PersegiPanjangController::class,
    'hitungPersegiPanjang']);

Route::post('/segitiga', [App\Http\Controllers\Api\SegitigaController::class, 
    'hitungSegitiga']);

Route::post('/lingkaran', [App\Http\Controllers\Api\LingkaranController::class, 
    'hitungLingkaran']);

Route::post('/kubus', [App\Http\Controllers\Api\KubusController::class, 
    'hitungKubus']);