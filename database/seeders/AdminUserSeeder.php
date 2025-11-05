<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@f1tech.hu',
            'password' => Hash::make('admin'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);
    }
}
