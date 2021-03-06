<?php

declare(strict_types=1);

namespace AkioSarkiz;

use AkioSarkiz\Commands\GenerateOpenapi;
use Illuminate\Support\ServiceProvider;
use OpenApiGenerator\Contracts\ManagerBuilders as ManagerBuildersContract;
use OpenApiGenerator\ManagerBuilders;

class OpenapiAttributesServiceProvider extends ServiceProvider
{
    /**
     * Boot service provider.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->app->bind(ManagerBuildersContract::class, ManagerBuilders::class);

            $this->publishes([__DIR__ . '/../config/openapi.php' => config_path('openapi.php')], 'config');

            $this->commands([
                GenerateOpenapi::class,
            ]);
        }
    }

    /**
     * Register service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/openapi.php', 'openapi');
    }
}
