<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status')->insert([
            'description' => 'Новая',
            'color' => config("color.6.slug")
        ]);
        DB::table('status')->insert([
            'description' => 'В работе',
            'color' => config("color.1.slug")
        ]);
        DB::table('status')->insert([
            'description' => 'Выполнена',
            'color' => config("color.3.slug")
        ]);
        DB::table('status')->insert([
            'description' => 'Отклонена',
            'color' => config("color.4.slug")
        ]);
    }
}
