<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cargo')->default('Especialista de Soporte OTSI')->after('email');
            $table->string('rol')->default('tecnico')->after('cargo'); // 'jefe' | 'tecnico'
            $table->boolean('activo')->default(true)->after('rol');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->foreignId('registrado_por_user_id')
                ->nullable()
                ->after('tecnico_id')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropConstrainedForeignId('registrado_por_user_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['cargo', 'rol', 'activo']);
        });
    }
};
