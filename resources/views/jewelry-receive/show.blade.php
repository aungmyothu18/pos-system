@extends('layouts.app')

@section('content')
<div class="min-h-screen p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
        <!-- ခေါင်းစဉ်နှင့် လုပ်ဆောင်ချက်များ -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-amber-100 rounded-2xl shadow-sm">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-amber-600 to-amber-500 bg-clip-text text-transparent">
                        ရွှေလက်ခံမှတ်တမ်း
                    </h1>
                </div>
            </div>
            <div class="flex gap-2">
            <a href="{{ route('jewelry-receive.index') }}" class="group flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 text-white border-2 border-slate-200 text-slate-700 hover:border-amber-300 transition-all duration-200 shadow-sm hover:shadow">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                ပရင့်ထုတ်မည်
</a>
                <a href="{{ route('jewelry-receive.index') }}" class="group flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white border-2 border-slate-200 text-slate-700 hover:border-amber-300 transition-all duration-200 shadow-sm hover:shadow">
                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>နောက်သို့</span>
                </a>
            </div>
        </div>
        <div class="flex justify-between">
            <div class="flex items-center gap-2 mb-6 text-sm">
                <span class="px-3 py-1 bg-white rounded-full text-slate-600 shadow-sm border border-slate-200">
                    📅 {{ optional($receive->receive_date)->format('d-m-Y') }}
                </span>
                <span class="px-3 py-1 bg-white rounded-full text-slate-600 shadow-sm border border-slate-200">
                    👤 {{ $receive->customer_name }}
                </span>
                <span class="px-3 py-1 bg-white rounded-full text-slate-600 shadow-sm border border-slate-200">
                    📞 {{ $receive->customer_phone }}
                </span>
            </div>
            <div class="flex flex-row gap-2">
                    <form method="POST" action="{{ route('jewelry-receive.destroy', $receive->id) }}" onsubmit="return confirm('ဤမှတ်တမ်းကို ဖျက်မည် သေချာပါသလား?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex items-center gap-2 px-3 py-1 rounded-xl bg-gradient-to-r from-red-600 to-red-500 hover:from-red-500 hover:to-red-400 text-white shadow-lg shadow-red-500/20 hover:shadow-xl hover:shadow-red-500/30 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <span>ဖျက်မည်</span>
                        </button>
                    </form>
            </div>
    </div>

        <!-- ပစ္စည်းများစာရင်း -->
        <div class="bg-white rounded-2xl border-2 border-slate-200 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
            <div class="px-6 py-4 border-b-2 border-slate-200 bg-gradient-to-r from-slate-100 to-slate-50">
                <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    ပစ္စည်းများ
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">စဉ်</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">အမျိုးအစား</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">အလေးချိန်</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">အရောင်</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">စျေးနှုန်း</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">မှတ်ချက်</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($receive->items as $it)
                            <tr class="hover:bg-slate-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                    <span class="flex items-center justify-center w-6 h-6 text-slate-600 rounded-lg text-xs">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    <span class="px-3 py-1 bg-slate-100 rounded-lg">
                                        {{ $it->type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    <span class="font-mono">
                                        {{ $it->kyat ?? 0 }}ကျပ် {{ $it->pae ?? 0 }}ပဲ {{ $it->yway ?? 0 }}ရွေး {{ $it->point ?? 0 }}ပွိုင့်
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    <span class="px-3 py-1 rounded-lg" style="background-color: {{ $it->color }}20; color: {{ $it->color }}">
                                        {{ $it->color }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-mono font-semibold text-emerald-600">
                                    {{ number_format((float) ($it->price ?? 0)) }} ကျပ်
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    @if($it->remark)
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                            </svg>
                                            {{ $it->remark }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        @if($receive->items->isEmpty())
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <p class="text-slate-500">ပစ္စည်းမရှိပါ။</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            
            <!-- စုစုပေါင်း အောက်ခြေမှတ်ချက် -->
            <div class="px-20 py-4 border-t-2 border-slate-200 bg-slate-100">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-slate-600">
                        <span class="font-semibold">စုစုပေါင်းပစ္စည်း:</span> {{ $receive->items->count() }} ခု
                    </div>
                    <div class="text-sm text-slate-600">
                        <span class="text-emerald-600 font-bold">{{ ($receive->status ?? 'received') === 'received' ? '✓ လက်ခံပြီး' : '⏳ ဆိုင်းငံ့' }}</span>
                    </div>
                    <div class="text-sm text-slate-600">
                        <span class="font-semibold">စုစုပေါင်းတန်ဖိုး:</span> 
                        <span class="text-emerald-600 font-bold">{{ number_format((float) ($receive->total_value ?? 0)) }} ကျပ်</span>
                    </div>
                </div>
            </div>
            <!-- မှတ်ချက် -->
        @if(!empty($receive->overall_note))
        <div class="px-6 py-4 border-t-2 border-slate-200 bg-slate-50">
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-slate-500 mb-2">မှတ်ချက်</p>
                        <p class="text-slate-800 whitespace-pre-line leading-relaxed">{{ $receive->overall_note }}</p>
                    </div>
                </div>
            </div>
        @endif
        </div>

        <!-- Decorative Footer -->
        <div class="mt-6 text-center text-xs text-amber-400">
            <p>© 2024 လက်ဝတ်ရတနာဆိုင် - ရွှေလက်ခံမှတ်တမ်း</p>
        </div>
    </div>
</div>
@endsection