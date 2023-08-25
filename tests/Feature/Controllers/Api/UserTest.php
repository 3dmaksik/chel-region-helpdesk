<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Cabinet;
use App\Models\Category;
use App\Models\Help;
use App\Models\Priority;
use App\Models\Status;
use App\Models\User;
use Database\Seeders\CabinetTableSeeder;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    //use RefreshDatabase;

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
        $this->seed(CabinetTableSeeder::class);

        $this->superAdmin = User::factory()->create()->assignRole('superAdmin');
        $this->admin = User::factory()->create()->assignRole('admin');
        $this->manager = User::factory()->create()->assignRole('manager');
        $this->user = User::factory()->create()->assignRole('user');
    }

    public function test_controller_user_search_cabinet_super_admin(): void
    {
        $cabinet = Cabinet::factory()->create();
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(('select2.cabinet'), 'q='.$cabinet->description));
        $response->assertJsonFragment(['id' => $cabinet->id, 'description' => (string) $cabinet->description]);
        $response->assertStatus(200);
    }

    public function test_controller_user_store_super_admin(): void
    {
        $cabinet = Cabinet::factory()->create();
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.users.store')),
            [
                'name' => 'testStore',
                'password' => 'password',
                'firstname' => 'Имя',
                'lastname' => 'Фамилия',
                'patronymic' => 'Отчество',
                'cabinet_id' => (string) $cabinet->id,
                'role' => 'user',

            ], [
                'Accept' => 'application/json',
            ]);
        $user = User::where('name', 'testStore')->first();
        $this->assertEquals('testStore', $user->name);
        $this->assertEquals('Имя', $user->firstname);
        $this->assertEquals('Фамилия', $user->lastname);
        $this->assertEquals('Отчество', $user->patronymic);
        $this->assertEquals($cabinet->id, $user->cabinet_id);
        $this->assertEquals('user', $user->getRoleNames()[0]);
        $this->assertDatabaseHas('users', ['name' => 'testStore', 'firstname' => 'Имя', 'lastname' => 'Фамилия', 'patronymic' => 'Отчество', 'cabinet_id' => $cabinet->id]);
        $response->assertStatus(200);
    }

    public function test_controller_user_update_super_admin(): void
    {
        $cabinet = Cabinet::factory()->create();
        $newCabinet = Cabinet::factory()->create();
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
        $response = $this->actingAs($this->superAdmin, 'web')->putJson(route(config('constants.users.update'), $testUser->id),
            [
                'name' => 'testUpdate',
                'password' => 'password1',
                'firstname' => 'Имя',
                'lastname' => 'Фамилия',
                'patronymic' => 'Отчество',
                'cabinet_id' => (string) $newCabinet->id,
                'role' => 'admin',
            ], [
                'Accept' => 'application/json',
            ]);
        $user = User::where('name', 'testUpdate')->first();
        $this->assertEquals('testUpdate', $user->name);
        $this->assertEquals('Имя', $user->firstname);
        $this->assertEquals('Фамилия', $user->lastname);
        $this->assertEquals('Отчество', $user->patronymic);
        $this->assertEquals($newCabinet->id, $user->cabinet_id);
        $this->assertEquals('admin', $user->getRoleNames()[0]);
        $this->assertDatabaseHas('users', ['name' => 'testUpdate', 'firstname' => 'Имя', 'lastname' => 'Фамилия', 'patronymic' => 'Отчество', 'cabinet_id' => $newCabinet->id]);
        $response->assertStatus(200);
    }

    public function test_controller_user_update_password_super_admin(): void
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
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.users.password'), $testUser->id),
            [
                'password' => 'password1',
            ], [
                'Accept' => 'application/json',
            ]);
        $user = User::where('id', $testUser->id)->first();
        $this->assertTrue(Hash::check('password1', $user->password));
        $response->assertStatus(200);
    }

    public function test_controller_user_destroy_super_admin(): void
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
        $response = $this->actingAs($this->superAdmin, 'web')->deleteJson(route(config('constants.users.destroy'), $testUser->id));
        $response->assertStatus(200);
        $this->assertDatabaseMissing('users', ['id' => $testUser->id]);
    }

    public function test_controller_user_store_validation_error_required_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.users.store')));
        $response->assertJsonValidationErrors(['name', 'firstname', 'lastname', 'cabinet_id', 'role']);
        $response->assertStatus(422);
    }

    public function test_controller_user_store_validation_error_exists_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.users.store')),
            [
                'name' => 'testStore',
                'password' => 'password',
                'firstname' => 'Имя',
                'lastname' => 'Фамилия',
                'patronymic' => 'Отчество',
                'cabinet_id' => 0,
                'role' => 'test',

            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['cabinet_id', 'role']);
        $response->assertStatus(422);
    }

    public function test_controller_user_store_validation_error_min_super_admin(): void
    {
        $cabinet = Cabinet::factory()->create();
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.users.store')),
            [
                'name' => 'testStore',
                'password' => 'pas',
                'firstname' => 'Имя',
                'lastname' => 'Фамилия',
                'patronymic' => 'Отчество',
                'cabinet_id' => (string) $cabinet->id,
                'role' => 'user',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['password']);
        $response->assertStatus(422);
    }

    public function test_controller_user_store_validation_error_max_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.users.store')),
            [
                'name' => fake()->text(1000),
                'password' => fake()->text(1000),
                'firstname' => fake()->text(1000),
                'lastname' => fake()->text(1000),
                'patronymic' => fake()->text(1000),
                'cabinet_id' => (string) 1000,
                'role' => 'user',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['name', 'password', 'firstname', 'lastname', 'patronymic', 'cabinet_id']);
        $response->assertStatus(422);
    }

    public function test_controller_user_store_password_error_super_admin(): void
    {
        $cabinet = Cabinet::factory()->create();
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.users.store')),
            [
                'name' => 'testStore',
                'firstname' => 'Имя',
                'lastname' => 'Фамилия',
                'patronymic' => 'Отчество',
                'cabinet_id' => (string) $cabinet->id,
                'role' => 'user',

            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(422);
    }

    public function test_controller_user_update_password_error_super_admin(): void
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
        $response = $this->actingAs($testUser, 'web')->patchJson(route(config('constants.users.password'), $testUser->id),
            [
                'password' => 'password1',
            ], [
                'Accept' => 'application/json',
            ]);
        $this->assertFalse(Hash::check('password1', $testUser->password));
        $response->assertStatus(422);
    }

    public function test_controller_user_update_error_help_check_super_admin(): void
    {
        $cabinet = Cabinet::factory()->create();
        $category = Category::factory()->create([
            'description' => 'Новая',
        ]);
        $status = Status::factory()->create();
        $response = $this->actingAs($this->superAdmin, 'web')->putJson(route(config('constants.users.update'), $this->superAdmin->id),
            [
                'name' => 'testUpdate',
                'firstname' => 'Имя',
                'lastname' => 'Фамилия',
                'patronymic' => 'Отчество',
                'cabinet_id' => (string) $cabinet->id,
                'category_id' => $category->id,
                'status_id' => $status->id,
                'role' => 'admin',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(422);
    }

    public function test_controller_user_destroy_error_help_check_super_admin(): void
    {
        $cabinet = Cabinet::factory()->create();
        $priority = Priority::factory()->create();
        $status = Status::factory()->create();
        $category = Category::factory()->create([
            'description' => 'Новая',
        ]);
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
        Help::factory()->create([
            'user_id' => $testUser->id,
            'executor_id' => $testUser->id,
            'status_id' => $status->id,
            'category_id' => $category->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->deleteJson(route(config('constants.users.destroy'), $testUser->id));
        $response->assertStatus(422);
    }

    public function test_controller_user_destroy_error_self_last_check_super_admin(): void
    {
        $cabinet = Cabinet::factory()->create();
        User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => fake()->unique()->name(),
            'lastname' => fake()->unique()->name(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => $cabinet->id,
        ])->assignRole('superAdmin');
        Auth::login($this->superAdmin);
        $response = $this->actingAs($this->superAdmin, 'web')->deleteJson(route(config('constants.users.destroy'), $this->superAdmin->id));
        $response->assertStatus(422);
    }

    public function test_controller_user_store_error_admin(): void
    {
        $response = $this->actingAs($this->admin, 'web')->postJson(route(config('constants.users.store')));
        $response->assertStatus(403);
    }

    public function test_controller_user_store_error_manager(): void
    {
        $response = $this->actingAs($this->manager, 'web')->postJson(route(config('constants.users.store')));
        $response->assertStatus(403);
    }

    public function test_controller_user_store_error_user(): void
    {
        $response = $this->actingAs($this->user, 'web')->postJson(route(config('constants.users.store')));
        $response->assertStatus(403);
    }

    public function test_controller_user_update_error_admin(): void
    {
        $cabinet = Cabinet::factory()->create();
        $newCabinet = Cabinet::factory()->create();
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
        $response = $this->actingAs($this->admin, 'web')->putJson(route(config('constants.users.update'), $testUser->id),
            [
                'name' => 'testUpdate',
                'password' => 'password1',
                'firstname' => 'Имя',
                'lastname' => 'Фамилия',
                'patronymic' => 'Отчество',
                'cabinet_id' => (string) $newCabinet->id,
                'role' => 'admin',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }

    public function test_controller_user_update_error_manager(): void
    {
        $cabinet = Cabinet::factory()->create();
        $newCabinet = Cabinet::factory()->create();
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
        $response = $this->actingAs($this->manager, 'web')->putJson(route(config('constants.users.update'), $testUser->id),
            [
                'name' => 'testUpdate',
                'password' => 'password1',
                'firstname' => 'Имя',
                'lastname' => 'Фамилия',
                'patronymic' => 'Отчество',
                'cabinet_id' => (string) $newCabinet->id,
                'role' => 'admin',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }

    public function test_controller_user_update_error_user(): void
    {
        $cabinet = Cabinet::factory()->create();
        $newCabinet = Cabinet::factory()->create();
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
        $response = $this->actingAs($this->user, 'web')->putJson(route(config('constants.users.update'), $testUser->id),
            [
                'name' => 'testUpdate',
                'password' => 'password1',
                'firstname' => 'Имя',
                'lastname' => 'Фамилия',
                'patronymic' => 'Отчество',
                'cabinet_id' => (string) $newCabinet->id,
                'role' => 'admin',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }

    public function test_controller_user_update_password_error_admin(): void
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
        $response = $this->actingAs($this->admin, 'web')->patchJson(route(config('constants.users.password'), $testUser->id),
            [
                'password' => 'password1',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }

    public function test_controller_user_update_password_error_manager(): void
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
        $response = $this->actingAs($this->manager, 'web')->patchJson(route(config('constants.users.password'), $testUser->id),
            [
                'password' => 'password1',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }

    public function test_controller_user_update_password_error_user(): void
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
        $response = $this->actingAs($this->user, 'web')->patchJson(route(config('constants.users.password'), $testUser->id),
            [
                'password' => 'password1',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }

    public function test_controller_user_destroy_error_admin(): void
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
        $response = $this->actingAs($this->admin, 'web')->deleteJson(route(config('constants.users.destroy'), $testUser->id));
        $response->assertStatus(403);
    }

    public function test_controller_user_destroy_error_manager(): void
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
        $response = $this->actingAs($this->manager, 'web')->deleteJson(route(config('constants.users.destroy'), $testUser->id));
        $response->assertStatus(403);
    }

    public function test_controller_user_destroy_error_user(): void
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
        $response = $this->actingAs($this->user, 'web')->deleteJson(route(config('constants.users.destroy'), $testUser->id));
        $response->assertStatus(403);
    }
}
