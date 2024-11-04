<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Category;
use App\Models\Help;
use App\Models\Priority;
use App\Models\Status;
use App\Models\User;
use Database\Seeders\CabinetTableSeeder;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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

    public function test_controller_help_store_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        Storage::fake('local');
        $image = UploadedFile::fake()->image('image.png', 100, 100)->size(100);
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.help.store')),
            [
                'category_id' => $category->id,
                'user_id' => $this->user->id,
                'description_long' => 'Текст',
                'images' => [$image],

            ], [
                'Accept' => 'application/json',
            ]);
        $help = Help::first();
        $this->assertEquals($category->id, $help->category_id);
        $this->assertEquals($this->user->id, $help->user_id);
        $this->assertEquals('Текст', $help->description_long);
        $this->assertDatabaseHas('help', ['category_id' => $category->id, 'user_id' => $this->user->id, 'description_long' => 'Текст']);
        $response->assertStatus(200);
    }

    public function test_controller_help_store_auth_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        Auth::login($this->superAdmin);
        Storage::fake('local');
        $image = UploadedFile::fake()->image('image.png', 100, 100)->size(100);
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.help.store')),
            [
                'category_id' => $category->id,
                'user_id' => auth()->user()->id,
                'description_long' => 'Текст',
                'images' => [$image],
            ], [
                'Accept' => 'application/json',
            ]);
        $help = Help::first();
        $this->assertEquals($category->id, $help->category_id);
        $this->assertEquals($this->superAdmin->id, auth()->user()->id);
        $this->assertEquals('Текст', $help->description_long);
        $this->assertDatabaseHas('help', ['category_id' => $category->id, 'user_id' => auth()->user()->id, 'description_long' => 'Текст']);
        $response->assertStatus(200);
    }

    public function test_controller_help_update_super_admin(): void
    {
        $oldCategory = Category::factory()->create([
            'description' => 'Старая',
        ]);
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $oldPriority = Priority::factory()->create([
            'description' => 'Средний',
            'rang' => 1,
            'warning_timer' => 1,
            'danger_timer' => 2,
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $oldCategory->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'priority_id' => $oldPriority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.help.update'), $oldHelp->id),
            [
                'category_id' => $category->id,
                'user_id' => $this->superAdmin->id,
                'priority_id' => $priority->id,

            ], [
                'Accept' => 'application/json',
            ]);
        $help = Help::first();
        $this->assertEquals($category->id, $help->category_id);
        $this->assertEquals($this->superAdmin->id, $help->user_id);
        $this->assertEquals($priority->id, $help->priority_id);
        $this->assertDatabaseHas('help', ['category_id' => $category->id, 'user_id' => $this->superAdmin->id, 'priority_id' => $priority->id]);
        $response->assertStatus(200);
    }

    public function test_controller_help_accept_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 1,
            'user_id' => $this->user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.help.accept'), $oldHelp->id),
            [
                'executor_id' => $this->manager->id,
                'priority_id' => $priority->id,
                'info' => 'В работу',

            ], [
                'Accept' => 'application/json',
            ]);
        $help = Help::first();
        $this->assertEquals($this->manager->id, $help->executor_id);
        $this->assertEquals($priority->id, $help->priority_id);
        $this->assertEquals('В работу', $help->info);
        $this->assertDatabaseHas('help', ['executor_id' => $this->manager->id, 'priority_id' => $priority->id, 'info' => 'В работу']);
        $response->assertStatus(200);
    }

    public function test_controller_help_execute_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 2,
            'user_id' => $this->user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        Storage::fake('local');
        $image = UploadedFile::fake()->image('image.png', 100, 100)->size(100);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.help.execute'), $oldHelp->id),
            [
                'info_final' => 'Готово',
                'images_final' => [$image],

            ], [
                'Accept' => 'application/json',
            ]);
        $help = Help::first();
        $this->assertEquals('Готово', $help->info_final);
        $this->assertDatabaseHas('help', ['info_final' => 'Готово']);
        $response->assertStatus(200);
    }

    public function test_controller_help_redefine_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => 1,
        ])->assignRole('manager');
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 2,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.help.redefine'), $oldHelp->id),
            [
                'executor_id' => $testUser->id,

            ], [
                'Accept' => 'application/json',
            ]);
        $help = Help::first();
        $this->assertEquals($testUser->id, $help->executor_id);
        $this->assertDatabaseHas('help', ['executor_id' => $testUser->id]);
        $response->assertStatus(200);
    }

    public function test_controller_help_reject_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 1,
            'user_id' => $this->user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.help.reject'), $oldHelp->id),
            [
                'info_final' => 'Отклонено',
            ], [
                'Accept' => 'application/json',
            ]);
        $help = Help::first();
        $this->assertEquals('Отклонено', $help->info_final);
        $this->assertDatabaseHas('help', ['info_final' => 'Отклонено']);
        $response->assertStatus(200);
    }

    public function test_controller_help_store_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        Storage::fake('local');
        $image = UploadedFile::fake()->image('image.png', 100, 100)->size(100);
        $response = $this->actingAs($this->admin, 'web')->postJson(route(config('constants.help.store')),
            [
                'category_id' => $category->id,
                'user_id' => $this->user->id,
                'description_long' => 'Текст',
                'images' => [$image],

            ], [
                'Accept' => 'application/json',
            ]);
        $help = Help::first();
        $this->assertEquals($category->id, $help->category_id);
        $this->assertEquals($this->user->id, $help->user_id);
        $this->assertEquals('Текст', $help->description_long);
        $this->assertDatabaseHas('help', ['category_id' => $category->id, 'user_id' => $this->user->id, 'description_long' => 'Текст']);
        $response->assertStatus(200);
    }

    public function test_controller_help_store_auth_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        Auth::login($this->admin);
        Storage::fake('local');
        $image = UploadedFile::fake()->image('image.png', 100, 100)->size(100);
        $response = $this->actingAs($this->admin, 'web')->postJson(route(config('constants.help.store')),
            [
                'category_id' => $category->id,
                'description_long' => 'Текст',
                'user_id' => auth()->user()->id,
                'images' => [$image],
            ], [
                'Accept' => 'application/json',
            ]);
        $help = Help::first();
        $this->assertEquals($category->id, $help->category_id);
        $this->assertEquals($this->admin->id, auth()->user()->id);
        $this->assertEquals('Текст', $help->description_long);
        $this->assertDatabaseHas('help', ['category_id' => $category->id, 'user_id' => auth()->user()->id, 'description_long' => 'Текст']);
        $response->assertStatus(200);
    }

    public function test_controller_help_update_admin(): void
    {
        $oldCategory = Category::factory()->create([
            'description' => 'Старая',
        ]);
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $oldPriority = Priority::factory()->create([
            'description' => 'Средний',
            'rang' => 1,
            'warning_timer' => 1,
            'danger_timer' => 2,
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $oldCategory->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'priority_id' => $oldPriority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->admin, 'web')->patchJson(route(config('constants.help.update'), $oldHelp->id),
            [
                'category_id' => $category->id,
                'user_id' => $this->admin->id,
                'priority_id' => $priority->id,

            ], [
                'Accept' => 'application/json',
            ]);
        $help = Help::first();
        $this->assertEquals($category->id, $help->category_id);
        $this->assertEquals($this->admin->id, $help->user_id);
        $this->assertEquals($priority->id, $help->priority_id);
        $this->assertDatabaseHas('help', ['category_id' => $category->id, 'user_id' => $this->admin->id, 'priority_id' => $priority->id]);
        $response->assertStatus(200);
    }

    public function test_controller_help_accept_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 1,
            'user_id' => $this->user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->admin, 'web')->patchJson(route(config('constants.help.accept'), $oldHelp->id),
            [
                'executor_id' => $this->manager->id,
                'priority_id' => $priority->id,
                'info' => 'В работу',

            ], [
                'Accept' => 'application/json',
            ]);
        $help = Help::first();
        $this->assertEquals($this->manager->id, $help->executor_id);
        $this->assertEquals($priority->id, $help->priority_id);
        $this->assertEquals('В работу', $help->info);
        $this->assertDatabaseHas('help', ['executor_id' => $this->manager->id, 'priority_id' => $priority->id, 'info' => 'В работу']);
        $response->assertStatus(200);
    }

    public function test_controller_help_execute_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 2,
            'user_id' => $this->user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        Storage::fake('local');
        $image = UploadedFile::fake()->image('image.png', 100, 100)->size(100);
        $response = $this->actingAs($this->admin, 'web')->patchJson(route(config('constants.help.execute'), $oldHelp->id),
            [
                'info_final' => 'Готово',
                'images_final' => [$image],

            ], [
                'Accept' => 'application/json',
            ]);
        $help = Help::first();
        $this->assertEquals('Готово', $help->info_final);
        $this->assertDatabaseHas('help', ['info_final' => 'Готово']);
        $response->assertStatus(200);
    }

    public function test_controller_help_redefine_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => 1,
        ])->assignRole('manager');
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 2,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->admin, 'web')->patchJson(route(config('constants.help.redefine'), $oldHelp->id),
            [
                'executor_id' => $testUser->id,

            ], [
                'Accept' => 'application/json',
            ]);
        $help = Help::first();
        $this->assertEquals($testUser->id, $help->executor_id);
        $this->assertDatabaseHas('help', ['executor_id' => $testUser->id]);
        $response->assertStatus(200);
    }

    public function test_controller_help_reject_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 1,
            'user_id' => $this->user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->admin, 'web')->patchJson(route(config('constants.help.reject'), $oldHelp->id),
            [
                'info_final' => 'Отклонено',
            ], [
                'Accept' => 'application/json',
            ]);
        $help = Help::first();
        $this->assertEquals('Отклонено', $help->info_final);
        $this->assertDatabaseHas('help', ['info_final' => 'Отклонено']);
        $response->assertStatus(200);
    }

    public function test_controller_help_execute_manager(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 2,
            'user_id' => $this->user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        Storage::fake('local');
        $image = UploadedFile::fake()->image('image.png', 100, 100)->size(100);
        $response = $this->actingAs($this->manager, 'web')->patchJson(route(config('constants.help.execute'), $oldHelp->id),
            [
                'info_final' => 'Готово',
                'images_final' => [$image],

            ], [
                'Accept' => 'application/json',
            ]);
        $help = Help::first();
        $this->assertEquals('Готово', $help->info_final);
        $this->assertDatabaseHas('help', ['info_final' => 'Готово']);
        $response->assertStatus(200);
    }

    public function test_controller_help_store_validation_error_required_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.help.store')));
        $response->assertJsonValidationErrors(['category_id', 'user_id', 'description_long']);
        $response->assertStatus(422);
    }

    public function test_controller_help_update_validation_error_required_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $help = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.help.update'), $help->id));
        $response->assertJsonValidationErrors(['category_id', 'user_id', 'priority_id']);
        $response->assertStatus(422);
    }

    public function test_controller_help_accept_validation_error_required_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $help = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 1,
            'user_id' => $this->user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.help.accept'), $help->id));
        $response->assertJsonValidationErrors(['executor_id', 'priority_id']);
        $response->assertStatus(422);
    }

    public function test_controller_help_execute_validation_error_required_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $help = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 2,
            'user_id' => $this->user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        Storage::fake('local');
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.help.execute'), $help->id));
        $response->assertJsonValidationErrors(['info_final']);
        $response->assertStatus(422);
    }

    public function test_controller_help_redefine_validation_error_required_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $help = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 2,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.help.redefine'), $help->id));
        $response->assertJsonValidationErrors(['executor_id']);
        $response->assertStatus(422);
    }

    public function test_controller_help_reject_validation_error_required_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $help = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 1,
            'user_id' => $this->user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.help.reject'), $help->id));
        $response->assertJsonValidationErrors(['info_final']);
        $response->assertStatus(422);
    }

    public function test_controller_help_store_validation_error_exists_super_admin(): void
    {
        Storage::fake('local');
        $image = UploadedFile::fake()->image('image.png', 100, 100)->size(100);
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.help.store')),
            [
                'category_id' => 0,
                'user_id' => 0,
                'description_long' => 'Текст',
                'images' => [$image],

            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['category_id', 'user_id']);
        $response->assertStatus(422);
    }

    public function test_controller_help_update_validation_error_exists_super_admin(): void
    {
        $oldCategory = Category::factory()->create([
            'description' => 'Старая',
        ]);
        $oldPriority = Priority::factory()->create([
            'description' => 'Средний',
            'rang' => 1,
            'warning_timer' => 1,
            'danger_timer' => 2,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $oldCategory->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'priority_id' => $oldPriority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.help.update'), $oldHelp->id),
            [
                'category_id' => 0,
                'user_id' => 0,
                'priority_id' => 0,

            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['category_id', 'user_id', 'priority_id']);
        $response->assertStatus(422);
    }

    public function test_controller_help_accept_validation_error_exists_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 1,
            'user_id' => $this->user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.help.accept'), $oldHelp->id),
            [
                'executor_id' => 0,
                'priority_id' => 0,
                'info' => 'В работу',

            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['executor_id', 'priority_id']);
        $response->assertStatus(422);
    }

    public function test_controller_help_redefine_validation_error_exists_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 2,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.help.redefine'), $oldHelp->id),
            [
                'executor_id' => 0,

            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['executor_id']);
        $response->assertStatus(422);
    }

    public function test_controller_help_store_validation_error_size_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        Storage::fake('local');
        $image = UploadedFile::fake()->image('avatar.png', 100, 100)->size(30720);
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.help.store')),
            [
                'category_id' => $category->id,
                'user_id' => $this->user->id,
                'description_long' => 'Текст',
                'images' => [$image],

            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['images.0']);
        $response->assertStatus(422);
    }

    public function test_controller_help_execute_validation_error_size_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 2,
            'user_id' => $this->user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        Storage::fake('local');
        $image = UploadedFile::fake()->image('image.png', 100, 100)->size(300720);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.help.execute'), $oldHelp->id),
            [
                'info_final' => 'Готово',
                'images_final' => [$image],

            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(422);
    }

    public function test_controller_help_store_validation_error_mime_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        Storage::fake('local');
        $image = UploadedFile::fake()->create('image.ogg')->size(100);
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.help.store')),
            [
                'category_id' => $category->id,
                'user_id' => $this->user->id,
                'description_long' => 'Текст',
                'images' => [$image],

            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['images.0']);
        $response->assertStatus(422);
    }

    public function test_controller_help_execute_validation_error_mime_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 2,
            'user_id' => $this->user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        Storage::fake('local');
        $image = UploadedFile::fake()->create('image.ogg')->size(100);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.help.execute'), $oldHelp->id),
            [
                'info_final' => 'Готово',
                'images_final' => [$image],

            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(500);
    }

    public function test_controller_help_store_validation_error_integer_super_admin(): void
    {
        Storage::fake('local');
        $image = UploadedFile::fake()->image('image.png', 100, 100)->size(100);
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.help.store')),
            [
                'category_id' => 'test',
                'user_id' => 'test',
                'description_long' => 'Текст',
                'images' => [$image],

            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['category_id', 'user_id']);
        $response->assertStatus(422);
    }

    public function test_controller_help_update_validation_error_integer_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.help.update'), $oldHelp->id),
            [
                'category_id' => 'test',
                'user_id' => 'test',
                'priority_id' => 'test',

            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['category_id', 'user_id', 'priority_id']);
        $response->assertStatus(422);
    }

    public function test_controller_help_accept_validation_error_integer_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 1,
            'user_id' => $this->user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.help.accept'), $oldHelp->id),
            [
                'executor_id' => 'test',
                'priority_id' => 'test',
                'info' => 'В работу',

            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['executor_id', 'priority_id']);
        $response->assertStatus(422);
    }

    public function test_controller_help_redefine_validation_error_integer_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 2,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.help.redefine'), $oldHelp->id),
            [
                'executor_id' => 'test',

            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['executor_id']);
        $response->assertStatus(422);
    }

    public function test_controller_help_accept_status_error_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 2,
            'user_id' => $this->user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.help.accept'), $oldHelp->id),
            [
                'executor_id' => $this->manager->id,
                'priority_id' => $priority->id,
                'info' => 'В работу',

            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(422);
    }

    public function test_controller_help_accept_user_error_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 1,
            'user_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.help.accept'), $oldHelp->id),
            [
                'executor_id' => $this->user->id,
                'priority_id' => $priority->id,
                'info' => 'В работу',

            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(422);
    }

    public function test_controller_help_execute_status_error_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 1,
            'user_id' => $this->user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        Storage::fake('local');
        $image = UploadedFile::fake()->image('image.png', 100, 100)->size(100);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.help.execute'), $oldHelp->id),
            [
                'info_final' => 'Готово',
                'images_final' => [$image],

            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(422);
    }

    public function test_controller_help_redefine_user_error_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => 1,
        ])->assignRole('manager');
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 1,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.help.redefine'), $oldHelp->id),
            [
                'executor_id' => $testUser->id,

            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(422);
    }

    public function test_controller_help_redefine_status_error_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => 1,
        ])->assignRole('manager');
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 1,
            'user_id' => $this->user->id,
            'executor_id' => $this->user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.help.redefine'), $oldHelp->id),
            [
                'executor_id' => $testUser->id,

            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(422);
    }

    public function test_controller_help_reject_status_error_super_admin(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 2,
            'user_id' => $this->user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.help.reject'), $oldHelp->id),
            [
                'info_final' => 'Отклонено',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(422);
    }

    public function test_controller_help_update_error_user(): void
    {
        $oldCategory = Category::factory()->create([
            'description' => 'Старая',
        ]);
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $oldPriority = Priority::factory()->create([
            'description' => 'Средний',
            'rang' => 1,
            'warning_timer' => 1,
            'danger_timer' => 2,
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $oldCategory->id,
            'status_id' => $this->status->id,
            'user_id' => $this->user->id,
            'priority_id' => $oldPriority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->user, 'web')->patchJson(route(config('constants.help.update'), $oldHelp->id),
            [
                'category_id' => $category->id,
                'user_id' => $this->user->id,
                'priority_id' => $priority->id,

            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }

    public function test_controller_help_accept_error_manager(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 1,
            'user_id' => $this->user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->manager, 'web')->patchJson(route(config('constants.help.accept'), $oldHelp->id),
            [
                'executor_id' => $this->manager->id,
                'priority_id' => $priority->id,
                'info' => 'В работу',

            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }

    public function test_controller_help_accept_error_user(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 1,
            'user_id' => $this->user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->user, 'web')->patchJson(route(config('constants.help.accept'), $oldHelp->id),
            [
                'executor_id' => $this->manager->id,
                'priority_id' => $priority->id,
                'info' => 'В работу',

            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }

    public function test_controller_help_reject_error_manager(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 1,
            'user_id' => $this->user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->manager, 'web')->patchJson(route(config('constants.help.reject'), $oldHelp->id),
            [
                'info_final' => 'Отклонено',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }

    public function test_controller_help_reject_error_user(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 1,
            'user_id' => $this->user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->user, 'web')->patchJson(route(config('constants.help.reject'), $oldHelp->id),
            [
                'info_final' => 'Отклонено',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }

    public function test_controller_help_redefine_error_manager(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => 1,
        ])->assignRole('manager');
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 2,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->manager, 'web')->patchJson(route(config('constants.help.redefine'), $oldHelp->id),
            [
                'executor_id' => $testUser->id,

            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }

    public function test_controller_help_redefine_error_user(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $testUser = User::factory()->create([
            'name' => fake()->unique()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => fake()->text(10),
            'cabinet_id' => 1,
        ])->assignRole('manager');
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 2,
            'user_id' => $this->user->id,
            'executor_id' => $this->manager->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        $response = $this->actingAs($this->user, 'web')->patchJson(route(config('constants.help.redefine'), $oldHelp->id),
            [
                'executor_id' => $testUser->id,

            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }

    public function test_controller_help_execute_error_user(): void
    {
        $category = Category::factory()->create([
            'description' => 'Общая',
        ]);
        $priority = Priority::factory()->create([
            'description' => 'Высокий',
            'rang' => 2,
            'warning_timer' => 4,
            'danger_timer' => 6,
        ]);
        $this->status = Status::factory()->create([
            'description' => 'Новая',
        ]);
        $oldHelp = Help::factory()->create([
            'category_id' => $category->id,
            'status_id' => 2,
            'user_id' => $this->user->id,
            'priority_id' => $priority->id,
            'description_long' => fake()->text(),
        ]);
        Storage::fake('local');
        $image = UploadedFile::fake()->image('image.png', 100, 100)->size(100);
        $response = $this->actingAs($this->user, 'web')->patchJson(route(config('constants.help.execute'), $oldHelp->id),
            [
                'info_final' => 'Готово',
                'images_final' => [$image],

            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }
}
