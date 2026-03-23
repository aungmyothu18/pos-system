{{-- resources/views/partials/jewellery-item.blade.php --}}
<div class="item-row grid grid-cols-12 gap-2 items-center bg-white p-3 rounded-xl shadow-sm hover:shadow-md transition border border-dotted border-amber-100">
    <!-- Serial Number -->
    <div class="col-span-1 text-center font-bold text-amber-700 item-serial text-base">
        {{ is_numeric($index) ? $index + 1 : '' }}
    </div>

    <!-- Item Type -->
    <div class="col-span-2">
        <select name="items[{{ $index }}][type]" class="w-full p-2.5 text-sm border-2 border-amber-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition bg-amber-50/50">
            <option value="">ရွေးချယ်ပါ</option>
            <option value="လက်စွပ်">လက်စွပ်</option>
            <option value="လက်စွယ်">လက်စွယ်</option>
            <option value="လည်ဆွဲ">လည်ဆွဲ</option>
            <option value="နားကပ်">နားကပ်</option>
            <option value="ဆွဲကြိုး">ဆွဲကြိုး</option>
            <option value="လက်ကောက်">လက်ကောက်</option>
            <option value="ခါးပတ်">ခါးပတ်</option>
            <option value="ပန်းတီ">ပန်းတီ</option>
            <option value="အခြား">အခြား</option>
        </select>
    </div>

    <!-- Weight (4 columns) -->
    <div class="col-span-4 grid grid-cols-4 gap-1">
        <input type="number" name="items[{{ $index }}][kyat]" step="0.01" placeholder="ကျပ်" 
            class="w-full p-2 text-sm border-2 border-amber-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition bg-amber-50/50">
        <input type="number" name="items[{{ $index }}][pae]" step="0.01" placeholder="ပဲ" 
            class="w-full p-2 text-sm border-2 border-amber-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition bg-amber-50/50">
        <input type="number" name="items[{{ $index }}][yway]" step="0.01" placeholder="ရွေး" 
            class="w-full p-2 text-sm border-2 border-amber-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition bg-amber-50/50">
        <input type="number" name="items[{{ $index }}][point]" step="0.01" placeholder="ပွိုင့်" 
            class="w-full p-2 text-sm border-2 border-amber-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition bg-amber-50/50">
    </div>

    <!-- Color -->
    <div class="col-span-1">
        <select name="items[{{ $index }}][color]" class="w-full p-2.5 text-sm border-2 border-amber-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition bg-amber-50/50">
            <option value="">ရွေး</option>
            <option value="ရွှေ">ရွှေ</option>
            <option value="ရွှေဝါ">ရွှေဝါ</option>
            <option value="ရွှေဖြူ">ရွှေဖြူ</option>
            <option value="ပန်းတီ">ပန်းတီ</option>
            <option value="ပလက်တီနမ်">ပလက်တီနမ်</option>
            <option value="ငွေ">ငွေ</option>
        </select>
    </div>

    <!-- Price -->
    <div class="col-span-2">
        <input type="number" name="items[{{ $index }}][price]" step="1000" placeholder="စျေးနှုန်း" 
            class="w-full p-2.5 text-sm border-2 border-amber-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition bg-amber-50/50 item-price">
    </div>

    <!-- Remark -->
    <div class="col-span-2 flex gap-1">
        <input type="text" name="items[{{ $index }}][remark]" placeholder="မှတ်ချက်" 
            class="w-full p-2.5 text-sm border-2 border-amber-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition bg-amber-50/50">
        <button type="button" class="remove-item-btn text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </button>
    </div>
</div>