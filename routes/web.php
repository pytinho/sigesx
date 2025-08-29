<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServidorController;
use App\Http\Controllers\AuthController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'show'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
});

Route::middleware('auth')->group(function () {
    Route::get('/', fn() => redirect()->route('servidores.index'))->name('home');

    Route::resource('servidores', ServidorController::class)
         ->parameters(['servidores' => 'servidor']);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
