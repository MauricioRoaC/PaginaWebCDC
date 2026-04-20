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
    Schema::create('contacts', function (Blueprint $table) {
        $table->id();

        $table->foreignId('contact_category_id')
            ->nullable()
            ->constrained()
            ->nullOnDelete();

        $table->string('name');                     // Nombre de la unidad: FELCC, FELCV, etc.
        $table->text('description')->nullable();    // Qué hace esa unidad
        $table->string('phone')->nullable();        // Teléfono

        $table->string('map_url')->nullable();      // URL a Google Maps (para abrir al click)
        $table->decimal('lat', 10, 7)->nullable();  // Latitud
        $table->decimal('lng', 10, 7)->nullable();  // Longitud

        $table->string('logo_path')->nullable();    // Imagen opcional
        $table->boolean('is_visible')->default(true);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
