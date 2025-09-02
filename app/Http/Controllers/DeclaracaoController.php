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
        'vinculo'   => 'Declaração de Vínculo',
        'funcao'    => 'Declaração de Função',
        'frequencia'=> 'Declaração de Frequência',
    ];

    public function index()
    {
        $tipos = self::TIPOS;                 // <- casa com sua view
        return view('declaracoes.index', compact('tipos'));
    }

    // AJAX: dado um CPF, busca o servidor e retorna campos pra auto-preencher
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
            'nome'    => $s->nome,
            'email'   => $s->email,
            'cargo'   => $s->cargo,
            'funcao'  => optional($s->funcao)->nome,
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

        $payload = [
            'titulo'   => self::TIPOS[$data['tipo']],
            'tipo'     => $data['tipo'],
            'servidor' => $servidor,
            'agora'    => now()->locale('pt_BR'),
        ];

        // Renderiza o Blade e baixa o PDF
        $pdf = Pdf::loadView('declaracoes.pdf', $payload)->setPaper('a4');
        $filename = Str::slug(self::TIPOS[$data['tipo']].' '.$servidor->nome).'.pdf';

        return $pdf->download($filename);
    }

    /**
     * Busca por CPF usando apenas dígitos, independente de máscara no BD.
     * Funciona mesmo que o CPF esteja salvo como '000.000.000-00'.
     */
    private function findByCpfDigits(string $cpfDigits): ?Servidor
    {
        // MySQL 5/8 compat: remove ., - e / (ajuste se precisar de +REPLACE)
        return Servidor::query()
            ->with('funcao')
            ->whereRaw("REPLACE(REPLACE(REPLACE(cpf, '.', ''), '-', ''), '/', '') = ?", [$cpfDigits])
            ->first();
    }
}
