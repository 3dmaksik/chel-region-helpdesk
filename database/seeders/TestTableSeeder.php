<?php

namespace Database\Seeders;

use App\Base\Helpers\GeneratorAppNumberHelper;
use App\Models\Cabinet;
use App\Models\Category;
use App\Models\Help;
use App\Models\Priority;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['user', 'manager', 'admin', 'superAdmin'];
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for ($i = 2; $i <= 1000; $i++) {
            Cabinet::flushQueryCache();
            $last = Cabinet::select('id')->orderBy('id', 'desc')->first();
            if ($last->id == 1000) {
            break;
            }
            DB::table('cabinet')->insert([
                'description' => $i,
            ]);
        }
        for ($i = 1; $i <= 9; $i++) {
            Priority::flushQueryCache();
            $warning_timer = mt_rand(1, 9999);
            $faker = app(Faker::class);
            if ($i == 3) {
            $i = 4;
            }
            $last = Priority::select('id')->orderBy('id', 'desc')->first();
            if ($last->id == 9) {
            break;
            }
            DB::table('priority')->insert([
                'description' => substr(str_shuffle($permitted_chars), 0, 16),
                'rang' => $i,
                'warning_timer' => $warning_timer,
                'danger_timer' => mt_rand($warning_timer + 1, 99999),
            ]);
        }
        for ($i = 1; $i <= 1000; $i++) {
            DB::table('category')->insert([
                'description' => substr(str_shuffle($permitted_chars), 0, 16),
            ]);
            Category::flushQueryCache();
        }
        for ($i = 1; $i <= 5000; $i++) {
            $role_num = mt_rand(0, 3);
            User::create([
                'name' => substr(str_shuffle($permitted_chars), 0, 16),
                'email' => substr(str_shuffle($permitted_chars), 0, 16).'@local.local',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'firstname' => substr(str_shuffle($permitted_chars), 0, 16),
                'lastname' => substr(str_shuffle($permitted_chars), 0, 16),
                'cabinet_id' => mt_rand(1, 250),
            ])->assignRole($roles[$role_num]);
            User::flushQueryCache();
        }

        $faker = app(Faker::class);
        for ($i = 2; $i <= 1000000; $i++) {
            $last = Help::select('app_number')->orderBy('id', 'desc')->first();
            if ($last == null) {
                    $app_number = GeneratorAppNumberHelper::generate();
            } else {
                    $app_number = GeneratorAppNumberHelper::generate($last->app_number);
            }
            $status_id = mt_rand(1, 4);
            if ($status_id == 2 || $status_id == 4) {
                $executor_id = null;
            } else {
                $executor_id = mt_rand(1, 999);
            }
            DB::table('help')->insert([
                'app_number' => $app_number,
                'category_id' => mt_rand(1, 99),
                'status_id' => $status_id,
                'priority_id' => mt_rand(1, 9),
                'user_id' => mt_rand(1, 999),
                'executor_id' => $executor_id,
                'description_long' => $faker->paragraph(),
                'info' => $faker->text(),
                'info_final' => $faker->paragraph(),
                'calendar_request' => $faker->dateTimeThisYear(),
                'calendar_accept' => $faker->dateTimeThisYear(),
                'calendar_warning' => $faker->dateTimeThisYear(),
                'calendar_execution' => $faker->dateTimeThisYear(),
                'calendar_final' => $faker->dateTimeThisYear(),
                'created_at' => now(),
            ]);
            Help::flushQueryCache();
        }
    }
}
