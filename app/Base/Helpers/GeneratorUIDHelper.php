<?php

namespace App\Base\Helpers;

use App\Core\Helpers\CoreHelper;

class GeneratorUIDHelper extends CoreHelper
{
    /**
     * [checking division by 4]
     */
    private static function check(int $number): void
    {
        if ($number % 4 != 0) {
            throw new \Exception('Check number is Invalid');
        }
    }

    /**
     * [generation UUID 4-4]
     */
    public static function generate(int $length): string
    {
        self::check($length);
        $characters = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        return rtrim(chunk_split($randomString, 4, '-'), '-');
    }
}
