<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Article;
use App\Models\User;
use Database\Seeders\CabinetTableSeeder;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsTest extends TestCase
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

    public function test_controller_news_store_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.news.store')),
            [
                'name' => 'Название',
                'description' => 'Описание',
                'news_text' => 'Текст',

            ], [
                'Accept' => 'application/json',
            ]);
        $article = Article::first();
        $this->assertEquals('Название', $article->name);
        $this->assertEquals('Описание', $article->description);
        $this->assertEquals('Текст', $article->news_text);
        $this->assertDatabaseHas('news', ['name' => 'Название', 'description' => 'Описание', 'news_text' => 'Текст']);
        $response->assertStatus(200);
    }

    public function test_controller_news_store_admin(): void
    {
        $response = $this->actingAs($this->admin, 'web')->postJson(route(config('constants.news.store')),
            [
                'name' => 'Название',
                'description' => 'Описание',
                'news_text' => 'Текст',

            ], [
                'Accept' => 'application/json',
            ]);
        $article = Article::first();
        $this->assertEquals('Название', $article->name);
        $this->assertEquals('Описание', $article->description);
        $this->assertEquals('Текст', $article->news_text);
        $this->assertDatabaseHas('news', ['name' => 'Название', 'description' => 'Описание', 'news_text' => 'Текст']);
        $response->assertStatus(200);
    }

    public function test_controller_news_update_super_admin(): void
    {
        $oldArticle = Article::factory()->create([
            'name' => 'Название',
            'description' => 'Описание',
            'news_text' => 'Текст',
        ]);
        $response = $this->actingAs($this->superAdmin, 'web')->patchJson(route(config('constants.news.update'), $oldArticle->id),
            [
                'name' => 'test',
                'description' => 'test',
                'news_text' => 'test',
            ], [
                'Accept' => 'application/json',
            ]);
        $article = Article::first();
        $this->assertEquals('test', $article->name);
        $this->assertEquals('test', $article->description);
        $this->assertEquals('test', $article->news_text);
        $this->assertDatabaseHas('news', ['name' => 'test', 'description' => 'test', 'news_text' => 'test']);
        $response->assertStatus(200);
    }

    public function test_controller_news_update_admin(): void
    {
        $oldArticle = Article::factory()->create([
            'name' => 'Название',
            'description' => 'Описание',
            'news_text' => 'Текст',
        ]);
        $response = $this->actingAs($this->admin, 'web')->patchJson(route(config('constants.news.update'), $oldArticle->id),
            [
                'name' => 'test',
                'description' => 'test',
                'news_text' => 'test',
            ], [
                'Accept' => 'application/json',
            ]);
        $article = Article::first();
        $this->assertEquals('test', $article->name);
        $this->assertEquals('test', $article->description);
        $this->assertEquals('test', $article->news_text);
        $this->assertDatabaseHas('news', ['name' => 'test', 'description' => 'test', 'news_text' => 'test']);
        $response->assertStatus(200);
    }

    public function test_controller_news_destroy_super_admin(): void
    {
        Article::factory()->count(5)->create();
        $article = Article::orderBy('id', 'DESC')->first();
        $response = $this->actingAs($this->superAdmin, 'web')->deleteJson(route(config('constants.news.destroy'), $article->id));
        $response->assertStatus(200);
        $this->assertDatabaseMissing('news', ['id' => $article->id]);
    }

    public function test_controller_news_destroy_admin(): void
    {
        Article::factory()->count(5)->create();
        $article = Article::orderBy('id', 'DESC')->first();
        $response = $this->actingAs($this->admin, 'web')->deleteJson(route(config('constants.news.destroy'), $article->id));
        $response->assertStatus(200);
        $this->assertDatabaseMissing('news', ['id' => $article->id]);
    }

    public function test_controller_news_store_validation_error_required_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.news.store')));
        $response->assertJsonValidationErrors(['name', 'description', 'news_text']);
        $response->assertStatus(422);
    }

    public function test_controller_news_store_validation_error_max_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.news.store')),
            [
                'name' => fake()->text(1000),
                'description' => fake()->text(1000),
                'news_text' => 'test',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['name', 'description']);
        $response->assertStatus(422);
    }

    public function test_controller_news_store_validation_error_date_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->postJson(route(config('constants.news.store')),
            [
                'name' => 'test',
                'description' => 'test',
                'news_text' => 'test',
                'created_at' => 'test',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertJsonValidationErrors(['created_at']);
        $response->assertStatus(422);
    }

    public function test_controller_news_store_error_manager(): void
    {
        $response = $this->actingAs($this->manager, 'web')->postJson(route(config('constants.news.store')));
        $response->assertStatus(403);
    }

    public function test_controller_news_store_error_user(): void
    {
        $response = $this->actingAs($this->user, 'web')->postJson(route(config('constants.news.store')));
        $response->assertStatus(403);
    }

    public function test_controller_news_update_error_manager(): void
    {
        $oldArticle = Article::factory()->create([
            'name' => 'Название',
            'description' => 'Описание',
            'news_text' => 'Текст',
        ]);
        $response = $this->actingAs($this->manager, 'web')->patchJson(route(config('constants.news.update'), $oldArticle->id),
            [
                'name' => 'test',
                'description' => 'test',
                'news_text' => 'test',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }

    public function test_controller_news_update_error_user(): void
    {
        $oldArticle = Article::factory()->create([
            'name' => 'Название',
            'description' => 'Описание',
            'news_text' => 'Текст',
        ]);
        $response = $this->actingAs($this->user, 'web')->patchJson(route(config('constants.news.update'), $oldArticle->id),
            [
                'name' => 'test',
                'description' => 'test',
                'news_text' => 'test',
            ], [
                'Accept' => 'application/json',
            ]);
        $response->assertStatus(403);
    }

    public function test_controller_news_destroy_error_manager(): void
    {
        Article::factory()->count(5)->create();
        $article = Article::orderBy('id', 'DESC')->first();
        $response = $this->actingAs($this->manager, 'web')->deleteJson(route(config('constants.news.destroy'), $article->id));
        $response->assertStatus(403);
    }

    public function test_controller_news_destroy_error_user(): void
    {
        Article::factory()->count(5)->create();
        $article = Article::orderBy('id', 'DESC')->first();
        $response = $this->actingAs($this->user, 'web')->deleteJson(route(config('constants.news.destroy'), $article->id));
        $response->assertStatus(403);
    }
}
