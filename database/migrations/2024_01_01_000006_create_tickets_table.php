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
            $table->string('codigo_ticket')->unique()->index(); // MEJORA: Indexar el código para búsquedas rápidas de trazabilidad.
            $table->text('descripcion_incidente');

            // MEJORA: Definición de llaves foráneas con restricciones de borrado explícitas.
            $table->foreignId('area_municipal_id')
                  ->constrained('area_municipals')
                  ->onUpdate('restrict') // Si cambia el ID de área, impide cambiarlo si hay tickets.
                  ->onDelete('restrict'); // Impide borrar un área si tiene tickets activos.

            $table->foreignId('categoria_id')
                  ->constrained('categorias')
                  ->onUpdate('restrict')
                  ->onDelete('restrict'); // Impide borrar una categoría crítica.

            $table->foreignId('tecnico_id')
                  ->nullable()
                  ->constrained('tecnicos')
                  ->onUpdate('set null')
                  ->onDelete('set null'); // Si se borra el técnico, el ticket queda sin asignar, pero persiste.

            // MEJORA: Índices compuestos para optimizar las consultas típicas de los dashboards de soporte.
            $table->string('prioridad')->default('MEDIA')->index();
            $table->string('estado')->default('PENDIENTE')->index();
            $table->index(['estado', 'prioridad']);

            $table->text('diagnostico_solucion')->nullable();
            $table->timestamp('fecha_cierre')->nullable()->index(); // Indexar fecha cierre para reportes.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};