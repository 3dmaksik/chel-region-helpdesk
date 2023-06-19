<?php

namespace Tests\Feature\Controllers;

use App\Models\Article;
use App\Models\User;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsTest extends TestCase
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

        $this->superAdmin = User::factory()->create()->assignRole('superAdmin');
        $this->admin = User::factory()->create()->assignRole('admin');
        $this->manager = User::factory()->create()->assignRole('manager');
        $this->user = User::factory()->create()->assignRole('user');
    }

    public function test_controller_news_index_super_admin(): void
    {
        Article::factory()->count(15)->create();
        $this->assertDatabaseCount('news', 15);
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.news.index')));
        $response->assertStatus(200);
    }

    public function test_controller_news_create_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.news.create')));
        $response->assertStatus(200);
    }

    public function test_controller_news_create_admin(): void
    {
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.news.create')));
        $response->assertStatus(200);
    }

    public function test_controller_news_show_super_admin(): void
    {
        $article = Article::factory()->create();
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.news.show'), $article->id));
        $response->assertStatus(200);
    }

    public function test_controller_news_show_admin(): void
    {
        $article = Article::factory()->create();
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.news.show'), $article->id));
        $response->assertStatus(200);
    }

    public function test_controller_news_show_manager(): void
    {
        $article = Article::factory()->create();
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.news.show'), $article->id));
        $response->assertStatus(200);
    }

    public function test_controller_news_show_user(): void
    {
        $article = Article::factory()->create();
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.news.show'), $article->id));
        $response->assertStatus(200);
    }

    public function test_controller_news_edit_super_admin(): void
    {
        $article = Article::factory()->create();
        $response = $this->actingAs($this->superAdmin, 'web')->get(route(config('constants.news.edit'), $article->id));
        $response->assertStatus(200);
    }

    public function test_controller_news_edit_admin(): void
    {
        $article = Article::factory()->create();
        $response = $this->actingAs($this->admin, 'web')->get(route(config('constants.news.edit'), $article->id));
        $response->assertStatus(200);
    }

    public function test_controller_news_create_error_manager(): void
    {
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.news.create')));
        $response->assertStatus(403);
    }

    public function test_controller_news_create_error_user(): void
    {
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.news.create')));
        $response->assertStatus(403);
    }

    public function test_controller_news_edit_error_manager(): void
    {
        $article = Article::factory()->create();
        $response = $this->actingAs($this->manager, 'web')->get(route(config('constants.news.edit'), $article->id));
        $response->assertStatus(403);
    }

    public function test_controller_news_edit_error_user(): void
    {
        $article = Article::factory()->create();
        $response = $this->actingAs($this->user, 'web')->get(route(config('constants.news.edit'), $article->id));
        $response->assertStatus(403);
    }
}
