<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\DAO\CategoryDAO;
use App\Http\DAO\ProductDAO;
use App\Exports\OutOfStockExport;
use App\Exports\ProductTemplateExport;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $categoryDao = new CategoryDAO();
        $productDao = new ProductDAO();

        $categories = $categoryDao->getAllCategories();

        $products = $productDao->getAllProducts();

        return view('inventory.index', compact('categories', 'products'));
    }

    public function outOfStock(Request $request)
    {
        $categoryDao = new CategoryDAO();
        $categories = $categoryDao->getAllCategories();

        $products = Product::query()
            ->with('category')
            ->where(function ($query) {
                $query->whereNull('stock')
                    ->orWhere('stock', '<=', 0);
            })
            ->when($request->filled('category_id'), function ($query) use ($request) {
                $query->where('category_id', $request->input('category_id'));
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderByDesc('created_at')
            ->paginate(15)
            ->appends($request->only('category_id', 'search'));

        return view('inventory.out-of-stock', compact('products', 'categories'));
    }

    public function exportOutOfStock(Request $request)
    {
        $products = Product::query()
            ->with('category')
            ->where(function ($query) {
                $query->whereNull('stock')
                    ->orWhere('stock', '<=', 0);
            })
            ->when($request->filled('category_id'), function ($query) use ($request) {
                $query->where('category_id', $request->input('category_id'));
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderByDesc('created_at')
            ->get();

        $fileName = 'out-of-stock-' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new OutOfStockExport($products), $fileName);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'purchase_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
        ]);

        // Check if a product with the same name and category_id already exists
        $exists = Product::where('name', $validatedData['name'])
            ->where('category_id', $validatedData['category_id'])
            ->exists();

        if ($exists) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['name' => 'A product with this name already exists in the selected category.']);
        }

        Product::create($validatedData);

        return redirect()->route('inventory')->with('success', 'Item created successfully.');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'purchase_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
        ]);

        $product = Product::findOrFail($id);

        // Prevent duplicate product in the same category (exclude current product)
        $exists = Product::where('name', $validatedData['name'])
            ->where('category_id', $validatedData['category_id'])
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['name' => 'A product with this name already exists in the selected category.']);
        }

        $product->update($validatedData);

        return redirect()->route('inventory')->with('success', 'Item updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('inventory')->with('success', 'Item deleted successfully.');
    }

    /**
     * Download the product import template (single-sheet Excel file).
     */
    public function downloadTemplate()
    {
        $fileName = 'product-template-' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new ProductTemplateExport(), $fileName);
    }

    /**
     * Import products from an uploaded Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);

        Excel::import(new ProductsImport(), $request->file('excel_file'));

        return redirect()
            ->route('inventory')
            ->with('success', 'Products imported successfully.');
    }
}