<?php

namespace App\Http\DAO;

use App\Models\Product;
use Illuminate\Support\Collection;

class ProductDAO
{
    public function getAllProducts($perPage = 15)
    {
        return Product::query()
            ->with('category')
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    /**
     * Returns a lightweight list for autocomplete.
     *
     * @return \Illuminate\Support\Collection<int, array{id:int, name:string, price:string}>
     */
    public function searchByName(string $query, int $limit = 10): Collection
    {
        $q = trim($query);
        if ($q === '') {
            return collect();
        }

        return Product::query()
            ->select(['id', 'name', 'price'])
            ->where('name', 'like', '%' . $q . '%')
            ->orderBy('name')
            ->limit($limit)
            ->get()
            ->map(fn (Product $p) => [
                'id' => $p->id,
                'name' => $p->name,
                // keep as string to preserve decimal precision in JSON
                'price' => (string) $p->price,
            ]);
    }
}

