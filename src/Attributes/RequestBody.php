<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Attributes;

use AkioSarkiz\Openapi\PayloadFactory;
use Attribute;
use JetBrains\PhpStorm\Immutable;

#[
    Attribute(Attribute::TARGET_METHOD),
    Immutable,
]
class RequestBody
{
    /**
     * Create new instance.
     *
     * @param string|PayloadFactory|null $factory
     */
    public function __construct(
        public null|string|PayloadFactory $factory = '',
    ) {
        //
    }
}
