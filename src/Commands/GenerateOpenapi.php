<?php

declare(strict_types=1);

namespace AkioSarkiz\Commands;

use AkioSarkiz\Contacts\TransformerOpenapi;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Storage;
use OpenApiGenerator\Exceptions\OpenapiException;
use OpenApiGenerator\Generator;
use Symfony\Component\Finder\Finder;

class GenerateOpenapi extends Command
{
    /**
     * The signature command.
     *
     * @var string
     */
    protected $signature = 'openapi:generate';

    /**
     * The description command.
     *
     * @var string
     */
    protected $description = 'Generate openapi file.';

    /**
     * @var Finder
     */
    private Finder $finder;

    /**
     * @var Generator
     */
    private Generator $generator;

    /**
     * Command handler.
     *
     * @param  Finder  $finder
     * @param  Generator  $generator
     * @return int
     */
    public function handle(Finder $finder, Generator $generator): int
    {
        $this->finder = $finder;
        $this->generator = $generator;

        $this->injectFiles();
        $this->generate();

        return self::SUCCESS;
    }

    /**
     * Inject paths to autoload.
     *
     * @return void
     */
    private function injectFiles(): void
    {
        foreach (config('openapi.scan_paths') as $path) {
            $sourceFiles = $this->finder->files()->name('*.php')->in($path);

            foreach ($sourceFiles as $file) {
                include_once $file->getPathname();
            }
        }
    }

    /**
     * Generate docs.
     *
     * @return void
     * @throws OpenapiException
     */
    private function generate(): void
    {
        try {
            $transformer = app()->make(TransformerOpenapi::class);
            $schema = $transformer->transform($this->generator->generate()->dataJson());
        } catch (BindingResolutionException | OpenApiException) {
            $schema = $this->generator->generate()->dataJson();
        }

        Storage::put(config('openapi.save_path'), $schema);
    }
}
