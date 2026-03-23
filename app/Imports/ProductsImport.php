<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
     * Map each row from the Excel file to a Product.
     *
     * The template uses the following headings:
     * - Product Name
     * - Category
     * - Purchase Price
     * - Selling Price
     * - Stock
     */
    public function model(array $row)
    {
        $name = $row['product_name'] ?? null;
        $categoryName = $row['category'] ?? null;

        if (! $name || ! $categoryName) {
            return null;
        }

        $purchasePrice = (float) ($row['purchase_price'] ?? 0);
        $sellingPrice = (float) ($row['selling_price'] ?? 0);
        $stock = (int) ($row['stock'] ?? 0);

        $category = Category::firstOrCreate(
            ['name' => $categoryName],
            ['slug' => Str::slug($categoryName)]
        );

        return Product::updateOrCreate(
            ['name' => $name],
            [
                'category_id'    => $category->id,
                'purchase_price' => $purchasePrice,
                'price'          => $sellingPrice,
                'stock'          => $stock,
            ]
        );
    }
}

