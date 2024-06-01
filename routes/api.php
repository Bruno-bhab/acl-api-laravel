<?php

use App\Http\Controllers\Api\Auth\AuthApiController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/me', [AuthApiController::class, 'me'])->middleware('auth:sanctum')->name('auth.me');
Route::post('/logout', [AuthApiController::class, 'logout'])->middleware('auth:sanctum')->name('auth.logout');
Route::post('/auth', [AuthApiController::class, 'auth'])->name('auth.login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('/permissions', PermissionController::class);
    Route::apiResource('users', UserController::class);
});


