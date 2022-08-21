<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Transformers;

use AkioSarkiz\Openapi\Adapters\RequestBody as RequestBodyAdapter;
use AkioSarkiz\Openapi\Adapters\RequestResponse as RequestResponseAdapter;
use AkioSarkiz\Openapi\Adapters\Route as RouteAdapter;
use AkioSarkiz\Openapi\Adapters\SchemaModel as SchemaModelAdapter;
use AkioSarkiz\Openapi\Attributes\RequestBody as RequestBodyAttribute;
use AkioSarkiz\Openapi\Attributes\RequestResponse as RequestResponseAttribute;
use AkioSarkiz\Openapi\Attributes\Route as RouteAttribute;
use AkioSarkiz\Openapi\Attributes\SchemaModel as SchemaModelAttribute;
use AkioSarkiz\Openapi\Contacts\AttributeAdapter;
use AkioSarkiz\Openapi\Contacts\Resolvable;
use AkioSarkiz\Openapi\Contacts\TransformerOpenapi;
use AkioSarkiz\Openapi\SchemaResolvers\RecursiveResolver;
use Illuminate\Support\Arr;
use JetBrains\PhpStorm\Pure;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;

class AttributesOpenapiTransformer implements TransformerOpenapi
{
    /**
     * Custom attributes.
     *
     * @var array<class-string, class-string>
     */
    private array $customAttributes = [];

    /**
     * Supported attributes.
     *
     * @var array<class-string, class-string>
     */
    private const ATTRIBUTE_ADAPTER_MAP = [
        SchemaModelAttribute::class => SchemaModelAdapter::class,
        RouteAttribute::class => RouteAdapter::class,
        RequestBodyAttribute::class => RequestBodyAdapter::class,
        RequestResponseAttribute::class => RequestResponseAdapter::class,
    ];

    /**
     * Get attribute adapter map.
     *
     * @return array<class-string, class-string>
     */
    private function getAttributeAdapterMap(): array
    {
        return array_merge(
            self::ATTRIBUTE_ADAPTER_MAP,
            $this->customAttributes,
            config('openapi.custom_attributes'),
        );
    }

    /**
     * @inheritDoc
     */
    public function init(array $args): void
    {
        $this->customAttributes = Arr::get($args, 'attributes', []);
    }

    /**
     * @inheritDoc
     */
    public function transform(array $schema): array
    {
        foreach (get_declared_classes() as $class) {
            try {
                $this->parseReflection(new ReflectionClass($class), $schema);
            } catch (ReflectionException) {
                echo "Error reflection {$class}\n";
            }
        }

        return $schema;
    }

    private function resolveSchema(array $schema, AttributeAdapter $adapter): array
    {
        /**
         * Make resolver. When adapter implemented Resolvable will be use adapter resolver else
         * will be use default resolver (RecursiveResolver).
         */
        $resolver = $adapter instanceof Resolvable
            ? $adapter->getResolver()
            : app(RecursiveResolver::class);

        return $resolver->resolve($schema, $adapter->getPath(), $adapter->getSchema());
    }

    private function parseReflection(ReflectionClass $reflectionClass, array &$schema): void
    {
        $attributeAdapterMap = $this->getAttributeAdapterMap();

        foreach ($attributeAdapterMap as $attribute => $adapter) {
            if ($this->hasAttributes($reflectionClass, $attribute)) {
                /** @var AttributeAdapter $adapterInstance */
                $adapterInstance = new $adapter();
                $adapterInstance->init($reflectionClass);
                $schema = $this->resolveSchema($schema, $adapterInstance);
            }
        }
    }

    /**
     * Search attributes in the class. When attribute exists method return true, else false.
     *
     * @param  ReflectionClass  $reflectionClass  Context class for search.
     * @param  string  $attributeName  Class name.
     * @return bool
     */
    #[Pure]
    private function hasAttributes(ReflectionClass $reflectionClass, string $attributeName): bool
    {
        if ($reflectionClass->getAttributes($attributeName, ReflectionAttribute::IS_INSTANCEOF)) {
            return true;
        }

        foreach ($reflectionClass->getMethods() as $reflectionMethod) {
            if ($reflectionMethod->getAttributes($attributeName, ReflectionAttribute::IS_INSTANCEOF)) {
                return true;
            }
        }

        return false;
    }
}
