@extends('layouts.app')

@section('content')
<div class="">
  <header class="sticky top-0 z-20 flex items-center justify-between gap-4 px-4 py-3 bg-white/95 backdrop-blur border-b border-slate-200">
    <button id="sidebar-open" class="lg:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-900" aria-label="Open menu">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
    </button>
    <h1 class="text-lg font-semibold text-slate-900 truncate">Out of Stock Items</h1>
    <div class="flex items-center gap-2">
      {{-- Remove dark mode toggle button --}}
      <div class="w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center text-white font-medium text-sm">A</div>
    </div>
  </header>

  <main class="p-4 sm:p-6">
    <div class="max-w-6xl mx-auto">

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

      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
        <div class="flex flex-col sm:flex-row gap-3">
          
          <form method="GET" action="{{ route('out-of-stock') }}" class="w-full sm:w-auto">
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
                  href="{{ route('out-of-stock') }}"
                  class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 hover:bg-slate-50"
                >
                  Clear
                </a>
              @endif
            </div>
          </form>
          
          <div class="relative w-full sm:max-w-xs">
            <form method="GET" action="{{ route('out-of-stock') }}" class="w-full">
              <input
                type="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="အမည်ဖြင့်ရှာရန်..."
                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2 pr-10 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
              >
              @if(request()->filled('category_id'))
                <input type="hidden" name="category_id" value="{{ request('category_id') }}">
              @endif
              <button type="submit" class="absolute inset-y-0 right-3 flex items-center text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"/>
                </svg>
              </button>
            </form>
          </div>
          
        </div>

        <div class="flex flex-row gap-3">
          <a
            href="{{ route('out-of-stock.export', request()->only('category_id', 'search')) }}"
            class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-500 shadow-sm"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 4h16v6H4zM4 14h16v6H4zM10 8h4M10 18h4"/>
            </svg>
            <span>Export Excel</span>
          </a>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <div class="overflow-x-auto">
          <table class="min-w-full text-sm">
            <thead>
              <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-left">
                <th class="px-4 py-3 font-semibold">No</th>
                <th class="px-4 py-3 font-semibold">Product Name</th>
                <th class="px-4 py-3 font-semibold">Category</th>
                <th class="px-4 py-3 font-semibold text-right">Purchase Price</th>
                <th class="px-4 py-3 font-semibold text-right">Selling Price</th>
                <th class="px-4 py-3 font-semibold text-right">Stock</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              @forelse($products as $product)
                <tr class="hover:bg-slate-50">
                  <td class="px-4 py-3 font-medium text-slate-900">{{ $loop->iteration }}</td>
                  <td class="px-4 py-3 text-slate-900">{{ $product->name }}</td>
                  <td class="px-4 py-3 text-slate-700">{{ optional($product->category)->name ?? '-' }}</td>
                  <td class="px-4 py-3 text-right text-slate-900">
                    {{ isset($product->purchase_price) ? '$' . number_format($product->purchase_price, 2) : '-' }}
                  </td>
                  <td class="px-4 py-3 text-right text-slate-900">
                    {{ isset($product->price) ? '$' . number_format($product->price, 2) : '-' }}
                  </td>
                  <td class="px-4 py-3 text-right text-red-600 font-semibold">
                    {{ $product->stock ?? 0 }}
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="px-4 py-10 text-center text-slate-500">
                    All products currently have stock.
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
</div>
@endsection

