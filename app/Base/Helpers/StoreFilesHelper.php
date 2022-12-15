<?php

namespace App\Base\Helpers;

use App\Core\Helpers\CoreHelper;
use Intervention\Image\Facades\Image;

class StoreFilesHelper extends CoreHelper
{
    protected static array $url;

    public static function createFile($request): array
    {
        static $i = 0;
        $imgPath = 'images';
        foreach ($request as $file) {
                $fileName = time() . '_' . mt_rand() . '.png';
                //Изменение размера изображения
                $img = Image::make($file->path());
                $img->resize(1920, 1080, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($imgPath . '/' . $fileName);
                $url[$i] = ['url' => $fileName];
                $i++;
        }
        return $url;
    }
}
