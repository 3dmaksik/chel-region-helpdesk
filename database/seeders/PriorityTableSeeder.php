<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriorityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('priority')->insert([
            'description' => 'Средний',
            'rang' => 3,
            'warning_timer' => 4,
            'danger_timer' => 8,
        ]);
    }
}
