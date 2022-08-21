<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi;

use AkioSarkiz\Openapi\Enums\ConsoleColor;

/**
 * Simple class for colored print to console.
 */
class Console
{
    /**
     * @param $content
     * @param  ConsoleColor  $color
     * @return string
     */
    public static function format($content, ConsoleColor $color): string
    {
        $footer = "\033[0m";
        $header = match ($color->label) {
            ConsoleColor::RED()->label => "\033[31m",
            ConsoleColor::GREEN()->label => "\033[32m",
            ConsoleColor::YELLOW()->label => "\033[33m",
            ConsoleColor::BLUE()->label => "\033[34m",
            ConsoleColor::MAGENTA()->label => "\033[35m",
            ConsoleColor::CYAN()->label => "\033[36m",
            ConsoleColor::LIGHT_GREY()->label => "\033[37m",
            ConsoleColor::DARK_GREY()->label => "\033[90m",
            ConsoleColor::LIGHT_RED()->label => "\033[91m",
            ConsoleColor::LIGHT_GREEN()->label => "\033[92m",
            ConsoleColor::LIGHT_YELLOW()->label => "\033[93m",
            ConsoleColor::LIGHT_BLUE()->label => "\033[94m",
            ConsoleColor::LIGHT_MAGENTA()->label => "\033[95m",
            ConsoleColor::LIGHT_CYAN()->label => "\033[92m",
            default => '',
        };

        return $header.$content.$footer;
    }

    /**
     * @param $content
     * @param  ConsoleColor  $color
     * @return void
     */
    public static function writeln($content, ConsoleColor $color): void
    {
        if (env('APP_ENV') === 'testing') {
            return;
        }

        echo self::format($content, $color).PHP_EOL;
    }

    /**
     * @param $content
     * @param  ConsoleColor  $color
     * @return void
     */
    public static function write($content, ConsoleColor $color): void
    {
        if (env('APP_ENV') === 'testing') {
            return;
        }

        echo self::format($content, $color);
    }
}
