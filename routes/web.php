<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServidorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeclaracaoController; // <-- ADICIONADO

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

    // ===== ROTAS DE DECLARAÇÕES =====
    Route::get('/declaracoes', [DeclaracaoController::class, 'index'])->name('declaracoes.index');
    Route::get('/declaracoes/lookup', [DeclaracaoController::class, 'lookup'])->name('declaracoes.lookup');
    Route::post('/declaracoes/gerar', [DeclaracaoController::class, 'gerar'])->name('declaracoes.gerar');
    // ================================

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
