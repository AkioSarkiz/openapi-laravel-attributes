<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Transformers;

use AkioSarkiz\Openapi\Contacts\TransformerOpenapi;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SortPathsTransformer implements TransformerOpenapi
{
    /**
     * Empty not used.
     *
     * @var string[]
     */
    private array $customPriority = [];

    /**
     * @var string[]
     */
    private array $methodPriority = [
        'GET',
        'HEAD',
        'POST',
        'PATCH',
        'PUT',
        'DELETE',
        'CONNECT',
        'OPTIONS',
        'TRACE',
    ];

    /**
     * @inheritDoc
     */
    public function transform(array $schema): array
    {
        $paths = collect(Arr::get($schema, 'paths', []))->transform(function ($paths) {
            return collect($paths)
                ->sortBy(fn($value, $key) => (int) array_search(Str::upper($key), $this->getPriority()))
                ->all();
        });

        Arr::set($schema, 'paths', $paths->all());

        return $schema;
    }

    /**
     * @return string[]
     */
    private function getPriority(): array
    {
        return count($this->customPriority) ? $this->customPriority : $this->methodPriority;
    }

    /**
     * @inheritDoc
     */
    public function init(array $args): void
    {
        $this->setPriority(Arr::get($args, 'priority', config('openapi.custom_priority')));
    }

    /**
     * @param  array  $priority
     * @return void
     */
    private function setPriority(array $priority): void
    {
        $this->customPriority = collect($priority)->transform(fn($item) => Str::upper($item))->all();
    }
}
