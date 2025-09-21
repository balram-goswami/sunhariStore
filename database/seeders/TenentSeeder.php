<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TenentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tenants')->insert([
            'name' => Str::random(10),
            'domain' => 'tenent1.local',
        ]);

        DB::table('tenants')->insert([
            'name' => Str::random(10),
            'domain' => 'tenent2.local',
        ]);
    }
}
