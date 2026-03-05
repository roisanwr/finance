{{-- ============================================================
DASHBOARD PARTIAL: Investment Allocation (HTML ONLY - no scripts)
============================================================ --}}
<div
    class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col h-full">
    <div class="p-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
        <div>
            <h3 class="font-bold text-gray-900 dark:text-white">Alokasi Kekayaan</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Distribusi penempatan dana Anda saat ini</p>
        </div>
        <button class="text-gray-400 hover:text-indigo-600 transition-colors">
            <i data-lucide="more-vertical" class="w-5 h-5"></i>
        </button>
    </div>

    <div class="p-6 flex-1 flex flex-col justify-center relative">
        <div id="allocationChart" class="w-full flex justify-center items-center h-64"></div>

        @if(array_sum($chartSeries) == 0)
        <div
            class="absolute inset-0 flex flex-col items-center justify-center bg-white/90 dark:bg-gray-800/90 z-10 p-6 text-center">
            <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-3">
                <i data-lucide="pie-chart" class="w-6 h-6 text-gray-400"></i>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada data alokasi.</p>
        </div>
        @endif
    </div>
</div>