<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Attributes;

use AkioSarkiz\Openapi\Contacts\PayloadFactory;
use Attribute;
use JetBrains\PhpStorm\Immutable;

#[
    Attribute(Attribute::TARGET_METHOD),
    Immutable,
]
class Route
{
    /**
     * Create new instance.
     *
     * @param string|PayloadFactory|null $factory
     * @param string $description
     */
    public function __construct(
        public null|string|PayloadFactory $factory = null,
        public string $description = '',
    ) {
    }
}
