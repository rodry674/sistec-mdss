<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('area_municipals', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->index(); // MEJORA: Índice para búsquedas rápidas por nombre.
            $table->text('descripcion')->nullable();
            $table->timestamps();

            // MEJORA: Índice único compuesto para evitar nombres duplicados en la misma municipalidad.
            $table->unique(['nombre']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('area_municipals');
    }
};