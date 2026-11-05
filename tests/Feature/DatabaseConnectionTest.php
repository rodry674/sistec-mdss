<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DatabaseConnectionTest extends TestCase
{
    public function test_sqlite_en_memoria_funciona(): void
    {
        $this->assertSame(
            'sqlite',
            DB::getDefaultConnection()
        );

        $this->assertSame(
            ':memory:',
            DB::connection()->getDatabaseName()
        );

        $this->assertTrue(
            DB::connection()->getPdo() !== null
        );
    }
}
