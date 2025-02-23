<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        //
        User::create([
            'name' => 'Admin',
            'email' => 'admin_irenthub@hulas.co',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => Date::now()
        ]);
    }
}
