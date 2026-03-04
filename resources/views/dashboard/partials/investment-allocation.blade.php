{{-- ============================================================
DASHBOARD PARTIAL: Investment Allocation
Menampilkan progress bar alokasi portofolio investasi
(kolom: 1/3 lebar).
@include('dashboard.partials.investment-allocation')
============================================================ --}}
<div
    class="bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden transition-colors">
    <div class="flex justify-between items-center p-5 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-base font-bold text-gray-900 dark:text-white transition-colors">Alokasi Investasi</h2>
    </div>

    <div class="p-5 space-y-4">

        {{-- Saham --}}
        <div>
            <div class="flex justify-between text-sm mb-1">
                <span class="text-gray-600 dark:text-gray-400 font-medium">Saham</span>
                <span class="text-gray-900 dark:text-gray-200 font-bold">55%</span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                <div class="bg-blue-500 h-2 rounded-full" style="width: 55%"></div>
            </div>
        </div>

        {{-- Kripto --}}
        <div>
            <div class="flex justify-between text-sm mb-1">
                <span class="text-gray-600 dark:text-gray-400 font-medium">Kripto</span>
                <span class="text-gray-900 dark:text-gray-200 font-bold">25%</span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                <div class="bg-amber-500 h-2 rounded-full" style="width: 25%"></div>
            </div>
        </div>

        {{-- Reksa Dana Pasar Uang --}}
        <div>
            <div class="flex justify-between text-sm mb-1">
                <span class="text-gray-600 dark:text-gray-400 font-medium">Reksa Dana Pasar Uang</span>
                <span class="text-gray-900 dark:text-gray-200 font-bold">15%</span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                <div class="bg-green-500 h-2 rounded-full" style="width: 15%"></div>
            </div>
        </div>

        {{-- Logam Mulia --}}
        <div>
            <div class="flex justify-between text-sm mb-1">
                <span class="text-gray-600 dark:text-gray-400 font-medium">Logam Mulia</span>
                <span class="text-gray-900 dark:text-gray-200 font-bold">5%</span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                <div class="bg-yellow-400 h-2 rounded-full" style="width: 5%"></div>
            </div>
        </div>

    </div>
</div>