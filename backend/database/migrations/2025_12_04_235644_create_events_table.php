<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');                 // Asunto
            $table->text('description')->nullable(); // Detalle
            $table->timestamp('start_at');           // Inicio
            $table->timestamp('end_at')->nullable(); // Fin
            $table->boolean('all_day')->default(false);
            $table->string('location')->nullable();  // Ej: "Av. X cerrada..."
            $table->boolean('is_public')->default(true); // Por si luego quieres eventos internos
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};

