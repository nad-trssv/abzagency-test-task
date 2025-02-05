<?php

use App\Http\Controllers\API\PositionController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

    Route::post('/token', [AuthController::class, 'token'])->name('token');

    Route::prefix('/users')->group(function() {
        Route::get('/', [UserController::class, 'index'])->name('api.users.index');
        Route::get('/{user}', [UserController::class, 'show'])->name('api.users.show');
    });

    Route::get('/positions', [PositionController::class, 'index'])->name('api.positions.index');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/users', [UserController::class, 'store'])->name('api.users.store');
        Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
    });