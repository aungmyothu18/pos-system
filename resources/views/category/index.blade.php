@extends('layouts.app')

@section('title', 'Category Management')

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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </div>
                <h1 class="text-xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">Category Management</h1>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <!-- (Dark Mode Toggle removed) -->
            
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
        <div class="max-w-6xl mx-auto space-y-6" id="category-page">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="space-y-1">
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        အမျိုးအစားများ
                    </h2>
                    <div class="flex items-center gap-2 text-sm my-2">
                        <span class="px-3 py-1 bg-white rounded-full text-slate-600 shadow-sm border border-slate-200">
                          <svg class="inline w-4 h-4 mr-1 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                          </svg>
                          စုစုပေါင်း {{ $categories->count() }} ခု
                        </span>
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
            @if (session('success'))
                <div class="animate-slide-down rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm flex items-center gap-3 shadow-lg">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="animate-slide-down rounded-xl bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm flex items-center gap-3 shadow-lg">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="w-1/2">
                  <h3 class="font-semibold text-slate-900 flex items-center gap-2 my-4">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        အမျိုးအစားအသစ်ထည့်ရန်
                  </h3>
                  <form method="POST" action="{{ route('category.store') }}" class="flex flex-col sm:flex-row gap-4">
                        @csrf
                        <div class="flex-1">
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="ဥပမာ - အီလက်ထရောနစ်"
                                class="w-full rounded-xl border-2 border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                required
                            >
                        </div>
                        <div class="sm:self-end">
                            <button
                                type="submit"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-semibold hover:from-indigo-700 hover:to-purple-700 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span>အသစ်ထည့်မည်</span>
                            </button>
                        </div>
                    </form>
              </div>

            <!-- Categories List Card -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-slate-200/60 overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                <!-- Table Header with Search -->
                <div class="px-6 py-4 border-b border-slate-200 bg-gradient-to-r from-indigo-50 to-purple-50">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <h3 class="font-semibold text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            အမျိုးအစားစာရင်း
                        </h3>
                        <div class="relative w-full sm:w-72">
                            <input
                                type="search"
                                id="category-search"
                                placeholder="ရှာရန်..."
                                class="w-full rounded-xl border-2 border-slate-200 bg-white px-4 py-2 pl-10 text-sm text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                            >
                            <svg class="absolute left-3 top-2.5 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-slate-200">
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-indigo-600 uppercase tracking-wider">စဥ်</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-indigo-600 uppercase tracking-wider">အမျိုးအစားအမည်</th>
                                <th class="px-6 py-3.5 text-right text-xs font-semibold text-indigo-600 uppercase tracking-wider">လုပ်ဆောင်ချက်များ</th>
                            </tr>
                        </thead>
                        <tbody id="categoryTableBody" class="divide-y divide-slate-100">
                            @forelse($categories as $category)
                                <tr class="hover:bg-indigo-50/50 transition-colors duration-150 group" data-name="{{ Str::lower($category->name) }}">
                                    <td class="px-6 py-3">
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 group-hover:bg-indigo-100 text-xs font-medium text-slate-600">
                                            {{ $loop->iteration }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                                                <span class="text-xs font-bold text-indigo-600">
                                                    {{ strtoupper(substr($category->name, 0, 2)) }}
                                                </span>
                                            </div>
                                            <span class="font-medium text-slate-900">
                                                {{ $category->name }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <!-- Edit Button -->
                                            <button
                                                type="button"
                                                class="inline-flex items-center justify-center p-2 rounded-lg bg-indigo-100 text-indigo-600 hover:bg-indigo-200 transition-all duration-200"
                                                title="Edit"
                                                onclick='openEditCategoryModal({{ $category->id }}, @json($category->name))'
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                                </svg>
                                            </button>

                                            <!-- Delete Button -->
                                            <form
                                                method="POST"
                                                action="{{ route('category.destroy', $category->id) }}"
                                                class="inline-block"
                                                onsubmit="return confirm('ဤအမျိုးအစားကို ဖျက်မှာ သေချာပါသလား？');"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center justify-center p-2 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition-all duration-200"
                                                    title="Delete"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 7h12M10 11v6m4-6v6M9 7V5a1 1 0 011-1h4a1 1 0 011 1v2m-9 0h10l-1 12H8L7 7z"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-3">
                                            <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                                            </svg>
                                            <p class="text-slate-500 font-medium">အမျိုးအစားများ မရှိသေးပါ</p>
                                            <p class="text-sm text-slate-400">အပေါ်မှ အသစ်ထည့်ရန် ခလုတ်ကို နှိပ်ပါ</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Edit Modal -->
<div id="editCategoryModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeEditCategoryModal()"></div>
    <div class="relative mx-auto mt-24 w-[92%] max-w-md animate-modal-pop">
        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200/60 overflow-hidden">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-200 bg-gradient-to-r from-indigo-50 to-purple-50 flex items-center justify-between">
                <h3 class="font-semibold text-slate-900 flex items-center gap-2" id="modal-title">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    အမျိုးအစားပြင်ဆင်ရန်
                </h3>
                <button type="button" class="p-2 rounded-lg hover:bg-slate-200 transition-colors duration-200" onclick="closeEditCategoryModal()" aria-label="Close">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <form id="editCategoryForm" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        အမျိုးအစားအမည်
                    </label>
                    <input
                        type="text"
                        id="editCategoryName"
                        name="name"
                        class="w-full rounded-xl border-2 border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                        required
                        autocomplete="off"
                    >
                </div>
                
                <!-- Modal Footer -->
                <div class="flex items-center justify-end gap-3 pt-4">
                    <button type="button" class="px-4 py-2 rounded-lg border-2 border-slate-200 text-sm font-medium text-slate-700 hover:bg-slate-50 transition-all duration-200" onclick="closeEditCategoryModal()">
                        မလုပ်တော့ပါ
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-semibold hover:from-indigo-700 hover:to-purple-700 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                        သိမ်းမည်
                    </button>
                </div>
            </form>
        </div>
    </div>
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

    @keyframes modalPop {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    .animate-modal-pop {
        animation: modalPop 0.2s ease-out;
    }
</style>

<script>
    const categoryUpdateUrlTemplate = @json(route('category.update', ['id' => 0]));

    function openEditCategoryModal(id, name) {
        const modal = document.getElementById('editCategoryModal');
        const form = document.getElementById('editCategoryForm');
        const input = document.getElementById('editCategoryName');

        if (!modal || !form || !input) return;

        form.action = categoryUpdateUrlTemplate.replace(/0$/, String(id));
        input.value = name || '';
        modal.classList.remove('hidden');
        
        // Focus input after modal opens
        setTimeout(() => {
            input.focus();
            input.select();
        }, 100);
    }

    function closeEditCategoryModal() {
        const modal = document.getElementById('editCategoryModal');
        if (!modal) return;
        modal.classList.add('hidden');
    }

    // Search functionality
    (function () {
        const searchInput = document.getElementById('category-search');
        const rows = document.querySelectorAll('#categoryTableBody tr[data-name]');

        if (!searchInput || !rows.length) return;

        searchInput.addEventListener('input', function () {
            const term = (this.value || '').toLowerCase().trim();
            
            rows.forEach(row => {
                const name = row.getAttribute('data-name') || '';
                const matches = !term || name.includes(term);
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

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeEditCategoryModal();
        }
    });

    // (Dark mode toggle function removed)
</script>
@endsection