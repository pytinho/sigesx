<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FuncaoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => fake()->unique()->jobTitle(), // sobrescrito pelo seeder fixo
        ];
    }
}
