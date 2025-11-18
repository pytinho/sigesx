<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('servidores', function (Blueprint $table) {
            $table->string('contato', 25)->nullable()->after('email');
        });

        // Preenche contato com o que existir (ddd e/ou celular)
        DB::statement("
            UPDATE servidores
               SET contato = TRIM(CONCAT(COALESCE(NULLIF(ddd,''), ''), 
                                         CASE 
                                           WHEN (ddd IS NOT NULL AND ddd <> '' AND celular IS NOT NULL AND celular <> '') THEN ' '
                                           ELSE ''
                                         END,
                                         COALESCE(NULLIF(celular,''), '')))
        ");

        // Remove as colunas antigas
        Schema::table('servidores', function (Blueprint $table) {
            if (Schema::hasColumn('servidores', 'ddd'))     $table->dropColumn('ddd');
            if (Schema::hasColumn('servidores', 'celular')) $table->dropColumn('celular');
        });
    }

    public function down(): void
    {
        // Recria ddd e celular 
        Schema::table('servidores', function (Blueprint $table) {
            $table->string('ddd', 255)->nullable()->after('email');
            $table->string('celular', 255)->nullable()->after('ddd');
        });

        DB::statement("UPDATE servidores SET ddd = contato");

        Schema::table('servidores', function (Blueprint $table) {
            $table->dropColumn('contato');
        });
    }
};
