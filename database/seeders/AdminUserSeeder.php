<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@coinpel.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('Admin@123'),
                'must_change_password' => true,
                'is_blocked' => false,
            ]
        );
    }
}
