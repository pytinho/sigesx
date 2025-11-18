<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('servidores', function (Blueprint $table) {
            $table->unsignedSmallInteger('carga_horaria')->nullable()->after('vinculo');
        });
    }

    public function down(): void
    {
        Schema::table('servidores', function (Blueprint $table) {
            $table->dropColumn('carga_horaria');
        });
    }
};
