<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Create default admin account
        Admin::create([
            'id' => (string) Str::uuid(),
            'Restaurant_Name' => 'Main Admin',
            'email' => 'admin@example.com',
            'password' => '12345678', // Will be hashed by the model's setPasswordAttribute method
        ]);
    }
}