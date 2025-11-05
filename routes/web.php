<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServidorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeclaracaoController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\HomeController;


Route::middleware(['auth'])->group(function () {
  Route::get('/pdfs', [PdfController::class, 'index'])->name('pdfs.index');
  Route::post('/pdfs', [PdfController::class, 'store'])->name('pdfs.store');
  Route::get('/pdfs/{pdf}/download', [PdfController::class, 'download'])->name('pdfs.download');
  Route::delete('/pdfs/{pdf}', [PdfController::class, 'destroy'])->name('pdfs.destroy');
});


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'show'])->name('login');

    // throttle simples: 5 tentativas / minuto por IP
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.perform');
});

Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::resource('servidores', ServidorController::class)
         ->parameters(['servidores' => 'servidor']);

    // ===== ROTAS DE DECLARAÇÕES =====
    Route::get('/declaracoes', [DeclaracaoController::class, 'index'])->name('declaracoes.index');
    Route::get('/declaracoes/lookup', [DeclaracaoController::class, 'lookup'])->name('declaracoes.lookup');
    Route::post('/declaracoes/gerar', [DeclaracaoController::class, 'gerar'])->name('declaracoes.gerar');
    // ================================

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
