<?php

namespace Tests\Unit;

use App\Services\ValidadorCodigoPatrimonial;
use PHPUnit\Framework\TestCase;

class CodigoPatrimonialTest extends TestCase
{
    public function test_rechaza_codigo_patrimonial_vacio(): void
    {
        $validador = new ValidadorCodigoPatrimonial;

        $this->assertFalse($validador->esValido(''));
    }
}
