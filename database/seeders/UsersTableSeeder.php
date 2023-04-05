<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'test@local.local',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'cabinet_id' => 1,
        ])->assignRole('superAdmin');
    }
}
