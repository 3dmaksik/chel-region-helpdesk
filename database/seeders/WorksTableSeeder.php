<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WorksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

            DB::table('work')->insert([
                'firstname' => 'admin',
                'lastname' => Str::random(10),
                'cabinet_id'=> 1,
                'user_id' => 1,
            ]);
    }
}
