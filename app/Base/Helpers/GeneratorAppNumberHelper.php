<?php

declare(strict_types=1);

namespace App\Base\Helpers;

use Carbon\Carbon;

final class GeneratorAppNumberHelper
{
    /**
     * [this year]
     */
    public static int $nowYear;

    /**
     * [word to generate]
     */
    public static string $genWorld = 'ADM';

    /**
     * [parsing the last entry]
     */
    public static array $parse;

    /**
     * [generation of a new number]
     */
    public static array $generator;

    /**
     * [first application number]
     */
    public static int $startNumber = 1;

    /**
     * [current order number]
     */
    public static int $number = 1;

    /**
     * [order number generation]
     *
     * @param mixed string
     */
    public static function generate(?string $last = null): string
    {
        self::$nowYear = Carbon::now()->year;
        if ($last) {
            self::$parse = explode('-', $last);
            if (self::$nowYear === (int) self::$parse[1]) {
                self::$number = self::$parse[2] + self::$startNumber;
            }
        }
        self::$generator = [
            self::$genWorld,
            self::$nowYear,
            self::$number,
        ];

        return implode('-', self::$generator);
    }
}
