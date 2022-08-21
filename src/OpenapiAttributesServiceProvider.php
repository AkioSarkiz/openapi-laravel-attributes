<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi;

use AkioSarkiz\Openapi\Commands\GenerateOpenapi;
use AkioSarkiz\Openapi\Commands\OpenapiAdapterMakeCommand;
use AkioSarkiz\Openapi\Commands\OpenapiAttributeMakeCommand;
use AkioSarkiz\Openapi\Commands\OpenapiTransformerMakeCommand;
use Illuminate\Support\ServiceProvider;

class OpenapiAttributesServiceProvider extends ServiceProvider
{
    /**
     * Boot service provider.
     *
     * @return void
     */
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([__DIR__.'/../config/openapi.php' => config_path('openapi.php')], 'config');

        $this->commands([
            GenerateOpenapi::class,
            OpenapiAdapterMakeCommand::class,
            OpenapiAttributeMakeCommand::class,
            OpenapiTransformerMakeCommand::class,
        ]);
    }

    /**
     * Register service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/openapi.php', 'openapi');
    }
}
