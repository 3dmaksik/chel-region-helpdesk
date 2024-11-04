<?php

namespace Tests\Unit;

use App\Base\Helpers\StoreFilesHelper;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoreFileTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_store_image(): void
    {
        Storage::fake('avatar');
        for ($i = 1; $i <= 10; $i++) {
            $avatar = UploadedFile::fake()->image('avatar.jpg', 100, 100)->size(10);
            $filename = StoreFilesHelper::createImageName();
            $file = StoreFilesHelper::createOneImage($filename, $avatar, 'avatar', 32, 32);
            $this->assertNull($file);
            Storage::disk('avatar')->delete($filename);
        }
    }

    public function test_store_sound(): void
    {
        Storage::fake('sound');
        for ($i = 1; $i <= 10; $i++) {
            $sound = UploadedFile::fake()->create('sound.ogg')->size(10);
            $filename = StoreFilesHelper::createSoundName();
            $file = StoreFilesHelper::createNotify($filename, $sound, 'sound');
            $this->assertNull($file);
            Storage::disk('sound')->delete($filename);
        }
    }
    public function test_store_file(): void
    {
        Storage::fake('file');
        for ($i = 1; $i <= 10; $i++) {
            $testFile = UploadedFile::fake()->create('file.zip')->size(10);
            $filename = StoreFilesHelper::createFileName($testFile);
            $file = StoreFilesHelper::createOneFile('file', $filename, $testFile );
            $this->assertNull($file);
            Storage::disk('file')->delete($filename);
        }
    }
}
