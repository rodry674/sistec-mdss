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

    public function test_acepta_codigo_patrimonial_con_formato_institucional(): void
    {
        $validador = new ValidadorCodigoPatrimonial;

        $this->assertTrue($validador->esValido('PAT-2026-001'));
        $this->assertTrue($validador->esValido('  pat-2026-002  '));
    }

    public function test_rechaza_codigo_patrimonial_muy_corto_o_con_simbolos(): void
    {
        $validador = new ValidadorCodigoPatrimonial;

        $this->assertFalse($validador->esValido('AB1'));
        $this->assertFalse($validador->esValido('PAT@2026#01'));
    }
}
