<?php

namespace Database\Factories;

use App\Models\Servidor;
use App\Models\Funcao;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class ServidorFactory extends Factory
{
    protected $model = Servidor::class;

    public function definition(): array
    {
        $faker = fake('pt_BR');

        $ufsCidades = [
            ['TO','Palmas'], ['TO','Araguaína'], ['TO','Gurupi'],
            ['PA','Belém'], ['PA','Marabá'],
            ['PB','João Pessoa'], ['PB','Campina Grande'],
            ['DF','Brasília'], ['SP','São Paulo'], ['RJ','Rio de Janeiro'],
        ];
        [$uf, $cidade] = Arr::random($ufsCidades);

        $vinculos = ['Efetivo','Temporário','Comissionado','Estagiário','Voluntário','Requisitado','Cedido','Designado','Substituto','Readaptado'];
        $cargas   = [20,30,40];
        $sexos    = ['F','M'];

        $dtNascimento = Carbon::now()->subYears(rand(21, 60))->subDays(rand(0, 365));
        $dtEntrada    = Carbon::now()->subYears(rand(0, 15))->subDays(rand(0, 365));
        $dtSaida      = (rand(0,4) === 1) ? $dtEntrada->copy()->addYears(rand(0,5))->addDays(rand(0,200)) : null;

        return [
            'nome'            => $faker->name(),
            'cpf'             => $faker->unique()->cpf(), // formatado 000.000.000-00
            'dt_nascimento'   => $dtNascimento->format('Y-m-d'),
            'naturalidade'    => Arr::random(['Palmas','Araguaína','Belém','Brasília','Rio de Janeiro','São Paulo']),
            'cep'             => preg_replace('/\D/','',$faker->postcode()), // 77000000...
            'endereco'        => $faker->streetAddress(),
            'lote'            => (string) rand(1, 200),
            'cidade'          => $cidade,
            'uf'              => $uf,
            'cargo'           => Arr::random(['Agente Adm Educacional','Professor','Coordenador','Diretor','Assistente Administrativo','Auxiliar']),
            'vinculo'         => Arr::random($vinculos),
            'dt_entrada'      => $dtEntrada->format('Y-m-d'),
            'dt_saida'        => $dtSaida?->format('Y-m-d'),
            'unidade_escolar' => Arr::random(['Escola Municipal Luiz Gonzaga','Escola Municipal Tocantins','CEM Centro']),
            'codigo_ue'       => $faker->numerify('###.#.##'),
            'email'           => $faker->unique()->safeEmail(),
            'contato'         => $faker->cellphoneNumber(),
            'sexo'            => Arr::random($sexos),
            'funcao_id'       => Funcao::inRandomOrder()->value('id') ?? Funcao::factory(),
            'carga_horaria'   => Arr::random($cargas),
        ];
    }
}
