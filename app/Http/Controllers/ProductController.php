<?php

namespace App\Http\Controllers;

use App\Http\DAO\CategoryDAO;
use App\Http\DAO\ProductDAO;
use Illuminate\Http\Request;
use App\Models\Transaction;

class ProductController extends Controller
{
    public function index()
    {
        $categoryDao = new CategoryDAO();
        $productDao = new ProductDAO();

        $categories = $categoryDao->getAllCategories();
        $products = $productDao->getAllProducts()->where('stock', '>', 0);

        $todaySales = (float) Transaction::query()
            ->where('type', 'Sale')
            ->whereDate('created_at', now()->toDateString())
            ->sum('total_amount');

        $todayTransactions = (int) Transaction::query()
            ->where('type', 'Sale')
            ->whereDate('created_at', now()->toDateString())
            ->count();

        $todayCustomers = (int) Transaction::query()
            ->where('type', 'Sale')
            ->whereDate('created_at', now()->toDateString())
            ->distinct('customer_id')
            ->count('customer_id');

        return view('pos.index', compact(
            'categories',
            'products',
            'todaySales',
            'todayTransactions',
            'todayCustomers'
        ));
    }

    public function search(Request $request)
    {
        $request->validate([
            'q' => ['nullable', 'string', 'max:255'],
            'limit' => ['nullable', 'integer', 'min:1', 'max:50'],
        ]);

        $productDao = new ProductDAO();
        $products = $productDao->searchByName(
            (string) $request->query('q', ''),
            (int) $request->query('limit', 10)
        );

        return response()->json($products);
    }
}

