<?php

namespace Tests\Feature\Controllers;

use App\Models\Cabinet;
use App\Models\User;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    //use DatabaseTransactions;
    use RefreshDatabase;

    private User $superAdmin;

    private User $admin;

    private User $manager;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $this->withoutMiddleware(RedirectIfAuthenticated::class);
        $this->seed(RolesTableSeeder::class);

        $this->superAdmin = User::factory()->create()->assignRole('superAdmin');
        $this->admin = User::factory()->create()->assignRole('admin');
        $this->manager = User::factory()->create()->assignRole('manager');
        $this->user = User::factory()->create()->assignRole('user');
    }

    public function test_controller_user_index_super_admin(): void
    {
        User::factory()->create()->assignRole('user');
        $this->assertDatabaseCount('users', 5);
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.users.index')));
        $response->assertStatus(200);
    }

    public function test_controller_user_create_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.users.create')));
        $response->assertStatus(200);
    }

    public function test_controller_user_show_super_admin(): void
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
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.users.show'), $testUser->id));
        $response->assertStatus(200);
    }

    public function test_controller_user_edit_super_admin(): void
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
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.users.edit'), $testUser->id));
        $response->assertStatus(200);
    }

    public function test_controller_user_index_error_admin(): void
    {
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.users.index')));
        $response->assertStatus(403);
    }

    public function test_controller_user_index_error_manager(): void
    {
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.users.index')));
        $response->assertStatus(403);
    }

    public function test_controller_user_index_error_user(): void
    {
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.users.index')));
        $response->assertStatus(403);
    }

    public function test_controller_user_create_error_admin(): void
    {
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.users.create')));
        $response->assertStatus(403);
    }

    public function test_controller_user_create_error_manager(): void
    {
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.users.create')));
        $response->assertStatus(403);
    }

    public function test_controller_user_create_error_user(): void
    {
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.users.create')));
        $response->assertStatus(403);
    }

    public function test_controller_user_edit_error_admin(): void
    {
        $user = User::factory()->create()->assignRole('user');
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.users.edit'), $user->id));
        $response->assertStatus(403);
    }

    public function test_controller_user_edit_error_manager(): void
    {
        $user = User::factory()->create()->assignRole('user');
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.users.edit'), $user->id));
        $response->assertStatus(403);
    }

    public function test_controller_user_edit_error_user(): void
    {
        $user = User::factory()->create()->assignRole('user');
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.users.edit'), $user->id));
        $response->assertStatus(403);
    }

    public function test_controller_user_show_error_admin(): void
    {
        $user = User::factory()->create()->assignRole('user');
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.users.show'), $user->id));
        $response->assertStatus(403);
    }

    public function test_controller_user_show_error_manager(): void
    {
        $user = User::factory()->create()->assignRole('user');
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.users.show'), $user->id));
        $response->assertStatus(403);
    }

    public function test_controller_user_show_error_user(): void
    {
        $user = User::factory()->create()->assignRole('user');
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.users.show'), $user->id));
        $response->assertStatus(403);
    }
}
