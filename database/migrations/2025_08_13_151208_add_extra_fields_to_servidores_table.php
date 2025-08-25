<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('servidores', function (Blueprint $table) {
            // só adiciona se não existir (idempotente p/ ambientes)
            if (!Schema::hasColumn('servidores', 'naturalidade'))  $table->string('naturalidade')->nullable()->after('dt_nascimento');
            if (!Schema::hasColumn('servidores', 'cep'))           $table->string('cep', 20)->nullable()->after('naturalidade');
            if (!Schema::hasColumn('servidores', 'endereco'))      $table->string('endereco')->nullable()->after('cep');
            if (!Schema::hasColumn('servidores', 'cargo'))         $table->string('cargo')->nullable()->after('endereco');
            if (!Schema::hasColumn('servidores', 'vinculo'))       $table->string('vinculo', 60)->nullable()->after('cargo');
            if (!Schema::hasColumn('servidores', 'dt_entrada'))    $table->date('dt_entrada')->nullable()->after('vinculo');
            if (!Schema::hasColumn('servidores', 'dt_saida'))      $table->date('dt_saida')->nullable()->after('dt_entrada');
            if (!Schema::hasColumn('servidores', 'unidade_escolar')) $table->string('unidade_escolar', 180)->nullable()->after('dt_saida');
            if (!Schema::hasColumn('servidores', 'codigo_ue'))     $table->string('codigo_ue', 40)->nullable()->after('unidade_escolar');
        });
    }

    public function down(): void
    {
        Schema::table('servidores', function (Blueprint $table) {
            if (Schema::hasColumn('servidores', 'codigo_ue'))       $table->dropColumn('codigo_ue');
            if (Schema::hasColumn('servidores', 'unidade_escolar')) $table->dropColumn('unidade_escolar');
            if (Schema::hasColumn('servidores', 'dt_saida'))        $table->dropColumn('dt_saida');
            if (Schema::hasColumn('servidores', 'dt_entrada'))      $table->dropColumn('dt_entrada');
            if (Schema::hasColumn('servidores', 'vinculo'))         $table->dropColumn('vinculo');
            if (Schema::hasColumn('servidores', 'cargo'))           $table->dropColumn('cargo');
            if (Schema::hasColumn('servidores', 'endereco'))        $table->dropColumn('endereco');
            if (Schema::hasColumn('servidores', 'cep'))             $table->dropColumn('cep');
            if (Schema::hasColumn('servidores', 'naturalidade'))    $table->dropColumn('naturalidade');
        });
    }
};
