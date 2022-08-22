<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Transformers;

use AkioSarkiz\Openapi\Contacts\TransformerOpenapi;
use Illuminate\Support\Arr;

class VariablesParseTransformer implements TransformerOpenapi
{
    /**
     * @var array
     */
    private array $variables = [];

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        $this->variables = config('openapi.variables', []);
    }

    /**
     * @inheritDoc
     */
    public function transform(array $schema): array
    {
        array_walk_recursive($schema, function (mixed &$value) {
            if (! is_string($value)) {
                return;
            }

            foreach ($this->variables as $variableName => $variableValue) {
                if (is_string($variableValue) || is_float($variableValue) || is_int($variableValue)) {
                    $value = $this->replace($variableName, (string) $variableValue, $value);
                } elseif (is_callable($variableValue)) {
                    $value = $this->replace($variableName, (string) call_user_func($variableValue, $value), $value);
                } else {
                    echo 'Not supported variable type.' . PHP_EOL;
                }
            }
        });

        return $schema;
    }

    private function replace(string $variableName, string $variableValue, string $value): string
    {
        return preg_replace('/\{\s*\{\s*' . $this->formatSearchPreg($variableName) . '\}\}/', $variableValue, $value);
    }

    private function formatSearchPreg(string $variableName): string
    {
        return str_replace(['_', '-', '.'], ['\_', '\-', '\.'], $variableName);
    }
}
