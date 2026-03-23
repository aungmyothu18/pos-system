<?php

namespace App\Http\DAO;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class TransactionDAO
{
    public function getSaleTransactionsPaginated(int $perPage = 15)
    {
        return Transaction::where('type', 'Sale')
            ->with('items')
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function getTransactionWithItemsOrFail(int $id): Transaction
    {
        return Transaction::with('items')->findOrFail($id);
    }

    /**
     * @param array<int, array{product_name:string, price:numeric, qty:int}> $items
     */
    public function createSaleTransaction(array $items): Transaction
    {
        return DB::transaction(function () use ($items) {
            $transaction = Transaction::create([
                'type' => 'Sale',
                'status' => 'Finished',
                'total_amount' => 0,
            ]);

            $totalAmount = 0;

            // Preload products by name to minimize queries
            $productNames = array_values(array_unique(array_map(
                static fn (array $item): string => (string) ($item['product_name'] ?? ''),
                $items
            )));

            $productsByName = Product::query()
                ->whereIn('name', $productNames)
                ->get()
                ->keyBy('name');

            foreach ($items as $item) {
                $name = (string) ($item['product_name'] ?? '');
                $qty = (int) ($item['qty'] ?? 0);

                if ($name === '' || $qty <= 0) {
                    continue;
                }

                $price = (float) ($item['price'] ?? 0);
                $subtotal = $price * $qty;

                /** @var \App\Models\Product|null $product */
                $product = $productsByName->get($name);
                if ($product) {
                    if ($product->stock < $qty) {
                        throw new \RuntimeException("Insufficient stock for product: {$product->name}");
                    }

                    $product->decrement('stock', $qty);
                    $product->stock -= $qty;
                }

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_name' => $name,
                    'price' => $price,
                    'qty' => $qty,
                    'subtotal' => $subtotal,
                ]);

                $totalAmount += $subtotal;
            }

            $transaction->update(['total_amount' => $totalAmount]);

            return $transaction;
        });
    }
}

