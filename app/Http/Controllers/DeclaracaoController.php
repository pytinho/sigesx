<?php

namespace App\Http\Controllers;

use App\Models\Servidor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Barryvdh\DomPDF\Facade\Pdf; // barryvdh/laravel-dompdf

class DeclaracaoController extends Controller
{
    // Tipos exibidos no select da view
    private const TIPOS = [
        'vinculo'      => 'Declaração de Vínculo',
        'funcao'       => 'Declaração de Função',
        'frequencia'   => 'Declaração de Frequência',
        'inicio'       => 'Declaração de Início de Atividade',
        'encerramento' => 'Declaração de Encerramento de Atividade',
    ];

    public function index()
    {
        $tipos = self::TIPOS;
        return view('declaracoes.index', compact('tipos'));
    }

    // JSON: dado um CPF, busca o servidor e retorna campos para auto-preencher
    public function lookup(Request $request)
    {
        $cpfDigits = preg_replace('/\D/', '', (string) $request->query('cpf'));
        if (strlen($cpfDigits) !== 11) {
            return response()->json(['ok' => false, 'message' => 'CPF inválido.']);
        }

        $s = $this->findByCpfDigits($cpfDigits);
        if (!$s) {
            return response()->json(['ok' => false, 'message' => 'Servidor não encontrado.']);
        }

        return response()->json([
            'ok'   => true,
            'data' => [
                'nome'   => $s->nome,
                'email'  => $s->email,
                'cargo'  => $s->cargo,
                'funcao' => optional($s->funcao)->nome,
            ]
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
            throw ValidationException::withMessages(['cpf' => 'CPF inválido.']);
        }

        $servidor = $this->findByCpfDigits($cpfDigits);
        if (!$servidor) {
            throw ValidationException::withMessages(['cpf' => 'CPF não encontrado.']);
        }

        // Regra: não gerar declaração de encerramento se não houver dt_saida
        if ($data['tipo'] === 'encerramento' && empty($servidor->dt_saida)) {
            throw ValidationException::withMessages([
                'tipo' => 'Servidor ainda ativo (sem data de saída). Não é possível gerar a declaração de encerramento.'
            ]);
        }

        $payload = [
            'titulo'   => self::TIPOS[$data['tipo']],
            'tipo'     => $data['tipo'],
            'servidor' => $servidor,
            'agora'    => now()->locale('pt_BR'),
        ];

        // Seleciona a view do PDF conforme o tipo
        $view = match ($data['tipo']) {
            'inicio'       => 'declaracoes.pdf_inicio',
            'encerramento' => 'declaracoes.pdf_encerramento',
            'vinculo'      => 'declaracoes.pdf_vinculo',
            default        => 'declaracoes.pdf',
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