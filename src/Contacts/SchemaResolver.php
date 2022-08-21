<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Contacts;

interface SchemaResolver
{
    /**
     * Resolve schema.
     *
     * @param  array  $schema current schema.
     * @param  string  $path path from setter.
     * @param  array  $data data from setter.
     * @return array transformed schema.
     */
    public function resolve(array $schema, string $path, array $data): array;
}
