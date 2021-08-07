<?php

declare(strict_types=1);

namespace AkioSarkiz\Tests\Unit;

use AkioSarkiz\Commands\GenerateOpenapi;
use AkioSarkiz\Contacts\TransformerOpenapi as TransformerOpenapiContract;
use AkioSarkiz\Tests\TestCase;
use AkioSarkiz\Tests\Unit\Classes\TransformerOpenapi;

class GenerateOpenapiTest extends TestCase
{
    public function test_generate(): void
    {
        $path = storage_path('app/' . config('openapi.save_path'));

        if (file_exists($path)) {
            unlink($path);
        }

        $this->artisan(GenerateOpenapi::class)
            ->assertExitCode(0);

        $this->assertTrue(
            file_exists($path)
        );
    }

    public function test_transform(): void
    {
        $this->app->bind(TransformerOpenapiContract::class, TransformerOpenapi::class);
        $path = storage_path('app/' . config('openapi.save_path'));

        if (file_exists($path)) {
            unlink($path);
        }

        $this->artisan(GenerateOpenapi::class)
            ->assertExitCode(0);

        $this->assertTrue(
            file_exists($path)
        );

        $data = json_decode(file_get_contents($path), true);
        $this->assertSame($data['openapi'], TransformerOpenapi::OPENAPI_VERSION);
    }
}
