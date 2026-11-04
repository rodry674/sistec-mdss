<?php

namespace App\Services;

class IncidenteService
{
    public function registrarRecepcion(array $datos): array
    {
        return [
            'dni' => $datos['dni'],
            'nombre_usuario' => $datos['nombre_usuario'],
            'area_municipal' => $datos['area_municipal'],
            'codigo_patrimonial' => $datos['codigo_patrimonial'],
            'estado' => 'Recepcionado',
            'fecha_ingreso' => date('Y-m-d H:i:s'),
        ];
    }
}
