<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceivedItemController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('type', 'Received')
            ->with('items')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('received-items.index', compact('transactions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|in:In Progress,Finished',
            'items' => 'required|array|min:1',
            'items.*.product_name' => 'required|string',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                'type' => 'Received',
                'status' => $request->status,
                'total_amount' => 0,
            ]);

            $totalAmount = 0;
            foreach ($request->items as $item) {
                if (!empty($item['product_name']) && $item['qty'] > 0) {
                    $subtotal = $item['price'] * $item['qty'];
                    TransactionItem::create([
                        'transaction_id' => $transaction->id,
                        'product_name' => $item['product_name'],
                        'price' => $item['price'],
                        'qty' => $item['qty'],
                        'subtotal' => $subtotal,
                    ]);
                    $totalAmount += $subtotal;
                }
            }

            $transaction->update(['total_amount' => $totalAmount]);

            DB::commit();

            return redirect()->route('received-items.index')
                ->with('success', 'Received transaction created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create transaction: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update(['status' => $request->status]);

        return back()->with('success', 'Status updated successfully.');
    }

    public function show($id)
    {
        $transaction = Transaction::with('items')->findOrFail($id);
        return view('received-items.show', compact('transaction'));
    }
}
