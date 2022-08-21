<?php

namespace AkioSarkiz\Openapi\Tests;

use AkioSarkiz\Openapi\OpenapiAttributesServiceProvider;
use Illuminate\Support\Facades\Config;
use Orchestra\Testbench\TestCase as TestCaseBase;

class TestCase extends TestCaseBase
{
    public function setUp(): void
    {
        parent::setUp();

        // setup database.
        Config::set('database.default', 'pgsql');
        Config::set('database.connections.pgsql.host', 'app-pgsql');
        Config::set('database.connections.pgsql.port', '5432');
        Config::set('database.connections.pgsql.database', 'app');
        Config::set('database.connections.pgsql.username', 'admin');
        Config::set('database.connections.pgsql.password', 'secret');
    }

    protected function getPackageProviders($app): array
    {
        return [
            OpenapiAttributesServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        // perform environment setup
    }
}
