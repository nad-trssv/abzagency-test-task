<?php

use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function() {
    Route::prefix('users')->group(function() {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::get('{user}', [UserController::class, 'show'])->name('users.show');
    });
});