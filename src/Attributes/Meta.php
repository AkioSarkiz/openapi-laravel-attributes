<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Attributes;

use Attribute;
use JetBrains\PhpStorm\Immutable;

#[
    Attribute(Attribute::TARGET_CLASS),
    Immutable,
]
class Meta
{
    /**
     * Create new instance attribute.
     *
     * @param  string  $class  instanceof HasMeta.
     *
     * @see HasMeta
     */
    public function __construct(
        public string $class,
    ) {
        //
    }
}
