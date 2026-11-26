<?php

namespace App\Services;

class ValidadorCodigoPatrimonial
{
    private const PATRON_CODIGO_SBN = '/^[0-9]{12}$/';

    public function esValido(string $codigo): bool
    {
        $codigoSinEspacios = trim($codigo);

        return preg_match(self::PATRON_CODIGO_SBN, $codigoSinEspacios) === 1;
    }
}
