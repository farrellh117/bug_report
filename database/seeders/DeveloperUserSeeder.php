<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DeveloperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Developer One',
            'email' => 'developer@example.com',
            'password' => Hash::make('password123'), // Ganti password sesuai kebutuhan
            'role' => 'developer',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
