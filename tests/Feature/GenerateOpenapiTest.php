<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Tests\Feature;

use AkioSarkiz\Openapi\Commands\GenerateOpenapi;
use AkioSarkiz\Openapi\Contacts\TransformerOpenapi as TransformerOpenapiContract;
use AkioSarkiz\Openapi\Tests\TestCase;
use AkioSarkiz\Openapi\Tests\Unit\Classes\TransformerOpenapi;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use function config;

class GenerateOpenapiTest extends TestCase
{
    /**
     * @return string
     */
    private function getSavePath(): string
    {
        return Storage::disk(config('openapi.disk'))
            ->path(str_replace('{ext}', config('openapi.format'), config('openapi.save_path')));
    }

    public function test_generate(): void
    {
        $path = $this->getSavePath();

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
        $path = $this->getSavePath();

        if (file_exists($path)) {
            unlink($path);
        }

        Config::push('openapi.transformers', TransformerOpenapi::class);

        $this->artisan(GenerateOpenapi::class)
            ->assertExitCode(0);

        $this->assertTrue(
            file_exists($path)
        );

        $data = json_decode(file_get_contents($path), true);
        $this->assertSame($data['openapi'], TransformerOpenapi::OPENAPI_VERSION);
    }

    public function test_work(): void
    {
        Config::set('openapi.scan_paths', [realpath(__DIR__ . '/../TestApp')]);

        $this->artisan(GenerateOpenapi::class, ['path' => __DIR__ . '/openapi.{ext}'])
            ->assertExitCode(0);
    }
}
