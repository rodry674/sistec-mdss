<?php

namespace Tests\Unit;

use App\Services\IncidenteService;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class IncidenteServiceTest extends TestCase
{
    public function test_debe_registrar_recepcion_de_equipo_con_estado_recepcionado(): void
    {
        $service = new IncidenteService;

        $datosInput = [
            'dni' => '12345678',
            'nombre_usuario' => 'Juan Pérez',
            'area_municipal' => 'Gerencia de Informática',
            'codigo_patrimonial' => 'pat-2026-001',
        ];

        $resultado = $service->registrarRecepcion($datosInput);

        $this->assertEquals('Recepcionado', $resultado['estado']);
        $this->assertEquals('PAT-2026-001', $resultado['codigo_patrimonial']);
        $this->assertArrayHasKey('fecha_ingreso', $resultado);
    }

    public function test_rechaza_recepcion_cuando_dni_no_tiene_8_digitos(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $service = new IncidenteService;
        $service->registrarRecepcion([
            'dni' => '123',
            'nombre_usuario' => 'Ana Gómez',
            'area_municipal' => 'Logística',
            'codigo_patrimonial' => 'PAT-2026-005',
        ]);
    }

    public function test_rechaza_recepcion_cuando_codigo_patrimonial_es_invalido(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $service = new IncidenteService;
        $service->registrarRecepcion([
            'dni' => '87654321',
            'nombre_usuario' => 'Luis Torres',
            'area_municipal' => 'Tesorería',
            'codigo_patrimonial' => '@@',
        ]);
    }
}