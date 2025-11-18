<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('pdfs', function (Blueprint $table) {
      $table->id();
      $table->string('titulo');               
      $table->unsignedSmallInteger('ano');    
      $table->string('disk')->default('local');
      $table->string('path');                 
      $table->string('mime');                 
      $table->unsignedBigInteger('size'); 
      $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); 
      $table->timestamps();

      $table->index(['ano']);
    });
  }
  public function down(): void {
    Schema::dropIfExists('pdfs');
  }
};
