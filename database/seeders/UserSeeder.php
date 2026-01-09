<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@pemdi.test',
            'password' => Hash::make('password'),
        ]);

        // Create a test regular user
        User::create([
            'name' => 'Test User',
            'email' => 'user@pemdi.test',
            'password' => Hash::make('password'),
        ]);
    }
}
