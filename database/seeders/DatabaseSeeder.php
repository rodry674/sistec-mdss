<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Áreas Usuarias de la Municipalidad Distrital de San Sebastián
        DB::table('area_municipals')->insertOrIgnore([
            ['id' => 1, 'nombre' => 'Gerencia de Administración y Finanzas', 'descripcion' => 'Gestión administrativa y tesorería', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nombre' => 'Subgerencia de Remuneraciones', 'descripcion' => 'Control de planillas y haberes', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nombre' => 'Gerencia de Infraestructura y Obras', 'descripcion' => 'Supervisión y ejecución de obras públicas', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nombre' => 'Oficina de Gestión de Riesgos (OGRD)', 'descripcion' => 'Defensa civil y prevención', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'nombre' => 'Mesa de Partes y Trámite Documentario', 'descripcion' => 'Atención al ciudadano y recepción documental', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 2. Catálogo de Tipos de Equipos e Incidentes (PBI-05)
        DB::table('categorias')->insertOrIgnore([
            ['id' => 1, 'nombre' => 'Computadora de Escritorio (CPU)', 'descripcion' => 'Mantenimiento de hardware, fuente y sistema operativo', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nombre' => 'Laptop Institucional', 'descripcion' => 'Equipos portátiles de gerencias y campo', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nombre' => 'Impresora / Escáner Multifuncional', 'descripcion' => 'Insumos, tóner, cabezales y atascos', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nombre' => 'Redes, Cableado e Internet', 'descripcion' => 'Puntos de red RJ45, switches y conectividad', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'nombre' => 'Software Municipal (SIADEG / SIAF)', 'descripcion' => 'Configuración de sistemas administrativos', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 3. Especialistas Técnicos de la OTSI
        DB::table('tecnicos')->insertOrIgnore([
            ['id' => 1, 'nombres' => 'Carlos', 'apellidos' => 'Quispe Mamani', 'email' => 'cquispe@munisansebastian.gob.pe', 'telefono' => '984111222', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nombres' => 'Luis', 'apellidos' => 'Condori Huamán', 'email' => 'lcondori@munisansebastian.gob.pe', 'telefono' => '984333444', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nombres' => 'Andrea', 'apellidos' => 'Tito Ccahuana', 'email' => 'atito@munisansebastian.gob.pe', 'telefono' => '984555666', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
