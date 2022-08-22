<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Adapters;

use AkioSarkiz\Openapi\Attributes\Meta;
use AkioSarkiz\Openapi\Attributes\Route as RouteAttribute;
use AkioSarkiz\Openapi\Contacts\AttributeAdapter;
use Illuminate\Routing\Route as LaravelRoute;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route as RouteFacade;
use Illuminate\Support\Str;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionMethod;
use stdClass;

class Route implements AttributeAdapter
{
    private ReflectionClass|ReflectionMethod $reflection;

    private string $path;

    private array $schema;

    public function init(ReflectionClass|ReflectionMethod $reflection): void
    {
        $this->reflection = $reflection;

        $this->initPath();
        $this->initSchema();
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getSchema(): array
    {
        return $this->schema;
    }

    private function initPath(): void
    {
        $this->path = 'paths';
    }

    private function initSchema(): void
    {
        $reflectionClass = $this->reflection;
        $routeCollection = RouteFacade::getRoutes();
        $methods = $this->reflection instanceof ReflectionClass ? $this->reflection->getMethods() : [$this->reflection];

        foreach ($methods as $method) {
            $route = $routeCollection->getByAction($reflectionClass->getName() . '@' . $method->getName());

            if ($route) {
                $this->injectRoute($route);
            }
        }
    }

    private function generateOperationId(LaravelRoute $route): string
    {
        return App::environment('testing') ? '123456' : $route->getName() ?? uniqid();
    }

    private function formatRouteMethod(string $routeMethod): string
    {
        return (string) Str::of($routeMethod)->lower();
    }

    private function injectRoute(LaravelRoute $route): void
    {
        $schemaNode = &$this->schema[$this->formatUri($route->uri)];

        foreach ($route->methods() as $routeMethod) {
            $data = [
                'operationId' => $this->generateOperationId($route),
                'summary' => $this->generateSummary($route),
                'description' => $this->generateDescription($route),
                'parameters' => $this->generateParameters($route),
                'security' => $this->generateSecurity($route),
                'tags' => $this->generateTags(),
                'responses' => [],
            ];

            if ($this->isSupportedRequestBody($routeMethod)) {
                $data['requestBody'] = $this->generateRequestBody();
            }

            $schemaNode[$this->formatRouteMethod($routeMethod)] = $data;
        }
    }

    private function generateSummary(LaravelRoute $route): string
    {
        $summary = $this->getMetaRouteValue($route, 'summary');

        if ($summary) {
            return $summary;
        }

        $routeName = $route->getName();

        if (! $routeName) {
            return '';
        }

        return (string) Str::of($routeName)->studly()->replace('.', ' ');
    }

    private function getMeta(): array
    {
        $reflectionClass = $this->reflection;
        /** @var ReflectionAttribute $metaAttribute */
        $metaAttribute = head($reflectionClass->getAttributes(Meta::class));

        if ($metaAttribute) {
            return app($metaAttribute->newInstance()->class)->meta();
        }

        return ! method_exists($reflectionClass->getName(), 'meta')
            ? []
            : call_user_func([$reflectionClass->getName(), 'meta']);
    }

    private function getMetaValue(string $key): mixed
    {
        return Arr::get($this->getMeta(), $key);
    }

    private function getMetaRoute(LaravelRoute $route): array
    {
        return Arr::get($this->getMeta(), $route->getActionMethod(), []);
    }

    private function getMetaRouteValue(LaravelRoute $route, string $key): mixed
    {
        return Arr::get($this->getMetaRoute($route), $key);
    }

    private function generateDescription(LaravelRoute $route): string
    {
        $reflectionClass = $this->reflection;
        $description = $this->getMetaRouteValue($route, 'description');

        if ($description) {
            return $description;
        } else {
            $attributes = $reflectionClass->getMethod($route->getActionMethod())->getAttributes(RouteAttribute::class);

            return ! count($attributes) ? '' : head($attributes)->newInstance()->description;
        }
    }

    private function formatUri(string $uri): string
    {
        return (string) Str::of($uri)->start('/');
    }

    private function generateParameters(LaravelRoute $route): array
    {
        preg_match_all('/\{([\w\_0-9]+)(\?)?\}/', $route->uri(), $matches);

        if (! count($matches[0])) {
            return [];
        }

        $parameters = [];

        for ($i = 0; $i < count($matches[0]); $i++) {
            $name = $matches[1][$i];
            $parameters[] = [
                'name' => $name,
                'in' => 'path',
                'required' => $matches[2][$i] === '',
                'description' => $this->getMetaRouteValue($route, "parameters.$name.description") ?? '',
                'schema' => [
                    'type' => $this->getMetaRouteValue($route, "parameters.$name.type")
                        ?? Arr::get(config('openapi.map_type_parameter'), $name, 'number'),
                ],
            ];
        }

        return $parameters;
    }

    private function generateSecurity(LaravelRoute $route): array
    {
        $security = [];
        $mapMiddlewareSecurity = config('openapi.map_middleware_security');

        foreach ($route->gatherMiddleware() as $middleware) {
            if (array_key_exists($middleware, $mapMiddlewareSecurity)) {
                $security[] = [$mapMiddlewareSecurity[$middleware] => []];
            }
        }

        return $security;
    }

    private function generateTags(): array
    {
        return $this->getMetaValue('tags') ?? [];
    }

    private function generateRequestBody(): array|StdClass
    {
        return new StdClass();
    }

    private function isSupportedRequestBody(string $routeMethod): bool
    {
        return in_array((string) Str::of($routeMethod)->lower(), ['post', 'patch', 'put']);
    }
}
