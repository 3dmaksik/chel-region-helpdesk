<?php

namespace Tests\Feature\Controllers;

use App\Models\Status;
use App\Models\User;
use Database\Seeders\CabinetTableSeeder;
use Database\Seeders\RolesTableSeeder;
use Database\Seeders\StatusesTableSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatusTest extends TestCase
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
        $this->seed(CabinetTableSeeder::class);
        $this->seed(StatusesTableSeeder::class);

        $this->superAdmin = User::factory()->create()->assignRole('superAdmin');
        $this->admin = User::factory()->create()->assignRole('admin');
        $this->manager = User::factory()->create()->assignRole('manager');
        $this->user = User::factory()->create()->assignRole('user');
    }

    public function test_controller_status_index_super_admin(): void
    {
        $this->assertDatabaseCount('status', 4);
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.status.index')));
        $response->assertStatus(200);
    }

    public function test_controller_status_edit_super_admin(): void
    {
        $status = Status::first();
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.status.edit'), $status->id));
        $response->assertStatus(200);
    }

    public function test_controller_status_index_error_admin(): void
    {
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.status.index')));
        $response->assertStatus(403);
    }

    public function test_controller_status_index_error_manager(): void
    {
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.status.index')));
        $response->assertStatus(403);
    }

    public function test_controller_status_index_error_user(): void
    {
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.status.index')));
        $response->assertStatus(403);
    }

    public function test_controller_status_edit_error_admin(): void
    {
        $status = Status::first();
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.status.edit'), $status->id));
        $response->assertStatus(403);
    }

    public function test_controller_status_edit_error_manager(): void
    {
        $status = Status::first();
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.status.edit'), $status->id));
        $response->assertStatus(403);
    }

    public function test_controller_status_edit_error_user(): void
    {
        $status = Status::first();
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.status.edit'), $status->id));
        $response->assertStatus(403);
    }
}
