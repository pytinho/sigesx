<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servidor;
use Barryvdh\DomPDF\Facade\Pdf; // PDF
use Carbon\Carbon;              // Datas

class DeclaracaoController extends Controller
{
    public function index()
    {
        // Tipos de declaração disponíveis (podemos mover para tabela/config depois)
        $tipos = [
            'inicio_atividade'  => 'Declaração de Início de Atividade',
            'encarregamento'    => 'Declaração de Encarregamento',
            'atividade_escolar' => 'Declaração de Atividade Escolar',
        ];

        return view('declaracoes.index', compact('tipos'));
    }

    public function lookup(Request $request)
    {
        $cpf = preg_replace('/\D/', '', (string) $request->query('cpf'));

        if (!$cpf || !$this->cpfValido($cpf)) {
            return response()->json(['message' => 'CPF inválido.'], 422);
        }

        $servidor = Servidor::with('funcao')->where('cpf', $cpf)->first();

        if (!$servidor) {
            return response()->json(['message' => 'Servidor não encontrado.'], 404);
        }

        return response()->json([
            'id'      => $servidor->id,
            'nome'    => $servidor->nome,
            'cpf'     => $servidor->cpf,
            'email'   => $servidor->email,
            'contato' => trim(($servidor->ddd ? "({$servidor->ddd}) " : '') . ($servidor->celular ?? '')),
            'cargo'   => $servidor->cargo,
            'funcao'  => optional($servidor->funcao)->nome,
            'entrada' => $servidor->dt_entrada,
            'saida'   => $servidor->dt_saida,
            'vinculo' => $servidor->vinculo,
        ]);
    }

    public function gerar(Request $request)
    {
        $data = $request->validate([
            'tipo' => 'required|string',
            'cpf'  => 'required|string',
        ]);

        $cpf = preg_replace('/\D/', '', $data['cpf']);

        $servidor = Servidor::with('funcao')
            ->where('cpf', $cpf)
            ->firstOrFail();

        // Seleciona o template pelo tipo
        $view = match ($data['tipo']) {
            'inicio_atividade'  => 'declaracoes.pdf.inicio_atividade',
            'encarregamento'    => 'declaracoes.pdf.encarregamento',
            'atividade_escolar' => 'declaracoes.pdf.atividade_escolar',
            default             => 'declaracoes.pdf.default',
        };

        // Payload para o Blade
        $payload = [
            'servidor' => $servidor,
            'hoje'     => Carbon::now()->locale('pt_BR'),
        ];

        $pdf = Pdf::loadView($view, $payload);

        $nomeArquivo = sprintf('declaracao_%s_%s.pdf', $data['tipo'], $cpf);

        // Abra no navegador com stream() se preferir
        // return $pdf->stream($nomeArquivo);
        return $pdf->download($nomeArquivo);
    }

    private function cpfValido(string $cpf): bool
    {
        if (strlen($cpf) !== 11 || preg_match('/^(.)\1{10}$/', $cpf)) return false;

        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ((int)$cpf[$t] !== $d) return false;
        }
        return true;
    }
}
