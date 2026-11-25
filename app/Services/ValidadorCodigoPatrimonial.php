<?php

namespace App\Services;

class ValidadorCodigoPatrimonial
{
    public function esValido(string $codigo): bool
    {
        $codigoLimpio = trim($codigo);

        if ($codigoLimpio === '') {
            return false;
        }

        return (bool) preg_match('/^[A-Za-z0-9-]{5,20}$/', $codigoLimpio);
    }
}
