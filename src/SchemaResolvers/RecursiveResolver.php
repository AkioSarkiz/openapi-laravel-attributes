<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\SchemaResolvers;

use AkioSarkiz\Openapi\Contacts\SchemaResolver;
use Illuminate\Support\Arr;

class RecursiveResolver implements SchemaResolver
{
    /**
     * @inheritDoc
     */
    public function resolve(array $schema, string $path, array $data): array
    {
        Arr::set(
            $schema,
            $path,
            array_merge_recursive($data, Arr::get($schema, $path, []))
        );

        return $schema;
    }
}
