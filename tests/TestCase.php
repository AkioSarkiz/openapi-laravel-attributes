<?php

namespace AkioSarkiz\Tests;

use AkioSarkiz\OpenapiAttributesServiceProvider;
use Config;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Config::set('openapi.scan_paths', [realpath(__DIR__ . '/app')]);
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
