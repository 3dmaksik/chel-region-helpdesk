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
    private static string $saveStorage;

    /**
     * [creating multiple images]
     */
    public static function createFileImages(array $request, string $type = 'public', int $w = 1920, int $h = 1080): ?array
    {
        $url = [];
        foreach ($request as $file) {
            $url[self::$i] = self::createOneImage($file, $type, $w, $h);
            self::$i++;
        }

        return $url;
    }

    /**
     * [generate image name]
     */
    protected static function createImageName(): string
    {
        self::$nameGenerate = time().'_'.random_int(0, mt_getrandmax()).'.png';

        return self::$nameGenerate;
    }

    /**
     * [generate sound name]
     */
    protected static function createSoundName(): string
    {
        self::$nameGenerate = time().'_'.random_int(0, mt_getrandmax()).'.ogg';

        return self::$nameGenerate;
    }

    /**
     * [create one image]
     */
    public static function createOneImage(UploadedFile $file, string $type, int $w, int $h): ?string
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

        return $img->resize($w, $h, function ($constraint): void {
            $constraint->aspectRatio();
        });
    }

    /**
     * [save image]
     */
    protected static function saveImageStorage(string $type, string $fileName, Img $img): string
    {
        Storage::disk($type)->put($fileName, $img);

        return json_encode(['url' => $fileName], JSON_THROW_ON_ERROR);
    }

    /**
     * [save sound]
     */
    protected static function saveSoundStorage(UploadedFile $file, string $type, string $fileName): string
    {
        Storage::disk($type)->put($fileName, file_get_contents($file));

        return json_encode(['url' => $fileName], JSON_THROW_ON_ERROR);
    }

    /**
     * [create one sound]
     */
    public static function createNotify(UploadedFile $request, string $type): ?string
    {
        self::$fileName = self::createSoundName();
        self::$saveStorage = self::saveSoundStorage($request, $type, self::$fileName);

        return self::$saveStorage;
    }
}
