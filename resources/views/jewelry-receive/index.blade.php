@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">
  <!-- Header -->
  <header class="sticky top-0 z-20 flex items-center justify-between gap-4 px-4 py-3 bg-white/80 backdrop-blur-xl border-b border-slate-200/50 shadow-sm">
    <div class="flex items-center gap-3">
      <button id="sidebar-open" class="lg:hidden p-2.5 rounded-xl text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-200" aria-label="Open menu">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
      <div class="flex items-center gap-2">
        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-amber-500 to-yellow-600 flex items-center justify-center shadow-md">
          <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        </div>
        <h1 class="text-xl font-bold bg-gradient-to-r from-amber-600 to-yellow-600 bg-clip-text text-transparent">ပစ္စည်းလက်ခံစာရင်း</h1>
      </div>
    </div>
    
    <div class="flex items-center gap-2">
        <div class="w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center text-white font-medium text-sm">A</div>
      </div>
  </header>

  <main class="p-4 sm:p-6 lg:p-8" >
    <div class="max-w-7xl mx-auto" x-data="{ showModal: false }">
        <!-- Alert Messages -->
        @if (session('success'))
          <div class="rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm mb-6 flex items-center gap-2 shadow-sm" id="success-alert">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
            <button onclick="this.parentElement.remove()" class="ml-auto text-emerald-600 hover:text-emerald-800">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        @endif

        @if ($errors->any())
          <div class="rounded-xl bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm mb-6 shadow-sm" id="error-alert">
            <ul class="list-disc list-inside space-y-1">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        @php
          use Illuminate\Support\Carbon;

          $receivesCollection = $receives instanceof \Illuminate\Pagination\AbstractPaginator
            ? collect($receives->items())
            : collect($receives);

          $todayCount = $receivesCollection->filter(function ($r) {
            if (empty($r->receive_date)) return false;
            return Carbon::parse($r->receive_date)->isToday();
          })->count();

          $totalValue = (float) $receivesCollection->sum(function ($r) {
            return (float) ($r->total_value ?? 0);
          });

          $totalItems = (int) $receivesCollection->sum(function ($r) {
            return (int) ($r->items_count ?? $r->total_items ?? 0);
          });

          $customerCount = (int) $receivesCollection
            ->map(function ($r) {
              $phone = trim((string) ($r->customer_phone ?? ''));
              if ($phone !== '') return $phone;
              return trim((string) ($r->customer_name ?? ''));
            })
            ->filter(fn ($v) => $v !== '')
            ->unique()
            ->count();
        @endphp

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

          <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-slate-500">ဖောက်သည်ဦးရေ</p>
                <p class="text-2xl font-bold text-slate-900 mt-1" id="customer-count">{{ number_format($customerCount) }}</p>
              </div>
              <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
              </div>
            </div>
          </div>
          <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-slate-500">ယနေ့လက်ခံမှု</p>
                <p class="text-2xl font-bold text-slate-900 mt-1" id="today-count">{{ number_format($todayCount) }}</p>
              </div>
              <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
              </div>
            </div>
          </div>
          
          <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-slate-500">စုစုပေါင်းပစ္စည်း</p>
                <p class="text-2xl font-bold text-slate-900 mt-1" id="total-items-display">{{ number_format($totalItems) }}</p>
              </div>
              <div class="w-12 h-12 rounded-2xl bg-purple-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                </svg>
              </div>
            </div>
          </div>

          <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-slate-500">စုစုပေါင်းတန်ဖိုး</p>
                <p class="text-2xl font-bold text-slate-900 mt-1" id="total-value-display">{{ number_format($totalValue) }} ကျပ်</p>
              </div>
              <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
              </div>
            </div>
          </div>
        </div>
        

        <!-- Actions Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
          <div class="flex flex-col sm:flex-row gap-3">
            <!-- Search Box -->
            <div class="relative sm:w-80">
              <form method="GET" action="{{ route('jewelry-receive.index') }}" class="w-full" id="search-form">
                <input
                  type="search"
                  name="search"
                  value="{{ request('search') }}"
                  placeholder="အမည် သို့မဟုတ် ဖုန်းနံပါတ်ဖြင့် ရှာရန်..."
                  class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 pl-10 text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all"
                  id="search-input"
                >
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"/>
                </svg>
              </form>
            </div>

            <!-- Filter Buttons -->
            <div id="dataFilter"class="flex gap-2">
              <button 
                onclick="filterByDate('today')" 
                class="px-4 py-2 rounded-xl border text-sm font-medium transition-all
                  {{ (request('filter') === 'today') 
                    ? 'bg-amber-50  border-amber-300 text-amber-700 '
                    : 'bg-white border-slate-200 text-slate-600 hover:bg-amber-50 hover:border-amber-300' 
                  }}
                ">
                ယနေ့
              </button>
              <button 
                onclick="filterByDate('week')" 
                class="px-4 py-2 rounded-xl border text-sm font-medium transition-all
                  {{ (request('filter') === 'week') 
                    ? 'bg-amber-50 border-amber-300 text-amber-700 ' 
                    : 'bg-white border-slate-200 text-slate-600 hover:bg-amber-50 hover:border-amber-300' 
                  }}
                ">
                ယခုအပတ်
              </button>
              <button 
                onclick="filterByDate('month')" 
                class="px-4 py-2 rounded-xl border text-sm font-medium transition-all
                  {{ (request('filter') === 'month') 
                    ? 'bg-amber-50 border-amber-300 text-amber-700 ' 
                    : 'bg-white border-slate-200 text-slate-600 hover:bg-amber-50 hover:border-amber-300' 
                  }}
                ">
                ယခုလ
              </button>
            </div>   
          </div>

          <!-- Add New Button -->
          <div class="flex flex-row gap-3">
            <!-- Export Button -->
            <a
              href="#"
              onclick="exportToExcel()"
              class="inline-flex items-center justify-center rounded-xl bg-emerald-600 hover:bg-emerald-500 px-4 py-2.5 text-sm font-medium text-white shadow-md hover:shadow-lg transition-all transform hover:scale-105"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4h16v6H4zM4 14h16v6H4zM10 8h4M10 18h4"/>
              </svg>
              <span>Excel ထုတ်မည်</span>
            </a>
            <button
              @click="showModal = true"
              class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-amber-500 to-yellow-600 hover:from-amber-600 hover:to-yellow-700 px-5 py-2.5 text-sm font-medium text-white shadow-md hover:shadow-lg transition-all transform hover:scale-105"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
              </svg>
              <span>ပစ္စည်းလက်ခံမည်</span>
            </button>
          </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden mb-6">
          <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
              <thead>
                <tr class="bg-gradient-to-r from-slate-100 to-slate-50 border-b border-slate-200 text-slate-700">
                  <th class="px-4 py-4 font-semibold text-left">စဉ်</th>
                  <th class="px-4 py-4 font-semibold text-left">ရက်စွဲ</th>
                  <th class="px-4 py-4 font-semibold text-left">အမည်</th>
                  <th class="px-4 py-4 font-semibold text-left">ဖုန်းနံပါတ်</th>
                  <th class="px-4 py-4 font-semibold text-left">ပစ္စည်းအရေအတွက်</th>
                  <th class="px-4 py-4 font-semibold text-right">စုစုပေါင်းတန်ဖိုး</th>
                  <th class="px-4 py-4 font-semibold text-center">အခြေအနေ</th>
                  <th class="px-4 py-4 font-semibold text-center">လုပ်ဆောင်ချက်</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100" id="table-body">
                @forelse ($receives as $receive)
                  <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-4 py-3 text-slate-600">
                      {{ ($receives->currentPage() - 1) * $receives->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-4 py-3 text-slate-600">
                      {{ optional($receive->receive_date)->format('d-m-Y') }}
                    </td>
                    <td class="px-4 py-3 font-medium text-slate-800">{{ $receive->customer_name }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $receive->customer_phone }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ (int) ($receive->items_count ?? $receive->total_items ?? 0) }} ခု</td>
                    <td class="px-4 py-3 text-right font-medium text-slate-800">{{ number_format((float) ($receive->total_value ?? 0)) }} ကျပ်</td>
                    <td class="px-4 py-3 text-center">
                      @php($isReceived = ($receive->status ?? 'received') === 'received')
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $isReceived ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                        {{ $isReceived ? 'လက်ခံပြီး' : 'ဆိုင်းငံ့' }}
                      </span>
                    </td>
                    <td class="px-4 py-3">
                      <div class="flex items-center justify-center gap-2">
                        <a href="{{ route('jewelry-receive.show', $receive->id) }}" class="p-1.5 rounded-lg hover:bg-blue-50 text-blue-600 transition-colors" title="ကြည့်ရန်">
                          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                          </svg>
                        </a>
                        <button onclick="deleteRecord({{ $receive->id }})" class="p-1.5 rounded-lg hover:bg-red-50 text-red-600 transition-colors" title="ဖျက်ရန်">
                          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                          </svg>
                        </button>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="8" class="px-4 py-10 text-center text-slate-500">
                      မှတ်တမ်းမရှိသေးပါ။
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
          {{ $receives->links() }}
        </div>

        <!-- Include the modal form component (must be inside x-data scope) -->
        @include('partials.jewelry-receive-modal')
      </div>
  </main>
</div>

@push('scripts')
<script>
// Update datetime
function updateDateTime() {
    const now = new Date();
    const options = { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric', 
        hour: '2-digit', 
        minute: '2-digit' 
    };
    document.getElementById('current-datetime').textContent = now.toLocaleDateString('my-MM', options);
}
updateDateTime();
setInterval(updateDateTime, 60000);

// Search with debounce
let searchTimeout;
document.getElementById('search-input').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        document.getElementById('search-form').submit();
    }, 500);
});

// Filter by date
function filterByDate(period) {
    window.location.href = "{{ route('jewelry-receive.index') }}?filter=" + period;
}

// Export to Excel (respect current filters/search)
function exportToExcel() {
    const baseUrl = "{{ route('jewelry-receive.export') }}";
    const currentParams = new URLSearchParams(window.location.search || '');
    const query = currentParams.toString();

    window.location.href = query ? `${baseUrl}?${query}` : baseUrl;
}

// View Details
function viewDetails(id) {
    window.location.href = "/jewelry-receive/" + id;
}

// Edit Record
function editRecord(id) {
    window.location.href = "/jewelry-receive/" + id + "/edit";
}

// Delete Record with confirmation
function deleteRecord(id) {
    if (confirm('ဤမှတ်တမ်းကို ဖျက်မည် သေချာပါသလား?')) {
        // Create a form to submit DELETE request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/jewelry-receive/' + id;
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        form.appendChild(csrfInput);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    }
}

</script>
@endpush
@endsection