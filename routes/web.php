<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServidorController;
use App\Http\Controllers\AuthController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'show'])->name('login');

    // throttle simples: 5 tentativas / minuto por IP
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.perform');
});

Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::get('/', fn() => redirect()->route('servidores.index'))->name('home');

    Route::resource('servidores', ServidorController::class)
         ->parameters(['servidores' => 'servidor']);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
