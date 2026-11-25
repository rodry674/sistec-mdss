<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_ticket')->unique();
            $table->text('descripcion_incidente');

            $table->foreignId('area_municipal_id')
                ->constrained('area_municipals')
                ->onUpdate('restrict')
                ->onDelete('restrict');

            $table->foreignId('categoria_id')
                ->constrained('categorias')
                ->onUpdate('restrict')
                ->onDelete('restrict');

            $table->foreignId('tecnico_id')
                ->nullable()
                ->constrained('tecnicos')
                ->onUpdate('set null')
                ->onDelete('set null');

            $table->string('prioridad')->default('MEDIA')->index();
            $table->string('estado')->default('PENDIENTE')->index();
            $table->index(['estado', 'prioridad']);

            $table->text('diagnostico_solucion')->nullable();
            $table->timestamp('fecha_cierre')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};