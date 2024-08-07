<?php

namespace Tests\Feature\Controllers;

use App\Models\Category;
use App\Models\User;
use Database\Seeders\CabinetTableSeeder;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
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

    public function test_controller_category_index_super_admin(): void
    {
        Category::factory()->count(config('settings.pages'))->create();
        $this->assertDatabaseCount('category', config('settings.pages'));
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.category.index')));
        $response->assertStatus(200);
    }

    public function test_controller_category_create_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.category.create')));
        $response->assertStatus(200);
    }

    public function test_controller_category_edit_super_admin(): void
    {
        $category = Category::factory()->create();
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.category.edit'), $category->id));
        $response->assertStatus(200);
    }

    public function test_controller_category_index_error_admin(): void
    {
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.category.index')));
        $response->assertStatus(403);
    }

    public function test_controller_category_index_error_manager(): void
    {
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.category.index')));
        $response->assertStatus(403);
    }

    public function test_controller_category_index_error_user(): void
    {
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.category.index')));
        $response->assertStatus(403);
    }

    public function test_controller_category_create_error_admin(): void
    {
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.category.create')));
        $response->assertStatus(403);
    }

    public function test_controller_category_create_error_manager(): void
    {
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.category.create')));
        $response->assertStatus(403);
    }

    public function test_controller_category_create_error_user(): void
    {
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.category.create')));
        $response->assertStatus(403);
    }

    public function test_controller_category_edit_error_admin(): void
    {
        $category = Category::factory()->create();
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.category.edit'), $category->id));
        $response->assertStatus(403);
    }

    public function test_controller_category_edit_error_manager(): void
    {
        $category = Category::factory()->create();
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.category.edit'), $category->id));
        $response->assertStatus(403);
    }

    public function test_controller_category_edit_error_user(): void
    {
        $category = Category::factory()->create();
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.category.edit'), $category->id));
        $response->assertStatus(403);
    }
}
