<?php

declare(strict_types=1);

namespace App\Base\Helpers;

use App\Core\Helpers\CoreHelper;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

final class GeneratorQRHelper extends CoreHelper
{
    /**
     * [generation QR code]
     */
    public static function generate(string $generator): string
    {
        return base64_encode((string) QrCode::encoding('UTF-8')->format('png')->size(200)->generate(route('test').'/'.$generator));
    }
}
