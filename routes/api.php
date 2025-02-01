<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::middleware(['api'])->group(function() {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::prefix('users')->group(function() {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::get('{user}', [UserController::class, 'show'])->name('users.show');
    });

    Route::middleware(['auth:sanctum'])->group(function() {
        Route::get('/protected', [AuthController::class, 'protectedRoute'])->name('protectedRoute');
    });
});