<?php

namespace App\Services;

class ValidadorCodigoPatrimonial
{
    private const PATRON_INSTITUCIONAL = '/^[A-Z0-9-]{5,20}$/';

    private const PATRON_CODIGO_SBN = '/^[0-9]{12}$/';

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

        return preg_match(self::PATRON_INSTITUCIONAL, $codigoNormalizado) === 1;
    }

    public function esCodigoSbnValido(string $codigo): bool
    {
        return preg_match(self::PATRON_CODIGO_SBN, trim($codigo)) === 1;
    }
}
