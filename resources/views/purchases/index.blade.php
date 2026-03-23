@extends('layouts.app')

@section('content')
<div class="">
    <header class="sticky top-0 z-20 flex items-center justify-between gap-4 px-4 py-3 bg-white/95 dark:bg-slate-900/95 backdrop-blur border-b border-slate-200 dark:border-slate-700/50">
      <button id="sidebar-open" class="lg:hidden p-2 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white" aria-label="Open menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
      </button>
      <h1 class="text-lg font-semibold text-slate-900 dark:text-white truncate">POS</h1>
      <div class="flex items-center gap-2">
        <button type="button" onclick="toggleDarkMode()" class="p-2 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors" aria-label="Toggle dark mode">
          <span class="dark-mode-icon-dark"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg></span>
          <span class="dark-mode-icon-light hidden"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg></span>
        </button>
        <div class="w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center text-white font-medium text-sm">A</div>
      </div>
    </header>

    <main class="p-4 sm:p-6">
      <div id="purchases" class="section">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-2">
          <form method="GET" action="{{ route('items-list') }}" class="flex items-center gap-3">
            <div>
              <label for="category-filter" class="block text-xs font-medium text-slate-500 mb-1">အမျိုးအစား</label>
              <select
                id="category-filter"
                name="category_id"
                class="rounded-lg border border-indigo-200 bg-indigo-50 text-sm px-3 py-2 focus:border-indigo-500 focus:bg-white focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                onchange="this.form.submit()"
              >
                <option value="">{{ __('အားလုံး') }}</option>
              </select>
            </div>
          </form>

          <div class="flex items-center gap-2">
            <div class="relative">
              <input
                type="search"
                id="item-search"
                placeholder="အမည်ဖြင့်ရှာရန်..."
                class="w-48 sm:w-64 rounded-lg border border-slate-200 bg-white px-3 py-2 pr-8 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
              >
              <span class="pointer-events-none absolute inset-y-0 right-2 flex items-center text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"/>
                </svg>
              </span>
            </div>

            <form id="excel-import-form" action="#" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
              @csrf
              <label class="inline-flex items-center cursor-pointer">
                <svg class="w-5 h-5 text-indigo-600 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8 17v-6h8v6m-8 0h.01M16 17v1a2 2 0 01-2 2H7a2 2 0 01-2-2v-1m14-6V5a2 2 0 00-2-2H7a2 2 0 00-2 2v6"></path>
                </svg>
                <span class="text-sm text-slate-700 dark:text-slate-200">Excel ဖြင့်ထည့်မည်</span>
                <input type="file" name="excel_file" accept=".xlsx, .xls" class="hidden" onchange="document.getElementById('excel-import-form').submit();">
              </label>
            </form>

            <button
              type="button"
              onclick="openNewInventoryItemModal()"
              class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-500 shadow-sm"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
              </svg>
              <span>အသစ်ထည့်</span>
            </button>
          </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-4 rounded-lg shadow border border-slate-200/60 dark:border-slate-700/50">
          <div class="overflow-x-auto">
            <table class="w-full" id="purchaseTable">
              <thead>
                <tr class="border-b border-slate-200 dark:border-slate-700">
                  <th class="p-2 text-left">No</th>
                  <th class="p-2 text-left">Item</th>
                  <th class="p-2 text-left">Category</th>
                  <th class="p-2 text-left">Qty</th>
                  <th class="p-2 text-left">Purchase Price</th>
                  <th class="p-2 text-left">Supplier</th>
                  <th class="p-2 text-left">Phone</th>
                  <th class="p-2 text-left">Date</th>
                </tr>
              </thead>
              <tbody id="purchaseList">
                <tr>
                  <td colspan="6" class="p-4 text-center text-slate-500 dark:text-slate-400">
                    No purchases yet.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>

    <div id="editInventoryItemModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
      <div class="bg-white rounded-xl p-6 shadow-xl w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold text-slate-900">ပြင်ဆင်ခြင်း</h3>
          <button onclick="closeEditInventoryItemModal()" class="text-slate-400 hover:text-slate-600 text-xl leading-none">&times;</button>
        </div>
        <form id="editInventoryItemForm" method="POST" action="" class="space-y-4">
          @csrf
          @method('PUT')
          <div>
            <label for="editItemName" class="block text-sm font-medium text-slate-700 mb-1">ပစ္စည်းအမည်</label>
            <input
              type="text"
              id="editItemName"
              name="name"
              required
              class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            />
          </div>
          <div>
            <label for="editItemCategory" class="block text-sm font-medium text-slate-700 mb-1">အမျိုးအစား</label>
            <select
              id="editItemCategory"
              name="category_id"
              required
              class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            >
              <option value="">{{ __('ရွေးချယ်ရန်') }}</option>
            </select>
          </div>
          <div>
            <label for="editItemPrice" class="block text-sm font-medium text-slate-700 mb-1">ဈေးနှုန်း</label>
            <input
              type="number"
              id="editItemPrice"
              name="price"
              min="0"
              step="0.01"
              required
              class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            />
          </div>
          <div class="flex justify-end gap-2 pt-2">
            <button
              type="button"
              onclick="closeEditInventoryItemModal()"
              class="px-4 py-2 rounded-lg bg-slate-100 text-slate-700 text-sm hover:bg-slate-200"
            >
              မလုပ်ပါ
            </button>
            <button
              type="submit"
              class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-500"
            >
              ပြင်မည်
            </button>
          </div>
        </form>
      </div>
    </div>
</div>
@endsection

