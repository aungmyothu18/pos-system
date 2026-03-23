@extends('layouts.app')

@section('content')
<div class="">
    <header class="sticky top-0 z-20 flex items-center justify-between gap-4 px-4 py-3 bg-white/95 backdrop-blur border-b border-slate-200">
      <button id="sidebar-open" class="lg:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-900" aria-label="Open menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
      </button>
      <h1 class="text-lg font-semibold text-slate-900 truncate">POS</h1>
      <div class="flex items-center gap-2">
        <div class="w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center text-white font-medium text-sm">A</div>
      </div>
    </header>

    <main class="p-4 sm:p-6">
      
    <div id="user-list" class="section">
                <h2 class="text-2xl font-bold mb-4">အသုံးပြုသူများ</h2>
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="overflow-x-auto">
                        <table class="w-full" id="userTable">
                            <thead>
                                <tr class="border-b">
                                    <th class="p-2">အမည်</th>
                                    <th class="p-2">အီးမေးလ်</th>
                                    <th class="p-2">အခန်းကဏ္ဍ</th>
                                    <th class="p-2">လုပ်ဆောင်ချက်</th>
                                </tr>
                            </thead>
                            <tbody id="userList"></tbody>
                        </table>
                    </div>
                </div>
            </div>
    </main>
  </div>
@endsection