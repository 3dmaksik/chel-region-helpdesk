<?php

namespace App\Base\Helpers;

use App\Core\Helpers\CoreHelper;

class StringUserHelper extends CoreHelper
{
    /**
     * [processed string]
     *
     * @var string
     */
    protected static string $data;

    /**
     * [string processing by 3 parameters]
     *
     * @param string $string
     *
     * @return string
     */
    public static function run(string $string) : string
    {
        static::$data = $string;
        self::stringTrim(static::$data);
        self::stringAllLower(static::$data);
        self::stringUpFirst(static::$data);
        return static::$data;
    }

    /**
     * [removing spaces]
     *
     * @param mixed $string
     *
     * @return string
     */
    protected static function stringTrim($string): string
    {
        return static::$data = trim($string);
    }

    /**
     * [convert all characters to lower case]
     *
     * @param mixed $string
     *
     * @return string
     */
    protected static function stringAllLower($string): string
    {
        return static::$data = strtolower($string);
    }

    /**
     * [convert first character to upper case]
     *
     * @param mixed $string
     *
     * @return string
     */
    protected static function stringUpFirst($string): string
    {
        return static::$data = mb_convert_case($string, MB_CASE_TITLE, 'UTF-8');
    }
}
