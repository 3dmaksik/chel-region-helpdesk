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
                'firstname' => Str::random(10),
                'lastname' => Str::random(10),
                'encrypt_description' =>  md5('metal'.Str::random(10).'admin')
            ]);
    }
}
