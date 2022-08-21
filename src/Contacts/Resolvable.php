<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Contacts;

interface Resolvable
{
    /**
     * Get the resolver for schema.
     *
     * @return SchemaResolver
     */
    public function getResolver(): SchemaResolver;
}
