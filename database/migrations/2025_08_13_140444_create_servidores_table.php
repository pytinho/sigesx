<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('servidores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cpf')->unique();
            $table->date('dt_nascimento')->nullable();
            $table->string('email')->nullable();
            $table->string('ddd')->nullable();
            $table->string('celular')->nullable();
            $table->string('naturalidade')->nullable();
            $table->string('sexo')->nullable();
            $table->unsignedBigInteger('funcao_id')->nullable();
            $table->foreign('funcao_id')->references('id')->on('funcoes');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servidores');
    }
};
