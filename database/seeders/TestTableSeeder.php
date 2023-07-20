<?php

namespace Database\Seeders;

use App\Base\Helpers\GeneratorAppNumberHelper;
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
        for ($i = 1; $i <= 64000; $i++) {
            User::factory()->create([
                'name' => mt_rand().Str::random(100).$i,
                'email' => mt_rand().Str::random(100).$i.'@.ru',
                'email_verified_at' => now(),
                'firstname' => fake()->firstName(),
                'lastname' => fake()->lastName(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'cabinet_id' => fake()->numberBetween(1, 64500),
            ]);
        }
        for ($i = 1; $i <= 500000; $i++) {
            $last = Help::select('app_number')->orderBy('id', 'desc')->first();
            if ($last == null) {
                $app_number = GeneratorAppNumberHelper::generate();
            } else {
                $app_number = GeneratorAppNumberHelper::generate($last->app_number);
            }
            Help::factory()->create([
                'app_number' => $app_number,
                'category_id' => fake()->numberBetween(1, 99),
                'status_id' => fake()->numberBetween(1, 4),
                'priority_id' => fake()->numberBetween(1, 6),
                'user_id' => fake()->numberBetween(1, 63500),
                'executor_id' => fake()->numberBetween(1, 63500),
                'info' => fake()->text(),
                'info_final' => fake()->text(),
                'calendar_request' => fake()->date(),
                'calendar_accept' => fake()->date(),
                'calendar_warning' => fake()->date(),
                'calendar_execution' => fake()->date(),
                'calendar_final' => fake()->date(),
                'description_long' => fake()->text(),
                'lead_at' => fake()->numberBetween(1, 999),
            ]);
        }
    }
}
