<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@admin.com'], // check if exists
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'), // change to secure password
            ]
        );
    }
}