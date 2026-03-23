@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">
    <!-- Header -->
    <header class="sticky top-0 z-20 flex items-center justify-between gap-4 px-4 py-3 bg-white/80 backdrop-blur-xl border-b border-slate-200/60 shadow-sm">
        <div class="flex items-center gap-2">
            <button id="sidebar-open" class="lg:hidden p-2.5 rounded-xl text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-200" aria-label="Open menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-md">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h1 class="text-xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">အရောင်းအသေးစိတ်</h1>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <!-- Dark Mode Toggle Removed -->

            <!-- User Avatar -->
            <div class="relative group">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm shadow-md cursor-pointer hover:shadow-lg transition-all duration-200 group-hover:scale-105">
                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="absolute right-0 mt-2 w-48 py-2 bg-white rounded-xl shadow-xl border border-slate-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                    <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-600">Profile</a>
                    <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-600">Settings</a>
                    <hr class="my-2 border-slate-200">
                    <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="p-4 sm:p-6 lg:p-8">
        <div class="max-w-6xl mx-auto space-y-6">
            <!-- Back Button & Title -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="space-y-2">
                    <a
                        href="{{ route('sale-items.index') }}"
                        class="inline-flex items-center gap-2 text-slate-600 hover:text-indigo-600 transition-colors duration-200 group"
                    >
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span>နောက်သို့</span>
                    </a>
                    
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                Invoice #{{ $transaction->invoice_number }}
                            </h2>
                            <p class="text-sm text-slate-500 flex items-center gap-2 mt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ optional($transaction->created_at)->format('Y-m-d H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 text-emerald-700 px-4 py-2 text-sm font-medium">
                        <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                        {{ $transaction->status ?? 'Finished' }}
                    </span>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                

                <!-- Total Amount Card -->
                
            </div>

            <!-- Items Table Card -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-slate-200/60 overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                <!-- Table Header with Title -->
                <div class="px-6 py-4 border-b border-slate-200 bg-gradient-to-r from-indigo-50 to-purple-50">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            ဝယ်ယူခဲ့သောပစ္စည်းများ
                        </h3>
                        <span class="text-sm text-slate-500">
                            {{ $transaction->items->count() }} items
                        </span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-slate-200">
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-indigo-600 uppercase tracking-wider">ပစ္စည်း</th>
                                <th class="px-6 py-3.5 text-right text-xs font-semibold text-indigo-600 uppercase tracking-wider">ဈေးနှုန်း</th>
                                <th class="px-6 py-3.5 text-right text-xs font-semibold text-indigo-600 uppercase tracking-wider">ပမာဏ</th>
                                <th class="px-6 py-3.5 text-right text-xs font-semibold text-indigo-600 uppercase tracking-wider">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($transaction->items as $index => $item)
                                <tr class="hover:bg-indigo-50/50 transition-colors duration-150 group">
                                    <td class="px-6 py-3">
                                        <div class="flex items-center gap-3">
                                            <span class="w-6 h-6 rounded-full bg-slate-100 group-hover:bg-indigo-100 flex items-center justify-center text-xs font-medium text-slate-600">
                                                {{ $index + 1 }}
                                            </span>
                                            <span class="font-medium text-slate-900">
                                                {{ $item->product_name }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 text-right">
                                        <span class="text-slate-700 font-mono">
                                            {{ number_format((float) ($item->price ?? 0), 0) }}
                                            <span class="text-xs text-slate-500 ml-1">MMK</span>
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-right">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-slate-100 text-slate-700">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a3 3 0 01-3-3V6a3 3 0 013-3z"/>
                                            </svg>
                                            {{ (int) ($item->qty ?? 0) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-right">
                                        <span class="font-bold text-indigo-600">
                                            {{ number_format((float) ($item->subtotal ?? 0), 0) }}
                                            <span class="text-xs font-normal text-slate-500 ml-1">MMK</span>
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-3">
                                            <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                            </svg>
                                            <p class="text-slate-500 font-medium">ပစ္စည်းများ မရှိပါ</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-gradient-to-r from-indigo-50 to-purple-50">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-right text-slate-600 font-semibold">
                                    စုစုပေါင်း
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-lg font-bold text-indigo-600">
                                        {{ number_format((float) ($transaction->total_amount ?? 0), 0) }}
                                        <span class="text-sm font-normal text-slate-500 ml-1">MMK</span>
                                    </span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3">
                <button
                    onclick="window.print()"
                    class="inline-flex items-center gap-2 rounded-xl bg-slate-100 px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-200 transition-all duration-200"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    <span>ပရင့်ထုတ်မည်</span>
                </button>
                <a
                    href="{{ route('sale-items.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-indigo-700 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>စာရင်းသို့ပြန်သွားမည်</span>
                </a>
            </div>
        </div>
    </main>
</div>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .fade-in {
        animation: fadeIn 0.5s ease-out;
    }

    /* Print styles */
    @media print {
        header, .print\\:hidden, button, a {
            display: none !important;
        }
        body {
            background: white;
        }
    }
</style>

<script>
    // toggleDarkMode removed

    // Add animation class to cards on load
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.bg-white\\/80');
        cards.forEach((card, index) => {
            card.style.animation = `fadeIn 0.5s ease-out ${index * 0.1}s forwards`;
            card.style.opacity = '0';
        });
    });
</script>
@endsection