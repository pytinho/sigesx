<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServidorController;

Route::get('/', fn () => redirect()->route('servidores.create'));
Route::resource('servidores', ServidorController::class);
