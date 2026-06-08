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

        // ─── Vendor 1: Vendor One ─────────────────────────────────
        $vendor = User::create([
            'name' => 'Vendor One',
            'email' => 'vendor@example.com',
            'password' => 'password',
            'role' => 'vendor',
            'city' => 'Kathmandu',
            'address' => 'Thamel, Kathmandu 44600',
            'latitude' => 27.7172453,
            'longitude' => 85.3239605,
        ]);

        User::create([
            'name' => 'Consumer One',
            'email' => 'consumer@example.com',
            'password' => 'password',
            'role' => 'consumer',
            'city' => 'Kathmandu',
            'latitude' => 27.7100,
            'longitude' => 85.3300,
        ]);

        $vendor->vegetables()->createMany([
            // Vegetables
            ['name' => 'Fresh Tomatoes', 'name_ne' => 'ताजा टमाटर', 'price' => 80, 'available_quantity' => 25.50, 'condition' => 'Fresh', 'category' => 'Vegetables', 'image' => ['https://images.unsplash.com/photo-1592924357228-91a4daadcfea?w=400&h=400&fit=crop']],
            ['name' => 'Carrots Bundle', 'name_ne' => 'गाजरको पोका', 'price' => 60, 'available_quantity' => 20.00, 'condition' => 'Farm Fresh', 'category' => 'Vegetables', 'image' => ['https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?w=400&h=400&fit=crop']],
            ['name' => 'Green Capsicum', 'name_ne' => 'हरियो भेडे खुर्सानी', 'price' => 140, 'available_quantity' => 18.00, 'condition' => 'Fresh', 'category' => 'Vegetables', 'image' => ['https://images.unsplash.com/photo-1563565375-f3fdfdbefa83?w=400&h=400&fit=crop']],
            ['name' => 'Red Onions', 'name_ne' => 'रातो प्याज', 'price' => 55, 'available_quantity' => 40.00, 'condition' => 'Daily Harvest', 'category' => 'Vegetables', 'image' => ['https://images.unsplash.com/photo-1618512496248-a07fe83aa8cb?w=400&h=400&fit=crop']],
            ['name' => 'Cucumber', 'name_ne' => 'काँक्रो', 'price' => 45, 'available_quantity' => 30.00, 'condition' => 'Fresh', 'category' => 'Vegetables', 'image' => ['https://images.unsplash.com/photo-1604977042946-1eecc30f269e?w=400&h=400&fit=crop']],
            ['name' => 'Beetroot', 'name_ne' => 'चुकन्दर', 'price' => 75, 'available_quantity' => 14.00, 'condition' => 'Fresh', 'category' => 'Vegetables', 'image' => ['https://images.unsplash.com/photo-1593104547489-5cfb3838a3b5?w=400&h=400&fit=crop']],
            ['name' => 'Radish (Moola)', 'name_ne' => 'मूला', 'price' => 40, 'available_quantity' => 35.00, 'condition' => 'Farm Fresh', 'category' => 'Vegetables', 'image' => ['https://images.unsplash.com/photo-1592512019821-9b301a7641e8?w=400&h=400&fit=crop']],
            // Leafy Greens
            ['name' => 'Organic Spinach', 'name_ne' => 'अर्गानिक पालुङ्गो', 'price' => 120, 'available_quantity' => 12.00, 'condition' => 'Organic', 'category' => 'Leafy Greens', 'image' => ['https://images.unsplash.com/photo-1576045057995-568f588f82fb?w=400&h=400&fit=crop']],
            ['name' => 'Mustard Greens (Saag)', 'name_ne' => 'तोरीको साग', 'price' => 50, 'available_quantity' => 10.00, 'condition' => 'Fresh', 'category' => 'Leafy Greens', 'image' => ['https://images.unsplash.com/photo-1578037089813-0e10970758e2?w=400&h=400&fit=crop']],
            ['name' => 'Fenugreek Leaves (Methi)', 'name_ne' => 'मेथीको साग', 'price' => 40, 'available_quantity' => 8.00, 'condition' => 'Fresh', 'category' => 'Leafy Greens', 'image' => ['https://images.unsplash.com/photo-1615485290382-441e4d049cb5?w=400&h=400&fit=crop']],
            // Fruits
            ['name' => 'Banana', 'name_ne' => 'केरा', 'price' => 60, 'available_quantity' => 50.00, 'condition' => 'Fresh', 'category' => 'Fruits', 'image' => ['https://images.unsplash.com/photo-1603833665858-e61d17a86224?w=400&h=400&fit=crop']],
            ['name' => 'Papaya', 'name_ne' => 'मेवा', 'price' => 90, 'available_quantity' => 15.00, 'condition' => 'Farm Fresh', 'category' => 'Fruits', 'image' => ['https://images.unsplash.com/photo-1526318472351-c75fcf070305?w=400&h=400&fit=crop']],
            // Herbs
            ['name' => 'Fresh Coriander (Dhaniya)', 'name_ne' => 'ताजा धनिया', 'price' => 30, 'available_quantity' => 5.00, 'condition' => 'Fresh', 'category' => 'Herbs', 'image' => ['https://images.unsplash.com/photo-1592417817098-8fd3d9eb14a5?w=400&h=400&fit=crop']],
            ['name' => 'Mint Leaves (Pudina)', 'name_ne' => 'पुदिना', 'price' => 35, 'available_quantity' => 6.00, 'condition' => 'Organic', 'category' => 'Herbs', 'image' => ['https://images.unsplash.com/photo-1628556270448-4d4e4148e1b1?w=400&h=400&fit=crop']],
        ]);

        // ─── Vendor 2: Green Valley Farm ──────────────────────────
        $vendor2 = User::create([
            'name' => 'Green Valley Farm',
            'email' => 'vendor2@example.com',
            'password' => 'password',
            'role' => 'vendor',
            'city' => 'Lalitpur',
            'address' => 'Patan Durbar Square, Lalitpur 44700',
            'latitude' => 27.6650,
            'longitude' => 85.3260,
        ]);

        $vendor2->vegetables()->createMany([
            // Vegetables
            ['name' => 'Broccoli', 'name_ne' => 'ब्रोकाउली', 'price' => 180, 'available_quantity' => 15.00, 'condition' => 'Organic', 'category' => 'Vegetables', 'image' => ['https://images.unsplash.com/photo-1584270354949-c26b0d5b4a0c?w=400&h=400&fit=crop']],
            ['name' => 'Cauliflower', 'name_ne' => 'काउली', 'price' => 90, 'available_quantity' => 22.00, 'condition' => 'Fresh', 'category' => 'Vegetables', 'image' => ['https://images.unsplash.com/photo-1568584710177-9ac653d76756?w=400&h=400&fit=crop']],
            ['name' => 'Green Beans', 'name_ne' => 'हरियो सिमी', 'price' => 110, 'available_quantity' => 16.50, 'condition' => 'Premium', 'category' => 'Vegetables', 'image' => ['https://images.unsplash.com/photo-1567375698344-f15e7e4b3f1e?w=400&h=400&fit=crop']],
            ['name' => 'Potatoes', 'name_ne' => 'आलु', 'price' => 35, 'available_quantity' => 60.00, 'condition' => 'Daily Harvest', 'category' => 'Vegetables', 'image' => ['https://images.unsplash.com/photo-1518977676601-b53f82aba655?w=400&h=400&fit=crop']],
            ['name' => 'Pumpkin', 'name_ne' => 'फर्सी', 'price' => 70, 'available_quantity' => 10.00, 'condition' => 'Farm Fresh', 'category' => 'Vegetables', 'image' => ['https://images.unsplash.com/photo-1570586437263-ab629712d07b?w=400&h=400&fit=crop']],
            ['name' => 'Eggplant (Baingan)', 'name_ne' => 'भान्टा', 'price' => 65, 'available_quantity' => 24.00, 'condition' => 'Fresh', 'category' => 'Vegetables', 'image' => ['https://images.unsplash.com/photo-1615484477778-ca3b77940c25?w=400&h=400&fit=crop']],
            ['name' => 'Zucchini', 'name_ne' => 'जुकीनी', 'price' => 150, 'available_quantity' => 12.00, 'condition' => 'Premium', 'category' => 'Vegetables', 'image' => ['https://images.unsplash.com/photo-1607301405390-d831c242f59b?w=400&h=400&fit=crop']],
            // Leafy Greens
            ['name' => 'Lettuce (Iceberg)', 'name_ne' => 'आइसबर्ग लेटस', 'price' => 85, 'available_quantity' => 10.00, 'condition' => 'Fresh', 'category' => 'Leafy Greens', 'image' => ['https://images.unsplash.com/photo-1622206151226-18ca2c9ab4a1?w=400&h=400&fit=crop']],
            ['name' => 'Cabbage', 'name_ne' => 'बन्दा', 'price' => 45, 'available_quantity' => 28.00, 'condition' => 'Daily Harvest', 'category' => 'Leafy Greens', 'image' => ['https://images.unsplash.com/photo-1595665592839-1a4b29ea2039?w=400&h=400&fit=crop']],
            // Exotic
            ['name' => 'Red Cabbage', 'name_ne' => 'रातो बन्दा', 'price' => 130, 'available_quantity' => 8.00, 'condition' => 'Premium', 'category' => 'Exotic', 'image' => ['https://images.unsplash.com/photo-1594282486552-73b4d06c6f58?w=400&h=400&fit=crop']],
            ['name' => 'Asparagus', 'name_ne' => 'एस्पारागस', 'price' => 350, 'available_quantity' => 6.00, 'condition' => 'Premium', 'category' => 'Exotic', 'image' => ['https://images.unsplash.com/photo-1599232210476-6b42f2b6c054?w=400&h=400&fit=crop']],
            // Herbs
            ['name' => 'Fresh Ginger', 'name_ne' => 'ताजा अदुवा', 'price' => 200, 'available_quantity' => 8.00, 'condition' => 'Premium', 'category' => 'Herbs', 'image' => ['https://images.unsplash.com/photo-1615485290382-441e4d049cb5?w=400&h=400&fit=crop']],
            ['name' => 'Garlic', 'name_ne' => 'लसुन', 'price' => 250, 'available_quantity' => 12.00, 'condition' => 'Organic', 'category' => 'Herbs', 'image' => ['https://images.unsplash.com/photo-1617886903355-9354bb57751f?w=400&h=400&fit=crop']],
        ]);

        // ─── Vendor 3: Himalayan Organics ─────────────────────────
        $vendor3 = User::create([
            'name' => 'Himalayan Organics',
            'email' => 'vendor3@example.com',
            'password' => 'password',
            'role' => 'vendor',
            'city' => 'Pokhara',
            'address' => 'Lakeside, Pokhara 33700',
            'latitude' => 28.2096,
            'longitude' => 83.9856,
        ]);

        $vendor3->vegetables()->createMany([
            // Fruits
            ['name' => 'Apple (Red Delicious)', 'name_ne' => 'स्याउ (रातो)', 'price' => 200, 'available_quantity' => 30.00, 'condition' => 'Organic', 'category' => 'Fruits', 'image' => ['https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?w=400&h=400&fit=crop']],
            ['name' => 'Pomegranate', 'name_ne' => 'अनार', 'price' => 180, 'available_quantity' => 20.00, 'condition' => 'Fresh', 'category' => 'Fruits', 'image' => ['https://images.unsplash.com/photo-1541344999736-83eca272f6fc?w=400&h=400&fit=crop']],
            ['name' => 'Mango (Alphonso)', 'name_ne' => 'आँप (अल्फोन्सो)', 'price' => 250, 'available_quantity' => 25.00, 'condition' => 'Premium', 'category' => 'Fruits', 'image' => ['https://images.unsplash.com/photo-1553279768-865429fa0078?w=400&h=400&fit=crop']],
            ['name' => 'Watermelon', 'name_ne' => 'तरबूज', 'price' => 40, 'available_quantity' => 45.00, 'condition' => 'Farm Fresh', 'category' => 'Fruits', 'image' => ['https://images.unsplash.com/photo-1589984662646-e7b2e4962f18?w=400&h=400&fit=crop']],
            ['name' => 'Orange', 'name_ne' => 'सुन्तला', 'price' => 120, 'available_quantity' => 35.00, 'condition' => 'Fresh', 'category' => 'Fruits', 'image' => ['https://images.unsplash.com/photo-1582972236019-ea4af5ffe587?w=400&h=400&fit=crop']],
            ['name' => 'Grapes (Green)', 'name_ne' => 'अङ्गुर (हरियो)', 'price' => 160, 'available_quantity' => 18.00, 'condition' => 'Organic', 'category' => 'Fruits', 'image' => ['https://images.unsplash.com/photo-1537640538966-79f369143f8f?w=400&h=400&fit=crop']],
            // Exotic
            ['name' => 'Avocado', 'name_ne' => 'एभोकाडो', 'price' => 300, 'available_quantity' => 10.00, 'condition' => 'Organic', 'category' => 'Exotic', 'image' => ['https://images.unsplash.com/photo-1523049673857-eb18f1d7b578?w=400&h=400&fit=crop']],
            ['name' => 'Dragon Fruit', 'name_ne' => 'ड्र्यागन फ्रुट', 'price' => 400, 'available_quantity' => 7.00, 'condition' => 'Premium', 'category' => 'Exotic', 'image' => ['https://images.unsplash.com/photo-1527325678964-54921661f888?w=400&h=400&fit=crop']],
            ['name' => 'Kiwi', 'name_ne' => 'किवी', 'price' => 280, 'available_quantity' => 12.00, 'condition' => 'Fresh', 'category' => 'Exotic', 'image' => ['https://images.unsplash.com/photo-1585059895524-72359a06133a?w=400&h=400&fit=crop']],
            // Leafy Greens
            ['name' => 'Celery', 'name_ne' => 'सेलेरी', 'price' => 150, 'available_quantity' => 9.00, 'condition' => 'Organic', 'category' => 'Leafy Greens', 'image' => ['https://images.unsplash.com/photo-1600965962361-9015b7f0e69c?w=400&h=400&fit=crop']],
            // Others
            ['name' => 'Sweet Corn', 'name_ne' => 'मीठो मकै', 'price' => 100, 'available_quantity' => 22.00, 'condition' => 'Farm Fresh', 'category' => 'Others', 'image' => ['https://images.unsplash.com/photo-1551754655-cd27e38d2076?w=400&h=400&fit=crop']],
            ['name' => 'Green Peas', 'name_ne' => 'हरियो मटर', 'price' => 110, 'available_quantity' => 15.00, 'condition' => 'Fresh', 'category' => 'Others', 'image' => ['https://images.unsplash.com/photo-1587733308811-d1882f84e203?w=400&h=400&fit=crop']],
            ['name' => 'Mushroom (Button)', 'name_ne' => 'च्याउ', 'price' => 200, 'available_quantity' => 8.00, 'condition' => 'Premium', 'category' => 'Others', 'image' => ['https://images.unsplash.com/photo-1540946485063-a40da27545f8?w=400&h=400&fit=crop']],
        ]);

        // ─── Vendor 4: Fresh Valley Produce ──────────────────────
        $vendor4 = User::create([
            'name' => 'Fresh Valley Produce',
            'email' => 'vendor4@example.com',
            'password' => 'password',
            'role' => 'vendor',
            'city' => 'Bhaktapur',
            'address' => 'Dattatreya Square, Bhaktapur 44800',
            'latitude' => 27.6710,
            'longitude' => 85.4298,
        ]);

        $vendor4->vegetables()->createMany([
            // Vegetables
            ['name' => 'Bitter Gourd (Karela)', 'name_ne' => 'करेला', 'price' => 55, 'available_quantity' => 14.00, 'condition' => 'Fresh', 'category' => 'Vegetables', 'image' => ['https://images.unsplash.com/photo-1605620829858-6e12cdcea7d7?w=400&h=400&fit=crop']],
            ['name' => 'Bottle Gourd (Lauka)', 'name_ne' => 'लौका', 'price' => 35, 'available_quantity' => 30.00, 'condition' => 'Daily Harvest', 'category' => 'Vegetables', 'image' => ['https://images.unsplash.com/photo-1598032895557-1b5e1f8b0c4c?w=400&h=400&fit=crop']],
            ['name' => 'Ridge Gourd (Turai)', 'name_ne' => 'तुरई', 'price' => 45, 'available_quantity' => 18.00, 'condition' => 'Fresh', 'category' => 'Vegetables', 'image' => ['https://images.unsplash.com/photo-1596797038530-2c107229654b?w=400&h=400&fit=crop']],
            ['name' => 'Cabbage (Round)', 'name_ne' => 'गोल बन्दा', 'price' => 40, 'available_quantity' => 25.00, 'condition' => 'Farm Fresh', 'category' => 'Vegetables', 'image' => ['https://images.unsplash.com/photo-1595665592839-1a4b29ea2039?w=400&h=400&fit=crop']],
            // Fruits
            ['name' => 'Lemon', 'name_ne' => 'कागती', 'price' => 120, 'available_quantity' => 40.00, 'condition' => 'Fresh', 'category' => 'Fruits', 'image' => ['https://images.unsplash.com/photo-1590502593387-2001d76c8ffe?w=400&h=400&fit=crop']],
            ['name' => 'Guava', 'name_ne' => 'अम्बा', 'price' => 80, 'available_quantity' => 20.00, 'condition' => 'Farm Fresh', 'category' => 'Fruits', 'image' => ['https://images.unsplash.com/photo-1531538606174-0f90ff5dce83?w=400&h=400&fit=crop']],
            // Herbs
            ['name' => 'Turmeric (Fresh)', 'name_ne' => 'ताजा बेसार', 'price' => 180, 'available_quantity' => 6.00, 'condition' => 'Organic', 'category' => 'Herbs', 'image' => ['https://images.unsplash.com/photo-1615485290382-441e4d049cb5?w=400&h=400&fit=crop']],
            ['name' => 'Curry Leaves', 'name_ne' => 'करी पात', 'price' => 25, 'available_quantity' => 4.00, 'condition' => 'Fresh', 'category' => 'Herbs', 'image' => ['https://images.unsplash.com/photo-1590114538142-97f0febf1f0f?w=400&h=400&fit=crop']],
            // Others
            ['name' => 'Tapioca (Cassava)', 'name_ne' => 'सिमल तरुल', 'price' => 60, 'available_quantity' => 20.00, 'condition' => 'Daily Harvest', 'category' => 'Others', 'image' => ['https://images.unsplash.com/photo-1607603880764-7d69d9a7b025?w=400&h=400&fit=crop']],
            ['name' => 'Yam (Suran)', 'name_ne' => 'तरुल', 'price' => 70, 'available_quantity' => 16.00, 'condition' => 'Farm Fresh', 'category' => 'Others', 'image' => ['https://images.unsplash.com/photo-1590168410090-b0324ef7a8ff?w=400&h=400&fit=crop']],
        ]);

        // ─── Consumers ───────────────────────────────────────────
        User::create([
            'name' => 'Consumer Two',
            'email' => 'consumer2@example.com',
            'password' => 'password',
            'role' => 'consumer',
            'city' => 'Pokhara',
            'latitude' => 28.2050,
            'longitude' => 83.9800,
        ]);

        // ─── Settings ────────────────────────────────────────────
        \App\Models\Setting::create(['key' => 'market_name', 'value' => 'Digital KrishiBazaar']);
        \App\Models\Setting::create(['key' => 'market_description', 'value' => 'A direct farm-to-consumer platform — cutting out middlemen, fair prices for all.']);
    }
}
