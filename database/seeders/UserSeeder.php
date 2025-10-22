<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo tài khoản admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@book.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        // Tạo tài khoản user bình thường
        User::create([
            'name' => 'Normal User',
            'email' => 'user@book.com',
            'password' => Hash::make('12345678'),
            'role' => 'user',
        ]);
    }
}