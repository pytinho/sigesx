<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('pdfs', function (Blueprint $table) {
      $table->id();
      $table->string('titulo');               // nome amigável
      $table->unsignedSmallInteger('ano');    // opcional, ajuda organizar
      $table->string('disk')->default('local');
      $table->string('path');                 // ex: pdfs/2025/uuid.pdf
      $table->string('mime');                 // application/pdf
      $table->unsignedBigInteger('size');     // bytes
      $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // quem subiu (se quiser)
      $table->timestamps();

      $table->index(['ano']);
    });
  }
  public function down(): void {
    Schema::dropIfExists('pdfs');
  }
};
