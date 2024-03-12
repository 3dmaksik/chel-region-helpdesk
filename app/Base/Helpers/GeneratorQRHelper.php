<?php

declare(strict_types=1);

namespace App\Base\Helpers;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

final class GeneratorQRHelper
{
    /**
     * [generation QR code]
     */
    public static function generate(string $generator): string
    {
        return base64_encode((string) QrCode::encoding('UTF-8')->format('png')->size(200)->generate(route('test').'/'.$generator));
    }
}
