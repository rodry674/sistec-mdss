<?php

namespace App\Services;

use InvalidArgumentException;

class IncidenteService
{
    public function registrarRecepcion(array $datos): array
    {
        $dni = trim((string) ($datos['dni'] ?? ''));
        if (! preg_match('/^\d{8}$/', $dni)) {
            throw new InvalidArgumentException('El DNI debe contener exactamente 8 dígitos numéricos.');
        }

        $validador = new ValidadorCodigoPatrimonial;
        $codigoBruto = (string) ($datos['codigo_patrimonial'] ?? '');
        if (! $validador->esValido($codigoBruto)) {
            throw new InvalidArgumentException('El código patrimonial no cumple con el formato institucional.');
        }

        return [
            'dni' => $dni,
            'nombre_usuario' => trim((string) ($datos['nombre_usuario'] ?? '')),
            'area_municipal' => trim((string) ($datos['area_municipal'] ?? '')),
            'codigo_patrimonial' => $validador->normalizar($codigoBruto),
            'estado' => 'Recepcionado',
            'fecha_ingreso' => date('Y-m-d H:i:s'),
        ];
    }
}
