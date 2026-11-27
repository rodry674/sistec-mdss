<?php

namespace Tests\Unit;

use App\Models\AreaMunicipal;
use App\Models\Categoria;
use App\Models\Tecnico;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class RelacionesModelosTest extends TestCase
{
    public function test_ticket_pertenece_a_un_area_municipal(): void
    {
        $ticket = new Ticket;

        $relacion = $ticket->areaMunicipal();

        $this->assertInstanceOf(BelongsTo::class, $relacion);
        $this->assertSame('area_id', $relacion->getForeignKeyName());
    }

    public function test_ticket_pertenece_a_una_categoria(): void
    {
        $ticket = new Ticket;

        $relacion = $ticket->categoria();

        $this->assertInstanceOf(BelongsTo::class, $relacion);
        $this->assertSame('categoria_id', $relacion->getForeignKeyName());
    }

    public function test_ticket_pertenece_a_un_tecnico(): void
    {
        $ticket = new Ticket;

        $relacion = $ticket->tecnico();

        $this->assertInstanceOf(BelongsTo::class, $relacion);
        $this->assertSame('tecnico_id', $relacion->getForeignKeyName());
    }

    public function test_area_municipal_tiene_muchos_tickets(): void
    {
        $area = new AreaMunicipal;

        $relacion = $area->tickets();

        $this->assertInstanceOf(HasMany::class, $relacion);
        $this->assertSame('area_id', $relacion->getForeignKeyName());
    }

    public function test_categoria_tiene_muchos_tickets(): void
    {
        $categoria = new Categoria;

        $relacion = $categoria->tickets();

        $this->assertInstanceOf(HasMany::class, $relacion);
        $this->assertSame('categoria_id', $relacion->getForeignKeyName());
    }

    public function test_tecnico_tiene_muchos_tickets(): void
    {
        $tecnico = new Tecnico;

        $relacion = $tecnico->tickets();

        $this->assertInstanceOf(HasMany::class, $relacion);
        $this->assertSame('tecnico_id', $relacion->getForeignKeyName());
    }

    public function test_usuario_identifica_si_es_jefe(): void
    {
        $usuario = new User;
        $usuario->rol = 'jefe';

        $this->assertTrue($usuario->esJefe());

        $usuario->rol = 'tecnico';

        $this->assertFalse($usuario->esJefe());
    }
}
