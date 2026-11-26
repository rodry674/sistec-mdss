<?php

namespace Tests\Feature;

use App\Services\ValidadorCodigoPatrimonial;
use PHPUnit\Framework\TestCase;

class RecepcionEquiposAtddTest extends TestCase
{
    public function test_acepta_codigo_sbn_de_12_digitos(): void
    {
        // Given: un equipo con codigo patrimonial valido
        $codigo = '123456789012';

        // When: se valida el codigo patrimonial
        $resultado = (new ValidadorCodigoPatrimonial)->esValido($codigo);

        // Then: el sistema acepta el codigo
        $this->assertTrue($resultado);
    }

    public function test_rechaza_codigo_con_letras(): void
    {
        // Given: un equipo con codigo que contiene letras
        $codigo = 'PAT-2026-001';

        // When: se valida el codigo patrimonial
        $resultado = (new ValidadorCodigoPatrimonial)->esValido($codigo);

        // Then: el sistema rechaza el codigo
        $this->assertFalse($resultado);
    }

    public function test_rechaza_codigo_incompleto(): void
    {
        // Given: un equipo con codigo incompleto
        $codigo = '123456';

        // When: se valida el codigo patrimonial
        $resultado = (new ValidadorCodigoPatrimonial)->esValido($codigo);

        // Then: el sistema rechaza el codigo
        $this->assertFalse($resultado);
    }

    public function test_rechaza_codigo_vacio(): void
    {
        // Given: un equipo sin codigo patrimonial
        $codigo = '';

        // When: se valida el codigo patrimonial
        $resultado = (new ValidadorCodigoPatrimonial)->esValido($codigo);

        // Then: el sistema rechaza el codigo
        $this->assertFalse($resultado);
    }
}
