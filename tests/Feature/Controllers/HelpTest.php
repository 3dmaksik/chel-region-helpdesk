<?php

namespace Tests\Feature\Controllers;

use App\Models\Category;
use App\Models\Help;
use App\Models\Priority;
use App\Models\Status;
use App\Models\User;
use Database\Seeders\CabinetTableSeeder;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HelpTest extends TestCase
{
    use DatabaseTransactions;
    //use RefreshDatabase;

    private User $superAdmin;

    private User $admin;

    private User $manager;

    private User $user;

    private Category $category;

    private Priority $priority;

    private Status $status;

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

    public function test_controller_help_index_super_admin(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);

        Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $this->assertDatabaseCount('help', 1);
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.help.index')));
        $response->assertStatus(200);
    }

    public function test_controller_help_load_index_super_admin(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);

        Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $this->assertDatabaseCount('help', 1);
        $response = $this->actingAs($this->superAdmin, 'web')->post(route(config('constants.help.index')));
        $response->assertStatus(200);
    }

    public function test_controller_help_new_super_admin(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);

        Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $this->assertDatabaseCount('help', 1);
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.help.new')));
        $response->assertStatus(200);
    }

    public function test_controller_help_load_new_super_admin(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);

        Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $this->assertDatabaseCount('help', 1);
        $response = $this->actingAs($this->superAdmin, 'web')->post(route(config('constants.help.new')));
        $response->assertStatus(200);
    }

    public function test_controller_help_worker_super_admin(): void
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
        $this->status = Status::factory()->create([
            'description' => 'В работе',
        ]);

        Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $this->assertDatabaseCount('help', 1);
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.help.worker')));
        $response->assertStatus(200);
    }

    public function test_controller_help_load_worker_super_admin(): void
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
        $this->status = Status::factory()->create([
            'description' => 'В работе',
        ]);

        Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $this->assertDatabaseCount('help', 1);
        $response = $this->actingAs($this->superAdmin, 'web')->post(route(config('constants.help.worker')));
        $response->assertStatus(200);
    }

    public function test_controller_help_completed_super_admin(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);

        Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $this->assertDatabaseCount('help', 1);
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.help.completed')));
        $response->assertStatus(200);
    }

    public function test_controller_help_load_completed_super_admin(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Выполнена',
        ]);

        Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $this->assertDatabaseCount('help', 1);
        $response = $this->actingAs($this->superAdmin, 'web')->post(route(config('constants.help.completed')));
        $response->assertStatus(200);
    }

    public function test_controller_help_dismiss_super_admin(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);

        Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $this->assertDatabaseCount('help', 1);
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.help.dismiss')));
        $response->assertStatus(200);
    }

    public function test_controller_help_load_dismiss_super_admin(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Отклонена',
        ]);

        Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $this->assertDatabaseCount('help', 1);
        $response = $this->actingAs($this->superAdmin, 'web')->post(route(config('constants.help.dismiss')));
        $response->assertStatus(200);
    }

    public function test_controller_help_create_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.help.create')));
        $response->assertStatus(200);
    }

    public function test_controller_help_show_super_admin(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);

        $help = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.help.show'), $help->id));
        $response->assertStatus(200);
    }

    public function test_controller_help_load_show_super_admin(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);

        $help = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->post(route(config('constants.help.show'), $help->id));
        $response->assertStatus(200);
    }

    public function test_controller_help_edit_super_admin(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);

        $help = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.help.edit'), $help->id));
        $response->assertStatus(200);
    }

    public function test_controller_help_new_admin(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);

        Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $this->assertDatabaseCount('help', 1);
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.help.new')));
        $response->assertStatus(200);
    }

    public function test_controller_help_load_new_admin(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);

        Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $this->assertDatabaseCount('help', 1);
        $response = $this->actingAs($this->admin, 'web')->post(route(config('constants.help.new')));
        $response->assertStatus(200);
    }

    public function test_controller_help_worker_admin(): void
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
        $this->status = Status::factory()->create([
            'description' => 'В работе',
        ]);

        Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $this->assertDatabaseCount('help', 1);
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.help.worker')));
        $response->assertStatus(200);
    }

    public function test_controller_help_load_worker_admin(): void
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
        $this->status = Status::factory()->create([
            'description' => 'В работе',
        ]);

        Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $this->assertDatabaseCount('help', 1);
        $response = $this->actingAs($this->admin, 'web')->post(route(config('constants.help.worker')));
        $response->assertStatus(200);
    }

    public function test_controller_help_completed_admin(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Выполнена',
        ]);

        Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $this->assertDatabaseCount('help', 1);
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.help.completed')));
        $response->assertStatus(200);
    }

    public function test_controller_help_load_completed_admin(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Выполнена',
        ]);

        Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $this->assertDatabaseCount('help', 1);
        $response = $this->actingAs($this->superAdmin, 'web')->post(route(config('constants.help.completed')));
        $response->assertStatus(200);
    }

    public function test_controller_help_dismiss_admin(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Отклонена',
        ]);

        Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $this->assertDatabaseCount('help', 1);
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.help.dismiss')));
        $response->assertStatus(200);
    }

    public function test_controller_help_load_dismiss_admin(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Отклонена',
        ]);

        Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $this->assertDatabaseCount('help', 1);
        $response = $this->actingAs($this->admin, 'web')->post(route(config('constants.help.dismiss')));
        $response->assertStatus(200);
    }

    public function test_controller_help_create_admin(): void
    {
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.help.create')));
        $response->assertStatus(200);
    }

    public function test_controller_help_show_admin(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);

        $help = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.help.show'), $help->id));
        $response->assertStatus(200);
    }

    public function test_controller_help_load_show_admin(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);

        $help = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->admin, 'web')->post(route(config('constants.help.show'), $help->id));
        $response->assertStatus(200);
    }

    public function test_controller_help_edit_admin(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);

        $help = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.help.edit'), $help->id));
        $response->assertStatus(200);
    }

    public function test_controller_help_worker_manager(): void
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
        $this->status = Status::factory()->create([
            'description' => 'В работе',
        ]);

        Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $this->assertDatabaseCount('help', 1);
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.help.worker')));
        $response->assertStatus(200);
    }

    public function test_controller_help_load_worker_manager(): void
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
        $this->status = Status::factory()->create([
            'description' => 'В работе',
        ]);

        Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $this->assertDatabaseCount('help', 1);
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.help.worker')));
        $response->assertStatus(200);
    }

    public function test_controller_help_completed_manager(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Выполнена',
        ]);

        Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $this->assertDatabaseCount('help', 1);
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.help.worker')));
        $response->assertStatus(200);
    }

    public function test_controller_help_load_completed_manager(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Выполнена',
        ]);

        Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $this->assertDatabaseCount('help', 1);
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.help.completed')));
        $response->assertStatus(200);
    }

    public function test_controller_help_show_manager(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);

        $help = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.help.show'), $help->id));
        $response->assertStatus(200);
    }

    public function test_controller_help_load_show_manager(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);

        $help = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->manager, 'web')->post(route(config('constants.help.show'), $help->id));
        $response->assertStatus(200);
    }

    public function test_controller_help_show_user(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);

        $help = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.help.show'), $help->id));
        $response->assertStatus(200);
    }

    public function test_controller_help_load_show_user(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);

        $help = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->user, 'web')->post(route(config('constants.help.show'), $help->id));
        $response->assertStatus(200);
    }

    public function test_controller_help_index_error_admin(): void
    {
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.help.index')));
        $response->assertStatus(403);
    }

    public function test_controller_help_load_index_error_admin(): void
    {
        $response = $this->actingAs($this->admin, 'web')->post(route(config('constants.help.index')));
        $response->assertStatus(403);
    }

    public function test_controller_help_index_error_manager(): void
    {
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.help.index')));
        $response->assertStatus(403);
    }

    public function test_controller_help_load_index_error_manager(): void
    {
        $response = $this->actingAs($this->manager, 'web')->post(route(config('constants.help.index')));
        $response->assertStatus(403);
    }

    public function test_controller_help_new_error_manager(): void
    {
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.help.new')));
        $response->assertStatus(403);
    }

    public function test_controller_help_load_new_error_manager(): void
    {
        $response = $this->actingAs($this->manager, 'web')->post(route(config('constants.help.new')));
        $response->assertStatus(403);
    }

    public function test_controller_help_dismiss_error_manager(): void
    {
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.help.dismiss')));
        $response->assertStatus(403);
    }

    public function test_controller_help_load_dismiss_error_manager(): void
    {
        $response = $this->actingAs($this->manager, 'web')->post(route(config('constants.help.dismiss')));
        $response->assertStatus(403);
    }

    public function test_controller_help_create_error_manager(): void
    {
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.help.create')));
        $response->assertStatus(403);
    }

    public function test_controller_help_edit_error_manager(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);

        $help = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.help.edit'), $help->id));
        $response->assertStatus(403);
    }

    public function test_controller_help_index_error_user(): void
    {
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.help.index')));
        $response->assertStatus(403);
    }

    public function test_controller_help_load_index_error_user(): void
    {
        $response = $this->actingAs($this->user, 'web')->post(route(config('constants.help.index')));
        $response->assertStatus(403);
    }

    public function test_controller_help_new_error_user(): void
    {
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.help.new')));
        $response->assertStatus(403);
    }

    public function test_controller_help_load_new_error_user(): void
    {
        $response = $this->actingAs($this->user, 'web')->post(route(config('constants.help.new')));
        $response->assertStatus(403);
    }

    public function test_controller_help_worker_error_user(): void
    {
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.help.worker')));
        $response->assertStatus(403);
    }

    public function test_controller_help_load_worker_error_user(): void
    {
        $response = $this->actingAs($this->user, 'web')->post(route(config('constants.help.worker')));
        $response->assertStatus(403);
    }

    public function test_controller_help_completed_error_user(): void
    {
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.help.completed')));
        $response->assertStatus(403);
    }

    public function test_controller_help_load_completed_error_user(): void
    {
        $response = $this->actingAs($this->user, 'web')->post(route(config('constants.help.completed')));
        $response->assertStatus(403);
    }

    public function test_controller_help_dismiss_error_user(): void
    {
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.help.dismiss')));
        $response->assertStatus(403);
    }

    public function test_controller_help_load_dismiss_error_user(): void
    {
        $response = $this->actingAs($this->user, 'web')->post(route(config('constants.help.dismiss')));
        $response->assertStatus(403);
    }

    public function test_controller_help_create_error_user(): void
    {
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.help.create')));
        $response->assertStatus(403);
    }

    public function test_controller_help_edit_error_user(): void
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
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);

        $help = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.help.edit'), $help->id));
        $response->assertStatus(403);
    }
}
