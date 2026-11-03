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

    public function test_rechaza_codigo_con_solo_espacios(): void
    {
        $validador = new ValidadorCodigoPatrimonial;

        $this->assertFalse($validador->esValido('   '));
    }
}
