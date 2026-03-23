<?php

namespace App\Http\Controllers;

use App\Http\DAO\TransactionDAO;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SaleItemController extends Controller
{
    public function __construct(private readonly TransactionDAO $transactionDao)
    {
    }

    public function index()
    {
        $transactions = $this->transactionDao->getSaleTransactionsPaginated(15);

        return view('sale-items.index', compact('transactions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_name' => 'required|string',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        try {
            $this->transactionDao->createSaleTransaction($request->items);

            return redirect()->route('sale-items.index')
                ->with('success', 'Sale transaction created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create transaction: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $transaction = $this->transactionDao->getTransactionWithItemsOrFail((int) $id);
        return view('sale-items.show', compact('transaction'));
    }

    /**
     * Export all sale transactions as CSV.
     */
    public function export(): StreamedResponse
    {
        $fileName = 'sale-items-' . now()->format('Y-m-d_H-i-s') . '.csv';

        $callback = static function () {
            $handle = fopen('php://output', 'w');

            // CSV header
            fputcsv($handle, [
                'Date',
                'Invoice',
                'Items',
                'Total Amount',
                'Status',
            ]);

            Transaction::where('type', 'Sale')
                ->with('items')
                ->orderByDesc('created_at')
                ->chunk(200, static function ($transactions) use ($handle) {
                    foreach ($transactions as $transaction) {
                        $itemsText = $transaction->items
                            ->map(static function ($it) {
                                return trim(($it->product_name ?? '') . ' x' . (int) ($it->qty ?? 0));
                            })
                            ->filter()
                            ->join('; ');

                        fputcsv($handle, [
                            optional($transaction->created_at)->format('Y-m-d H:i'),
                            $transaction->invoice_number,
                            $itemsText,
                            (float) ($transaction->total_amount ?? 0),
                            $transaction->status ?? 'Finished',
                        ]);
                    }
                });

            fclose($handle);
        };

        return response()->streamDownload($callback, $fileName, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
