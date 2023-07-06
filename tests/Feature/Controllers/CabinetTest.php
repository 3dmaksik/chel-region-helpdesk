<?php

namespace Tests\Feature\Controllers;

use App\Models\Cabinet;
use App\Models\User;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CabinetTest extends TestCase
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

    public function test_controller_cabinet_index_super_admin(): void
    {
        Cabinet::factory()->count(config('settings.pages'))->create();
        $this->assertDatabaseCount('cabinet', config('settings.pages'));
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.cabinet.index')));
        $response->assertStatus(200);
    }

    public function test_controller_cabinet_create_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.cabinet.create')));
        $response->assertStatus(200);
    }

    public function test_controller_cabinet_edit_super_admin(): void
    {
        $cabinet = Cabinet::factory()->create();
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.cabinet.edit'), $cabinet->id));
        $response->assertStatus(200);
    }

    public function test_controller_cabinet_index_error_admin(): void
    {
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.cabinet.index')));
        $response->assertStatus(403);
    }

    public function test_controller_cabinet_index_error_manager(): void
    {
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.cabinet.index')));
        $response->assertStatus(403);
    }

    public function test_controller_cabinet_index_error_user(): void
    {
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.cabinet.index')));
        $response->assertStatus(403);
    }

    public function test_controller_cabinet_create_error_admin(): void
    {
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.cabinet.create')));
        $response->assertStatus(403);
    }

    public function test_controller_cabinet_create_error_manager(): void
    {
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.cabinet.create')));
        $response->assertStatus(403);
    }

    public function test_controller_cabinet_create_error_user(): void
    {
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.cabinet.create')));
        $response->assertStatus(403);
    }

    public function test_controller_cabinet_edit_error_admin(): void
    {
        $cabinet = Cabinet::factory()->create();
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.cabinet.edit'), $cabinet->id));
        $response->assertStatus(403);
    }

    public function test_controller_cabinet_edit_error_manager(): void
    {
        $cabinet = Cabinet::factory()->create();
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.cabinet.edit'), $cabinet->id));
        $response->assertStatus(403);
    }

    public function test_controller_cabinet_edit_error_user(): void
    {
        $cabinet = Cabinet::factory()->create();
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.cabinet.edit'), $cabinet->id));
        $response->assertStatus(403);
    }
}
