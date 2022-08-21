<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Tests\Feature\RouteAdapter;

use AkioSarkiz\Openapi\Adapters\Route as RouteAdapter;
use AkioSarkiz\Openapi\Tests\TestCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route as RouteFacade;
use ReflectionClass;

class RouteAdapterTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        RouteFacade::get('ping', [PingController::class, 'ping']);

        RouteFacade::middleware(TrustMiddleware::class)->group(function () {
            RouteFacade::get('news', [NewsController::class, 'index']);
        });
    }

    public function test_get_route(): void
    {
        $adapter = new RouteAdapter();
        $adapter->init(new ReflectionClass(new PingController()));

        $this->assertSame($adapter->getPath(), 'paths');
        $this->assertSame($adapter->getSchema(), [
            '/ping' => [
                'get' => [
                    'operationId' => '123456',
                    'summary' => '',
                    'description' => '',
                    'parameters' => [],
                    'security' => [],
                    'tags' => [],
                ],
                'head' => [
                    'operationId' => '123456',
                    'summary' => '',
                    'description' => '',
                    'parameters' => [],
                    'security' => [],
                    'tags' => [],
                ],
            ],
        ]);
    }

    public function test_get_route_with_middleware(): void
    {
        Config::set('openapi.map_middleware_security', [
            TrustMiddleware::class => 'api_auth',
        ]);

        $adapter = new RouteAdapter();
        $adapter->init(new ReflectionClass(new NewsController()));

        $this->assertSame($adapter->getPath(), 'paths');
        $this->assertSame($adapter->getSchema(), [
            '/news' => [
                'get' => [
                    'operationId' => '123456',
                    'summary' => '',
                    'description' => '',
                    'parameters' => [],
                    'security' => [['api_auth' => []]],
                    'tags' => [],
                ],
                'head' => [
                    'operationId' => '123456',
                    'summary' => '',
                    'description' => '',
                    'parameters' => [],
                    'security' => [['api_auth' => []]],
                    'tags' => [],
                ],
            ],
        ]);
    }
}
