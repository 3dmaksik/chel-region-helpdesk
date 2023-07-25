<?php

namespace App\Base\Helpers;

use App\Core\Helpers\CoreHelper;
use Carbon\Carbon;

class GeneratorAppNumberHelper extends CoreHelper
{
    /**
     * [this year]
     */
    public static string $nowYear;

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
    public static int $number = 0;

    /**
     * [order number generation]
     *
     * @param mixed string
     */
    public static function generate(string $last = null): string
    {
        self::$nowYear = Carbon::now()->year;
        self::$parse = explode('-', $last);
        if ($last == null) {
            self::$number = self::$startNumber;
        } else {
            if (self::$nowYear == self::$parse[1]) {
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
