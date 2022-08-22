<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Adapters;

use AkioSarkiz\Openapi\Contacts\AttributeAdapter;
use ReflectionClass;
use ReflectionMethod;

class RequestResponse implements AttributeAdapter
{
    private ReflectionClass|ReflectionMethod $reflectionClass;

    /**
     * @inheritDoc
     */
    public function init(ReflectionClass|ReflectionMethod $reflection): void
    {
        $this->reflectionClass = $reflection;
    }

    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        // TODO: Implement getPath() method.
    }

    /**
     * @inheritDoc
     */
    public function getSchema(): array
    {
        // TODO: Implement getSchema() method.
    }
}
