@extends('layouts.app')

@section('content')
<div class="">
    <header class="sticky top-0 z-20 flex items-center justify-between gap-4 px-4 py-3 bg-white/95 backdrop-blur border-b border-slate-200">
      <button id="sidebar-open" class="lg:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-900" aria-label="Open menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
      </button>
      <h1 class="text-lg font-semibold text-slate-900 truncate">ပစ္စည်းစာရင်း  </h1>
      <div class="flex items-center gap-2">
        <!-- Removed dark-mode toggle button -->
        <div class="w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center text-white font-medium text-sm">A</div>
      </div>
    </header>

    <main class="p-4 sm:p-6">
      <div class="max-w-6xl mx-auto" id="items-list">

        @if (session('success'))
          <div class="rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm mb-4">
            {{ session('success') }}
          </div>
        @endif

        @if ($errors->any())
          <div class="rounded-lg bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm mb-4">
            <ul class="list-disc list-inside space-y-1">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <!-- Search + filters -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
          <div class="flex flex-col sm:flex-row gap-3">
            
          <form method="GET" action="{{ route('inventory') }}" class="w-full sm:w-auto">
              <div class="flex items-center gap-2">
                <select
                  name="category_id"
                  class="w-full sm:w-56 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                  onchange="this.form.submit()"
                >
                  <option value="">All Categories</option>
                  @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) request('category_id') === (string) $category->id)>
                      {{ $category->name }}
                    </option>
                  @endforeach
                </select>

                @if(request()->filled('category_id'))
                  <a
                    href="{{ route('inventory') }}"
                    class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 hover:bg-slate-50"
                  >
                    Clear
                  </a>
                @endif
              </div>
            </form>
            
            <div class="relative w-full sm:max-w-xs">
              <input
                type="search"
                id="item-search"
                placeholder="အမည်ဖြင့်ရှာရန်..."
                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2 pr-10 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
              >
              <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"/>
                </svg>
              </span>
            </div>
            
          </div>

          <div class="flex flex-row gap-3">
          <form id="excel-import-form" action="{{ route('inventory.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2 mt-2 sm:mt-0">
            <a
                href="{{ route('inventory.template') }}"
                class="ml-3 inline-flex items-center rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs sm:text-sm font-medium text-slate-700 hover:bg-slate-50"
              >
                <svg class="w-4 h-4 mr-1 text-slate-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v12m0 0l-4-4m4 4l4-4M6 20h12" />
                </svg>
                Template Download
              </a>
              @csrf
              <label class="inline-flex items-center cursor-pointer">
                <svg class="w-5 h-5 text-indigo-600 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8 17v-6h8v6m-8 0h.01M16 17v1a2 2 0 01-2 2H7a2 2 0 01-2-2v-1m14-6V5a2 2 0 00-2-2H7a2 2 0 00-2 2v6"></path>
                </svg>
                <span class="text-sm text-slate-700">Excel ဖြင့်ထည့်မည်</span>
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
              <span>အသစ်ထည့်မည်</span>
            </button>
          </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200">
          <div class="overflow-x-auto">
            <table class="min-w-full text-sm" id="inventoryTable">
              <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-left">
                  <th class="px-4 py-3 font-semibold">No</th>
                  <th class="px-4 py-3 font-semibold">Product Name</th>
                  <th class="px-4 py-3 font-semibold">Category</th>
                  <th class="px-4 py-3 font-semibold text-right">Purchase Price</th>
                  <th class="px-4 py-3 font-semibold text-right">Selling Price</th>
                  <th class="px-4 py-3 font-semibold text-right">Stock</th>
                  <th class="px-4 py-3 font-semibold text-right">Status</th>
                  <th class="px-4 py-3 font-semibold text-right">Actions</th>
                </tr>
              </thead>
              <tbody id="inventoryList" class="divide-y divide-slate-100">
                @forelse($products as $product)
                  <tr class="hover:bg-slate-50" data-name="{{ Str::lower($product->name) }}">
                    <td class="px-4 py-3 font-medium text-slate-900">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 text-slate-900">{{ $product->name }}</td>
                    <td class="px-4 py-3 text-slate-700">{{ optional($product->category)->name ?? '-' }}</td>
                    <td class="px-4 py-3 text-right text-slate-900">
                      {{ isset($product->purchase_price) ? '$' . number_format($product->purchase_price, 2) : '-' }}
                    </td>
                    <td class="px-4 py-3 text-right text-slate-900">${{ number_format($product->price, 2) }}</td>
                    <td class="px-4 py-3 text-right text-slate-900">{{ $product->stock ?? 0 }}</td>
                    <td class="px-4 py-3 text-right">
                      @php
                        $stock = $product->stock ?? 0;
                      @endphp
                      @if($stock > 10)
                        <span class="inline-block px-3 py-1 rounded-lg bg-green-100 border border-gray-500 text-xs font-semibold text-green-700">In Stock</span>
                      @elseif($stock > 0)
                        <span class="inline-block px-3 py-1 rounded-lg bg-orange-100 border border-gray-500 text-xs font-semibold text-orange-600">Low Stock</span>
                      @else
                        <span class="inline-block px-3 py-1 rounded-lg bg-red-100 border border-gray-500 text-xs font-semibold text-red-600">Out</span>
                      @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                    <button
                    type="button"
                    class="edit-item-btn inline-flex items-center justify-center p-1.5 rounded hover:bg-indigo-100 mr-2"
                    data-id="{{ $product->id }}"
                    data-name="{{ $product->name }}"
                    data-category="{{ $product->category_id }}"
                    data-purchase-price="{{ $product->purchase_price }}"
                    data-price="{{ $product->price }}"
                    data-stock="{{ $product->stock }}"
                >
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                      </button>
                      <form
                        method="POST"
                        action="{{ route('items.destroy', $product->id) }}"
                        class="inline-block"
                        onsubmit="return confirmDelete(this);"
                        style="display: inline"
                      >
                        @csrf
                        @method('DELETE')
                        <button
                          type="submit"
                          class="inline-flex items-center justify-center p-1.5 rounded hover:bg-red-100"
                          title="Delete"
                        >
                          <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 7h12M10 11v6m4-6v6M9 7V5a1 1 0 011-1h4a1 1 0 011 1v2m-9 0h10l-1 12H8L7 7z"/>
                          </svg>
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="px-4 py-10 text-center text-slate-500">
                      No products found.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

      <div class="mt-6 flex justify-center">
        {{ $products->links('pagination::tailwind') }}
      </div>

      </div>
    </main>

    <!-- New item modal -->
    <div id="newItemModal" class="fixed inset-0 z-50 hidden" aria-hidden="true">
      <div class="absolute inset-0 bg-slate-900/60" onclick="closeNewInventoryItemModal()"></div>
      <div class="relative mx-auto mt-16 w-[92%] max-w-xl">
        <div class="rounded-2xl bg-white shadow-xl border border-slate-200 overflow-hidden">
          <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200">
            <h2 class="text-base font-semibold text-slate-900">ပစ္စည်းအသစ်ထည့်မည်</h2>
            <button type="button" class="p-2 rounded-lg hover:bg-slate-100" onclick="closeNewInventoryItemModal()" aria-label="Close">
              <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>

          <form method="POST" action="{{ route('items.store') }}" class="p-5 space-y-4">
            @csrf

            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1">Product Name</label>
              <input
                type="text"
                name="name"
                required
                value="{{ old('name') }}"
                class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                placeholder="ဥပမာ - Coca Cola"
              >
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Category</label>
                <select
                  name="category_id"
                  required
                  class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                >
                  <option value="" disabled @selected(!old('category_id'))>Choose category</option>
                  @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) old('category_id') === (string) $category->id)>
                      {{ $category->name }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Stock</label>
                <input
                  type="number"
                  name="stock"
                  min="0"
                  value="{{ old('stock', 0) }}"
                  class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                  placeholder="ဥပမာ - 100"
                >
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Purchase Price</label>
                <input
                  type="number"
                  step="0.01"
                  min="0"
                  name="purchase_price"
                  required
                  value="{{ old('purchase_price') }}"
                  class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                  placeholder="ဥပမာ - 500.00"
                >
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Selling Price</label>
                <input
                  type="number"
                  step="0.01"
                  min="0"
                  name="price"
                  required
                  value="{{ old('price') }}"
                  class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                  placeholder="ဥပမာ - 600.00"
                >
              </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
              <button
                type="button"
                onclick="closeNewInventoryItemModal()"
                class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
              >
                Cancel
              </button>
              <button
                type="submit"
                class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-500 shadow-sm"
              >
                Save
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Edit item modal -->
    <div id="editItemModal" class="fixed inset-0 z-50 hidden" aria-hidden="true">
      <div class="absolute inset-0 bg-slate-900/60" onclick="closeEditInventoryItemModal()"></div>
      <div class="relative mx-auto mt-16 w-[92%] max-w-xl">
        <div class="rounded-2xl bg-white shadow-xl border border-slate-200 overflow-hidden">
          <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200">
            <h2 class="text-base font-semibold text-slate-900">ပစ္စည်းပြင်မည်</h2>
            <button type="button" class="p-2 rounded-lg hover:bg-slate-100" onclick="closeEditInventoryItemModal()" aria-label="Close">
              <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>

          <form id="editItemForm" method="POST" action="#" class="p-5 space-y-4">
            @csrf
            @method('PUT')

            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1">Product Name</label>
              <input
                type="text"
                name="name"
                required
                class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                placeholder="ဥပမာ - Coca Cola"
              >
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Category</label>
                <select
                  name="category_id"
                  required
                  class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                >
                  <option value="" disabled>Choose category</option>
                  @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                  @endforeach
                </select>
              </div>

              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Stock</label>
                <input
                  type="number"
                  name="stock"
                  min="0"
                  class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                  placeholder="ဥပမာ - 100"
                >
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Purchase Price</label>
                <input
                  type="number"
                  step="0.01"
                  min="0"
                  name="purchase_price"
                  required
                  class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                  placeholder="ဥပမာ - 500.00"
                >
              </div>
              <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Selling Price</label>
                <input
                  type="number"
                  step="0.01"
                  min="0"
                  name="price"
                  required
                  class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                  placeholder="ဥပမာ - 600.00"
                >
              </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
              <button
                type="button"
                onclick="closeEditInventoryItemModal()"
                class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
              >
                Cancel
              </button>
              <button
                type="submit"
                class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500 shadow-sm"
              >
                Update
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script>
      (function () {
        const searchInput = document.getElementById('item-search');
        const rows = document.querySelectorAll('#inventoryList tr[data-name]');

        if (!searchInput || !rows.length) return;

        searchInput.addEventListener('input', function () {
          const term = this.value.toLowerCase().trim();

          rows.forEach(row => {
            const name = row.getAttribute('data-name') || '';
            row.style.display = !term || name.includes(term) ? '' : 'none';
          });
        });
      })();
    </script>


    <script>
      const itemsUpdateUrlTemplate = @json(route('items.update', ['id' => 0]));

      function openNewInventoryItemModal() {
        const modal = document.getElementById('newItemModal');
        if (!modal) return;
        modal.classList.remove('hidden');
        modal.setAttribute('aria-hidden', 'false');

        const nameInput = modal.querySelector('input[name="name"]');
        if (nameInput) nameInput.focus();
      }

      function closeNewInventoryItemModal() {
        const modal = document.getElementById('newItemModal');
        if (!modal) return;
        modal.classList.add('hidden');
        modal.setAttribute('aria-hidden', 'true');
      }

      function confirmDelete() {
        return window.confirm('Delete this item?');
      }

      document.addEventListener('click', function(e) {
          if (e.target.closest('.edit-item-btn')) {
              const btn = e.target.closest('.edit-item-btn');
              
              const id = btn.dataset.id;
              const name = btn.dataset.name;
              const categoryId = btn.dataset.category;
              const purchasePrice = btn.dataset.purchasePrice;
              const price = btn.dataset.price;
              const stock = btn.dataset.stock;

              openEditInventoryItemModal(id, name, categoryId, purchasePrice, price, stock);
          }
      });

      function openEditInventoryItemModal(id, name, categoryId, purchasePrice, price, stock) {
        const modal = document.getElementById('editItemModal');
        const form = document.getElementById('editItemForm');
        if (!modal || !form) return;

        // Replace the last path segment (e.g. /0) with the actual id so multi-digit ids work
        const url = String(itemsUpdateUrlTemplate).replace(/\/[^/]+$/, '/' + id);
        form.setAttribute('action', url);

        const nameInput = modal.querySelector('input[name="name"]');
        const categorySelect = modal.querySelector('select[name="category_id"]');
        const stockInput = modal.querySelector('input[name="stock"]');
        const purchasePriceInput = modal.querySelector('input[name="purchase_price"]');
        const priceInput = modal.querySelector('input[name="price"]');

        if (nameInput) nameInput.value = name ?? '';
        if (categorySelect) categorySelect.value = String(categoryId || '');
        if (stockInput) stockInput.value = String(stock ?? 0);
        if (purchasePriceInput) purchasePriceInput.value = String(purchasePrice ?? 0);
        if (priceInput) priceInput.value = String(price ?? 0);

        modal.classList.remove('hidden');
        modal.setAttribute('aria-hidden', 'false');
        if (nameInput) nameInput.focus();
      }

      function closeEditInventoryItemModal() {
        const modal = document.getElementById('editItemModal');
        if (!modal) return;
        modal.classList.add('hidden');
        modal.setAttribute('aria-hidden', 'true');
      }

      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
          closeNewInventoryItemModal();
          closeEditInventoryItemModal();
        }
      });
    </script>
  </div>
@endsection