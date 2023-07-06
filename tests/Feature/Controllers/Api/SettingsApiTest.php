<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Cabinet;
use App\Models\User;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SettingsApiTest extends TestCase
{
    use DatabaseTransactions;
    //use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $this->withoutMiddleware(RedirectIfAuthenticated::class);
        $this->seed(RolesTableSeeder::class);
    }

    public function test_controller_settings_account_update_super_admin(): void
    {
        $cabinet = Cabinet::factory()->create();
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => fake()->unique()->name(),
            'lastname' => fake()->unique()->name(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => $cabinet->id,
        ])->assignRole('superAdmin');
        Auth::login($testUser);
        Storage::fake('local');
        $avatar = UploadedFile::fake()->image('avatar.jpg', 100, 100)->size(100);
        $sound = UploadedFile::fake()->create('sound.ogg')->size(100);
        $response = $this->actingAs($testUser, 'web')->patchJson(route(config('constants.settings.updateSettings')),
            [
                'avatar' => $avatar,
                'sound_notify' => $sound,
            ], [
                'Accept' => 'application/json',
            ]);
        $updateUser = User::findOrFail(auth()->user()->id);
        $clearAvatar = json_decode($updateUser->avatar, true);
        Storage::disk('avatar')->delete($clearAvatar['url']);
        $clearSound = json_decode($updateUser->sound_notify, true);
        Storage::disk('sound')->delete($clearSound['url']);
        $response->assertStatus(200);
        $this->assertNotEquals(null, $updateUser->avatar);
        $this->assertNotEquals(null, $updateUser->sound_notify);
    }

    public function test_controller_settings_account_update_admin(): void
    {
        $cabinet = Cabinet::factory()->create();
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => fake()->unique()->name(),
            'lastname' => fake()->unique()->name(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => $cabinet->id,
        ])->assignRole('admin');
        Auth::login($testUser);
        Storage::fake('local');
        $avatar = UploadedFile::fake()->image('avatar.jpg', 100, 100)->size(100);
        $sound = UploadedFile::fake()->create('sound.ogg')->size(100);
        $response = $this->actingAs($testUser, 'web')->patchJson(route(config('constants.settings.updateSettings')),
            [
                'avatar' => $avatar,
                'sound_notify' => $sound,
            ], [
                'Accept' => 'application/json',
            ]);
        $updateUser = User::findOrFail(auth()->user()->id);
        $clearAvatar = json_decode($updateUser->avatar, true);
        Storage::disk('avatar')->delete($clearAvatar['url']);
        $clearSound = json_decode($updateUser->sound_notify, true);
        Storage::disk('sound')->delete($clearSound['url']);
        $response->assertStatus(200);
        $this->assertNotEquals(null, $updateUser->avatar);
        $this->assertNotEquals(null, $updateUser->sound_notify);
    }

    public function test_controller_settings_account_update_manager(): void
    {
        $cabinet = Cabinet::factory()->create();
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => fake()->unique()->name(),
            'lastname' => fake()->unique()->name(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => $cabinet->id,
        ])->assignRole('manager');
        Auth::login($testUser);
        Storage::fake('local');
        $avatar = UploadedFile::fake()->image('avatar.jpg', 100, 100)->size(100);
        $sound = UploadedFile::fake()->create('sound.ogg')->size(100);
        $response = $this->actingAs($testUser, 'web')->patchJson(route(config('constants.settings.updateSettings')),
            [
                'avatar' => $avatar,
                'sound_notify' => $sound,
            ], [
                'Accept' => 'application/json',
            ]);
        $updateUser = User::findOrFail(auth()->user()->id);
        $clearAvatar = json_decode($updateUser->avatar, true);
        Storage::disk('avatar')->delete($clearAvatar['url']);
        $clearSound = json_decode($updateUser->sound_notify, true);
        Storage::disk('sound')->delete($clearSound['url']);
        $response->assertStatus(200);
        $this->assertNotEquals(null, $updateUser->avatar);
        $this->assertNotEquals(null, $updateUser->sound_notify);
    }

    public function test_controller_settings_account_update_user(): void
    {
        $cabinet = Cabinet::factory()->create();
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => fake()->unique()->name(),
            'lastname' => fake()->unique()->name(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => $cabinet->id,
        ])->assignRole('user');
        Auth::login($testUser);
        Storage::fake('local');
        $avatar = UploadedFile::fake()->image('avatar.jpg', 100, 100)->size(100);
        $sound = UploadedFile::fake()->create('sound.ogg')->size(100);
        $response = $this->actingAs($testUser, 'web')->patchJson(route(config('constants.settings.updateSettings')),
            [
                'avatar' => $avatar,
                'sound_notify' => $sound,
            ], [
                'Accept' => 'application/json',
            ]);
        $updateUser = User::findOrFail(auth()->user()->id);
        $clearAvatar = json_decode($updateUser->avatar, true);
        Storage::disk('avatar')->delete($clearAvatar['url']);
        $clearSound = json_decode($updateUser->sound_notify, true);
        Storage::disk('sound')->delete($clearSound['url']);
        $response->assertStatus(200);
        $this->assertNotEquals(null, $updateUser->avatar);
        $this->assertNotEquals(null, $updateUser->sound_notify);
    }

    public function test_controller_settings_password_update_super_admin(): void
    {
        $cabinet = Cabinet::factory()->create();
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => fake()->unique()->name(),
            'lastname' => fake()->unique()->name(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => $cabinet->id,
        ])->assignRole('superAdmin');
        Auth::login($testUser);
        $response = $this->actingAs($testUser, 'web')->patchJson(route(config('constants.settings.updatePassword')),
            [
                'current_password' => 'password',
                'password' => 'password1',
            ], [
                'Accept' => 'application/json',
            ]);
        $user = User::where('id', auth()->user()->id)->first();
        $this->assertTrue(Hash::check('password1', $user->password));
        $response->assertStatus(200);
    }

    public function test_controller_settings_password_update_admin(): void
    {
        $cabinet = Cabinet::factory()->create();
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => fake()->unique()->name(),
            'lastname' => fake()->unique()->name(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => $cabinet->id,
        ])->assignRole('admin');
        Auth::login($testUser);
        $response = $this->actingAs($testUser, 'web')->patchJson(route(config('constants.settings.updatePassword')),
            [
                'current_password' => 'password',
                'password' => 'password1',
            ], [
                'Accept' => 'application/json',
            ]);
        $user = User::where('id', auth()->user()->id)->first();
        $this->assertTrue(Hash::check('password1', $user->password));
        $response->assertStatus(200);
    }

    public function test_controller_settings_password_update_manager(): void
    {
        $cabinet = Cabinet::factory()->create();
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => fake()->unique()->name(),
            'lastname' => fake()->unique()->name(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => $cabinet->id,
        ])->assignRole('manager');
        Auth::login($testUser);
        $response = $this->actingAs($testUser, 'web')->patchJson(route(config('constants.settings.updatePassword')),
            [
                'current_password' => 'password',
                'password' => 'password1',
            ], [
                'Accept' => 'application/json',
            ]);
        $user = User::where('id', auth()->user()->id)->first();
        $this->assertTrue(Hash::check('password1', $user->password));
        $response->assertStatus(200);
    }

    public function test_controller_settings_password_update_user(): void
    {
        $cabinet = Cabinet::factory()->create();
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => fake()->unique()->name(),
            'lastname' => fake()->unique()->name(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => $cabinet->id,
        ])->assignRole('user');
        Auth::login($testUser);
        $response = $this->actingAs($testUser, 'web')->patchJson(route(config('constants.settings.updatePassword')),
            [
                'current_password' => 'password',
                'password' => 'password1',
            ], [
                'Accept' => 'application/json',
            ]);
        $user = User::where('id', auth()->user()->id)->first();
        $this->assertTrue(Hash::check('password1', $user->password));
        $response->assertStatus(200);
    }

    public function test_controller_settings_account_update_validation_error_size_super_admin(): void
    {
        $cabinet = Cabinet::factory()->create();
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => fake()->unique()->name(),
            'lastname' => fake()->unique()->name(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => $cabinet->id,
        ])->assignRole('superAdmin');
        Auth::login($testUser);
        Storage::fake('local');
        $avatar = UploadedFile::fake()->image('avatar.jpg', 100, 100)->size(30720);
        $sound = UploadedFile::fake()->create('sound.ogg')->size(30720);
        $response = $this->actingAs($testUser, 'web')->patchJson(route(config('constants.settings.updateSettings')),
            [
                'avatar' => $avatar,
                'sound_notify' => $sound,
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['avatar', 'sound_notify']);
        $response->assertStatus(422);
    }

    public function test_controller_settings_account_update_validation_error_mime_super_admin(): void
    {
        $cabinet = Cabinet::factory()->create();
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => fake()->unique()->name(),
            'lastname' => fake()->unique()->name(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => $cabinet->id,
        ])->assignRole('superAdmin');
        Auth::login($testUser);
        Storage::fake('local');
        $avatar = UploadedFile::fake()->create('sound.ogg')->size(100);
        $sound = UploadedFile::fake()->image('avatar.jpg', 100, 100)->size(100);
        $response = $this->actingAs($testUser, 'web')->patchJson(route(config('constants.settings.updateSettings')),
            [
                'avatar' => $avatar,
                'sound_notify' => $sound,
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['avatar', 'sound_notify']);
        $response->assertStatus(422);
    }

    public function test_controller_settings_password_update_validation_error_exists_super_admin(): void
    {
        $cabinet = Cabinet::factory()->create();
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => fake()->unique()->name(),
            'lastname' => fake()->unique()->name(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => $cabinet->id,
        ])->assignRole('admin');
        Auth::login($testUser);
        $response = $this->actingAs($testUser, 'web')->patchJson(route(config('constants.settings.updatePassword')));
        $response->assertJsonValidationErrors(['current_password', 'password']);
        $response->assertStatus(422);
    }

    public function test_controller_settings_password_update_validation_error_min_super_admin(): void
    {
        $cabinet = Cabinet::factory()->create();
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => fake()->unique()->name(),
            'lastname' => fake()->unique()->name(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => $cabinet->id,
        ])->assignRole('user');
        Auth::login($testUser);
        $response = $this->actingAs($testUser, 'web')->patchJson(route(config('constants.settings.updatePassword')),
            [
                'current_password' => 'password',
                'password' => 'pas',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['password']);
        $response->assertStatus(422);
    }

    public function test_controller_settings_password_update_validation_error_max_super_admin(): void
    {
        $cabinet = Cabinet::factory()->create();
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => fake()->unique()->name(),
            'lastname' => fake()->unique()->name(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => $cabinet->id,
        ])->assignRole('user');
        Auth::login($testUser);
        $response = $this->actingAs($testUser, 'web')->patchJson(route(config('constants.settings.updatePassword')),
            [
                'current_password' => 'password',
                'password' => fake()->text(1000),
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['password']);
        $response->assertStatus(422);
    }

    public function test_controller_settings_password_update_validation_error_check_super_admin(): void
    {
        $cabinet = Cabinet::factory()->create();
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => fake()->unique()->name(),
            'lastname' => fake()->unique()->name(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => $cabinet->id,
        ])->assignRole('user');
        Auth::login($testUser);
        $response = $this->actingAs($testUser, 'web')->patchJson(route(config('constants.settings.updatePassword')),
            [
                'current_password' => 'pass',
                'password' => 'password1',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(422);
    }
}
