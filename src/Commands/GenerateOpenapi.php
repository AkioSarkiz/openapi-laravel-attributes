<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Commands;

use AkioSarkiz\Openapi\Console;
use AkioSarkiz\Openapi\Contacts\TransformerOpenapi;
use AkioSarkiz\Openapi\Enums\ConsoleColor;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

class GenerateOpenapi extends Command
{
    /**
     * The signature command.
     *
     * @var string
     */
    protected $signature = 'openapi:generate
                            {path? : Custom absolute path for save docs}';

    /**
     * The description command.
     *
     * @var string
     */
    protected $description = 'Generate openapi file.';

    /**
     * Path to docs.
     *
     * @var string|null
     */
    private ?string $savePath = null;

    /**
     * Create new instance,
     *
     * @param  Finder  $finder
     */
    public function __construct(
        private Finder $finder,
    ) {
        parent::__construct();
    }

    /**
     * Command handler.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->injectFiles();
        $this->generate();

        Console::writeln(
            sprintf("Success generation!\nSaved into %s", $this->savePath),
            ConsoleColor::GREEN(),
        );

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
     */
    private function generate(): void
    {
        $payload = $this->getBasePayload();
        $this->transformPayload($payload);
        $this->savePayload($payload);
    }

    /**
     * @param  string  $path
     * @return string
     */
    private function transformSavePath(string $path): string
    {
        return str_replace('{ext}', config('openapi.format'), $path);
    }

    private function savePayload(array $payload): void
    {
        $customPath = $this->argument('path');
        $encodedPayload = $this->encodePayload($payload);

        if ($customPath) {
            $this->savePath = $this->transformSavePath($customPath);
            file_put_contents($this->transformSavePath($customPath), $encodedPayload);
        } else {
            $storage = Storage::disk(config('openapi.disk'));
            $transformedPath = $this->transformSavePath(config('openapi.save_path'));
            $this->savePath = $storage->path($transformedPath);
            $storage->put($transformedPath, $this->encodePayload($payload));
        }
    }

    #[ArrayShape(['openapi' => "string", 'info' => "array"])]
    private function getBasePayload(): array
    {
        return [
            'openapi' => '3.0.0',
            'info' => [
                'title' => config('app.name'),
                'version' => config('app.version', '1.0.0'),
            ],
        ];
    }

    /**
     * @param  array  $payload
     * @return string
     */
    private function encodePayload(array $payload): string
    {
        return match (config('openapi.format')) {
            'json' => json_encode($payload, JSON_UNESCAPED_SLASHES),
            'yml', 'yaml' => Yaml::dump($payload),
            default => sprintf("no supported format %s", config('openapi.format')),
        };
    }

    /**
     * @param  array  $payload
     * @return void
     */
    private function transformPayload(array &$payload): void
    {
        foreach (config('openapi.transformers') as $transformer) {
            try {
                $transformerInstance = app()->make($transformer);
                $transformerInstance->init();
                $payload = $transformerInstance->transform($payload);
            } catch (BindingResolutionException $e) {
                Console::writeln(
                    $e->getMessage(),
                    ConsoleColor::YELLOW(),
                );
            }
        }
    }

    /**
     * @param  string|array  $transformer
     * @return array
     */
    #[ArrayShape(['class' => 'string', 'args' => 'array'])]
    private function formatTransformer(string|array $transformer): array
    {
        if (is_string($transformer)) {
            return ['class' => $transformer, 'args' => []];
        } else {
            $class = $transformer[0];
            Arr::forget($transformer, '0');

            return ['class' => $class, 'args' => $transformer];
        }
    }
}
