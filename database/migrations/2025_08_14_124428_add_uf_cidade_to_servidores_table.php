<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('servidores', function (Blueprint $table) {
            $table->string('cidade', 120)->nullable()->after('endereco');
            $table->char('uf', 2)->nullable()->after('cidade');
           
            $table->index(['uf', 'cidade']);
        });
    }

    public function down(): void
    {
        Schema::table('servidores', function (Blueprint $table) {
            $table->dropIndex(['servidores_uf_cidade_index']);
            $table->dropColumn(['cidade', 'uf']);
        });
    }
};
