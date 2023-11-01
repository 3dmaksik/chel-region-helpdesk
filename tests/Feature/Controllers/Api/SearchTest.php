<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Cabinet;
use App\Models\User;
use Database\Seeders\CabinetTableSeeder;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
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
        $this->seed(CabinetTableSeeder::class);

        $this->superAdmin = User::factory()->create()->assignRole('superAdmin');
    }

    public function test_controller_search_cabinet_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin, 'web')->get(route('select2.cabinet').'?q=1');
        $response->assertStatus(200);
    }

    public function test_controller_search_cabinet_validation_error_min_super_admin(): void
    {
        Cabinet::factory()->create();
        $response = $this->actingAs($this->superAdmin, 'web')->get(route('select2.cabinet').'?q=');
        $response->assertSessionHasErrors(['q']);
        $response->assertStatus(302);
    }

    public function test_controller_search_cabinet_validation_error_max_super_admin(): void
    {
        Cabinet::factory()->create();
        $response = $this->actingAs($this->superAdmin, 'web')->get(route('select2.cabinet').'?q='.fake()->text(1000));
        $response->assertSessionHasErrors(['q']);
        $response->assertStatus(302);
    }
}
