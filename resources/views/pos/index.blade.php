@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">
    <!-- Modern Header with Glassmorphism -->
    <header class="sticky top-0 z-20 flex items-center justify-between gap-4 px-4 py-3 bg-white/70 backdrop-blur-xl border-b border-slate-200/50 shadow-sm">
        <div class="flex items-center gap-3">
            <button id="sidebar-open" class="lg:hidden p-2.5 rounded-xl text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-200" aria-label="မီနူး ဖွင့်ရန်">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-md">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h1 class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">POS Pro</h1>
            </div>
        </div>
        
        <div class="flex items-center gap-2">
            <div class="flex items-center gap-2">
        <div class="w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center text-white font-medium text-sm">A</div>
      </div>
        </div>
    </header>

    <main class="p-4 sm:p-6 lg:p-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 max-w-7xl mx-auto">
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-lg hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">ယနေ့ ရောင်းချမှု</p>
                        <p class="text-2xl font-bold text-slate-900 mt-1">${{ number_format((float) ($todaySales ?? 0), 2) }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-lg hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">ဖောက်သည်များ</p>
                        <p class="text-2xl font-bold text-slate-900 mt-1">{{ number_format((int) ($todayCustomers ?? 0)) }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-purple-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-lg hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">နည်းပါးသော ကုန်ပစ္စည်းများ</p>
                        <p class="text-2xl font-bold text-slate-900 mt-1">
                            {{
                                number_format(
                                    $products->where('stock', '<=', 10)->count()
                                )
                            }}
                        </p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m0 0V9h1v1m-1 9a7 7 0 110-14 7 7 0 010 14zm0-10a1 1 0 110-2 1 1 0 010 2z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-lg hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">ကုန်ပစ္စည်းအရေအတွက်</p>
                        <p class="text-2xl font-bold text-slate-900 mt-1">{{ $products->count() }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Layout: products left, cart right; stack on mobile -->
        <div class="flex flex-col lg:flex-row gap-6 max-w-7xl mx-auto">
            <!-- LEFT: Products -->
            <div class="flex-1 min-w-0 order-2 lg:order-1">
                <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-xl">
                    <!-- Search and Filter Bar -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-6">
                        <div class="relative flex-1">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input
                                type="search"
                                id="pos-product-search"
                                placeholder="ကုန်ပစ္စည်းများ ရှာဖွေပါ..."
                                class="w-full pl-10 pr-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                            >
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <div class="relative">
                                <button type="button" class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-all flex items-center gap-2" id="filter-dropdown-btn">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                                    </svg>
                                </button>
                                <div id="filter-dropdown" class="hidden absolute right-0 mt-2 w-48 rounded-xl shadow-lg bg-white border border-slate-100 z-40">
                                    <ul class="p-2 text-slate-700 text-sm">
                                        <li>
                                            <button type="button" class="w-full text-left px-4 py-2 rounded-lg hover:bg-indigo-100 transition" onclick="filterProducts('newest')">
                                                ပစ္စည်းအသစ်များ
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" class="w-full text-left px-4 py-2 rounded-lg hover:bg-indigo-100 transition" onclick="filterProducts('low_to_high')">
                                                ဈေးနှုန်း : နည်းမှများ
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" class="w-full text-left px-4 py-2 rounded-lg hover:bg-indigo-100 transition" onclick="filterProducts('high_to_low')">
                                                ဈေးနှုန်း : များမှနည်း
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <script>
                                    // Dropdown toggle + product sorting
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const btn = document.getElementById('filter-dropdown-btn');
                                        const dropdown = document.getElementById('filter-dropdown');
                                        const productsGrid = document.getElementById('products-grid');

                                        if (btn && dropdown) {
                                            btn.addEventListener('click', function() {
                                                dropdown.classList.toggle('hidden');
                                            });

                                            // Click outside to close dropdown
                                            document.addEventListener('click', function(e) {
                                                if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
                                                    dropdown.classList.add('hidden');
                                                }
                                            });
                                        }

                                        // Store original order so "Newest" can reset layout
                                        if (productsGrid) {
                                            const cards = productsGrid.querySelectorAll('[data-product-id]');
                                            cards.forEach((card, index) => {
                                                card.setAttribute('data-original-index', String(index));
                                            });
                                        }
                                    });

                                    function filterProducts(type) {
                                        const dropdown = document.getElementById('filter-dropdown');
                                        const productsGrid = document.getElementById('products-grid');
                                        if (!productsGrid) return;

                                        // Hide dropdown after selecting an option
                                        if (dropdown) {
                                            dropdown.classList.add('hidden');
                                        }

                                        const cards = Array.from(productsGrid.querySelectorAll('[data-product-id]'));
                                        if (!cards.length) return;

                                        let sorted = [...cards];

                                        if (type === 'low_to_high') {
                                            sorted.sort((a, b) => {
                                                const priceA = parseFloat(a.getAttribute('data-price') || '0');
                                                const priceB = parseFloat(b.getAttribute('data-price') || '0');
                                                return priceA - priceB;
                                            });
                                        } else if (type === 'high_to_low') {
                                            sorted.sort((a, b) => {
                                                const priceA = parseFloat(a.getAttribute('data-price') || '0');
                                                const priceB = parseFloat(b.getAttribute('data-price') || '0');
                                                return priceB - priceA;
                                            });
                                        } else if (type === 'newest') {
                                            // Reset to original order based on initial DOM index
                                            sorted.sort((a, b) => {
                                                const indexA = parseInt(a.getAttribute('data-original-index') || '0', 10);
                                                const indexB = parseInt(b.getAttribute('data-original-index') || '0', 10);
                                                return indexA - indexB;
                                            });
                                        }

                                        // Re-append cards in new order
                                        productsGrid.innerHTML = '';
                                        sorted.forEach(card => productsGrid.appendChild(card));
                                    }
                                </script>
                            </div>
                        </div>
                    </div>

                    <!-- Categories Pills -->
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="px-4 py-2 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-sm font-medium cursor-pointer hover:shadow-md transition-all transform hover:scale-105"
                            onclick="filterByCategory('all')"
                            data-category-id="all">
                            ကုန်ပစ္စည်းအားလုံး <span class="ml-1 px-1.5 py-0.5 bg-white/20 rounded-lg text-xs">{{ $products->count() }}</span>
                        </span>
                        @foreach($categories as $category)
                            <span class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-sm font-medium cursor-pointer hover:bg-indigo-100 hover:text-indigo-600 hover:border-indigo-200 border border-transparent transition-all"
                                onclick="filterByCategory('{{ $category->id }}')"
                                data-category-id="{{ $category->id }}">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>

                    <!-- Products Grid -->
                    <div id="products-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-4">
                    @forelse($products as $product)
                            @php
                                $stock = $product->stock ?? 0;
                            @endphp
                            <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-white to-slate-50 border-2 border-slate-200 hover:border-indigo-300 transition-all duration-300 hover:shadow-xl hover:-translate-y-1"
                                data-name="{{ Str::lower($product->name) }}"
                                data-product-id="{{ $product->id }}"
                                data-display-name="{{ $product->name }}"
                                data-price="{{ $product->price }}"
                                data-category-id="{{ $product->category_id }}"
                                data-stock="{{ $stock }}">
                                
                                <!-- Product Image Placeholder -->
                                <div class=" bg-gradient-to-br from-indigo-100 to-purple-100 p-4 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                
                                <!-- Product Info -->
                                <div class="p-3">
                                    <p class="font-semibold text-slate-800 truncate text-sm">
                                        {{ $product->name }}
                                    </p>
                                    <p class="text-xs text-slate-500 mt-0.5">
                                        {{ optional($product->category)->name ?? 'အမျိုးအစားမသတ်မှတ်ရသေးပါ' }}
                                    </p>
                                    
                                    <!-- Stock Indicator (virtual stock; updated when adding/removing from cart) -->
                                    <div class="flex items-center gap-1 mt-2">
                                        @php
                                            $dotColor = $stock > 10 ? 'bg-green-500' : ($stock > 0 ? 'bg-yellow-400' : 'bg-red-500');
                                        @endphp
                                        <div class="w-2 h-2 rounded-full {{ $dotColor }}" data-stock-dot></div>
                                        <p class="text-xs text-slate-600">
                                            လက်ကျန်: <span data-stock-value>{{ $stock }}</span>
                                        </p>
                                    </div>
                                    
                                    <!-- Price and Add Button -->
                                    <div class="mt-3 flex items-center justify-between">
                                        <p class="text-md font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                            ${{ number_format($product->price, 2) }}
                                        </p>
                                        <button
                                            type="button"
                                            class="add-to-cart-btn w-9 h-9 rounded-xl flex items-center justify-center shadow-md transition-all transform disabled:opacity-50 disabled:cursor-not-allowed {{ $stock > 0 ? 'bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white hover:shadow-lg hover:scale-110' : 'bg-gray-300 text-slate-500' }}"
                                            data-action="add-to-cart"
                                            @if($stock <= 0) disabled aria-disabled="true" title="လက်ကျန် မရှိတော့ပါ" @endif
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Hover Effect Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-indigo-500/10 to-transparent opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity"></div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <svg class="w-16 h-16 mx-auto text-slate-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <p class="text-slate-500">ကုန်ပစ္စည်း မရှိသေးပါ။ Database ကို ပထမဆုံး အချက်အလက်ထည့်ပါ။</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- RIGHT: Cart -->
            <div class="w-full lg:w-82 shrink-0 order-1 lg:order-2">
                <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-xl sticky top-24">
                    <!-- Cart Header -->
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H6.4M7 13l-1.5 7h13L17 13M7 13H5.4M10 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"/>
                                </svg>
                            </div>
                            <span>စျေးဝယ်ခြင်း</span>
                        </h2>
                        <span id="cart-count" class="px-2 py-1 rounded-lg bg-indigo-100 text-indigo-600 text-xs font-medium">0 ခု</span>
                    </div>
                    
                    <!-- Cart Items -->
                    <ul id="cart-items" class="space-y-3 max-h-[400px] overflow-y-auto pr-1 custom-scrollbar">
                        <li class="text-sm text-slate-500 py-8 text-center" data-cart-empty>
                            <svg class="w-12 h-12 mx-auto text-slate-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <p>စျေးဝယ်ခြင်း ထဲတွင် ပစ္စည်းမရှိသေးပါ</p>
                        </li>
                    </ul>
                    
                    <!-- Cart Summary -->
                    <div class="mt-4 pt-4 border-t border-slate-200 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600">စုစုပေါင်း</span>
                            <span id="cart-subtotal" class="font-medium text-slate-900">$0.00</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600">အခွန် (၁၀%)</span>
                            <span id="cart-tax" class="font-medium text-slate-900">$0.00</span>
                        </div>
                        <div class="flex justify-between text-base font-bold pt-2">
                            <span class="text-slate-800">စုစုပေါင်းငွေ</span>
                            <span id="cart-total" class="text-xl bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">$0.00</span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="mt-4 space-y-2">
                        <button
                            type="button"
                            id="checkout-btn"
                            data-checkout-url="{{ route('sale-items.store') }}"
                            class="w-full rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold text-sm py-3.5 transition-all transform hover:scale-[1.02] shadow-lg hover:shadow-xl flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            အတည်ပြုမည်
                        </button>
                        
                        <div class="grid grid-cols-2 gap-2">
                            <button
                                type="button"
                                id="print-btn"
                                class="flex items-center justify-center gap-2 rounded-xl bg-slate-100 border border-slate-200 text-slate-700 hover:bg-slate-200 font-medium text-sm py-3 transition-all"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                </svg>
                                ပရင့်ထုတ်မည်
                            </button>
                            <button
                                type="button"
                                id="clear-cart-btn"
                                class="rounded-xl bg-slate-100 border border-slate-200 text-slate-700 hover:bg-slate-200 font-medium text-sm py-3 transition-all"
                            >
                                ရှင်းလင်းမည်
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
/* Custom Scrollbar */
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 20px;
}

/* Removed dark scrollbar styles */

/* Animations */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

#cart-items li {
    animation: slideIn 0.3s ease-out;
}
</style>

<script>
// Update datetime (Myanmar language)
function updateDateTime() {
    const now = new Date();
    // Formatting datetime to Myanmar style (eg. DD-MM-YYYY HH:MM)
    const options = { day:'2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: false };
    document.getElementById('current-datetime').textContent = now.toLocaleDateString('my-MM', options);
}
updateDateTime();
setInterval(updateDateTime, 60000);

// Search products Myanmar
(function () {
    const searchInput = document.getElementById('pos-product-search');
    const cards = document.querySelectorAll('[data-name]');

    if (!searchInput || !cards.length) return;

    searchInput.addEventListener('input', function () {
        const term = this.value.toLowerCase().trim();

        cards.forEach(card => {
            const name = card.getAttribute('data-name') || '';
            card.style.display = !term || name.includes(term) ? '' : 'none';
        });
    });
})();

(function () {
    const productCards = document.querySelectorAll('[data-product-id]');
    const cartItemsContainer = document.getElementById('cart-items');
    const cartCountEl = document.getElementById('cart-count');
    const subtotalEl = document.getElementById('cart-subtotal');
    const taxEl = document.getElementById('cart-tax');
    const totalEl = document.getElementById('cart-total');
    const clearCartBtn = document.getElementById('clear-cart-btn');
    const checkoutBtn = document.getElementById('checkout-btn');
    const TAX_RATE = 0.10;

    if (!cartItemsContainer) return;

    const cart = new Map();

    function formatCurrency(value) {
        return Number(value || 0).toFixed(2);
    }

    /** Get available stock for a product: initial stock minus quantity in cart */
    function getAvailableStock(productId) {
        const card = document.querySelector(`[data-product-id="${productId}"]`);
        if (!card) return 0;
        const initial = parseInt(card.getAttribute('data-stock') || '0', 10);
        const inCart = cart.get(String(productId))?.quantity ?? 0;
        return Math.max(0, initial - inCart);
    }

    /** Sync all product cards: update displayed stock and + button state from cart */
    function syncAllProductCards() {
        document.querySelectorAll('[data-product-id]').forEach(card => {
            const id = card.getAttribute('data-product-id');
            const initial = parseInt(card.getAttribute('data-stock') || '0', 10);
            const inCart = cart.get(id)?.quantity ?? 0;
            const available = Math.max(0, initial - inCart);

            const valueEl = card.querySelector('[data-stock-value]');
            const dotEl = card.querySelector('[data-stock-dot]');
            const addBtn = card.querySelector('.add-to-cart-btn');

            if (valueEl) valueEl.textContent = available;
            if (dotEl) {
                dotEl.classList.remove('bg-green-500', 'bg-red-500');
                dotEl.classList.add(available > 0 ? 'bg-green-500' : 'bg-red-500');
            }
            if (addBtn) {
                addBtn.disabled = available <= 0;
                addBtn.setAttribute('aria-disabled', available <= 0 ? 'true' : 'false');
                addBtn.title = available <= 0 ? 'လက်ကျန် မရှိတော့ပါ' : 'စျေးသွင်းခြင်း';
                const stateClasses = ['bg-gray-300', 'text-slate-500', 'bg-gradient-to-r', 'from-indigo-500', 'to-purple-600', 'hover:from-indigo-600', 'hover:to-purple-700', 'text-white', 'hover:shadow-lg', 'hover:scale-110'];
                stateClasses.forEach(c => addBtn.classList.remove(c));
                if (available <= 0) {
                    addBtn.classList.add('bg-gray-300', 'text-slate-500');
                } else {
                    addBtn.classList.add('bg-gradient-to-r', 'from-indigo-500', 'to-purple-600', 'hover:from-indigo-600', 'hover:to-purple-700', 'text-white', 'hover:shadow-lg', 'hover:scale-110');
                }
            }
        });
    }

    function renderCart() {
        cartItemsContainer.innerHTML = '';

        const itemCount = Array.from(cart.values()).reduce((sum, item) => sum + (item.quantity || 0), 0);
        if (cartCountEl) cartCountEl.textContent = `${itemCount} ခု`;

        if (!cart.size) {
            const emptyItem = document.createElement('li');
            emptyItem.className = 'text-sm text-slate-500 py-8 text-center';
            emptyItem.innerHTML = `
                <svg class="w-12 h-12 mx-auto text-slate-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <p>စျေးဝယ်ခြင်း ထဲတွင် ပစ္စည်းမရှိသေးပါ</p>
            `;
            cartItemsContainer.appendChild(emptyItem);

            if (subtotalEl) subtotalEl.textContent = '$0.00';
            if (taxEl) taxEl.textContent = '$0.00';
            if (totalEl) totalEl.textContent = '$0.00';
            return;
        }

        let subtotal = 0;

        cart.forEach(item => {
            const lineTotal = item.price * item.quantity;
            subtotal += lineTotal;

            const initialStock = item.initialStock != null ? Number(item.initialStock) : 0;
            const canIncrement = initialStock - item.quantity > 0;
            const incrementBtnClass = canIncrement
                ? 'w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 flex items-center justify-center text-base leading-none transition-all'
                : 'w-8 h-8 rounded-lg bg-gray-300 text-slate-500 flex items-center justify-center text-base leading-none transition-all disabled:opacity-50 disabled:cursor-not-allowed cursor-not-allowed';

            const li = document.createElement('li');
            li.className = 'rounded-xl bg-slate-50 border border-slate-200 p-3 shadow-sm';
            li.innerHTML = `
                <div class="flex items-center gap-3">
                    <div class="min-w-0 flex-1">
                        <p class="text-slate-900 font-semibold truncate text-sm">${item.name}</p>
                        <p class="text-slate-500 text-xs">$${formatCurrency(item.price)} </p>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <button
                            type="button"
                            class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 flex items-center justify-center text-base leading-none transition-all"
                            data-cart-action="decrement"
                            data-product-id="${item.id}"
                            aria-label="အရေအတွက်လျှော့မည်"
                        >−</button>
                        <span class="w-5 text-center text-slate-900 font-medium text-sm">${item.quantity}</span>
                        <button
                            type="button"
                            class="cart-increment-btn ${incrementBtnClass}"
                            data-cart-action="increment"
                            data-product-id="${item.id}"
                            aria-label="အရေအတွက်တိုးမည်"
                            ${!canIncrement ? ' disabled title="လက်ကျန် မရှိတော့ပါ"' : ''}
                        >+</button>
                        <button
                            type="button"
                            class="ml-1 w-8 h-8 flex items-center justify-center rounded-lg hover:bg-red-50 text-red-500 border border-transparent hover:border-red-200 transition-all"
                            data-cart-action="remove"
                            data-product-id="${item.id}"
                            title="ဖျက်မည်"
                            aria-label="ပစ္စည်းဖယ်ရှားမည်"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m4 0H5" />
                            </svg>
                        </button>
                    </div>
                </div>
            `;

            cartItemsContainer.appendChild(li);
        });

        const tax = subtotal * TAX_RATE;
        const total = subtotal + tax;

        if (subtotalEl) subtotalEl.textContent = `$${formatCurrency(subtotal)}`;
        if (taxEl) taxEl.textContent = `$${formatCurrency(tax)}`;
        if (totalEl) totalEl.textContent = `$${formatCurrency(total)}`;
    }

    function getCartItemsPayload() {
        const items = [];
        cart.forEach(item => {
            if (item.quantity > 0) {
                items.push({
                    product_name: item.name,
                    price: item.price,
                    qty: item.quantity,
                });
            }
        });
        return items;
    }

    function addToCart(product, event) {
        const id = product.id;
        const available = getAvailableStock(id);
        if (available <= 0) return;

        const existing = cart.get(id);
        if (existing) {
            existing.quantity += 1;
        } else {
            cart.set(id, {
                ...product,
                quantity: 1,
                initialStock: product.initialStock != null ? Number(product.initialStock) : parseInt(document.querySelector(`[data-product-id="${id}"]`)?.getAttribute('data-stock') || '0', 10),
            });
        }
        renderCart();
        syncAllProductCards();

        // Show success feedback
        const addBtn = event?.target?.closest?.('.add-to-cart-btn') || event?.target;
        if (addBtn) {
            addBtn.classList.add('scale-125', 'bg-green-500');
            setTimeout(() => {
                addBtn.classList.remove('scale-125', 'bg-green-500');
            }, 200);
        }
    }

    productCards.forEach(card => {
        const addBtn = card.querySelector('[data-action="add-to-cart"]');
        if (!addBtn) return;

        addBtn.addEventListener('click', (e) => {
            const id = card.getAttribute('data-product-id');
            const name = card.getAttribute('data-display-name') || 'ပစ္စည်း';
            const price = parseFloat(card.getAttribute('data-price') || '0');
            const initialStock = parseInt(card.getAttribute('data-stock') || '0', 10);

            if (!id) return;

            addToCart({ id, name, price, initialStock }, e);
        });
    });

    cartItemsContainer.addEventListener('click', (event) => {
        const target = event.target;
        if (!(target instanceof HTMLElement)) return;

        const button = target.closest('button[data-cart-action]');
        if (!button) return;

        const action = button.getAttribute('data-cart-action');
        const id = button.getAttribute('data-product-id');
        if (!id || !action) return;

        const item = cart.get(id);
        if (!item) return;

        if (action === 'increment') {
            const initialStock = item.initialStock != null ? Number(item.initialStock) : 0;
            if (initialStock - item.quantity <= 0) return; // no more stock
            item.quantity += 1;
        } else if (action === 'decrement') {
            item.quantity -= 1;
            if (item.quantity <= 0) {
                cart.delete(id);
            }
        } else if (action === 'remove') {
            cart.delete(id);
        }

        renderCart();
        syncAllProductCards();
    });

    if (clearCartBtn) {
        clearCartBtn.addEventListener('click', () => {
            cart.clear();
            renderCart();
            syncAllProductCards();
        });
    }

    if (checkoutBtn) {
        const checkoutUrl = checkoutBtn.getAttribute('data-checkout-url');
        checkoutBtn.addEventListener('click', async () => {
            if (!cart.size) {
                alert('စျေးဝယ်ခြင်း ထဲတွင် ပစ္စည်းမရှိပါ။ ပစ္စည်းထည့်ပြီးမှ ဆက်လက်သွားပါ။');
                return;
            }

            if (!checkoutUrl) {
                alert('Checkout လင့်ခ် မသတ်မှတ်ရသေးပါ။');
                return;
            }

            const items = getCartItemsPayload();
            if (!items.length) {
                alert('စျေးဝယ်ခြင်း ထဲတွင် ပစ္စည်းမရှိပါ။ ပစ္စည်းထည့်ပြီးမှ ဆက်လက်သွားပါ။');
                return;
            }

            const csrfToken = document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute('content');

            if (!csrfToken) {
                alert('CSRF token မတွေ့ပါ။ စာမျက်နှာကို ပြန်လည်ဖွင့်၍ ထပ်စမ်းကြည့်ပါ။');
                return;
            }

            const originalCheckoutHtml = checkoutBtn.innerHTML;
            checkoutBtn.disabled = true;
            checkoutBtn.innerHTML = `
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                ဆောင့်ပါ...
            `;

            try {
                const response = await fetch(checkoutUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json, text/html',
                    },
                    body: JSON.stringify({ items }),
                });

                if (response.redirected) {
                    window.location.href = response.url;
                    return;
                }

                if (!response.ok) {
                    throw new Error('ထပ်မံကြိုးစားကြည့်ပါ။');
                }

                window.location.reload();
            } catch (error) {
                console.error(error);
                alert(error.message || 'Checkout မအောင်မြင်ပါ။ ထပ်မံကြိုးစားကြည့်ပါ။');
            } finally {
                checkoutBtn.disabled = false;
                checkoutBtn.innerHTML = originalCheckoutHtml;
            }
        });
    }

    renderCart();
    syncAllProductCards();
})();

function filterByCategory(categoryId) {
    const productCards = document.querySelectorAll('[data-product-id]');
    productCards.forEach(card => {
        const cardCategory = card.getAttribute('data-category-id');
        if (categoryId === 'all' || cardCategory === categoryId) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}

// Removed toggleDarkMode function as dark mode is not used


</script>
@endsection