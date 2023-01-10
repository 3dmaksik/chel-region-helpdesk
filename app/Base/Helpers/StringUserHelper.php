<?php

namespace App\Base\Helpers;

use App\Core\Helpers\CoreHelper;

class StringUserHelper extends CoreHelper
{
    protected static string $data;

    public static function run(string $string) : string
    {
        static::$data = $string;
        self::stringTrim(static::$data);
        self::stringAllLower(static::$data);
        self::stringUpFirst(static::$data);
        return static::$data;
    }

    protected static function stringTrim($string): string
    {
        return static::$data = trim($string);
    }

    protected static function stringAllLower($string): string
    {
        return static::$data = strtolower($string);
    }

    protected static function stringUpFirst($string): string
    {
        return static::$data = mb_convert_case($string, MB_CASE_TITLE, 'UTF-8');
    }
}
