<?php

namespace App\Base\Helpers;

use App\Core\Helpers\CoreHelper;

class StringUserHelper extends CoreHelper
{
    /**
     * [processed string]
     */
    protected static string|null $data;

    /**
     * [string processing by 3 parameters]
     */
    public static function run(string|null $string): string|null
    {
        static::$data = $string;
        if (static::$data != null) {
        self::stringTrim(static::$data);
        self::stringAllLower(static::$data);
        self::stringUpFirst(static::$data);
        }

        return static::$data;
    }

    /**
     * [removing spaces]
     *
     * @param  mixed  $string
     */
    protected static function stringTrim($string): string
    {
        return static::$data = trim($string);
    }

    /**
     * [convert all characters to lower case]
     *
     * @param  mixed  $string
     */
    protected static function stringAllLower($string): string
    {
        return static::$data = strtolower($string);
    }

    /**
     * [convert first character to upper case]
     *
     * @param  mixed  $string
     */
    protected static function stringUpFirst($string): string
    {
        return static::$data = mb_convert_case($string, MB_CASE_TITLE, 'UTF-8');
    }
}
