<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Tests\Unit;

use AkioSarkiz\Openapi\PayloadFactory;
use PHPUnit\Framework\TestCase;

class PayloadFactoryTest extends TestCase
{
    public function test_create(): void
    {
        $this->assertInstanceOf(PayloadFactory::class, PayloadFactory::make());
        $this->assertInstanceOf(PayloadFactory::class, new PayloadFactory());
    }

    public function test_basic(): void
    {
        $factory = PayloadFactory::make()
            ->field('id')->type('int')
            ->field('name')->type('string')
            ->field('surname')->type('string');

        $this->assertSame($factory->generate(), [
            'type' => 'object',
            'properties' => [
                'id' => [
                    'type' => 'int',
                ],
                'name' => [
                    'type' => 'string',
                ],
                'surname' => [
                    'type' => 'string',
                ],
            ],
        ]);
    }
}
