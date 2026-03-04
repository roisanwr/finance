{{-- ============================================================
DASHBOARD PARTIAL: Stats Cards
Menampilkan 4 kartu ringkasan statistik keuangan:
Net Worth, Saldo Kas, Valuasi Aset, Pengeluaran.
@include('dashboard.partials.stats-cards')
============================================================ --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">

    {{-- Card 1: Total Net Worth --}}
    <div
        class="bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 p-5 flex flex-col shadow-sm hover:shadow-md transition-all">
        <div class="flex items-center mb-3">
            <div class="bg-indigo-100 dark:bg-indigo-900/50 p-2.5 rounded-xl mr-3 text-indigo-600 dark:text-indigo-400">
                <i data-lucide="wallet" class="w-5 h-5"></i>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Kekayaan (Net Worth)</p>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white transition-colors">Rp 150.000.000</h3>
        <p class="text-xs mt-2 text-green-600 dark:text-green-400 flex items-center">
            <i data-lucide="trending-up" class="w-3 h-3 mr-1"></i> +2.5% bulan ini
        </p>
    </div>

    {{-- Card 2: Saldo Kas / Bank --}}
    <div
        class="bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 p-5 flex flex-col shadow-sm hover:shadow-md transition-all">
        <div class="flex items-center mb-3">
            <div class="bg-green-100 dark:bg-green-900/50 p-2.5 rounded-xl mr-3 text-green-600 dark:text-green-400">
                <i data-lucide="banknote" class="w-5 h-5"></i>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Saldo Kas / Bank</p>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white transition-colors">Rp 25.500.000</h3>
        <p class="text-xs mt-2 text-gray-500 dark:text-gray-400">Dari 3 rekening</p>
    </div>

    {{-- Card 3: Total Valuasi Aset --}}
    <div
        class="bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 p-5 flex flex-col shadow-sm hover:shadow-md transition-all">
        <div class="flex items-center mb-3">
            <div class="bg-amber-100 dark:bg-amber-900/50 p-2.5 rounded-xl mr-3 text-amber-500 dark:text-amber-400">
                <i data-lucide="pie-chart" class="w-5 h-5"></i>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Valuasi Aset</p>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white transition-colors">Rp 124.500.000</h3>
        <p class="text-xs mt-2 text-green-600 dark:text-green-400">Floating Profit: Rp 14.500.000</p>
    </div>

    {{-- Card 4: Pengeluaran Bulan Ini --}}
    <div
        class="bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 p-5 flex flex-col shadow-sm hover:shadow-md transition-all">
        <div class="flex items-center mb-3">
            <div class="bg-red-100 dark:bg-red-900/50 p-2.5 rounded-xl mr-3 text-red-600 dark:text-red-400">
                <i data-lucide="trending-down" class="w-5 h-5"></i>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Pengeluaran Bulan Ini</p>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white transition-colors">Rp 4.250.000</h3>
        <p class="text-xs mt-2 text-red-500 dark:text-red-400">Sisa budget: Rp 750.000</p>
    </div>

</div>