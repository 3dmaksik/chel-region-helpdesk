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
     *
     * @var array
     */
    protected static array $url;
    /**
     * [counter in a loop]
     *
     * @var int
     */
    private static int $i = 0;
    /**
     * [generated name file]
     *
     * @var string
     */
    private static string $fileName;
    /**
     * [converted image]
     *
     * @var \Intervention\Image\Image
     */
    private static Img $img;
    /**
     * [converted image in width and height]
     *
     * @var \Intervention\Image\Image
     */
    private static Img $resize;
    /**
     * [width image]
     *
     * @var int
     */
    private static int $width;
    /**
     * [height image]
     *
     * @var int
     */
    private static int $height;
    /**
     * [creating multiple images]
     *
     * @param \Illuminate\Http\UploadedFile $request
     * @param string $type
     * @param int $w
     * @param int $h
     *
     * @return array
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
     *
     * @return string
     */
    protected static function createImageName() : string
    {
        return time() . '_' . mt_rand() . '.png';
    }

    /**
     * [generate sound name]
     *
     * @return string
     */
    protected static function createSoundName() : string
    {
        return time() . '_' . mt_rand() . '.ogg';
    }

    /**
     * [create one image]
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $type
     * @param int $w
     * @param int $h
     *
     * @return array
     */
    public static function createOneFile(UploadedFile $file, string $type, $w, $h) : array
    {
        self::$fileName = self::createImageName();
        self::$img = Image::make($file->getRealPath());
        self::$resize = self::resizeFile(self::$img, $w, $h);
        self::$resize->stream();
        return self::saveImageStorage($type, self::$fileName, self::$resize);
    }

    /**
     * [resize image]
     *
     * @param \Intervention\Image\Image $img
     * @param int $w
     * @param int $h
     *
     * @return \Intervention\Image\Image
     */
    protected static function resizeFile(Img $img, int $w, int $h): Img
    {
        self::$width = $img->width();
        self::$height = $img->height();
        (self::$width < $w) ? : $w = self::$width;
        (self::$height < $h) ? : $h = self::$height;
        return $img->resize($w, $h, function ($constraint) {
            $constraint->aspectRatio();
        });
    }

    /**
     * [save image]
     *
     * @param string $type
     * @param string $fileName
     * @param \Intervention\Image\Image $img
     *
     * @return array
     */
    protected static function saveImageStorage(string $type, string $fileName, Img $img) : array
    {
        Storage::disk($type)->put($fileName, $img);
        return ['url' => $fileName];
    }

    /**
     * [save sound]
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $path
     * @param string $fileName
     *
     * @return array
     */
    protected static function saveSoundStorage(UploadedFile $file, string $path, string $fileName) : array
    {
        $file->storeAs($path, $fileName);
        return ['url' => $fileName];
    }

    /**
     * [create one sound]
     *
     * @param \Illuminate\Http\UploadedFile $request
     *
     * @return array
     */
    public static function createNotify(UploadedFile $request) : array
    {
        self::$fileName = self::createSoundName();
        return self::saveSoundStorage($request, '\\public\\sound\\', self::$fileName);
    }
}
