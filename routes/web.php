<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServidorController;

Route::resource('servidores', ServidorController::class)
     ->parameters(['servidores' => 'servidor']);
