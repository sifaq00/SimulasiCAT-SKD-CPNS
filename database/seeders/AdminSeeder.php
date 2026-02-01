<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@simulasicpns.id'],
            [
                'name' => 'Administrator',
                'email' => 'admin@simulasicpns.id',
                'phone' => '081234567890',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
                'role' => User::ROLE_ADMIN,
                'is_active' => true,
            ]
        );
    }
}
