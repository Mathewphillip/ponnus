<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates three demonstration accounts for Ponnus with distinct roles.
     * Common demonstration password: password123
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Restaurant Administrator',
                'email' => 'admin@ponnus.test',
                'role' => 'Admin',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Restaurant Staff',
                'email' => 'staff@ponnus.test',
                'role' => 'Staff',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Restaurant Manager',
                'email' => 'manager@ponnus.test',
                'role' => 'Manager',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
