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
                <h1 class="text-xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">အရောင်းစာရင်း</h1>
            </div>
        </div>

        <div class="flex items-center gap-2">      
            <div class="flex items-center gap-2">
        <div class="w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center text-white font-medium text-sm">A</div>
      </div>            
            
        </div>
    </header>

    <!-- Main Content -->
    <main class="p-4 sm:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto space-y-6" id="sale-items">
            <!-- Alert Messages -->
            @if (session('success'))
                <div class="animate-slide-down rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm flex items-center gap-3 shadow-lg">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error') || $errors->any())
                <div class="animate-slide-down rounded-xl bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm flex items-center gap-3 shadow-lg">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        @if (session('error'))
                            <p>{{ session('error') }}</p>
                        @endif
                        @if ($errors->any())
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="space-y-1">
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        အရောင်းမှတ်တမ်းများ
                    </h2>
                    <div class="flex items-center gap-2 text-sm my-2">
                        <span class="px-3 py-1 bg-white rounded-full text-slate-600 shadow-sm border border-slate-200">
                          <svg class="inline w-4 h-4 mr-1 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                          </svg>
                          စုစုပေါင်း {{ $transactions->total() }} ခု
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Search Box -->
                    <div class="relative group">
                        <input
                            type="search"
                            id="sales-search"
                            placeholder="Invoice / product ရှာရန်..."
                            class="w-64 sm:w-72 rounded-xl border-2 border-slate-200 bg-white px-4 py-2.5 pl-10 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent placeholder-slate-400 transition-all duration-200 group-hover:border-indigo-300"
                        >
                        <svg class="absolute left-3 top-3 w-4 h-4 text-slate-400 group-hover:text-indigo-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    
                    <!-- Export Button -->
                    <button
                        type="button"
                        onclick="exportSalesCsv()"
                        class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 px-4 py-2.5 text-sm font-medium text-white hover:from-emerald-500 hover:to-teal-500 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M4 4h16v4H4V4zm0 16h16v-8H4v8z"/>
                        </svg>
                        <span>Export CSV</span>
                    </button>
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-slate-200/60 overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                    <table class="min-w-full text-sm" id="salesTable">
                        <thead>
                            <tr class="bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-slate-200">
                                <th class="px-4 py-3.5 text-center text-xs font-semibold text-indigo-600 uppercase tracking-wider">စဥ်</th>
                                <th class="px-4 py-3.5 text-left text-xs font-semibold text-indigo-600 uppercase tracking-wider">နေ့စွဲ</th>
                                <th class="px-4 py-3.5 text-left text-xs font-semibold text-indigo-600 uppercase tracking-wider">Invoice</th>
                                <th class="px-4 py-3.5 text-left text-xs font-semibold text-indigo-600 uppercase tracking-wider">ပစ္စည်း</th>
                                <th class="px-4 py-3.5 text-right text-xs font-semibold text-indigo-600 uppercase tracking-wider">စုစုပေါင်း</th>
                                <th class="px-4 py-3.5 text-left text-xs font-semibold text-indigo-600 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3.5 text-center text-xs font-semibold text-indigo-600 uppercase tracking-wider">လုပ်ဆောင်ချက်</th>
                            </tr>
                        </thead>
                        <tbody id="salesList" class="divide-y divide-slate-100">
                            @forelse($transactions as $transaction)
                                @php
                                    $itemsText = $transaction->items->map(function ($it) {
                                        return trim(($it->product_name ?? '') . ' x' . (int) ($it->qty ?? 0));
                                    })->filter()->values();
                                    $searchText = Str::lower(($transaction->invoice_number ?? '') . ' ' . $itemsText->join(' '));
                                @endphp
                                <tr class="hover:bg-indigo-50/50 transition-colors duration-150 group" data-search="{{ $searchText }}">
                                    <td class="px-4 py-3 text-center text-slate-500 whitespace-nowrap">
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 group-hover:bg-indigo-100 text-xs font-medium">
                                            {{ $loop->iteration }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-slate-600 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            {{ optional($transaction->created_at)->format('Y-m-d H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="font-mono font-medium text-indigo-600 bg-indigo-50 px-2 py-1 rounded-lg">
                                            {{ $transaction->invoice_number }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-slate-700">
                                        @if($itemsText->isEmpty())
                                            <span class="text-slate-400">-</span>
                                        @else
                                            <div class="space-y-1 max-w-xs">
                                                <div class="flex items-center gap-1 flex-wrap">
                                                    @foreach($itemsText->take(2) as $item)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-slate-100 text-xs">
                                                            {{ $item }}
                                                        </span>
                                                    @endforeach
                                                    @if($itemsText->count() > 2)
                                                        <span class="text-xs text-slate-500">
                                                            +{{ $itemsText->count() - 2 }} more
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="text-xs text-slate-500 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                                    </svg>
                                                    <span>Total Qty: {{ $transaction->items->sum('qty') }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <span class="font-bold text-lg text-slate-900">
                                            {{ number_format((float) ($transaction->total_amount ?? 0), 2) }}
                                            <span class="text-xs font-normal text-slate-500 ml-1">MMK</span>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 text-emerald-700 px-3 py-1 text-xs font-medium">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                            {{ $transaction->status ?? 'Finished' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <a
                                            href="{{ route('sale-items.show', $transaction->id) }}"
                                            class="inline-flex items-center gap-1.5 rounded-lg bg-gradient-to-r from-indigo-500 to-purple-600 px-3 py-1.5 text-xs font-medium text-white hover:from-indigo-600 hover:to-purple-700 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-3">
                                            <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <p class="text-slate-500 font-medium">အရောင်းမှတ်တမ်း မရှိသေးပါ</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>


                @if(method_exists($transactions, 'links'))
                    <div class="px-4 py-4 border-t border-slate-200 bg-slate-50/50">
                        {{ $transactions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>

<style>
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-slide-down {
        animation: slideDown 0.3s ease-out;
    }
</style>

<script>
    (function () {
        const searchInput = document.getElementById('sales-search');
        const rows = document.querySelectorAll('#salesList tr[data-search]');

        if (!searchInput || !rows.length) return;

        searchInput.addEventListener('input', function () {
            const term = String(this.value || '').toLowerCase().trim();

            rows.forEach(row => {
                const haystack = (row.getAttribute('data-search') || '').toLowerCase();
                const matches = !term || haystack.includes(term);
                row.style.display = matches ? '' : 'none';
                
                // Add fade animation for filtered rows
                if (matches && term) {
                    row.style.animation = 'slideDown 0.2s ease-out';
                } else {
                    row.style.animation = '';
                }
            });
        });
    })();

    function exportSalesCsv() {
        const table = document.getElementById('salesTable');
        if (!table) return;

        // Get visible rows only
        const rows = Array.from(table.querySelectorAll('tbody tr'))
            .filter(r => r instanceof HTMLTableRowElement)
            .filter(r => r.style.display !== 'none');

        if (rows.length === 0) {
            alert('No data to export');
            return;
        }

        // Get headers
        const headers = Array.from(table.querySelectorAll('thead th')).map(th => 
            `"${(th.textContent || '').replace(/"/g, '""')}"`
        );

        // Get data rows
        const dataRows = rows.map(row => {
            const cols = Array.from(row.querySelectorAll('td')).map(cell => {
                const text = (cell.textContent || '').replace(/\s+/g, ' ').trim();
                return `"${text.replace(/"/g, '""')}"`;
            });
            return cols.join(',');
        });

        const csv = [headers.join(','), ...dataRows].join('\n');

        // Create download
        const blob = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8;' }); // Add BOM for UTF-8
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `sale-items-${new Date().toISOString().slice(0,10)}.csv`;
        document.body.appendChild(a);
        a.click();
        a.remove();
        URL.revokeObjectURL(url);
    }

    // Add smooth hover effect for table rows
    document.querySelectorAll('#salesList tr').forEach(row => {
        row.addEventListener('mouseenter', () => {
            row.classList.add('scale-[1.01]', 'shadow-sm', 'relative', 'z-10');
        });
        row.addEventListener('mouseleave', () => {
            row.classList.remove('scale-[1.01]', 'shadow-sm', 'relative', 'z-10');
        });
    });
</script>
@endsection