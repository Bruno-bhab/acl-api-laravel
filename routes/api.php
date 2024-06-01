<?php

use App\Http\Controllers\Api\Auth\AuthApiController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\PermissionUserController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/me', [AuthApiController::class, 'me'])->middleware('auth:sanctum')->name('auth.me');
Route::post('/logout', [AuthApiController::class, 'logout'])->middleware('auth:sanctum')->name('auth.logout');
Route::post('/auth', [AuthApiController::class, 'auth'])->name('auth.login');

Route::middleware(['auth:sanctum', 'acl'])->group(function () {
    Route::apiResource('/permissions', PermissionController::class);

    Route::post('/users/{user}/permissions-sync', [PermissionUserController::class, 'syncPermissionsOfUser'])->name('users.permissions-sync');
    Route::get('/users/{user}/permissions', [PermissionUserController::class, 'getPermissionsOfUser'])->name('users.permissions');

    Route::apiResource('/users', UserController::class);
});
