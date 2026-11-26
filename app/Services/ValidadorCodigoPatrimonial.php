<?php

namespace App\Services;

class ValidadorCodigoPatrimonial
{
    private const PATRON_INSTITUCIONAL = '/^[A-Z0-9-]{5,20}$/';

    public function normalizar(string $codigo): string
    {
        return strtoupper(trim($codigo));
    }

    public function esValido(string $codigo): bool
    {
        $codigoNormalizado = $this->normalizar($codigo);

        if ($codigoNormalizado === '') {
            return false;
        }

        return (bool) preg_match(self::PATRON_INSTITUCIONAL, $codigoNormalizado);
    }
}
