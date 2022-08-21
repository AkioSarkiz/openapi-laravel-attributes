<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi;

use AkioSarkiz\Openapi\Contacts\PayloadFactory as PayloadFactoryContract;
use Illuminate\Support\Arr;
use JetBrains\PhpStorm\Pure;

class PayloadFactory implements PayloadFactoryContract
{
    /**
     * @var array<int,array>
     */
    private array $fields = [];

    /**
     * @var bool
     */
    private bool $isArray = false;

    /**
     * @var int|null
     */
    private ?int $customIndex = null;

    /**
     * @return static
     */
    #[Pure]
    public static function make(): self
    {
        return new self();
    }

    /**
     * @param  int|string  $field
     * @return PayloadFactory
     */
    public function ofField(int|string $field): self
    {
        $this->customIndex = is_int($field)
            ? $field
            : collect($this->fields)->search(fn($arrayField) => $arrayField['field'] === $field);

        return $this;
    }

    /**
     * @return $this
     */
    public function asArray(): self
    {
        $this->isArray = true;

        return $this;
    }

    /**
     * @param  array  $setters
     * @return void
     */
    private function inject(array $setters): void
    {
        foreach ($setters as $setter => $value) {
            Arr::set($this->fields[$this->customIndex ?? count($this->fields) - 1], $setter, $value);
        }

        $this->customIndex = null;
    }

    /**
     * @return $this
     */
    public function field(string $field, array $rules = []): self
    {
        $this->fields[] = compact('field', 'rules');

        return $this;
    }

    /**
     * @param  string  $description
     * @return $this
     */
    public function description(string $description): self
    {
        $this->inject(compact('description'));

        return $this;
    }

    /**
     * @param  mixed  $examples
     * @return $this
     */
    public function examples(mixed $examples): self
    {
        $this->inject(compact('examples'));

        return $this;
    }

    /**
     * @param  array  $enums
     * @return $this
     */
    public function enums(array $enums): self
    {
        $this->inject(compact('enums'));

        return $this;
    }

    /**
     * @param  string  $type
     * @return $this
     */
    public function type(string $type): self
    {
        $this->inject(compact('type'));

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function generate(): array
    {
        return $this->generateSchema();
    }

    /**
     * @return array
     */
    private function generateSchema(): array
    {
        $type = $this->isArray ? 'array' : 'object';
        $root = $this->isArray ? 'items' : 'properties';
        $schema = [
            'type' => $type,
            $root => [],
        ];

        foreach ($this->fields as $index => $data) {
            $schema[$root][$data['field']] = [
                'type' => $this->parseTypeFromRules($index),
            ];
        }

        return $schema;
    }

    /**
     * @param  int  $index
     * @return string
     */
    private function parseTypeFromRules(int $index): string
    {
        $data = $this->fields[$index];

        if (Arr::has($data, 'type')) {
            return $data['type'];
        }

        $config = [
            'string' => ['string', 'email'],
            'number' => ['int', 'integer'],
        ];

        foreach ($config as $type => $needs) {
            foreach ($needs as $need) {
                if (in_array($need, Arr::get($data, 'rules', []))) {
                    return $type;
                }
            }
        }

        return '';
    }

    /**
     * @return $this
     */
    public function format(string $format): self
    {
        $this->inject(compact('format'));

        return $this;
    }
}
