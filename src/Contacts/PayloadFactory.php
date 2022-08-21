<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Contacts;

interface PayloadFactory
{
    /**
     * Generate payload of request.
     *
     * @return array
     */
    public function generate(): array;
}
