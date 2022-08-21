<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Attributes;

use Attribute;
use JetBrains\PhpStorm\Immutable;

#[
    Attribute(Attribute::TARGET_CLASS),
    Immutable,
]
class SchemaModel
{
    /**
     * @param  string|null  $model extend model props.
     */
    public function __construct(
        public null|string $model = null,
    )
    {
    }
}
