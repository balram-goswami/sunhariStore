<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'sunhari.in2025@gmail.com',
            'password' => Hash::make('admin@123'),
            'role' => 1,
        ]);
        User::factory()->create([
            'name' => 'Vendor User',
            'email' => 'manager@sunhari.com',
            'password' => Hash::make('manager@123'),
            'role' => 2,
        ]);
    }
}
