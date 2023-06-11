<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Category;
use App\Models\Help;
use App\Models\User;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CategoryTest extends TestCase
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

        $this->superAdmin = User::factory()->create()->assignRole('superAdmin');
        $this->admin = User::factory()->create()->assignRole('admin');
        $this->manager = User::factory()->create()->assignRole('manager');
        $this->user = User::factory()->create()->assignRole('user');
    }

    public function test_controller_category_store_validation_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.category.store')),
            [
                'description' => 'Общая',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(200);
    }

    public function test_controller_category_store_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.category.store')),
            [
                'description' => 'Общая',
            ], [
                'Accept' => 'application/json',
            ]);
        $category = Category::first();
        $this->assertEquals('Общая', $category->description);
        $this->assertDatabaseHas('category', ['description' => 'Общая']);
    }

    public function test_controller_category_update_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.category.update'), $category->id),
            [
                'description' => 'Новая',
            ], [
                'Accept' => 'application/json',
            ]);
        $category = Category::first();
        $this->assertEquals('Новая', $category->description);
        $this->assertDatabaseHas('category', ['description' => 'Новая']);
    }

    public function test_controller_category_destroy_super_admin(): void
    {
        Category::factory()->count(5)->create();
        $category = Category::orderBy('id', 'DESC')->first();
        $response = $this->actingAs($this->superAdmin, 'web')->deleteJson(route(config('constants.category.destroy'), $category->id));
        $response->assertStatus(200);
        $this->assertDatabaseMissing('category', ['id' => $category->id]);
    }

    public function test_controller_category_store_validation_error_required_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.category.store')));
        $response->assertJsonValidationErrors(['description']);
    }

    public function test_controller_category_store_validation_error_max_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.category.store')),
            [
                'description' => fake()->text(1000),
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['description']);
    }

    public function test_controller_category_store_validation_error_unique_super_admin(): void
    {
        Category::factory()->create([
            'description' => 'Общая',
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.category.store')),
            [
                'description' => 'Общая',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['description']);
    }

    public function test_controller_category_destroy_error_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Новая',
        ]);
        Help::factory()->create([
            'category_id' => $category->id,
            'user_id' => fake()->unique()->numberBetween(1, 999),
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->deleteJson(route(config('constants.category.destroy'), $category->id));
        $response->assertStatus(422);
    }

    public function test_controller_category_store_error_admin(): void
    {
        $response = $this->actingAs($this->admin, 'web')->postJson(route(config('constants.category.store')));
        $response->assertStatus(403);
    }

    public function test_controller_category_store_error_manager(): void
    {
        $response = $this->actingAs($this->manager, 'web')->postJson(route(config('constants.category.store')));
        $response->assertStatus(403);
    }

    public function test_controller_category_store_error_user(): void
    {
        $response = $this->actingAs($this->user, 'web')->postJson(route(config('constants.category.store')));
        $response->assertStatus(403);
    }

    public function test_controller_category_update_error_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $response = $this->actingAs($this->admin, 'web')->patchJson(route(config('constants.category.update'), $category->id),
            [
                'description' => 2,
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }

    public function test_controller_category_update_error_manager(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $response = $this->actingAs($this->manager, 'web')->patchJson(route(config('constants.category.update'), $category->id),
            [
                'description' => 'Новая',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }

    public function test_controller_category_update_error_user(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $response = $this->actingAs($this->user, 'web')->patchJson(route(config('constants.category.update'), $category->id),
            [
                'description' => 'Новая',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }

    public function test_controller_category_destroy_error_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $response = $this->actingAs($this->admin, 'web')->deleteJson(route(config('constants.category.destroy'), $category->id));
        $response->assertStatus(403);
    }

    public function test_controller_category_destroy_error_manager(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $response = $this->actingAs($this->manager, 'web')->deleteJson(route(config('constants.category.destroy'), $category->id));
        $response->assertStatus(403);
    }

    public function test_controller_category_destroy_error_user(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $response = $this->actingAs($this->user, 'web')->deleteJson(route(config('constants.category.destroy'), $category->id));
        $response->assertStatus(403);
    }
}
