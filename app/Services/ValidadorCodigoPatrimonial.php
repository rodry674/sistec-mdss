<?php

namespace App\Services;

class ValidadorCodigoPatrimonial
{
    public function esValido(string $codigo): bool
    {
        $codigoSinEspacios = trim($codigo);

        return preg_match('/^[0-9]{12}$/', $codigoSinEspacios) === 1;
    }
}
