<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            // Electronics
            ['name' => 'USB-C Charger 65W', 'category' => 'Electronics', 'purchase_price' => 18.50, 'price' => 29.99, 'stock' => 40],
            ['name' => 'Wireless Mouse', 'category' => 'Electronics', 'purchase_price' => 7.25, 'price' => 14.99, 'stock' => 85],
            ['name' => 'Bluetooth Headphones', 'category' => 'Electronics', 'purchase_price' => 22.00, 'price' => 39.99, 'stock' => 35],
            ['name' => 'HDMI Cable 2m', 'category' => 'Electronics', 'purchase_price' => 2.10, 'price' => 6.99, 'stock' => 120],

            // Office Supplies
            ['name' => 'A4 Copy Paper (500 sheets)', 'category' => 'Office Supplies', 'purchase_price' => 3.90, 'price' => 6.50, 'stock' => 60],
            ['name' => 'Ballpoint Pens (10 pack)', 'category' => 'Office Supplies', 'purchase_price' => 1.80, 'price' => 3.99, 'stock' => 100],
            ['name' => 'Stapler', 'category' => 'Office Supplies', 'purchase_price' => 2.75, 'price' => 5.99, 'stock' => 45],
            ['name' => 'Notebook A5', 'category' => 'Office Supplies', 'purchase_price' => 0.85, 'price' => 1.99, 'stock' => 150],

            // Accessories
            ['name' => 'Phone Case (Universal)', 'category' => 'Accessories', 'purchase_price' => 1.20, 'price' => 4.99, 'stock' => 90],
            ['name' => 'Screen Protector', 'category' => 'Accessories', 'purchase_price' => 0.60, 'price' => 2.99, 'stock' => 140],
            ['name' => 'Laptop Sleeve 15"', 'category' => 'Accessories', 'purchase_price' => 6.00, 'price' => 12.99, 'stock' => 50],

            // Computer Parts
            ['name' => 'SSD 512GB', 'category' => 'Computer Parts', 'purchase_price' => 28.00, 'price' => 44.99, 'stock' => 25],
            ['name' => 'DDR4 RAM 16GB', 'category' => 'Computer Parts', 'purchase_price' => 19.00, 'price' => 32.99, 'stock' => 30],
            ['name' => 'CPU Cooler', 'category' => 'Computer Parts', 'purchase_price' => 9.50, 'price' => 16.99, 'stock' => 20],

            // Home Appliances
            ['name' => 'Electric Kettle', 'category' => 'Home Appliances', 'purchase_price' => 10.00, 'price' => 19.99, 'stock' => 18],
            ['name' => 'Extension Cord 4-Socket', 'category' => 'Home Appliances', 'purchase_price' => 3.40, 'price' => 7.99, 'stock' => 55],
        ];

        foreach ($items as $item) {
            $category = Category::firstOrCreate(['name' => $item['category']]);

            Product::updateOrCreate(
                ['name' => $item['name'], 'category_id' => $category->id],
                [
                    'purchase_price' => $item['purchase_price'],
                    'price' => $item['price'],
                    'stock' => $item['stock'],
                ]
            );
        }
    }
}
