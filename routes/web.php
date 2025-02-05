<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\PosController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('users.index');
})->name('users.index');
Route::prefix('users')->group(function () {
    Route::get('/token', function () {
        return view('users.getToken');
    })->name('users.token');
    
    Route::get('/{id}', function ($id) {
        return view('users.show', ['id' => $id]);
    })->name('users.show');
});

Route::get('/positions', function () {
    return view('positions.index');
})->name('positions.index');

Route::get('/documentation', function () {
    return view('documentation.index');
})->name('documentation.index');