<?php

namespace Database\Seeders;

use App\Models\Cabinet;
use App\Models\Category;
use App\Models\Help;
use App\Models\Priority;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()->count(100)->create();
        Priority::factory()->count(5)->create();
        Cabinet::factory()->count(65000)->create();
        for ($i = 1; $i <= 65000; $i++) {
            User::factory()->create([
                'name' => mt_rand().Str::random(100).$i,
                'email' => mt_rand().Str::random(100).$i.'@.ru',
                'email_verified_at' => now(),
                'firstname' => fake()->firstName(),
                'lastname' => fake()->lastName(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'cabinet_id' => fake()->numberBetween(1, 65000),
            ]);
        }
        Help::factory()->count(1000000)->create();
    }
}
