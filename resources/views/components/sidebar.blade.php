<aside id="sidebar" class="fixed top-0 left-0 z-40 h-full w-52 -translate-x-full lg:translate-x-0 bg-white border-r border-slate-200 flex flex-col">
    <div class="p-4 border-b border-slate-200 flex items-center justify-between">
      <a href="dashboard.html" class="font-semibold text-slate-900">POS Admin</a>
      <button id="sidebar-close" class="lg:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-900" aria-label="Close menu">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>
    <nav class="flex-1 p-3 space-y-1 overflow-y-auto">
      <a href="{{ route('dashboard') }}"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-bold
                {{ request()->routeIs('dashboard') ? 'bg-indigo-600/20 text-indigo-700' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-colors' }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
        ပင်မစာမျက်နှာ
      </a>
      <a href="{{ route('pos') }}"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-bold
                {{ request()->routeIs('pos') ? 'bg-indigo-600/20 text-indigo-700' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-colors' }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        အရောင်းကောင်တာ
      </a>
      <a href="{{ route('jewelry-receive.index') }}"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-bold
                {{ request()->routeIs('jewelry-receive.*') ? 'bg-indigo-600/20 text-indigo-700' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-colors' }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
        ရတနာပစ္စည်း လက်ခံ
      </a>
      <a href="{{ route('sale-items.index') }}"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-bold
                {{ request()->routeIs('sale-items.*') ? 'bg-indigo-600/20 text-indigo-700' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-colors' }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        အရောင်းမှတ်တမ်း  
      </a>
      <a href="{{ route('inventory') }}"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-bold
                {{ request()->routeIs('inventory') ? 'bg-indigo-600/20 text-indigo-700' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-colors' }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        ကုန်ပစ္စည်းများ
      </a>
      <a href="{{ route('out-of-stock') }}"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-bold
                {{ request()->routeIs('out-of-stock') ? 'bg-indigo-600/20 text-indigo-700' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-colors' }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13v-2a7 7 0 10-7 7h2M17 17l4 4m0 0l-4-4m4 4H15"></path>
        </svg>
        ပစ္စည်းပြတ်လပ်မှု
      </a>
      <a href="{{ route('category') }}"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-bold
                {{ request()->routeIs('category') ? 'bg-indigo-600/20 text-indigo-700' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-colors' }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2h-6m8 8h-8m8 0v6a2 2 0 01-2 2h-6m0-16H6a2 2 0 00-2 2v6m8-8v16m-8-3h8"/>
        </svg>
        အမျိုးအစားများ
      </a>

      <a href="{{ route('user-list') }}"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-bold
                {{ request()->routeIs('user-list') ? 'bg-indigo-600/20 text-indigo-700' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-colors' }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
        အသုံးပြုသူများ
      </a>
    </nav>
  </aside>