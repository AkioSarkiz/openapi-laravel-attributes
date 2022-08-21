<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Tests\Feature;

use AkioSarkiz\Openapi\Tests\TestCase;
use Illuminate\Support\Facades\DB;

class DatabaseConnectionTest extends TestCase
{
    public function test(): void
    {
        $this->assertIsString(DB::getDatabaseName());
    }
}
