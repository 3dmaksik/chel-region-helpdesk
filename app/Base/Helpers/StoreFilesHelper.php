<?php

namespace App\Base\Helpers;

use App\Core\Helpers\CoreHelper;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class StoreFilesHelper extends CoreHelper
{
    protected static array $url;

    public static function createFile($request, int $w = 1920, int $h = 1080): array
    {
        static $i = 0;
        $imgPath = 'images';
        foreach ($request as $file) {
                $fileName = time() . '_' . mt_rand() . '.png';
                //Изменение размера изображения
                $img = Image::make($file->path());
                $resize = $img->resize($w, $h, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($imgPath . '/' . $fileName);
                Storage::disk('public')->put($fileName, $resize);
                $url[$i] = ['url' => $fileName];
                unlink(public_path($imgPath . '/' . $fileName));
                $i++;
        }
        return $url;
    }

    public static function createNotify($request) : array
    {
        $fileName = time() . '_' . mt_rand() . '.ogg';
        Storage::disk('public')->put($fileName, $request->path());
        return ['url' => $fileName];
    }
}
