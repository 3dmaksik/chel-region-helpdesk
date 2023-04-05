<?php

namespace App\Base\Helpers;

use App\Core\Helpers\CoreHelper;
use Carbon\Carbon;

class GeneratorAppNumberHelper extends CoreHelper
{
    /**
     * [this year]
     *
     * @var string
     */
    public static string $nowYear;
    /**
     * [word to generate]
     *
     * @var string
     */
    public static string $genWorld = 'ADM';
    /**
     * [parsing the last entry]
     *
     * @var array
     */
    public static array $parse;
    /**
     * [generation of a new number]
     *
     * @var array
     */
    public static array $generator;
      /**
     * [first application number]
     *
     * @var int
     */
    public static int $startNumber = 1;
    /**
     * [current order number]
     *
     * @var int
     */
    public static int $number = 0;

    /**
     * [order number generation]
     *
     * @param mixed string
     *
     * @return string
     */
    public static function generate(string | null $last = null) : string
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
