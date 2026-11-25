<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->index(); // MEJORA: Índice para búsquedas rápidas.
            $table->integer('sla_horas_defecto')->default(2);
            $table->string('prioridad_defecto')->default('ALTA');
            $table->timestamps();

            // MEJORA: Índice único.
            $table->unique(['nombre']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};