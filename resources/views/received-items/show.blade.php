@extends('layouts.app')

@section('title', 'Received Details')
@section('page-title', 'Received Details')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <a href="{{ route('received-items.index') }}" class="text-blue-700 hover:text-blue-900 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Received Items
        </a>
        <button onclick="window.print()" class="bg-green-500 hover:bg-green-600 text-white font-medium px-6 py-2 rounded-lg transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            Print Slip
        </button>
    </div>

    <!-- Print Slip -->
    <div id="printSlip" class="bg-white rounded-lg shadow p-6 max-w-2xl mx-auto print:shadow-none print:p-4">
        <div class="text-center mb-6 print:mb-4">
            <h1 class="text-2xl font-bold text-black print:text-xl">RECEIVED RECEIPT</h1>
            <p class="text-sm text-gray-700 mt-1 print:text-xs">POS System</p>
        </div>

        <div class="border-b border-gray-300 pb-4 mb-4 print:pb-2 print:mb-2">
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-700">Invoice #:</span>
                    <span class="font-semibold ml-2">{{ $transaction->invoice_number }}</span>
                </div>
                <div>
                    <span class="text-gray-700">Customer ID:</span>
                    <span class="font-semibold ml-2">{{ $transaction->customer_id }}</span>
                </div>
                <div>
                    <span class="text-gray-700">Status:</span>
                    <span class="font-semibold ml-2 px-2 py-1 rounded text-xs 
                        {{ $transaction->status === 'Finished' ? 'bg-green-100 text-green-900' : 'bg-yellow-100 text-yellow-900' }}">
                        {{ $transaction->status }}
                    </span>
                </div>
                <div>
                    <span class="text-gray-700">Date:</span>
                    <span class="font-semibold ml-2">{{ $transaction->created_at->format('M d, Y') }}</span>
                </div>
                <div>
                    <span class="text-gray-700">Time:</span>
                    <span class="font-semibold ml-2">{{ $transaction->created_at->format('h:i A') }}</span>
                </div>
            </div>
        </div>

        <table class="w-full mb-4 print:mb-2">
            <thead>
                <tr class="border-b border-gray-300">
                    <th class="text-left py-2 text-sm font-semibold text-gray-800 print:text-xs">Item</th>
                    <th class="text-right py-2 text-sm font-semibold text-gray-800 print:text-xs">Price</th>
                    <th class="text-center py-2 text-sm font-semibold text-gray-800 print:text-xs">Qty</th>
                    <th class="text-right py-2 text-sm font-semibold text-gray-800 print:text-xs">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->items as $item)
                <tr class="border-b border-gray-200">
                    <td class="py-2 text-sm text-black print:text-xs">{{ $item->product_name }}</td>
                    <td class="py-2 text-sm text-right text-gray-800 print:text-xs">${{ number_format($item->price, 2) }}</td>
                    <td class="py-2 text-sm text-center text-gray-800 print:text-xs">{{ $item->qty }}</td>
                    <td class="py-2 text-sm text-right font-semibold text-black print:text-xs">${{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="border-t-2 border-gray-300 pt-4 print:pt-2">
            <div class="flex justify-between items-center">
                <span class="text-lg font-semibold text-black print:text-base">Total:</span>
                <span class="text-2xl font-bold text-black print:text-xl">${{ number_format($transaction->total_amount, 2) }}</span>
            </div>
        </div>

        <div class="mt-6 text-center text-sm text-gray-700 print:mt-4 print:text-xs">
            <p>Received Items Record</p>
            <p class="mt-2">{{ $transaction->created_at->format('F d, Y h:i A') }}</p>
        </div>
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    #printSlip, #printSlip * {
        visibility: visible;
    }
    #printSlip {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        max-width: 100%;
    }
    @page {
        margin: 0.5cm;
        size: auto;
    }
}
</style>
@endsection
