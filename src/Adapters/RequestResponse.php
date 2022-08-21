<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Adapters;

use AkioSarkiz\Openapi\Contacts\AttributeAdapter;
use ReflectionClass;

class RequestResponse implements AttributeAdapter
{
    private ReflectionClass $reflectionClass;

    /**
     * @inheritDoc
     */
    public function init(ReflectionClass $reflectionClass): void
    {
        $this->reflectionClass = $reflectionClass;
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
