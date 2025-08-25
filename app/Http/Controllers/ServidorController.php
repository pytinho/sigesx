<?php

namespace App\Http\Controllers;

use App\Models\Servidor;
use App\Models\Funcao;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ServidorController extends Controller
{
    public function index()
    {
       
        $servidores = Servidor::latest()->paginate(10);
        return view('servidores.index', compact('servidores'));
    }

    public function create()
    {
        $funcoes = Funcao::orderBy('nome')->get();
        return view('servidores.create', compact('funcoes'));
    }

public function store(Request $request)
{
    $ufs = ['AC','AL','AM','AP','BA','CE','DF','ES','GO','MA','MG','MS','MT','PA','PB','PE','PI','PR','RJ','RN','RO','RR','RS','SC','SE','SP','TO'];

    $validated = $request->validate(
        [
            'nome'            => ['required','string','max:255'],
            'cpf'             => ['required','string','max:255','unique:servidores,cpf'],
            'email'           => ['required','email','max:255'],
            'dt_nascimento'   => ['required','date_format:d/m/Y'],
            'naturalidade'    => ['nullable','string','max:255'],
            'cep'             => ['required','string','max:20'],
            'endereco'        => ['required','string','max:255'],
            'lote'            => ['required','string','max:50'],
            'cidade'          => ['required','string','max:120'],
            'uf'              => ['required','string','size:2', function($attr,$value,$fail) use ($ufs){
                                     if ($value && !in_array(strtoupper($value), $ufs)) $fail('UF inválida.');
                                  }],
            'cargo'           => ['required','string','max:255'],
            'funcao_id'       => ['required','exists:funcoes,id'],
            'vinculo'         => ['required','string','max:60'],
            'dt_entrada'      => ['required','date_format:d/m/Y'],
            'dt_saida'        => ['nullable','date_format:d/m/Y'],
            'unidade_escolar' => ['nullable','string','max:180'],
            'codigo_ue'       => ['nullable','string','max:40'],
            'contato'         => ['required','string','max:25'],
        ],
        // Mensagens personalizadas
        [
            'required'        => 'O campo :attribute é obrigatório.',
            'email.email'     => 'Informe um e-mail válido.',
            'date_format'     => 'O campo :attribute deve estar no formato :format.',
            'cpf.unique'      => 'Já existe um servidor cadastrado com este CPF.',
            'funcao_id.exists'=> 'Selecione uma Função válida.',
        ],

        //personalização dos nomes dos campos
        [
            'nome'            => 'Nome',
            'cpf'             => 'CPF',
            'email'           => 'E-mail',
            'dt_nascimento'   => 'Data de Nascimento',
            'cep'             => 'CEP',
            'endereco'        => 'Endereço',
            'lote'            => 'Lote',
            'cidade'          => 'Cidade',
            'uf'              => 'UF',
            'cargo'           => 'Cargo',
            'funcao_id'       => 'Função',
            'vinculo'         => 'Vínculo',
            'dt_entrada'      => 'Data de Entrada',
            'dt_saida'        => 'Data de Saída',
            'unidade_escolar' => 'Unidade Escolar',
            'codigo_ue'       => 'Código da UE',
            'contato'         => 'Contato',
        ]
    );

    // Normaliza UF
    $validated['uf'] = strtoupper($validated['uf']);

    // Naturalidade: "Cidade/UF"
    $validated['naturalidade'] = trim(($validated['cidade'] ?? '') . '/' . ($validated['uf'] ?? ''));

    // Converte datas dd/mm/aaaa -> Y-m-d
    $toDate = function ($v) {
        return $v ? Carbon::createFromFormat('d/m/Y', $v)->format('Y-m-d') : null;
    };
    if (!empty($validated['dt_nascimento'])) $validated['dt_nascimento'] = $toDate($validated['dt_nascimento']);
    if (!empty($validated['dt_entrada']))    $validated['dt_entrada']    = $toDate($validated['dt_entrada']);
    if (!empty($validated['dt_saida']))      $validated['dt_saida']      = $toDate($validated['dt_saida']);

    Servidor::create($validated);

    return redirect()->route('servidores.index')->with('success','Servidor cadastrado com sucesso!');
}

}

