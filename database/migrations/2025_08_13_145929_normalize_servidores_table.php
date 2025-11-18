<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('servidors') && !Schema::hasTable('servidores')) {
            Schema::rename('servidors', 'servidores');
        }
        if (Schema::hasTable('servidores_table') && !Schema::hasTable('servidores')) {
            Schema::rename('servidores_table', 'servidores');
    }

    if (Schema::hasTable('servidors') && Schema::hasTable('servidores')) {
        Schema::drop('servidors');
    }
    if (Schema::hasTable('servidores_table') && Schema::hasTable('servidores')) {
        Schema::drop('servidores_table');
    }
}
public function down(): void
{
   
}
};
