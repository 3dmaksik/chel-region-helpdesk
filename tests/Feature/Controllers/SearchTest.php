<?php

namespace Tests\Feature\Controllers;

use App\Models\Cabinet;
use App\Models\Category;
use App\Models\Help;
use App\Models\Priority;
use App\Models\Status;
use App\Models\User;
use Database\Seeders\RolesTableSeeder;
use Database\Seeders\StatusesTableSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
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
        $this->seed(StatusesTableSeeder::class);
    }

    public function test_controller_search_work_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Средний',
            'rang' => 1,
            'warning_timer' => 1,
            'danger_timer' => 2,
        ]);
        Cabinet::factory()->create([
            'description' => '1',
        ]);
        $user = User::factory()->create()->assignRole('superAdmin');
        $status = Status::first();
        Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $status->id,
            'user_id' => $user->id,
            'executor_id' => $user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($user, 'web')->get(route(config('constants.search.work'), $user->id));
        $response->assertStatus(200);
    }

    public function test_controller_search_category_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Средний',
            'rang' => 1,
            'warning_timer' => 1,
            'danger_timer' => 2,
        ]);
        Cabinet::factory()->create([
            'description' => '1',
        ]);
        $user = User::factory()->create()->assignRole('superAdmin');
        $status = Status::first();
        Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $status->id,
            'user_id' => $user->id,
            'executor_id' => $user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($user, 'web')->get(route(config('constants.search.category'), $category->id));
        $response->assertStatus(200);
    }

    public function test_controller_search_cabinet_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Средний',
            'rang' => 1,
            'warning_timer' => 1,
            'danger_timer' => 2,
        ]);
        $cabinet = Cabinet::factory()->create([
            'description' => '1',
        ]);
        $user = User::factory()->create()->assignRole('superAdmin');
        $status = Status::first();
        Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $status->id,
            'user_id' => $user->id,
            'executor_id' => $user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($user, 'web')->get(route(config('constants.search.cabinet'), $cabinet->id));
        $response->assertStatus(200);
    }

    public function test_controller_search_all_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Средний',
            'rang' => 1,
            'warning_timer' => 1,
            'danger_timer' => 2,
        ]);
        Cabinet::factory()->create([
            'description' => '1',
        ]);
        $user = User::factory()->create()->assignRole('superAdmin');
        $status = Status::first();
        Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $status->id,
            'user_id' => $user->id,
            'executor_id' => $user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($user, 'web')->get(route(config('constants.search.all')).'?search=1');
        $response->assertStatus(200);
    }
}
