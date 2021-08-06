<?php

declare(strict_types=1);

namespace AkioSarkiz\Contacts;

interface TransformerOpenapi
{
    /**
     * Transform openapi json.
     *
     * @param  string  $json
     * @return string
     */
    public function transform(string $json): string;
}
