<?php

namespace Tests\Unit;

use App\Services\IncidenteService;
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
            'codigo_patrimonial' => 'PAT-2026-001',
        ];

        $resultado = $service->registrarRecepcion($datosInput);

        $this->assertEquals('Recepcionado', $resultado['estado']);
        $this->assertEquals('PAT-2026-001', $resultado['codigo_patrimonial']);
        $this->assertArrayHasKey('fecha_ingreso', $resultado);
    }
}
