<?php

namespace App\Base\Helpers;

use App\Core\Helpers\CoreHelper;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Intervention\Image\Image as Img;

class StoreFilesHelper extends CoreHelper
{
    /**
     * [url one file or more files]
     */
    protected static array $url;

    /**
     * [counter in a loop]
     */
    private static int $i = 0;

    /**
     * [generated name file]
     */
    private static string $fileName;

    /**
     * [converted image]
     */
    private static Img $img;

    /**
     * [converted image in width and height]
     */
    private static Img $resize;

    /**
     * [width image]
     */
    private static int $width;

    /**
     * [height image]
     */
    private static int $height;

    /**
     * [generated name]
     */
    private static string $nameGenerate;

    /**
     * [saved file]
     */
    private static array $saveStorage;

    /**
     * [creating multiple images]
     */
    public static function createFile(UploadedFile $request, string $type = 'public', int $w = 1920, int $h = 1080): array
    {
        foreach ($request as $file) {
            $url[self::$i] = self::createOneFile($file, $type, $w, $h);
            self::$i++;
        }

        return $url;
    }

    /**
     * [generate image name]
     */
    protected static function createImageName(): string
    {
        self::$nameGenerate = time().'_'.mt_rand().'.png';

        return self::$nameGenerate;
    }

    /**
     * [generate sound name]
     */
    protected static function createSoundName(): string
    {
        self::$nameGenerate = time().'_'.mt_rand().'.ogg';

        return self::$nameGenerate;
    }

    /**
     * [create one image]
     *
     * @param  int  $w
     * @param  int  $h
     */
    public static function createOneFile(UploadedFile $file, string $type, $w, $h): array
    {
        self::$fileName = self::createImageName();
        self::$img = Image::make($file->getRealPath());
        self::$resize = self::resizeFile(self::$img, $w, $h);
        self::$resize->stream();
        self::$saveStorage = self::saveImageStorage($type, self::$fileName, self::$resize);

        return self::$saveStorage;
    }

    /**
     * [resize image]
     */
    protected static function resizeFile(Img $img, int $w, int $h): Img
    {
        self::$width = $img->width();
        self::$height = $img->height();
        (self::$width < $w) ?: $w = self::$width;
        (self::$height < $h) ?: $h = self::$height;

        return $img->resize($w, $h, function ($constraint) {
            $constraint->aspectRatio();
        });
    }

    /**
     * [save image]
     */
    protected static function saveImageStorage(string $type, string $fileName, Img $img): array
    {
        Storage::disk($type)->put($fileName, $img);

        return ['url' => $fileName];
    }

    /**
     * [save sound]
     */
    protected static function saveSoundStorage(UploadedFile $file, string $path, string $fileName): array
    {
        $file->storeAs($path, $fileName);

        return ['url' => $fileName];
    }

    /**
     * [create one sound]
     */
    public static function createNotify(UploadedFile $request): array
    {
        self::$fileName = self::createSoundName();
        self::$saveStorage = self::saveSoundStorage($request, '\\public\\sound\\', self::$fileName);

        return self::$saveStorage;
    }
}
