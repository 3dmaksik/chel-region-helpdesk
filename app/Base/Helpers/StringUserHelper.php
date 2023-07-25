<?php

namespace App\Base\Helpers;

use App\Core\Helpers\CoreHelper;

class StringUserHelper extends CoreHelper
{
    /**
     * [processed string]
     */
    protected static ?string $data = null;

    /**
     * [string processing by 3 parameters]
     */
    public static function run(?string $string): ?string
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
     */
    protected static function stringTrim(mixed $string): string
    {
        return static::$data = trim((string) $string);
    }

    /**
     * [convert all characters to lower case]
     */
    protected static function stringAllLower(mixed $string): string
    {
        return static::$data = strtolower((string) $string);
    }

    /**
     * [convert first character to upper case]
     */
    protected static function stringUpFirst(mixed $string): string
    {
        return static::$data = mb_convert_case((string) $string, MB_CASE_TITLE, 'UTF-8');
    }
}
