<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('users.index');
})->name('users.index');
Route::get('/{id}', function () {
    return view('users.show');
})->name('users.show');
