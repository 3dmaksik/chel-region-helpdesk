<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Status;
use App\Models\User;
use Database\Seeders\RolesTableSeeder;
use Database\Seeders\StatusesTableSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StatusTest extends TestCase
{
    use DatabaseTransactions;

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
        $this->seed(StatusesTableSeeder::class);

        $this->superAdmin = User::factory()->create()->assignRole('superAdmin');
        $this->admin = User::factory()->create()->assignRole('admin');
        $this->manager = User::factory()->create()->assignRole('manager');
        $this->user = User::factory()->create()->assignRole('user');
    }

    public function test_controller_status_update_super_admin(): void
    {
        $oldStatus = Status::first();
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.status.update'), $oldStatus->id),
            [
                'description' => 'Новейшая',
                'color' => 'light',
            ], [
                'Accept' => 'application/json',
            ]);
        $status = Status::first();
        $this->assertEquals('Новейшая', $status->description);
        $this->assertEquals('light', $status->color);
        $this->assertDatabaseHas('status', ['description' => 'Новейшая', 'color' => 'light']);
        $response->assertStatus(200);
    }

    public function test_controller_status_update_validation_error_required_super_admin(): void
    {
        $status = Status::first();
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.status.update'), $status->id),
            [
                'description' => '',
                'color' => '',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['description', 'color']);
        $response->assertStatus(422);
    }

    public function test_controller_status_update_validation_error_unique_super_admin(): void
    {
        $status = Status::first();
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.status.update'), $status->id),
            [
                'description' => 'Выполнена',
                'color' => 'danger',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['description', 'color']);
        $response->assertStatus(422);
    }

    public function test_controller_status_update_validation_error_color_super_admin(): void
    {
        $status = Status::first();
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.status.update'), $status->id),
            [
                'description' => 'Новейшая',
                'color' => 'test',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(422);
    }

    public function test_controller_status_update_error_admin(): void
    {
        $status = Status::first();
        $response = $this->actingAs($this->admin, 'web')->patchJson(route(config('constants.status.update'), $status->id),
            [
                'description' => 'Новейшая',
                'color' => 'light',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }

    public function test_controller_status_update_error_manager(): void
    {
        $status = Status::first();
        $response = $this->actingAs($this->manager, 'web')->patchJson(route(config('constants.status.update'), $status->id),
            [
                'description' => 'Новейшая',
                'color' => 'light',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }

    public function test_controller_status_update_error_user(): void
    {
        $status = Status::first();
        $response = $this->actingAs($this->user, 'web')->patchJson(route(config('constants.status.update'), $status->id),
            [
                'description' => 'Новейшая',
                'color' => 'light',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }
}
