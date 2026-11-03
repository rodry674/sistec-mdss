<?php

namespace App\Services;

class ValidadorCodigoPatrimonial
{
    public function esValido(string $codigo): bool
    {
        return $codigo !== '';
    }
}
