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
            $file = StoreFilesHelper::createOneImage($avatar, 'avatar', 32, 32);
            $this->assertJson($file);
            $clearAvatar = json_decode($file, true, 512, JSON_THROW_ON_ERROR);
            Storage::disk('avatar')->delete($clearAvatar['url']);
        }
    }

    public function test_store_sound(): void
    {
        Storage::fake('sound');
        for ($i = 1; $i <= 10; $i++) {
            $sound = UploadedFile::fake()->create('sound.ogg')->size(10);
            $file = StoreFilesHelper::createNotify($sound, 'sound');
            $this->assertJson($file);
            $clearSound = json_decode($file, true, 512, JSON_THROW_ON_ERROR);
            Storage::disk('sound')->delete($clearSound['url']);
        }
    }
}
