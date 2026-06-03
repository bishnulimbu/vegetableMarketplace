<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role' => 'admin',
        ]);

        $vendor = User::create([
            'name' => 'Vendor One',
            'email' => 'vendor@example.com',
            'password' => 'password',
            'role' => 'vendor',
        ]);

        User::create([
            'name' => 'Consumer One',
            'email' => 'consumer@example.com',
            'password' => 'password',
            'role' => 'consumer',
        ]);

        $vendor->vegetables()->createMany([
            ['name' => 'Fresh Tomatoes', 'price' => 2.50, 'available_quantity' => 30, 'image' => ['https://images.unsplash.com/photo-1592924357228-91a4daadcfea?w=400&h=400&fit=crop']],
            ['name' => 'Organic Spinach', 'price' => 3.75, 'available_quantity' => 18, 'image' => ['https://images.unsplash.com/photo-1576045057995-568f588f82fb?w=400&h=400&fit=crop']],
            ['name' => 'Carrots Bundle', 'price' => 1.80, 'available_quantity' => 24, 'image' => ['https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?w=400&h=400&fit=crop']],
        ]);

        \App\Models\Setting::create(['key' => 'market_name', 'value' => 'Fresh Vegetable Marketplace']);
        \App\Models\Setting::create(['key' => 'market_description', 'value' => 'A simple marketplace where vendors sell fresh vegetables to consumers.']);
    }
}
