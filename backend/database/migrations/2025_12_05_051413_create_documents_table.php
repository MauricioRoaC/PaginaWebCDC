<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();          // N° de documento
            $table->string('title');                       // Título
            $table->text('description')->nullable();       // Descripción
            $table->enum('type', ['rendicion', 'poa', 'pei']); // Tipo: 3 secciones
            $table->string('file_path');                   // Ruta del PDF en storage
            $table->boolean('is_public')->default(true);   // Por si luego quieres ocultar algo
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
