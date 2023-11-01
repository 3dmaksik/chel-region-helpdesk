<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(StatusesTableSeeder::class);
        $this->call(PriorityTableSeeder::class);
        $this->call(CabinetTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
