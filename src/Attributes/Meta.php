<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Attributes;

use AkioSarkiz\Openapi\Contacts\HasMeta;
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
     * @param  class-string<HasMeta>  $class  instanceof HasMeta.
     *
     * @see HasMeta
     */
    public function __construct(
        public string $class,
    ) {
        //
    }
}
