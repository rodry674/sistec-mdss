<?php

namespace App\Services;

class ValidadorCodigoPatrimonial
{
    public function esValido(string $codigo): bool
    {
        $codigoSinEspacios = trim($codigo);

        return $codigoSinEspacios !== '';
    }
}
