<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Servidor;

class ServidorSeeder extends Seeder
{
    public function run(): void
    {
        Servidor::factory()->count(50)->create();
    }
}
