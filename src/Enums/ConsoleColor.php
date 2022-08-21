<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Enums;

use Spatie\Enum\Enum;

/**
 * enums.
 *
 * @method static self RED()
 * @method static self GREEN()
 * @method static self YELLOW()
 * @method static self BLUE()
 * @method static self MAGENTA()
 * @method static self CYAN()
 * @method static self LIGHT_GREY()
 * @method static self DARK_GREY()
 * @method static self LIGHT_RED()
 * @method static self LIGHT_GREEN()
 * @method static self LIGHT_YELLOW()
 * @method static self LIGHT_BLUE()
 * @method static self LIGHT_MAGENTA()
 * @method static self LIGHT_CYAN()
 *
 */
class ConsoleColor extends Enum
{
    /**
     * @inheritDoc
     */
    protected static function values(): array
    {
        return [
            'RED' => 1,
            'GREEN' => 2,
            'YELLOW' => 3,
            'BLUE' => 4,
            'MAGENTA' => 5,
            'CYAN' => 6,
            'LIGHT_GREY' => 7,
            'DARK_GREY' => 8,
            'LIGHT_RED' => 9,
            'LIGHT_GREEN' => 10,
            'LIGHT_YELLOW' => 11,
            'LIGHT_BLUE' => 12,
            'LIGHT_MAGENTA' => 13,
            'LIGHT_CYAN' => 14,
        ];
    }
}
