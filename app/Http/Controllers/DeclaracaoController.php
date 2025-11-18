<?php

namespace App\Http\Controllers;

use App\Models\Servidor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf; // barryvdh/laravel-dompdf

class DeclaracaoController extends Controller
{
    // Tipos exibidos no select da view
    private const TIPOS = [
        'inicio'       => 'Declaração de Início de Atividade',
        'encerramento' => 'Declaração de Encerramento de Atividade',
        'vinculo'      => 'Declaração de Vínculo',
    ];

    public function index()
    {
        $tipos = self::TIPOS;
        return view('declaracoes.index', compact('tipos'));
    }

    // AJAX: dado um CPF, busca o servidor e retorna campos para auto-preencher
    public function lookup(Request $request)
    {
        abort_unless($request->ajax(), 404);

        $cpfDigits = preg_replace('/\D/', '', (string) $request->query('cpf'));
        if (strlen($cpfDigits) !== 11) {
            return response()->json(['message' => 'CPF inválido.'], 422);
        }

        $s = $this->findByCpfDigits($cpfDigits);
        if (!$s) {
            return response()->json(['message' => 'Servidor não encontrado.'], 404);
        }

        return response()->json([
            'nome'   => $s->nome,
            'email'  => $s->email,
            'cargo'  => $s->cargo,
            'funcao' => optional($s->funcao)->nome,
        ]);
    }

    // POST: gera o PDF
    public function gerar(Request $request)
    {
        $data = $request->validate([
            'tipo' => ['required', 'in:'.implode(',', array_keys(self::TIPOS))],
            'cpf'  => ['required', 'string'],
        ]);

        $cpfDigits = preg_replace('/\D/', '', $data['cpf']);
        if (strlen($cpfDigits) !== 11) {
            return back()->withErrors(['cpf' => 'CPF inválido.'])->withInput();
        }

        $servidor = $this->findByCpfDigits($cpfDigits);
        if (!$servidor) {
            return back()->withErrors(['cpf' => 'Servidor não encontrado.'])->withInput();
        }

        // Regra: não gerar declaração de encerramento se não houver dt_saida
        if ($data['tipo'] === 'encerramento' && empty($servidor->dt_saida)) {
            return back()->withErrors([
                'tipo' => 'Não é possível gerar a declaração de encerramento. Servidor ainda ativo (sem data de saída). '
            ])->withInput();
        }

        $payload = [
            'titulo'   => self::TIPOS[$data['tipo']],
            'tipo'     => $data['tipo'],
            'servidor' => $servidor,
            'agora'    => now()->locale('pt_BR'),
        ];

        // Seleciona a view do PDF conforme o tipo
        $view = match ($data['tipo']) {
            'inicio'       => 'declaracoes.pdf_inicio',       // usa dt_entrada
            'encerramento' => 'declaracoes.pdf_encerramento', // usa dt_saida
            'vinculo'      => 'declaracoes.pdf_vinculo',      // texto específico + tabela
            default        => 'declaracoes.pdf',              // demais modelos
        };

        $pdf = Pdf::loadView($view, $payload)->setPaper('a4');
        $filename = Str::slug(self::TIPOS[$data['tipo']].' '.$servidor->nome).'.pdf';

        return $pdf->download($filename);
    }

    private function findByCpfDigits(string $cpfDigits): ?Servidor
    {
        return Servidor::query()
            ->with('funcao')
            ->whereRaw("REPLACE(REPLACE(REPLACE(cpf, '.', ''), '-', ''), '/', '') = ?", [$cpfDigits])
            ->first();
    }
}
