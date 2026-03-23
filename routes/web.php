<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SaleItemController;
use App\Http\Controllers\ReceivedItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\JewelryReceiveController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Models\Product;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');

Route::get('/pos', [ProductController::class, 'index'])->name('pos');

Route::prefix('jewelry-receive')->name('jewelry-receive.')->group(function () {
    Route::get('/', [JewelryReceiveController::class, 'index'])->name('index');
    Route::post('/', [JewelryReceiveController::class, 'store'])->name('store');
    Route::get('/export', [JewelryReceiveController::class, 'export'])->name('export');
    Route::get('/{id}', [JewelryReceiveController::class, 'show'])->name('show');
    Route::delete('/{id}', [JewelryReceiveController::class, 'destroy'])->name('destroy');
});

Route::prefix('sale-items')->name('sale-items.')->group(function () {
    Route::get('/', [SaleItemController::class, 'index'])->name('index');
    Route::post('/', [SaleItemController::class, 'store'])->name('store');
    Route::get('/{id}', [SaleItemController::class, 'show'])->name('show');
    Route::get('/export/csv', [SaleItemController::class, 'export'])->name('export');
});

Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
Route::get('/inventory/template', [InventoryController::class, 'downloadTemplate'])->name('inventory.template');
Route::post('/inventory/import', [InventoryController::class, 'import'])->name('inventory.import');
Route::get('/out-of-stock', [InventoryController::class, 'outOfStock'])->name('out-of-stock');
Route::get('/out-of-stock/export', [InventoryController::class, 'exportOutOfStock'])->name('out-of-stock.export');

Route::prefix('items')->name('items.')->group(function () {
    Route::post('/', [InventoryController::class, 'store'])->name('store');
    Route::put('/{id}', [InventoryController::class, 'update'])->name('update');
    Route::delete('/{id}', [InventoryController::class, 'destroy'])->name('destroy');
});

Route::view('/user-list', 'user-list.index')->name('user-list');

Route::view('/purchases', 'purchases.index')->name('purchases');

Route::get('/category', [CategoryController::class, 'index'])->name('category');
Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
Route::put('/category/{id}', [CategoryController::class, 'update'])->name('category.update');
Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

Route::prefix('received-items')->name('received-items.')->group(function () {
    Route::get('/', [ReceivedItemController::class, 'index'])->name('index');
    Route::post('/', [ReceivedItemController::class, 'store'])->name('store');
    Route::put('/{id}/status', [ReceivedItemController::class, 'updateStatus'])->name('update-status');
    Route::get('/{id}', [ReceivedItemController::class, 'show'])->name('show');
});

Route::get('/api/products/search', [ProductController::class, 'search'])->name('api.products.search');
