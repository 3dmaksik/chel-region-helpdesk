<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Cabinet;
use App\Models\User;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CabinetTest extends TestCase
{
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

    public function test_controller_cabinet_store_validation_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.cabinet.store')),
            [
                'description' => 1,
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(200);
    }

    public function test_controller_cabinet_store_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.cabinet.store')),
            [
                'description' => 1,
            ], [
                'Accept' => 'application/json',
            ]);
        $cabinet = Cabinet::first();
        $this->assertEquals(1, $cabinet->description);
        $this->assertDatabaseHas('cabinet', ['description' => 1]);
    }

    public function test_controller_cabinet_update_super_admin(): void
    {
        $cabinet = Cabinet::factory()->create([
            'description' => 1,
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.cabinet.update'), $cabinet->id),
            [
                'description' => 2,
            ], [
                'Accept' => 'application/json',
            ]);
        $cabinet = Cabinet::first();
        $this->assertEquals(2, $cabinet->description);
        $this->assertDatabaseHas('cabinet', ['description' => 2]);
    }

    public function test_controller_cabinet_destroy_super_admin(): void
    {
        Cabinet::factory()->count(5)->create();
        $cabinet = Cabinet::orderBy('id', 'DESC')->first();
        $response = $this->actingAs($this->superAdmin, 'web')->deleteJson(route(config('constants.cabinet.destroy'), $cabinet->id));
        $response->assertStatus(200);
        $this->assertDatabaseMissing('cabinet', ['description' => 1]);
    }

    public function test_controller_cabinet_store_validation_error_required_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.cabinet.store')));
        $response->assertJsonValidationErrors(['description']);
    }

    public function test_controller_cabinet_store_validation_error_integer_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.cabinet.store')),
            [
                'description' => 'test',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['description']);
    }

    public function test_controller_cabinet_store_validation_error_max_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.cabinet.store')),
            [
                'description' => 251,
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['description']);
    }

    public function test_controller_cabinet_store_validation_error_unique_super_admin(): void
    {
        Cabinet::factory()->create([
            'description' => 1,
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.cabinet.store')),
            [
                'description' => 1,
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['description']);
    }

    public function test_controller_cabinet_destroy_error_super_admin(): void
    {
        $cabinet = Cabinet::factory()->create([
            'description' => 2,
        ]);
        User::factory()->create([
            'cabinet_id' => 2,
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->deleteJson(route(config('constants.cabinet.destroy'), $cabinet->id));
        $response->assertStatus(422);
    }

    public function test_controller_cabinet_store_error_admin(): void
    {
        $response = $this->actingAs($this->admin, 'web')->postJson(route(config('constants.cabinet.store')));
        $response->assertStatus(403);
    }

    public function test_controller_cabinet_store_error_manager(): void
    {
        $response = $this->actingAs($this->manager, 'web')->postJson(route(config('constants.cabinet.store')));
        $response->assertStatus(403);
    }

    public function test_controller_cabinet_store_error_user(): void
    {
        $response = $this->actingAs($this->user, 'web')->postJson(route(config('constants.cabinet.store')));
        $response->assertStatus(403);
    }

    public function test_controller_cabinet_update_error_admin(): void
    {
        $cabinet = Cabinet::factory()->create([
            'description' => 1,
        ]);
        $response = $this->actingAs($this->admin, 'web')->patchJson(route(config('constants.cabinet.update'), $cabinet->id),
            [
                'description' => 2,
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }

    public function test_controller_cabinet_update_error_manager(): void
    {
        $cabinet = Cabinet::factory()->create([
            'description' => 1,
        ]);
        $response = $this->actingAs($this->manager, 'web')->patchJson(route(config('constants.cabinet.update'), $cabinet->id),
            [
                'description' => 2,
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }

    public function test_controller_cabinet_update_error_user(): void
    {
        $cabinet = Cabinet::factory()->create([
            'description' => 1,
        ]);
        $response = $this->actingAs($this->user, 'web')->patchJson(route(config('constants.cabinet.update'), $cabinet->id),
            [
                'description' => 2,
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }

    public function test_controller_cabinet_destroy_error_admin(): void
    {
        $cabinet = Cabinet::factory()->create([
            'description' => 1,
        ]);
        $response = $this->actingAs($this->admin, 'web')->deleteJson(route(config('constants.cabinet.destroy'), $cabinet->id));
        $response->assertStatus(403);
    }

    public function test_controller_cabinet_destroy_error_manager(): void
    {
        $cabinet = Cabinet::factory()->create([
            'description' => 1,
        ]);
        $response = $this->actingAs($this->manager, 'web')->deleteJson(route(config('constants.cabinet.destroy'), $cabinet->id));
        $response->assertStatus(403);
    }

    public function test_controller_cabinet_destroy_error_user(): void
    {
        $cabinet = Cabinet::factory()->create([
            'description' => 1,
        ]);
        $response = $this->actingAs($this->user, 'web')->deleteJson(route(config('constants.cabinet.destroy'), $cabinet->id));
        $response->assertStatus(403);
    }
}
