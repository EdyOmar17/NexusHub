<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@nexushub.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('Admin123!'), // 8+ chars, letters, numbers, symbols
            ]
        );
    }
}
