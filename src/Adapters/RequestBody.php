<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Adapters;

use AkioSarkiz\Openapi\Contacts\AttributeAdapter;
use ReflectionClass;

class RequestBody implements AttributeAdapter
{
    private string $path;
    private array $schema;
    private ReflectionClass $reflectionClass;

    public function init(ReflectionClass $reflectionClass): void
    {
        $this->reflectionClass = $reflectionClass;

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
