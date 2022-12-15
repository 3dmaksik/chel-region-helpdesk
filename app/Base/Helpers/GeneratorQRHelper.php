<?php

namespace App\Base\Helpers;

use App\Core\Helpers\CoreHelper;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GeneratorQRHelper extends CoreHelper
{
    /**
     * Генерация QR
     *
     * @param string $generator
     *
     * @return string
     */
    public static function generate(string $generator): string
    {
        return base64_encode(QrCode::encoding('UTF-8')->format('png')->size(200)->generate(route('test') . '/' . $generator));
    }
}
