<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Contacts;

interface HasMeta
{
    /**
     * Get meta.
     *
     * @return array
     */
    public function meta(): array;
}
