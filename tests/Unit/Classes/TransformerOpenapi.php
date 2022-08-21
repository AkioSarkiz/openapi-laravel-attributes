<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Tests\Unit\Classes;

use AkioSarkiz\Openapi\Contacts\TransformerOpenapi as TransformerOpenapiContract;

class TransformerOpenapi implements TransformerOpenapiContract
{
    public const OPENAPI_VERSION = '4.0.0';

    /**
     * @inheritDoc
     */
    public function transform(array $schema): array
    {
        $schema['openapi'] = self::OPENAPI_VERSION;

        return $schema;
    }

    /**
     * @inheritDoc
     */
    public function init(array $args): void
    {
        //
    }
}
