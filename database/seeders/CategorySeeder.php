<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics'],
            ['name' => 'Office Supplies'],
            ['name' => 'Accessories'],
            ['name' => 'Computer Parts'],
            ['name' => 'Home Appliances'],
        ];

        foreach ($categories as $category) {
            // Check if the category already exists before creating to avoid duplicates
            Category::firstOrCreate(['name' => $category['name']]);
        }
    }
}
