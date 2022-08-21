<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\App;

class OpenapiTransformerMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:openapi-transformer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new openapi transformer class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Transformer';

    /**
     * @inheritDoc
     */
    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/transformer.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath(string $stub): string
    {
        return is_file($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.$stub;
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name): string
    {
        if (! file_exists($this->laravel->basePath().'/app/Openapi')) {
            mkdir($this->laravel->basePath().'/app/Openapi');
        }

        if (! file_exists($this->laravel->basePath().'/app/Openapi/Transformers')) {
            mkdir($this->laravel->basePath().'/app/Openapi/Transformers');
        }

        return $this->laravel->basePath().'/app/Openapi/Transformers/'.$name.'.php';
    }

    /**
     * @inheritDoc
     */
    protected function qualifyClass($name): string
    {
        return $name;
    }

    /**
     * @inheritDoc
     */
    protected function getNamespace($name): string
    {
        return App::getNamespace() . 'Openapi\Transformers';
    }
}