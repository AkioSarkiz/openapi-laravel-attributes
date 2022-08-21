<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Attributes;

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
     * @param  string  $class
     * @param  string  $factory
     */
    public function __construct(
        public string $factory = '',
    ) {
        //
    }
}