<?php

namespace App\Base\Helpers;

use App\Core\Helpers\CoreHelper;
use Carbon\Carbon;

class GeneratorAppNumberHelper extends CoreHelper
{
    /**
     * [Текущий год]
     *
     * @var string
     */
    public static string $nowYear;
    /**
     * [Слово для генерации]
     *
     * @var string
     */
    public static string $genWorld = 'ADM';
    /**
     * [Парсинг последней записи]
     *
     * @var array
     */
    public static array $parse;
    /**
     * [Генерация нового номера]
     *
     * @var array
     */
    public static array $generator;
      /**
     * [Нумерация заявки]
     *
     * @var int
     */
    public static int $startNumber = 1;
    /**
     * [Нумерация заявки]
     *
     * @var int
     */
    public static int $number = 0;

    /**
     * [Генератор номера заявки]
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
