<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FuncoesSeeder extends Seeder
{
    public function run(): void
    {
        $nomes = [
            'Assistente Administrativo Educacional',
            'Auxiliar de Serviços Gerais',
            'Auxiliar de Biblioteca',
            'Auxiliar de Laboratório de Informática',
            'Coordenador(a) Pedagógico(a)',
            'Diretor(a)',
            'Merendeiro(a)',
            'Monitor(a) de Apoio Escolar',
            'Orientador(a) Educacional',
            'Professor(a) Ensino Fundamental I',
            'Professor(a) Ensino Fundamental II',
            'Secretário(a) Escolar',
            'Supervisor(a) Escolar',
            'Vigia / Porteiro(a)',
        ];

        foreach ($nomes as $nome) {
            DB::table('funcoes')->updateOrInsert(
                ['nome' => $nome],
                [] // evita duplicar se rodar novamente
            );
        }
    }
}
