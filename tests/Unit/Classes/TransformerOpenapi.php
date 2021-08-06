<?php

declare(strict_types=1);

namespace AkioSarkiz\Tests\Unit\Classes;

use AkioSarkiz\Contacts\TransformerOpenapi as TransformerOpenapiContract;

class TransformerOpenapi implements TransformerOpenapiContract
{
    public const OPENAPI_VERSION = '4.0.0';

    public function transform(string $json): string
    {
        $data = json_decode($json, true);
        $data['openapi'] = self::OPENAPI_VERSION;

        return json_encode($data);
    }
}
