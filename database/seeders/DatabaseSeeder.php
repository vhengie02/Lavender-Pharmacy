<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test users
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@lavenderpharmacy.com',
            'password' => Hash::make('Admin123456'),
            'role' => 'admin',
            'contact_number' => '+63 912 3456789',
            'address' => '123 Main St, Manila, Philippines',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Editor User',
            'email' => 'editor@lavenderpharmacy.com',
            'password' => Hash::make('Editor123456'),
            'role' => 'editor',
            'contact_number' => '+63 912 3456790',
            'address' => '456 Oak Ave, Manila, Philippines',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Customer User',
            'email' => 'customer@lavenderpharmacy.com',
            'password' => Hash::make('Customer123456'),
            'role' => 'customer',
            'contact_number' => '+63 912 3456791',
            'address' => '789 Pine Rd, Manila, Philippines',
            'status' => 'active',
        ]);

        // Create categories
        $categories = [
            ['category_name' => 'Antibiotics', 'description' => 'Medicines to fight bacterial infections'],
            ['category_name' => 'Pain Relief', 'description' => 'Analgesics and anti-inflammatory drugs'],
            ['category_name' => 'Cold & Flu', 'description' => 'Remedies for common cold and flu symptoms'],
            ['category_name' => 'Vitamins', 'description' => 'Essential vitamins and supplements'],
            ['category_name' => 'Digestive', 'description' => 'Medicines for digestive health'],
            ['category_name' => 'First Aid', 'description' => 'Emergency and first aid supplies'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create sample products
        $products = [
            [
                'product_name' => 'Amoxicillin 500mg',
                'generic_name' => 'Amoxicillin',
                'brand_name' => 'Amoxil',
                'category_id' => 1,
                'description' => 'Antibiotic used to treat bacterial infections',
                'dosage_info' => '500mg',
                'price' => 45.00,
                'stock_quantity' => 100,
                'expiration_date' => now()->addMonths(12),
                'manufacturer' => 'GSK',
                'barcode' => '1234567890001',
                'prescription_required' => true,
            ],
            [
                'product_name' => 'Paracetamol 500mg',
                'generic_name' => 'Paracetamol',
                'brand_name' => 'Biogesic',
                'category_id' => 2,
                'description' => 'Pain reliever and fever reducer',
                'dosage_info' => '500mg',
                'price' => 25.00,
                'stock_quantity' => 200,
                'expiration_date' => now()->addMonths(18),
                'manufacturer' => 'Biogesic Inc',
                'barcode' => '1234567890002',
                'prescription_required' => false,
            ],
            [
                'product_name' => 'Vitamin C 1000mg',
                'generic_name' => 'Ascorbic Acid',
                'brand_name' => 'Vit C',
                'category_id' => 4,
                'description' => 'Immune system booster',
                'dosage_info' => '1000mg',
                'price' => 60.00,
                'stock_quantity' => 150,
                'expiration_date' => now()->addMonths(24),
                'manufacturer' => 'Vitamin World',
                'barcode' => '1234567890003',
                'prescription_required' => false,
            ],
            [
                'product_name' => 'Ibuprofen 200mg',
                'generic_name' => 'Ibuprofen',
                'brand_name' => 'Advil',
                'category_id' => 2,
                'description' => 'Anti-inflammatory pain reliever',
                'dosage_info' => '200mg',
                'price' => 35.00,
                'stock_quantity' => 80,
                'expiration_date' => now()->addMonths(12),
                'manufacturer' => 'Pfizer',
                'barcode' => '1234567890004',
                'prescription_required' => false,
            ],
            [
                'product_name' => 'Omeprazole 20mg',
                'generic_name' => 'Omeprazole',
                'brand_name' => 'Losec',
                'category_id' => 5,
                'description' => 'Stomach acid reducer',
                'dosage_info' => '20mg',
                'price' => 50.00,
                'stock_quantity' => 120,
                'expiration_date' => now()->addMonths(12),
                'manufacturer' => 'AstraZeneca',
                'barcode' => '1234567890005',
                'prescription_required' => true,
            ],
        ];

        foreach ($products as $product) {
            $product['date_added'] = now();
            $product['date_updated'] = now();
            Product::create($product);
        }
    }
}
