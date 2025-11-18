<?php

namespace App\Http\Controllers;

use App\Models\Servidor;
use App\Models\Pdf;

class HomeController extends Controller
{
    public function index()
    {
        // estatísticas gerais home
        $totalServidores = Servidor::count();
        $totalPdfs       = Pdf::count();

        // ultimas adições home
        $servidoresRecentes = Servidor::orderByDesc('id')->limit(5)->get();
        $pdfsRecentes       = Pdf::orderByDesc('id')->limit(5)->get();

        return view('home', compact(
            'totalServidores',
            'totalPdfs',
            'servidoresRecentes',
            'pdfsRecentes'
        ));
    }
}
