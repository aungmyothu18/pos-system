@extends('layouts.app')

@section('title', 'Received Items')
@section('page-title', 'Received Items')

@section('content')
<div class="space-y-6">
    <!-- Header with Add Button -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Received Transactions</h1>
        <button x-data @click="$store.modal = 'addReceivedModal'" 
                class="bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-2 rounded-lg transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New Received
        </button>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($transactions as $transaction)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $transaction->invoice_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->customer_id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('received-items.update-status', $transaction->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <select name="status" 
                                        onchange="this.form.submit()"
                                        class="text-xs font-semibold rounded-full px-3 py-1 border-0 focus:ring-2 focus:ring-offset-2
                                        {{ $transaction->status === 'Finished' ? 'bg-green-100 text-green-800 focus:ring-green-500' : 'bg-yellow-100 text-yellow-800 focus:ring-yellow-500' }}">
                                    <option value="In Progress" {{ $transaction->status === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="Finished" {{ $transaction->status === 'Finished' ? 'selected' : '' }}>Finished</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">${{ number_format($transaction->total_amount, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('received-items.show', $transaction->id) }}" 
                               class="text-blue-600 hover:text-blue-900">View Details</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No received transactions found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($transactions->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Add Received Modal -->
<div x-data="receivedModal()" 
     x-show="$store.modal === 'addReceivedModal'"
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="$store.modal === 'addReceivedModal'" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
             @click="$store.modal = null"></div>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <form @submit.prevent="submitForm" method="POST" action="{{ route('received-items.store') }}">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Add New Received</h3>
                        <button type="button" @click="$store.modal = null" class="text-gray-400 hover:text-gray-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="mb-4 grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Customer ID</label>
                            <input type="text" x-model="customerId" readonly 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Invoice Number</label>
                            <input type="text" x-model="invoiceNumber" readonly 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select x-model="status" name="status" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                <option value="In Progress">In Progress</option>
                                <option value="Finished">Finished</option>
                            </select>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Product Name</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase w-32">Price</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase w-24">Qty</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase w-32">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <template x-for="(item, index) in items" :key="index">
                                    <tr>
                                        <td class="px-3 py-2">
                                            <div class="relative">
                                                <input type="text" 
                                                       x-model="item.product_name"
                                                       @input="searchProducts(index, $event.target.value)"
                                                       @focus="showSuggestions[index] = true"
                                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                                       placeholder="Type product name">
                                                <div x-show="showSuggestions[index] && suggestions[index]?.length > 0" 
                                                     @click.away="showSuggestions[index] = false"
                                                     class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto">
                                                    <template x-for="suggestion in suggestions[index]" :key="suggestion.id">
                                                        <div @click="selectProduct(index, suggestion)" 
                                                             class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                                            <div class="font-medium" x-text="suggestion.name"></div>
                                                            <div class="text-sm text-gray-500" x-text="'$' + suggestion.price"></div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3 py-2">
                                            <input type="number" 
                                                   x-model.number="item.price"
                                                   @input="calculateSubtotal(index)"
                                                   step="0.01"
                                                   min="0"
                                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                        </td>
                                        <td class="px-3 py-2">
                                            <input type="number" 
                                                   x-model.number="item.qty"
                                                   @input="calculateSubtotal(index)"
                                                   min="1"
                                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                        </td>
                                        <td class="px-3 py-2">
                                            <input type="text" 
                                                   x-model="item.subtotal"
                                                   readonly
                                                   class="block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 font-semibold">
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 flex justify-between items-center">
                        <button type="button" @click="addRow" class="text-green-600 hover:text-green-800 text-sm font-medium">
                            + Add Row
                        </button>
                        <div class="text-right">
                            <span class="text-sm text-gray-600">Grand Total:</span>
                            <span class="text-xl font-bold text-gray-900 ml-2" x-text="'$' + grandTotal.toFixed(2)"></span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Save Transaction
                    </button>
                    <button type="button" @click="$store.modal = null" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('receivedModal', () => ({
        items: Array.from({ length: 8 }, () => ({ product_name: '', price: 0, qty: 1, subtotal: 0 })),
        suggestions: {},
        showSuggestions: {},
        customerId: 'CUST-' + Math.random().toString(36).substr(2, 8).toUpperCase(),
        invoiceNumber: 'RECV-' + new Date().toISOString().slice(0, 10).replace(/-/g, '') + '-' + Math.random().toString(36).substr(2, 6).toUpperCase(),
        status: 'In Progress',
        
        init() {
            this.items.forEach((_, index) => {
                this.suggestions[index] = [];
                this.showSuggestions[index] = false;
            });
            
            this.$watch('$store.modal', (value) => {
                if (value === 'addReceivedModal') {
                    this.resetForm();
                }
            });
        },
        
        resetForm() {
            this.items = Array.from({ length: 8 }, () => ({ product_name: '', price: 0, qty: 1, subtotal: 0 }));
            this.customerId = 'CUST-' + Math.random().toString(36).substr(2, 8).toUpperCase();
            this.invoiceNumber = 'RECV-' + new Date().toISOString().slice(0, 10).replace(/-/g, '') + '-' + Math.random().toString(36).substr(2, 6).toUpperCase();
            this.status = 'In Progress';
        },
        
        async searchProducts(index, query) {
            if (query.length < 2) {
                this.suggestions[index] = [];
                return;
            }
            
            try {
                const response = await fetch(`{{ route('api.products.search') }}?q=${encodeURIComponent(query)}`);
                const products = await response.json();
                this.suggestions[index] = products;
            } catch (error) {
                console.error('Error searching products:', error);
            }
        },
        
        selectProduct(index, product) {
            this.items[index].product_name = product.name;
            this.items[index].price = parseFloat(product.price);
            this.showSuggestions[index] = false;
            this.calculateSubtotal(index);
        },
        
        calculateSubtotal(index) {
            const item = this.items[index];
            item.subtotal = (item.price || 0) * (item.qty || 0);
        },
        
        addRow() {
            const index = this.items.length;
            this.items.push({ product_name: '', price: 0, qty: 1, subtotal: 0 });
            this.suggestions[index] = [];
            this.showSuggestions[index] = false;
        },
        
        get grandTotal() {
            return this.items.reduce((sum, item) => sum + (item.subtotal || 0), 0);
        },
        
        submitForm() {
            const form = this.$el.querySelector('form');
            const formData = new FormData(form);
            
            // Add status
            formData.append('status', this.status);
            
            // Add items to form data
            this.items.forEach((item, index) => {
                if (item.product_name && item.qty > 0) {
                    formData.append(`items[${index}][product_name]`, item.product_name);
                    formData.append(`items[${index}][price]`, item.price);
                    formData.append(`items[${index}][qty]`, item.qty);
                }
            });
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                if (response.ok) {
                    window.location.reload();
                } else {
                    return response.json().then(data => {
                        alert('Error: ' + (data.message || 'Failed to save transaction'));
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while saving the transaction');
            });
        }
    }));
});
</script>
@endsection
