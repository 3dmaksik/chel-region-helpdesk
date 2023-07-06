<?php

namespace Tests\Feature\Controllers;

use App\Models\Priority;
use App\Models\User;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PriorityTest extends TestCase
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

        $this->superAdmin = User::factory()->create()->assignRole('superAdmin');
        $this->admin = User::factory()->create()->assignRole('admin');
        $this->manager = User::factory()->create()->assignRole('manager');
        $this->user = User::factory()->create()->assignRole('user');
    }

    public function test_controller_priority_index_super_admin(): void
    {
        Priority::factory()->create();
        $this->assertDatabaseCount('priority', 1);
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.priority.index')));
        $response->assertStatus(200);
    }

    public function test_controller_priority_create_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.priority.create')));
        $response->assertStatus(200);
    }

    public function test_controller_priority_show_super_admin(): void
    {
        $priority = Priority::factory()->create();
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.priority.show'), $priority->id));
        $response->assertStatus(200);
    }

    public function test_controller_priority_edit_super_admin(): void
    {
        $priority = Priority::factory()->create();
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.priority.edit'), $priority->id));
        $response->assertStatus(200);
    }

    public function test_controller_priority_index_error_admin(): void
    {
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.priority.index')));
        $response->assertStatus(403);
    }

    public function test_controller_priority_index_error_manager(): void
    {
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.priority.index')));
        $response->assertStatus(403);
    }

    public function test_controller_priority_index_error_user(): void
    {
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.priority.index')));
        $response->assertStatus(403);
    }

    public function test_controller_priority_create_error_admin(): void
    {
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.priority.create')));
        $response->assertStatus(403);
    }

    public function test_controller_priority_create_error_manager(): void
    {
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.priority.create')));
        $response->assertStatus(403);
    }

    public function test_controller_priority_create_error_user(): void
    {
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.priority.create')));
        $response->assertStatus(403);
    }

    public function test_controller_priority_edit_error_admin(): void
    {
        $priority = Priority::factory()->create();
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.priority.edit'), $priority->id));
        $response->assertStatus(403);
    }

    public function test_controller_priority_edit_error_manager(): void
    {
        $priority = Priority::factory()->create();
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.priority.edit'), $priority->id));
        $response->assertStatus(403);
    }

    public function test_controller_priority_edit_error_user(): void
    {
        $priority = Priority::factory()->create();
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.priority.edit'), $priority->id));
        $response->assertStatus(403);
    }

    public function test_controller_priority_show_error_admin(): void
    {
        $priority = Priority::factory()->create();
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.priority.show'), $priority->id));
        $response->assertStatus(403);
    }

    public function test_controller_priority_show_error_manager(): void
    {
        $priority = Priority::factory()->create();
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.priority.show'), $priority->id));
        $response->assertStatus(403);
    }

    public function test_controller_priority_show_error_user(): void
    {
        $priority = Priority::factory()->create();
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.priority.show'), $priority->id));
        $response->assertStatus(403);
    }
}
