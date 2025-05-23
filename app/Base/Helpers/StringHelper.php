<?php

declare(strict_types=1);

namespace App\Base\Helpers;

final class StringHelper
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
        self::$data = $string;
        if (self::$data) {
            self::stringTrim(self::$data);
            self::stringAllLower(self::$data);
            self::stringUpFirst(self::$data);
        }

        return self::$data;
    }

    /**
     * [removing spaces]
     */
    public static function stringTrim(string $string): string
    {
        return self::$data = trim((string) $string);
    }

    /**
     * [convert all characters to lower case]
     */
    public static function stringAllLower(string $string): string
    {
        return self::$data = strtolower((string) $string);
    }

    /**
     * [convert first character to upper case]
     */
    public static function stringUpFirst(string $string): string
    {
        return self::$data = mb_convert_case((string) $string, MB_CASE_TITLE, 'UTF-8');
    }
}
