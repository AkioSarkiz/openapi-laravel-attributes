<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Contacts;

interface TransformerOpenapi
{
    /**
     * Initialization the transformers. Arguments handle.
     *
     * @param  array  $args
     * @return void
     */
    public function init(array $args): void;

    /**
     * Transform openapi json or yaml.
     *
     * @param  array  $schema  root schema openapi.
     * @return array
     */
    public function transform(array $schema): array;
}
