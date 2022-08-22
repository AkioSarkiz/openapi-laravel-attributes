<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Adapters;

use AkioSarkiz\Openapi\Attributes\SchemaModel as SchemaModelAttribute;
use AkioSarkiz\Openapi\Contacts\AttributeAdapter;
use Doctrine\DBAL\Types\AsciiStringType;
use Doctrine\DBAL\Types\BigIntType;
use Doctrine\DBAL\Types\BinaryType;
use Doctrine\DBAL\Types\BlobType;
use Doctrine\DBAL\Types\BooleanType;
use Doctrine\DBAL\Types\DateImmutableType;
use Doctrine\DBAL\Types\DateIntervalType;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\DBAL\Types\DateTimeTzImmutableType;
use Doctrine\DBAL\Types\DateTimeTzType;
use Doctrine\DBAL\Types\DateType;
use Doctrine\DBAL\Types\DecimalType;
use Doctrine\DBAL\Types\FloatType;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\JsonType;
use Doctrine\DBAL\Types\SmallIntType;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\TextType;
use Doctrine\DBAL\Types\TimeImmutableType;
use Doctrine\DBAL\Types\TimeType;
use Doctrine\DBAL\Types\Type;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionMethod;

class SchemaModel implements AttributeAdapter
{
    /**
     * ReflectionClass with SchemaModelAttribute.
     *
     * @var ReflectionClass|ReflectionMethod
     */
    private ReflectionClass|ReflectionMethod $reflectionClass;

    private string $path;
    private array $schema;

    /**
     * @inheritDoc
     */
    public function init(ReflectionClass|ReflectionMethod $reflection): void
    {
        $this->reflectionClass = $reflection;
        $this->initPath();
        $this->initSchema();
    }

    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @inheritDoc
     */
    public function getSchema(): array
    {
        return $this->schema;
    }

    private function initPath(): void
    {
        $this->path = 'components.schemas.'
            .str_replace(
                ['\\', '.'],
                [' ', ''],
                Str::after($this->reflectionClass->getName(), 'Models\\')
            );
    }

    private function initSchema(): void
    {
        $this->schema = [
            'type' => 'object',
            'properties' => [],
        ];

        $this->parseReflectionClass();
    }

    /**
     * Doctrine Column Type to Openapi format.
     *
     * @see Type
     * @param  Type  $type
     * @return array
     */
    private function convertDoctrineColumnType(Type $type): array
    {
        return match (get_class($type)) {
            AsciiStringType::class, StringType::class, TextType::class, BinaryType::class, BlobType::class,
            JsonType::class => [
                'type' => 'string',
            ],

            TimeType::class, DateTimeTzImmutableType::class, DateTimeImmutableType::class, DateTimeType::class,
            DateIntervalType::class, DateImmutableType::class, DateType::class, DateTimeTzType::class,
            TimeImmutableType::class => [
                'type' => 'string',
                'format' => 'date-time',
            ],

            BigIntType::class, IntegerType::class => [
                'type' => 'int64',
            ],
            BooleanType::class => [
                'type' => 'boolean',
            ],
            DecimalType::class => [
                'type' => 'number',
                'format' => 'double',
            ],
            FloatType::class => [
                'type' => 'number',
                'format' => 'float',
            ],
            SmallIntType::class => [
                'type' => 'int32',
            ],
        };
    }

    private function parseReflectionClass(): void
    {
        $instance = $this->reflectionClass->newInstance();
        $referenceModel = null;

        if ($instance instanceof Model) {
            $referenceModel = $instance;
        } else {
            $attributes = $this->reflectionClass
                ->getAttributes(SchemaModelAttribute::class, ReflectionAttribute::IS_INSTANCEOF);

            if (count($attributes) !== 0) {
                /** @var SchemaModelAttribute $attribute */
                $attribute = $attributes[0];

                if ($attribute->model) {
                    $referenceModel = app($attribute->model)->getTable();
                }
            }
        }

        if (! $referenceModel) {
            return;
        }

        $table = $referenceModel->getTable();
        $columns = Schema::getColumnListing($table);

        foreach ($columns as $column) {
            $this->schema['properties'][$column] = $this->convertDoctrineColumnType(
                DB::connection()->getDoctrineColumn($table, $column)->getType()
            );
        }
    }
}
