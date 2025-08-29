<?php

namespace Database\Seeders;

use App\Models\Funcao;
use Illuminate\Database\Seeder;

class FuncaoSeeder extends Seeder
{
    public function run(): void
    {
        $nomes = [
            'Docente', 'Coordenador Pedagógico', 'Diretor', 'Vice-diretor',
            'Agente Administrativo', 'Auxiliar de Serviços Gerais',
            'Monitor', 'Bibliotecário', 'Secretário Escolar', 'TI Suporte'
        ];

        foreach ($nomes as $n) {
            Funcao::firstOrCreate(['nome' => $n]);
        }
    }
}
