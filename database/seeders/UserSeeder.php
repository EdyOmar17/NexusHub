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
            ['email' => 'edy.omar2005@gmail.com'],
            [
                'name' => 'Edy Reyes - Administrador',
                'password' => Hash::make('Admin123!'), // 8+ chars, letters, numbers, symbols
            ]
        );
    }
}
