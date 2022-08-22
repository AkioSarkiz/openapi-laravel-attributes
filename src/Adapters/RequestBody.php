<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Adapters;

use AkioSarkiz\Openapi\Contacts\AttributeAdapter;
use ReflectionClass;
use ReflectionMethod;

class RequestBody implements AttributeAdapter
{
    private string $path;
    private array $schema;
    private ReflectionClass|ReflectionMethod $reflectionClass;

    public function init(ReflectionClass|ReflectionMethod $reflection): void
    {
        $this->reflectionClass = $reflection;

        $this->initPath();
        $this->initSchema();
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getSchema(): array
    {
        return $this->schema;
    }

    private function initPath(): void
    {
        $this->path = '';
    }

    private function initSchema(): void
    {
        $this->schema = [];
    }
}
