<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Contacts;

use ReflectionClass;
use ReflectionMethod;

interface AttributeAdapter
{
    /**
     * @param  ReflectionClass|ReflectionMethod  $reflection
     * @return void
     */
    public function init(ReflectionClass|ReflectionMethod $reflection): void;

    /**
     * Get path of schema. Supported dots.
     *
     * @return string
     */
    public function getPath(): string;

    /**
     * Get data schema.
     *
     * @return array
     */
    public function getSchema(): array;
}
