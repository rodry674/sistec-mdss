<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 50);
            $table->string('titulo', 150);
            $table->text('descripcion');
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->foreignId('area_id')->constrained('area_municipals')->onDelete('cascade');
            $table->foreignId('tecnico_id')->nullable()->constrained('tecnicos')->nullOnDelete();
            $table->string('solicitante', 150);
            $table->string('prioridad', 20)->default('Media');
            $table->integer('sla_horas')->nullable();
            $table->string('estado', 30)->default('Recepcionado');
            $table->text('diagnostico')->nullable();
            $table->text('solucion')->nullable();
            $table->dateTime('fecha_cierre')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
