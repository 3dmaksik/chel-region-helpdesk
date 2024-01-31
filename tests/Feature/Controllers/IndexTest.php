<?php

namespace Tests\Feature\Controllers;

use App\Models\Category;
use App\Models\Priority;
use App\Models\Status;
use App\Models\User;
use Database\Seeders\CabinetTableSeeder;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
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
    }

    public function test_controller_index_create_all(): void
    {
        $response = $this->get(route('index'));
        $response->assertStatus(200);
    }
}
