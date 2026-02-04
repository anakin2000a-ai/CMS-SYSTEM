<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'molham@gmail.com'], // حتى ما ينضاف مرتين
            [
                'name' => 'Molham nas',
                'password' => Hash::make('password123'),

                'bio' => 'Laravel backend developer working on API projects.',
                'avatar' => url('images/avatars/molham.png'),

                'categories' => ['laravel', 'api', 'backend'],

                'is_active' => true,
                'verified_at' => now(),
                'is_author' => true,
            ]
        );
    }
}
