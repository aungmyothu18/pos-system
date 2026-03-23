{{-- resources/views/partials/jewelry-receive-modal.blade.php --}}
<!-- Modal -->
<div
    x-show="showModal"
    x-cloak
    class="fixed inset-0 flex items-center justify-center z-50 bg-black/50 backdrop-blur-sm"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    <div 
        class="bg-white rounded-2xl shadow-2xl w-full max-w-5xl max-h-[90vh] overflow-y-auto relative m-4"
        @click.away="showModal = false"
    >
        <!-- Close Button -->
        <button 
            @click="showModal = false" 
            class="absolute top-4 right-4 z-10 w-8 h-8 rounded-xl bg-white/90 backdrop-blur border border-slate-200 text-slate-500 hover:text-slate-700 hover:bg-slate-100 transition-all"
        >
            <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Form -->
        <form method="POST" action="{{ route('jewelry-receive.store') }}" class="p-5" id="jewelry-form">
            @csrf

            <!-- Form Header -->
            <div class="relative mb-4">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 w-20 h-1 bg-gradient-to-r from-amber-400 to-yellow-600 rounded-full"></div>
                <h2 class="text-xl font-bold text-center text-amber-900 mb-1">လက်ဝတ်ရတနာလက်ခံစာရင်း</h2>
                <p class="text-center text-amber-700 text-xs">ကျေးဇူးပြု၍ အချက်အလက်များ မှန်ကန်စွာ ဖြည့်သွင်းပါ</p>
            </div>
            
            <!-- Customer Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-4">
                <div class="relative">
                    <label class="block text-sm font-bold text-amber-800 mb-2 flex items-center gap-1">
                        <span class="w-2 h-2 bg-amber-500 rounded-full"></span>
                        အမည် <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" placeholder="ဥပမာ - ဒေါ်စန်းစန်း" 
                                class="w-full p-2 text-base border-2 border-amber-200 rounded-xl focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition bg-amber-50/50">
                        <div class="absolute inset-y-0 right-3 flex items-center text-amber-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <label class="block text-sm font-bold text-amber-800 mb-2 flex items-center gap-1">
                        <span class="w-2 h-2 bg-amber-500 rounded-full"></span>
                        ဖုန်းနံပါတ် <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="tel" name="customer_phone" id="customer_phone" value="{{ old('customer_phone') }}" placeholder="09xxxxxxxx" 
                                class="w-full p-2 text-base border-2 border-amber-200 rounded-xl focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition bg-amber-50/50">
                        <div class="absolute inset-y-0 right-3 flex items-center text-amber-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="mb-4">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-bold text-amber-900 flex items-center gap-2">
                        <span class="bg-amber-500 w-1 h-5 rounded-full"></span>
                        ပစ္စည်းများ
                    </h3>
                    <button type="button" id="add-item-btn" class="bg-gradient-to-r from-amber-500 to-yellow-600 hover:from-amber-600 hover:to-yellow-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition duration-300 shadow-md hover:shadow-lg flex items-center gap-2 transform hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        ပစ္စည်းအသစ်
                    </button>
                </div>

                <!-- Table Header - Responsive design with comfortable sizes -->
                <div class="bg-gradient-to-r from-amber-700 to-amber-800 text-white rounded-t-xl p-3 shadow-lg">
                    <!-- Main headers -->
                    <div class="grid grid-cols-12 gap-2 text-sm font-bold">
                        <div class="col-span-1 text-center">စဉ်</div>
                        <div class="col-span-2 text-center">အမျိုးအစား</div>
                        <div class="col-span-4 text-center">အလေးချိန်</div>
                        <div class="col-span-1 text-center">အရောင်</div>
                        <div class="col-span-2 text-center">စျေးနှုန်း</div>
                        <div class="col-span-2 text-center">မှတ်ချက်</div>
                    </div>
                    
                    <!-- Sub headers for weight -->
                    <div class="grid grid-cols-12 gap-2 text-xs mt-1">
                        <div class="col-span-3"></div>
                        <div class="col-span-4 grid grid-cols-4 gap-1 text-center">
                            <div>ကျပ်</div>
                            <div>ပဲ</div>
                            <div>ရွေး</div>
                            <div>ပွိုင့်</div>
                        </div>
                        <div class="col-span-5"></div>
                    </div>
                </div>

                <!-- Items Container -->
                <div id="items-container" class="space-y-3 mt-3">
                    <!-- Default item -->
                    @include('partials.jewellery-item', ['index' => 0, 'item' => null])
                </div>

                <!-- Add Item Hint -->
                <div class="mt-3 text-center">
                    <span class="text-xs text-amber-600 bg-amber-100 px-3 py-1 rounded-full inline-flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        ပစ္စည်းအသစ်ထည့်ရန် "ပစ္စည်းအသစ်" ခလုတ်ကို နှိပ်ပါ
                    </span>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-2 gap-3 mb-4">
                <div class="bg-amber-100 p-3 rounded-xl flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                        <span class="text-amber-800 font-medium text-sm">စုစုပေါင်းပစ္စည်း</span>
                    </div>
                    <span class="bg-amber-600 text-white px-3 py-1 rounded-full font-bold text-sm" id="total-items-modal">၁ ခု</span>
                </div>

                <div class="bg-amber-100 p-3 rounded-xl flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                        <span class="text-amber-800 font-medium text-sm">စုစုပေါင်းတန်ဖိုး</span>
                    </div>
                    <span class="bg-blue-600 text-white px-3 py-1 rounded-full font-bold text-sm" id="total-value-modal">၀ ကျပ်</span>
                </div>
            </div>

            <!-- Overall Note -->
            <div class="mb-4">
                <label class="block text-sm font-bold text-amber-800 mb-2 flex items-center gap-2">
                    <span class="w-2 h-2 bg-amber-500 rounded-full"></span>
                    အားလုံးအတွက် မှတ်ချက်
                    <span class="text-xs text-amber-600 font-normal bg-amber-100 px-2 py-0.5 rounded-full">ချန်လှပ်နိုင်သည်</span>
                </label>
                <textarea name="overall_note" id="overall_note" rows="2" placeholder="ပစ္စည်းအားလုံးအတွက် မှတ်ချက်ရေးပါ (ဥပမာ - အပ်နှံသူ၏ အထူးမှာကြားချက်)" 
                        class="w-full p-3 text-base border-2 border-amber-200 rounded-xl focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition bg-amber-50/50"></textarea>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-3 border-t-2 border-amber-200 pt-4">
                <button type="button" @click="showModal = false" class="px-5 py-2 rounded-xl border-2 border-amber-300 text-amber-700 font-medium hover:bg-amber-50 hover:border-amber-400 transition duration-300 flex items-center gap-2 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    ပိတ်မည်
                </button>
                <button type="button" onclick="resetJewelryReceiveForm()" class="px-5 py-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 text-white font-medium hover:from-amber-600 hover:to-amber-700 transition duration-300 shadow-md hover:shadow-lg flex items-center gap-2 text-sm transform hover:scale-[1.02]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    ရှင်းလင်းမည်
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-gradient-to-r from-amber-600 to-yellow-700 text-white font-medium hover:from-amber-700 hover:to-yellow-800 transition duration-300 shadow-lg hover:shadow-xl flex items-center gap-2 text-sm transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    သိမ်းဆည်းမည်
                </button>
            </div>

            <!-- Decorative Footer -->
            <div class="mt-4 text-center text-xs text-amber-400">
                <p>© 2024 လက်ဝတ်ရတနာဆိုင် - ပုံစံ (ဇယားကွက်)</p>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let jewelryReceiveItemCount = 0;

    function resetJewelryReceiveForm() {
        const form = document.getElementById('jewelry-form');
        const container = document.getElementById('items-container');
        const template = document.getElementById('item-template');
        if (!form || !container || !template) return;

        form.querySelector('#customer_name').value = '';
        form.querySelector('#customer_phone').value = '';
        form.querySelector('#overall_note').value = '';
        container.innerHTML = template.innerHTML.replace(/ITEM_INDEX/g, '0');
        jewelryReceiveItemCount = 1;
        updateSerialNumbers();
        updateTotalItems();
        calculateTotalValue();
    }

    // စာမျက်နှာ အားလုံး load ဖြစ်ပြီးမှ အလုပ်လုပ်ရန်
    document.addEventListener('DOMContentLoaded', function() {
        jewelryReceiveItemCount = document.querySelectorAll('.item-row').length;

        // Add new item
        const addBtn = document.getElementById('add-item-btn');

            addBtn.addEventListener('click', function() {
                const container = document.getElementById('items-container');
                const template = document.getElementById('item-template');
                
                // .content.firstElementChild.cloneNode(true) သုံးတာက ပိုစိတ်ချရပါတယ်
                // ဒါပေမယ့် string replacement လုပ်မှာမလို့ innerHTML ကိုပဲ သုံးပါမယ်
                let html = template.innerHTML;
                
                // ITEM_INDEX အားလုံးကို လက်ရှိ itemCount နဲ့ အစားထိုးမယ်
                const newItemHtml = html.replace(/ITEM_INDEX/g, jewelryReceiveItemCount);
                
                container.insertAdjacentHTML('beforeend', newItemHtml);
                
                jewelryReceiveItemCount++;
                updateSerialNumbers();
                updateTotalItems();
            });


        // Remove item (Event Delegation)
        document.addEventListener('click', function(e) {
            const removeBtn = e.target.closest('.remove-item-btn');
            if (removeBtn) {
                const rows = document.querySelectorAll('.item-row');
                if (rows.length > 1) {
                    removeBtn.closest('.item-row').remove();
                    updateSerialNumbers();
                    updateTotalItems();
                    calculateTotalValue();
                } else {
                    alert('အနည်းဆုံး ပစ္စည်းတစ်ခုတော့ ထားရှိရပါမည်။');
                }
            }
        });
    });

    // ကျန်တဲ့ function တွေကိုတော့ အပြင်မှာပဲ ထားလို့ရပါတယ်
    function updateSerialNumbers() {
        document.querySelectorAll('.item-row').forEach((row, index) => {
            const serialDisplay = row.querySelector('.item-serial');
            if (serialDisplay) {
                serialDisplay.textContent = index + 1;
            }
        });
    }

    function updateTotalItems() {
        const count = document.querySelectorAll('.item-row').length;
        const totalDisplay = document.getElementById('total-items-modal');
        if (totalDisplay) {
            totalDisplay.textContent = count + ' ခု';
        }
    }

    function calculateTotalValue() {
        let total = 0;
        document.querySelectorAll('.item-price').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        const totalValueDisplay = document.getElementById('total-value-modal');
        if (totalValueDisplay) {
            totalValueDisplay.textContent = total.toLocaleString() + ' ကျပ်';
        }
    }

    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('item-price')) {
            calculateTotalValue();
        }
    });
</script>
@endpush

<!-- Item Template -->
<template id="item-template">
    @include('partials.jewellery-item', ['index' => 'ITEM_INDEX', 'item' => null])
</template>