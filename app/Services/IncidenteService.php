<?php

namespace App\Services;

use InvalidArgumentException;

class IncidenteService
{
    public function __construct(
        private readonly ValidadorCodigoPatrimonial $validador = new ValidadorCodigoPatrimonial
    ) {}

    public function registrarRecepcion(array $datos): array
    {
        $dni = $this->validarDni((string) ($datos['dni'] ?? ''));
        $codigoBruto = (string) ($datos['codigo_patrimonial'] ?? '');

        if (! $this->validador->esValido($codigoBruto)) {
            throw new InvalidArgumentException('El código patrimonial no cumple con el formato institucional.');
        }

        return [
            'dni' => $dni,
            'nombre_usuario' => trim((string) ($datos['nombre_usuario'] ?? '')),
            'area_municipal' => trim((string) ($datos['area_municipal'] ?? '')),
            'codigo_patrimonial' => $this->validador->normalizar($codigoBruto),
            'estado' => 'Recepcionado',
            'fecha_ingreso' => date('Y-m-d H:i:s'),
        ];
    }

    private function validarDni(string $dni): string
    {
        $dniLimpio = trim($dni);

        if (! preg_match('/^\d{8}$/', $dniLimpio)) {
            throw new InvalidArgumentException('El DNI debe contener exactamente 8 dígitos numéricos.');
        }

        return $dniLimpio;
    }
}
