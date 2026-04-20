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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            // Usuario que hizo la acción
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Tipo de acción
            $table->string('action'); // create, update, delete

            // Módulo (users, news, events, etc)
            $table->string('module');

            // Descripción del evento
            $table->text('description');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};