<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servidor;
use App\Models\Funcao;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class FolhaPontoController extends Controller
{
    public function index(Request $request)
    {
        $mes = (int) $request->query('mes', (int) now()->format('m'));
        $ano = (int) $request->query('ano', (int) now()->format('Y'));
        $mes = $mes >= 1 && $mes <= 12 ? $mes : (int) now()->format('m');
        $ano = $ano >= 1990 && $ano <= 2100 ? $ano : (int) now()->format('Y');

        $cpf       = trim((string) $request->query('cpf', ''));
        $cargo     = trim((string) $request->query('cargo', ''));
        $funcaoId  = $request->query('funcao_id');
        $cpfDigits = preg_replace('/\D/', '', $cpf);
        $gerar     = (bool) $request->query('gerar', false);

        // Dias do mês
        $dias = [];
        $inicio = Carbon::createFromDate($ano, $mes, 1);
        $diasNoMes = (int) $inicio->daysInMonth;
        for ($d = 1; $d <= $diasNoMes; $d++) {
            $dt = Carbon::createFromDate($ano, $mes, $d)->locale('pt_BR');
            $dias[] = [
                'n'   => $d,
                'dow' => $dt->isoFormat('dddd'),
            ];
        }

        $unidades = Servidor::query()
            ->whereNotNull('unidade_escolar')
            ->where('unidade_escolar', '!=', '')
            ->select('unidade_escolar')
            ->distinct()
            ->pluck('unidade_escolar');
        $unidadeUnica = $unidades->count() === 1 ? $unidades->first() : null;

        $servidores = collect();
        if ($gerar) {
            $servidores = Servidor::query()
                ->with('funcao')
                ->when($cpfDigits !== '', fn($qb) => $qb->whereRaw(
                    "REPLACE(REPLACE(REPLACE(cpf, '.', ''), '-', ''), '/', '') like ?",
                    ["%{$cpfDigits}%"]
                ))
                ->when($cargo !== '', fn($qb) => $qb->where('cargo', 'like', "%{$cargo}%"))
                ->when($funcaoId, fn($qb) => $qb->where('funcao_id', $funcaoId))
                ->when($unidadeUnica, fn($qb) => $qb->where('unidade_escolar', $unidadeUnica))
                ->orderBy('nome')
                ->get();
        }

        $funcoes = Funcao::orderBy('nome')->get(['id','nome']);

        return view('folha.folha', compact(
            'mes','ano','dias','servidores','cpf','cargo','funcaoId','funcoes','gerar','unidadeUnica'
        ));
    }

    public function pdf(Request $request)
    {
        $mes = (int) $request->input('mes');
        $ano = (int) $request->input('ano');
        $cpf = trim((string) $request->input('cpf',''));
        $cargo = trim((string) $request->input('cargo',''));
        $funcaoId = $request->input('funcao_id');

        if ($mes < 1 || $mes > 12) $mes = (int) now()->format('m');
        if ($ano < 1990 || $ano > 2100) $ano = (int) now()->format('Y');

        $cpfDigits = preg_replace('/\D/', '', $cpf);

        $dias = [];
        $inicio = Carbon::createFromDate($ano, $mes, 1);
        $diasNoMes = (int) $inicio->daysInMonth;
        for ($d = 1; $d <= $diasNoMes; $d++) {
            $dt = Carbon::createFromDate($ano, $mes, $d)->locale('pt_BR');
            $dias[] = [
                'n'   => $d,
                'dow' => $dt->isoFormat('dddd'),
            ];
        }

        $unidades = Servidor::query()
            ->whereNotNull('unidade_escolar')
            ->where('unidade_escolar', '!=', '')
            ->select('unidade_escolar')
            ->distinct()
            ->pluck('unidade_escolar');
        $unidadeUnica = $unidades->count() === 1 ? $unidades->first() : null;

        $servidores = Servidor::query()
            ->with('funcao')
            ->when($cpfDigits !== '', fn($qb) => $qb->whereRaw(
                "REPLACE(REPLACE(REPLACE(cpf, '.', ''), '-', ''), '/', '') like ?",
                ["%{$cpfDigits}%"]
            ))
            ->when($cargo !== '', fn($qb) => $qb->where('cargo', 'like', "%{$cargo}%"))
            ->when($funcaoId, fn($qb) => $qb->where('funcao_id', $funcaoId))
            ->when($unidadeUnica, fn($qb) => $qb->where('unidade_escolar', $unidadeUnica))
            ->orderBy('nome')
            ->get();

        if ($servidores->isEmpty()) {
            return back()->withErrors(['cpf' => 'Nenhum servidor encontrado para os filtros.'])->withInput();
        }

        $mesNome = Carbon::createFromDate($ano, $mes, 1)->locale('pt_BR')->monthName;
        $payload = compact('mes','ano','mesNome','dias','servidores');
        $pdf = Pdf::loadView('folha.pdf', $payload)->setPaper('a4', 'portrait');
        $filename = sprintf('folha-ponto-%02d-%04d.pdf', $mes, $ano);
        return $pdf->download($filename);
    }
}
