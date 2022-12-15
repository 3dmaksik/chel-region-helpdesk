<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
            'email' =>'test@local.local',
            'password' => Hash::make('password'),
            'work_id' => 1,
            'email_verified_at'=> now(),
        ])->assignRole('admin');
    }
}
