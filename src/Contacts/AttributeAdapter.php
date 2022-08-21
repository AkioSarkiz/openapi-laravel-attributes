<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Contacts;

use ReflectionClass;

interface AttributeAdapter
{
    /**
     * @param  ReflectionClass  $reflectionClass
     * @return void
     */
    public function init(ReflectionClass $reflectionClass): void;

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
