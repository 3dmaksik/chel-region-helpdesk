<?php

namespace Tests\Feature\Controllers;

use App\Models\Cabinet;
use App\Models\User;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    //use DatabaseTransactions;
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $this->withoutMiddleware(RedirectIfAuthenticated::class);
        $this->seed(RolesTableSeeder::class);
    }

    public function test_controller_settings_edit_account_super_admin(): void
    {
        $cabinet = Cabinet::factory()->create();
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => $cabinet->id,
            'avatar' => 'avatar.jpg',
            'sound_notify' => 'sound.ogg',
        ])->assignRole('superAdmin');
        $response = $this->actingAs($testUser, 'web')->get(route(config('constants.settings.account')));
        $response->assertStatus(200);
    }

    public function test_controller_settings_edit_account_admin(): void
    {
        $cabinet = Cabinet::factory()->create();
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => $cabinet->id,
            'avatar' => 'avatar.jpg',
            'sound_notify' => 'sound.ogg',
        ])->assignRole('admin');
        $response = $this->actingAs($testUser, 'web')->get(route(config('constants.settings.account')));
        $response->assertStatus(200);
    }

    public function test_controller_settings_edit_account_manager(): void
    {
        $cabinet = Cabinet::factory()->create();
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => $cabinet->id,
            'avatar' => 'avatar.jpg',
            'sound_notify' => 'sound.ogg',
        ])->assignRole('manager');
        $response = $this->actingAs($testUser, 'web')->get(route(config('constants.settings.account')));
        $response->assertStatus(200);
    }

    public function test_controller_settings_edit_account_user(): void
    {
        $cabinet = Cabinet::factory()->create();
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => $cabinet->id,
            'avatar' => 'avatar.jpg',
            'sound_notify' => 'sound.ogg',
        ])->assignRole('user');
        $response = $this->actingAs($testUser, 'web')->get(route(config('constants.settings.account')));
        $response->assertStatus(200);
    }

    public function test_controller_settings_edit_password_super_admin(): void
    {
        $cabinet = Cabinet::factory()->create();
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => $cabinet->id,
        ])->assignRole('superAdmin');
        $response = $this->actingAs($testUser, 'web')->get(route(config('constants.settings.password')));
        $response->assertStatus(200);
    }

    public function test_controller_settings_edit_password_admin(): void
    {
        $cabinet = Cabinet::factory()->create();
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => $cabinet->id,
        ])->assignRole('admin');
        $response = $this->actingAs($testUser, 'web')->get(route(config('constants.settings.password')));
        $response->assertStatus(200);
    }

    public function test_controller_settings_edit_password_manager(): void
    {
        $cabinet = Cabinet::factory()->create();
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => $cabinet->id,
        ])->assignRole('manager');
        $response = $this->actingAs($testUser, 'web')->get(route(config('constants.settings.password')));
        $response->assertStatus(200);
    }

    public function test_controller_settings_edit_password_user(): void
    {
        $cabinet = Cabinet::factory()->create();
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => $cabinet->id,
        ])->assignRole('user');
        $response = $this->actingAs($testUser, 'web')->get(route(config('constants.settings.password')));
        $response->assertStatus(200);
    }
}
