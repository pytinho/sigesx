<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServidorController;

// rota inicial (home) redireciona para a listagem de servidores
Route::get('/', function () {
    return redirect()->route('servidores.index');
});

Route::resource('servidores', ServidorController::class)
     ->parameters(['servidores' => 'servidor']);
