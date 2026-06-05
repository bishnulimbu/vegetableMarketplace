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
            ['name' => 'Fresh Tomatoes', 'name_ne' => 'ताजा टमाटर', 'price' => 80, 'available_quantity' => 25.50, 'condition' => 'Fresh', 'image' => ['https://images.unsplash.com/photo-1592924357228-91a4daadcfea?w=400&h=400&fit=crop']],
            ['name' => 'Organic Spinach', 'name_ne' => 'अर्गानिक पालुङ्गो', 'price' => 120, 'available_quantity' => 12.00, 'condition' => 'Organic', 'image' => ['https://images.unsplash.com/photo-1576045057995-568f588f82fb?w=400&h=400&fit=crop']],
            ['name' => 'Carrots Bundle', 'name_ne' => 'गाजरको पोका', 'price' => 60, 'available_quantity' => 20.00, 'condition' => 'Farm Fresh', 'image' => ['https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?w=400&h=400&fit=crop']],
            ['name' => 'Green Capsicum', 'name_ne' => 'हरियो भेडे खुर्सानी', 'price' => 140, 'available_quantity' => 18.00, 'condition' => 'Fresh', 'image' => ['https://images.unsplash.com/photo-1563565375-f3fdfdbefa83?w=400&h=400&fit=crop']],
            ['name' => 'Red Onions', 'name_ne' => 'रातो प्याज', 'price' => 55, 'available_quantity' => 40.00, 'condition' => 'Daily Harvest', 'image' => ['https://images.unsplash.com/photo-1618512496248-a07fe83aa8cb?w=400&h=400&fit=crop']],
            ['name' => 'Cucumber', 'name_ne' => 'काँक्रो', 'price' => 45, 'available_quantity' => 30.00, 'condition' => 'Fresh', 'image' => ['https://images.unsplash.com/photo-1604977042946-1eecc30f269e?w=400&h=400&fit=crop']],
        ]);

        $vendor2 = User::create([
            'name' => 'Green Valley Farm',
            'email' => 'vendor2@example.com',
            'password' => 'password',
            'role' => 'vendor',
        ]);

        $vendor2->vegetables()->createMany([
            ['name' => 'Broccoli', 'name_ne' => 'ब्रोकाउली', 'price' => 180, 'available_quantity' => 15.00, 'condition' => 'Organic', 'image' => ['https://images.unsplash.com/photo-1584270354949-c26b0d5b4a0c?w=400&h=400&fit=crop']],
            ['name' => 'Cauliflower', 'name_ne' => 'काउली', 'price' => 90, 'available_quantity' => 22.00, 'condition' => 'Fresh', 'image' => ['https://images.unsplash.com/photo-1568584710177-9ac653d76756?w=400&h=400&fit=crop']],
            ['name' => 'Green Beans', 'name_ne' => 'हरियो सिमी', 'price' => 110, 'available_quantity' => 16.50, 'condition' => 'Premium', 'image' => ['https://images.unsplash.com/photo-1567375698344-f15e7e4b3f1e?w=400&h=400&fit=crop']],
            ['name' => 'Potatoes', 'name_ne' => 'आलु', 'price' => 35, 'available_quantity' => 60.00, 'condition' => 'Daily Harvest', 'image' => ['https://images.unsplash.com/photo-1518977676601-b53f82aba655?w=400&h=400&fit=crop']],
            ['name' => 'Pumpkin', 'name_ne' => 'फर्सी', 'price' => 70, 'available_quantity' => 10.00, 'condition' => 'Farm Fresh', 'image' => ['https://images.unsplash.com/photo-1570586437263-ab629712d07b?w=400&h=400&fit=crop']],
            ['name' => 'Eggplant (Baingan)', 'name_ne' => 'भान्टा', 'price' => 65, 'available_quantity' => 24.00, 'condition' => 'Fresh', 'image' => ['https://images.unsplash.com/photo-1615484477778-ca3b77940c25?w=400&h=400&fit=crop']],
            ['name' => 'Fresh Ginger', 'name_ne' => 'ताजा अदुवा', 'price' => 200, 'available_quantity' => 8.00, 'condition' => 'Premium', 'image' => ['https://images.unsplash.com/photo-1615485290382-441e4d049cb5?w=400&h=400&fit=crop']],
            ['name' => 'Garlic', 'name_ne' => 'लसुन', 'price' => 250, 'available_quantity' => 12.00, 'condition' => 'Organic', 'image' => ['https://images.unsplash.com/photo-1617886903355-9354bb57751f?w=400&h=400&fit=crop']],
        ]);

        \App\Models\Setting::create(['key' => 'market_name', 'value' => 'Digital KrishiBazaar']);
        \App\Models\Setting::create(['key' => 'market_description', 'value' => 'A direct farm-to-consumer platform — cutting out middlemen, fair prices for all.']);
    }
}
