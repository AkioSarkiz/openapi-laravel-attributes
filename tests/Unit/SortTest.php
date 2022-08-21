<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Tests\Unit;

use AkioSarkiz\Openapi\Tests\TestCase;
use AkioSarkiz\Openapi\Transformers\SortPathsTransformer;

class SortTest extends TestCase
{
    private const PATHS = [
        '/users' => [
            'post' => [
                'tags' => ['users'],
            ],
            'get' => [
                'tags' => ['users'],
            ],
            'delete' => [
                'tags' => ['users'],
            ],
        ],
        '/user/trashed' => [
            'get' => [
                'tags' => ['users'],
            ],
            'delete' => [
                'tags' => ['users'],
            ],
            'post' => [
                'tags' => ['users'],
            ],
        ],
    ];

    public function test_sort(): void
    {
        /** @var SortPathsTransformer $transformer */
        $transformer = app(SortPathsTransformer::class);
        $transformer->init([]);
        $formattedData = $transformer->transform(['paths' => self::PATHS]);

        $this->assertSame(
            $formattedData['paths'],
            [
                '/users' => [
                    'get' => [
                        'tags' => ['users'],
                    ],
                    'post' => [
                        'tags' => ['users'],
                    ],
                    'delete' => [
                        'tags' => [
                            0 => 'users',
                        ],
                    ],
                ],
                '/user/trashed' => [
                    'get' => [
                        'tags' => ['users'],
                    ],
                    'post' => [
                        'tags' => ['users'],
                    ],
                    'delete' => [
                        'tags' => ['users'],
                    ],
                ],
            ]
        );
    }

    public function test_sort_custom_priority(): void
    {
        /** @var SortPathsTransformer $transformer */
        $transformer = app(SortPathsTransformer::class);
        $transformer->init([
            'priority' => [
                'DELETE',
                'GET',
                'POST',
                'PATCH',
                'PUT',
            ],
        ]);
        $formattedData = $transformer->transform(['paths' => self::PATHS]);

        $this->assertSame(
            $formattedData['paths'],
            [
                '/users' => [
                    'delete' => [
                        'tags' => [
                            0 => 'users',
                        ],
                    ],
                    'get' => [
                        'tags' => ['users'],
                    ],
                    'post' => [
                        'tags' => ['users'],
                    ],
                ],
                '/user/trashed' => [
                    'delete' => [
                        'tags' => ['users'],
                    ],
                    'get' => [
                        'tags' => ['users'],
                    ],
                    'post' => [
                        'tags' => ['users'],
                    ],
                ],
            ]
        );
    }
}
