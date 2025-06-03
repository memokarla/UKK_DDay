<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('pkl', App\Http\Controllers\Api\PklController::class);
Route::apiResource('siswa', App\Http\Controllers\Api\SiswaController::class);
Route::apiResource('guru', App\Http\Controllers\Api\GuruController::class);
Route::apiResource('industri', App\Http\Controllers\Api\IndustriController::class);