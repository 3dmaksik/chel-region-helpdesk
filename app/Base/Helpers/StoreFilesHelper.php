<?php

namespace App\Base\Helpers;

use App\Core\Helpers\CoreHelper;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class StoreFilesHelper extends CoreHelper
{
    protected static array $url;

    public static function createFile($request, int $w, int $h): array
    {
        static $i = 0;
        foreach ($request as $file) {
            $url[$i] = self::createOneFile($file, $w, $h);
            $i++;
        }
        return $url;
    }

    public static function createOneFile($file, $w = 1920, int $h = 1080) : array
    {
        $imgPath = 'images';
        $fileName = time() . '_' . mt_rand() . '.png';
        $img = Image::make($file->path());
                $resize = $img->resize($w, $h, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($imgPath . '/' . $fileName);
                Storage::disk('public')->put($fileName, $resize);
                unlink(public_path($imgPath . '/' . $fileName));
        return ['url' => $fileName];
    }

    public static function createNotify($request) : array
    {
        $fileName = time() . '_' . mt_rand() . '.ogg';
        Storage::disk('public')->put($fileName, $request->path());
        return ['url' => $fileName];
    }
}
