<?php

declare(strict_types=1);

namespace App\Base\Helpers;

use App\Core\Helpers\CoreHelper;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Intervention\Image\Image as Img;

final class StoreFilesHelper extends CoreHelper
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
     * [creating multiple images]
     */
    public static function createFileImages(array $request, string $type = 'public', int $w = 1920, int $h = 1080): array
    {
        self::$url = [];
        foreach ($request as $file) {
            self::$fileName = self::createImageName();
            self::createOneImage(self::$fileName, $file, $type, $w, $h);
            self::$url[] = ['url' => self::$fileName];
            self::$i++;
        }

        return self::$url;
    }

    /**
     * [generate image name]
     */
    public static function createImageName(): string
    {
        self::$nameGenerate = time().'_'.random_int(0, mt_getrandmax()).'.png';

        return self::$nameGenerate;
    }

    /**
     * [generate sound name]
     */
    public static function createSoundName(): string
    {
        self::$nameGenerate = time().'_'.random_int(0, mt_getrandmax()).'.ogg';

        return self::$nameGenerate;
    }

    /**
     * [create one image]
     */
    public static function createOneImage(string $filename, UploadedFile $file, string $type, int $w, int $h): void
    {
        self::$fileName = $filename;
        self::$img = Image::make($file->getRealPath());
        self::$resize = self::resizeFile(self::$img, $w, $h);
        self::$resize->stream();
        self::saveImageStorage($type, self::$fileName, self::$resize);
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
    protected static function saveImageStorage(string $type, string $fileName, Img $img): void
    {
        Storage::disk($type)->put($fileName, $img);
    }

    /**
     * [save sound]
     */
    protected static function saveSoundStorage(UploadedFile $file, string $type, string $fileName): void
    {
        Storage::disk($type)->put($fileName, File::get($file));

    }

    /**
     * [create one sound]
     */
    public static function createNotify(string $filename, UploadedFile $request, string $type): void
    {
        self::$fileName = $filename;
        self::saveSoundStorage($request, $type, self::$fileName);
    }
}
