<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Help;
use App\Models\Priority;
use App\Models\User;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PriorityTest extends TestCase
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

    public function test_controller_priority_store_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.priority.store')),
            [
                'description' => 'Средний',
                'rang' => 1,
                'warning_timer' => 1,
                'danger_timer' => 2,

            ], [
                'Accept' => 'application/json',
            ]);
        $priority = Priority::first();
        $this->assertEquals('Средний', $priority->description);
        $this->assertEquals(1, $priority->rang);
        $this->assertEquals(1, $priority->warning_timer);
        $this->assertEquals(2, $priority->danger_timer);
        $this->assertDatabaseHas('priority', ['description' => 'Средний', 'rang' => 1, 'warning_timer' => 1, 'danger_timer' => 2]);
        $response->assertStatus(200);
    }

    public function test_controller_piority_update_super_admin(): void
    {
        $oldPriority = Priority::factory()->create([
            'description' => 'Средний',
            'rang' => 1,
            'warning_timer' => 1,
            'danger_timer' => 2,
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.priority.update'), $oldPriority->id),
            [
                'description' => 'Новый',
                'rang' => 2,
                'warning_timer' => 2,
                'danger_timer' => 4,
            ], [
                'Accept' => 'application/json',
            ]);
        $priority = Priority::first();
        $this->assertEquals('Новый', $priority->description);
        $this->assertEquals(2, $priority->rang);
        $this->assertEquals(2, $priority->warning_timer);
        $this->assertEquals(4, $priority->danger_timer);
        $this->assertDatabaseHas('priority', ['description' => 'Новый', 'rang' => 2, 'warning_timer' => 2, 'danger_timer' => 4]);
        $response->assertStatus(200);
    }

    public function test_controller_priority_destroy_super_admin(): void
    {
        Priority::factory()->count(5)->create();
        $priority = Priority::orderBy('id', 'DESC')->first();
        $response = $this->actingAs($this->superAdmin, 'web')->deleteJson(route(config('constants.priority.destroy'), $priority->id));
        $response->assertStatus(200);
        $this->assertDatabaseMissing('priority', ['id' => $priority->id]);
    }

    public function test_controller_priority_store_validation_error_required_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.priority.store')));
        $response->assertJsonValidationErrors(['description', 'rang', 'warning_timer', 'danger_timer']);
        $response->assertStatus(422);
    }

    public function test_controller_priority_store_validation_error_integer_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.priority.store')),
            [
                'description' => 'Средний',
                'rang' => 'test',
                'warning_timer' => 'test',
                'danger_timer' => 'test',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['rang', 'warning_timer', 'danger_timer']);
        $response->assertStatus(422);
    }

    public function test_controller_priority_store_validation_error_min_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.priority.store')),
            [
                'description' => 'Средний',
                'rang' => 1,
                'warning_timer' => 0,
                'danger_timer' => 0,
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['warning_timer', 'danger_timer']);
        $response->assertStatus(422);
    }

    public function test_controller_priority_store_validation_error_max_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.priority.store')),
            [
                'description' => fake()->text(1000),
                'rang' => 1000,
                'warning_timer' => 4,
                'danger_timer' => 2,
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['description', 'rang', 'warning_timer']);
        $response->assertStatus(422);
    }

    public function test_controller_priority_store_validation_error_unique_super_admin(): void
    {
        Priority::factory()->create([
            'description' => 'Средний',
            'rang' => 1,
            'warning_timer' => 1,
            'danger_timer' => 2,
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.priority.store')),
            [
                'description' => 'Средний',
                'rang' => 1,
                'warning_timer' => 2,
                'danger_timer' => 4,
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['description', 'rang']);
        $response->assertStatus(422);
    }

    public function test_controller_priority_destroy_error_help_check_super_admin(): void
    {
        $priority = Priority::factory()->create([
            'description' => 'Средний',
            'rang' => 1,
            'warning_timer' => 1,
            'danger_timer' => 2,
        ]);
        Help::factory()->create([
            'category_id' => 1,
            'priority_id' => $priority->id,
            'user_id' => fake()->unique()->numberBetween(1, 999),
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->deleteJson(route(config('constants.priority.destroy'), $priority->id));
        $response->assertStatus(422);
    }

    public function test_controller_priority_store_error_admin(): void
    {
        $response = $this->actingAs($this->admin, 'web')->postJson(route(config('constants.priority.store')));
        $response->assertStatus(403);
    }

    public function test_controller_priority_store_error_manager(): void
    {
        $response = $this->actingAs($this->manager, 'web')->postJson(route(config('constants.priority.store')));
        $response->assertStatus(403);
    }

    public function test_controller_priority_store_error_user(): void
    {
        $response = $this->actingAs($this->user, 'web')->postJson(route(config('constants.priority.store')));
        $response->assertStatus(403);
    }

    public function test_controller_piority_update_error_admin(): void
    {
        $oldPriority = Priority::factory()->create([
            'description' => 'Средний',
            'rang' => 1,
            'warning_timer' => 1,
            'danger_timer' => 2,
        ]);
        $response = $this->actingAs($this->admin, 'web')->patchJson(route(config('constants.priority.update'), $oldPriority->id),
            [
                'description' => 'Новый',
                'rang' => 2,
                'warning_timer' => 2,
                'danger_timer' => 4,
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }

    public function test_controller_piority_update_error_manager(): void
    {
        $oldPriority = Priority::factory()->create([
            'description' => 'Средний',
            'rang' => 1,
            'warning_timer' => 1,
            'danger_timer' => 2,
        ]);
        $response = $this->actingAs($this->manager, 'web')->patchJson(route(config('constants.priority.update'), $oldPriority->id),
            [
                'description' => 'Новый',
                'rang' => 2,
                'warning_timer' => 2,
                'danger_timer' => 4,
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }

    public function test_controller_piority_update_error_user(): void
    {
        $oldPriority = Priority::factory()->create([
            'description' => 'Средний',
            'rang' => 1,
            'warning_timer' => 1,
            'danger_timer' => 2,
        ]);
        $response = $this->actingAs($this->user, 'web')->patchJson(route(config('constants.priority.update'), $oldPriority->id),
            [
                'description' => 'Новый',
                'rang' => 2,
                'warning_timer' => 2,
                'danger_timer' => 4,
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }

    public function test_controller_priority_destroy_error_admin(): void
    {
        Priority::factory()->count(5)->create();
        $priority = Priority::orderBy('id', 'DESC')->first();
        $response = $this->actingAs($this->admin, 'web')->deleteJson(route(config('constants.priority.destroy'), $priority->id));
        $response->assertStatus(403);
    }

    public function test_controller_priority_destroy_error_manager(): void
    {
        Priority::factory()->count(5)->create();
        $priority = Priority::orderBy('id', 'DESC')->first();
        $response = $this->actingAs($this->manager, 'web')->deleteJson(route(config('constants.priority.destroy'), $priority->id));
        $response->assertStatus(403);
    }

    public function test_controller_priority_destroy_error_user(): void
    {
        Priority::factory()->count(5)->create();
        $priority = Priority::orderBy('id', 'DESC')->first();
        $response = $this->actingAs($this->user, 'web')->deleteJson(route(config('constants.priority.destroy'), $priority->id));
        $response->assertStatus(403);
    }
}
