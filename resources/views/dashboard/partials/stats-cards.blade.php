{{-- ============================================================
DASHBOARD PARTIAL: Stats Cards
Menampilkan 4 kartu ringkasan statistik keuangan:
Net Worth, Saldo Kas, Valuasi Aset, Pengeluaran.
@include('dashboard.partials.stats-cards')
============================================================ --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">

    {{-- Card 1: Total Kekayaan (Net Worth) --}}
    <button onclick="document.getElementById('netWorthModal').showModal()"
        class="bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 p-5 flex flex-col shadow-sm hover:shadow-md transition-all text-left w-full relative overflow-hidden group">
        {{-- Hover overlay --}}
        <div
            class="absolute inset-0 bg-indigo-50/0 group-hover:bg-indigo-50/50 dark:bg-indigo-900/0 dark:group-hover:bg-indigo-900/20 transition-colors pointer-events-none">
        </div>

        <div class="flex items-center justify-between mb-3 relative z-10 w-full">
            <div class="flex items-center">
                <div
                    class="bg-indigo-100 dark:bg-indigo-900/50 p-2.5 rounded-xl mr-3 text-indigo-600 dark:text-indigo-400">
                    <i data-lucide="wallet" class="w-5 h-5"></i>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Kekayaan Bersih</p>
            </div>
            <i data-lucide="zoom-in"
                class="w-4 h-4 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white transition-colors relative z-10">Rp {{
            number_format($netWorth, 0, ',', '.') }}</h3>
        <p class="text-xs mt-2 text-indigo-600 dark:text-indigo-400 flex items-center relative z-10">
            Klik untuk melihat rincian
        </p>
    </button>

    {{-- MODAL Rincian Net Worth --}}
    <dialog id="netWorthModal"
        class="bg-transparent m-auto p-0 rounded-2xl backdrop:bg-gray-900/50 backdrop:backdrop-blur-sm open:animate-in open:fade-in open:zoom-in-95 w-full max-w-md">
        <div
            class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-xl overflow-hidden text-left">
            {{-- Header --}}
            <div
                class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/50">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="wallet" class="w-5 h-5 text-indigo-500"></i>
                    Rincian Kekayaan
                </h3>
                <button onclick="document.getElementById('netWorthModal').close()"
                    class="text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- Body --}}
            <div class="p-6 space-y-4">
                {{-- Total Besar --}}
                <div class="text-center pb-2 border-b border-gray-100 dark:border-gray-700 mb-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Total Net Worth</p>
                    <p class="text-3xl font-black text-indigo-600 dark:text-indigo-400">Rp {{ number_format($netWorth,
                        0, ',', '.') }}</p>
                </div>

                {{-- Komponen Kas --}}
                <div
                    class="bg-green-50/50 dark:bg-green-900/10 border border-green-100 dark:border-green-800/50 rounded-xl p-4 flex justify-between items-center hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="bg-green-100 dark:bg-green-800 text-green-600 dark:text-green-300 p-2 rounded-lg">
                            <i data-lucide="banknote" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-gray-100 text-sm">Uang Kas & Bank</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Total saldo di dompet</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-green-600 dark:text-green-400 text-sm">Rp {{
                            number_format($totalBalance, 0, ',', '.') }}</p>
                        @if($netWorth > 0)
                        <p class="text-[10px] text-gray-400">{{ round(($totalBalance / $netWorth) * 100, 1) }}% dari
                            total</p>
                        @endif
                    </div>
                </div>

                {{-- Komponen Aset --}}
                <div
                    class="bg-amber-50/50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-800/50 rounded-xl p-4 flex justify-between items-center hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="bg-amber-100 dark:bg-amber-800 text-amber-600 dark:text-amber-300 p-2 rounded-lg">
                            <i data-lucide="pie-chart" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-gray-100 text-sm">Valuasi Aset</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Total nilai investasi</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-amber-600 dark:text-amber-400 text-sm">Rp {{
                            number_format($totalAssetValue, 0, ',', '.') }}</p>
                        @if($netWorth > 0)
                        <p class="text-[10px] text-gray-400">{{ round(($totalAssetValue / $netWorth) * 100, 1) }}% dari
                            total</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div
                class="px-6 py-4 bg-gray-50 dark:bg-gray-800/80 border-t border-gray-100 dark:border-gray-700 text-center">
                <button onclick="document.getElementById('netWorthModal').close()"
                    class="w-full bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium py-2 rounded-lg transition-colors text-sm">
                    Tutup
                </button>
            </div>
        </div>
    </dialog>


    {{-- Card 2: Pemasukan Bulan Ini --}}
    <button onclick="document.getElementById('incomeModal').showModal()"
        class="bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 p-5 flex flex-col shadow-sm hover:shadow-md transition-all text-left w-full relative overflow-hidden group">
        <div
            class="absolute inset-0 bg-green-50/0 group-hover:bg-green-50/50 dark:bg-green-900/0 dark:group-hover:bg-green-900/20 transition-colors pointer-events-none">
        </div>

        <div class="flex items-center justify-between mb-3 relative z-10 w-full">
            <div class="flex items-center">
                <div class="bg-green-100 dark:bg-green-900/50 p-2.5 rounded-xl mr-3 text-green-600 dark:text-green-400">
                    <i data-lucide="trending-up" class="w-5 h-5"></i>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Pemasukan Bulan Ini</p>
            </div>
            <i data-lucide="zoom-in"
                class="w-4 h-4 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white transition-colors relative z-10">Rp {{
            number_format($monthlyIncome, 0, ',', '.') }}</h3>
        <p class="text-xs mt-2 text-green-600 dark:text-green-400 flex items-center relative z-10">
            Klik untuk melihat riwayat pemasukan
        </p>
    </button>

    {{-- MODAL Rincian Pemasukan --}}
    <dialog id="incomeModal"
        class="bg-transparent m-auto p-0 rounded-2xl backdrop:bg-gray-900/50 backdrop:backdrop-blur-sm open:animate-in open:fade-in open:zoom-in-95 w-full max-w-md my-8">
        <div
            class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-xl overflow-hidden text-left flex flex-col max-h-[85vh]">
            {{-- Header --}}
            <div
                class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/50 shrink-0">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="trending-up" class="w-5 h-5 text-green-500"></i>
                    Riwayat Pemasukan
                </h3>
                <button onclick="document.getElementById('incomeModal').close()"
                    class="text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- Body --}}
            <div class="p-0 overflow-y-auto">
                {{-- Total Besar --}}
                <div
                    class="p-6 text-center border-b border-gray-100 dark:border-gray-700 bg-green-50/30 dark:bg-green-900/10">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Total Bulan Ini</p>
                    <p class="text-3xl font-black text-green-600 dark:text-green-400">Rp {{
                        number_format($monthlyIncome, 0, ',', '.') }}</p>
                    <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-1">*Tidak termasuk transfer antar dompet
                        (Exclude Transfer)</p>
                </div>

                {{-- List Pemasukan --}}
                <div class="divide-y divide-gray-100 dark:divide-gray-700/50 p-2">
                    @forelse($monthlyIncomeList as $income)
                    <div
                        class="p-4 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors rounded-xl flex justify-between items-center group">
                        <div class="flex gap-3 items-center">
                            <div
                                class="bg-green-100 dark:bg-green-900/30 text-green-500 dark:text-green-400 p-2 rounded-lg shrink-0">
                                <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                            </div>
                            <div class="flex-1 truncate max-w-[150px] sm:max-w-xs">
                                <p class="font-bold text-gray-900 dark:text-gray-100 text-sm truncate"
                                    title="{{ $income->description }}">
                                    {{ $income->description ?: 'Pemasukan' }}
                                </p>
                                <div
                                    class="flex items-center gap-2 mt-0.5 text-[11px] text-gray-500 dark:text-gray-400">
                                    <span class="bg-gray-200 dark:bg-gray-700 px-1.5 py-0.5 rounded">{{
                                        $income->category ? $income->category->name : 'Uncategorized' }}</span>
                                    <span>{{ \Carbon\Carbon::parse($income->transaction_date)->format('d M') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="font-bold text-green-600 dark:text-green-400 text-sm">+ Rp {{
                                number_format($income->amount, 0, ',', '.') }}</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">{{ $income->wallet ? $income->wallet->name : '-'
                                }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                        <i data-lucide="inbox" class="w-10 h-10 mx-auto mb-3 text-gray-300 dark:text-gray-600"></i>
                        <p>Belum ada pemasukan yang tercatat di bulan ini.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Footer --}}
            <div
                class="px-6 py-4 bg-gray-50 dark:bg-gray-800/80 border-t border-gray-100 dark:border-gray-700 text-center shrink-0">
                <button onclick="document.getElementById('incomeModal').close()"
                    class="w-full bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium py-2 rounded-lg transition-colors text-sm">
                    Tutup
                </button>
            </div>
        </div>
    </dialog>

    {{-- Card 3: Total Valuasi Aset --}}
    <button onclick="document.getElementById('assetModal').showModal()"
        class="bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 p-5 flex flex-col shadow-sm hover:shadow-md transition-all text-left w-full relative overflow-hidden group">
        <div
            class="absolute inset-0 bg-amber-50/0 group-hover:bg-amber-50/50 dark:bg-amber-900/0 dark:group-hover:bg-amber-900/20 transition-colors pointer-events-none">
        </div>

        <div class="flex items-center justify-between mb-3 relative z-10 w-full">
            <div class="flex items-center">
                <div class="bg-amber-100 dark:bg-amber-900/50 p-2.5 rounded-xl mr-3 text-amber-500 dark:text-amber-400">
                    <i data-lucide="pie-chart" class="w-5 h-5"></i>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Valuasi Aset</p>
            </div>
            <i data-lucide="zoom-in"
                class="w-4 h-4 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white transition-colors relative z-10">Rp {{
            number_format($totalAssetValue, 0, ',', '.') }}</h3>
        <p class="text-xs mt-2 text-amber-600 dark:text-amber-400 flex items-center relative z-10">
            Klik untuk melihat rincian portofolio
        </p>
    </button>

    {{-- MODAL Rincian Aset --}}
    <dialog id="assetModal"
        class="bg-transparent m-auto p-0 rounded-2xl backdrop:bg-gray-900/50 backdrop:backdrop-blur-sm open:animate-in open:fade-in open:zoom-in-95 w-full max-w-md my-8">
        <div
            class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-xl overflow-hidden text-left flex flex-col max-h-[85vh]">
            {{-- Header --}}
            <div
                class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/50 shrink-0">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="pie-chart" class="w-5 h-5 text-amber-500"></i>
                    Rincian Aset
                </h3>
                <button onclick="document.getElementById('assetModal').close()"
                    class="text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- Body --}}
            <div class="p-0 overflow-y-auto">
                {{-- Total Besar --}}
                <div
                    class="p-6 text-center border-b border-gray-100 dark:border-gray-700 bg-amber-50/30 dark:bg-amber-900/10">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Total Nilai Investasi</p>
                    <p class="text-3xl font-black text-amber-600 dark:text-amber-400">Rp {{
                        number_format($totalAssetValue, 0, ',', '.') }}</p>
                </div>

                {{-- List Aset --}}
                <div class="divide-y divide-gray-100 dark:divide-gray-700/50 p-2">
                    @forelse($portfolios as $portfolio)
                    @php
                    $currentPrice = $portfolio->asset->latestValuation ?
                    $portfolio->asset->latestValuation->price_per_unit : 0;
                    $value = $portfolio->total_units * $currentPrice;
                    @endphp
                    <div
                        class="p-4 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors rounded-xl flex justify-between items-center group">
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-gray-100 text-sm flex items-center gap-2">
                                {{ $portfolio->asset->name }}
                                @if($portfolio->asset->ticker_symbol)
                                <span
                                    class="text-[10px] bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-1.5 py-0.5 rounded uppercase">{{
                                    $portfolio->asset->ticker_symbol }}</span>
                                @endif
                            </h4>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">
                                {{ number_format($portfolio->total_units, 4, ',', '.') }} {{
                                $portfolio->asset->unit_name }} &times; Rp {{ number_format($currentPrice, 0, ',', '.')
                                }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-900 dark:text-gray-200 text-sm">Rp {{ number_format($value, 0,
                                ',', '.') }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                        <i data-lucide="inbox" class="w-10 h-10 mx-auto mb-3 text-gray-300 dark:text-gray-600"></i>
                        <p>Belum ada aset investasi aktif.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Footer --}}
            <div
                class="px-6 py-4 bg-gray-50 dark:bg-gray-800/80 border-t border-gray-100 dark:border-gray-700 text-center shrink-0">
                <button onclick="document.getElementById('assetModal').close()"
                    class="w-full bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium py-2 rounded-lg transition-colors text-sm">
                    Tutup
                </button>
            </div>
        </div>
    </dialog>

    {{-- Card 4: Pengeluaran Bulan Ini --}}
    <button onclick="document.getElementById('expenseModal').showModal()"
        class="bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 p-5 flex flex-col shadow-sm hover:shadow-md transition-all text-left w-full relative overflow-hidden group">
        <div
            class="absolute inset-0 bg-red-50/0 group-hover:bg-red-50/50 dark:bg-red-900/0 dark:group-hover:bg-red-900/20 transition-colors pointer-events-none">
        </div>

        <div class="flex items-center justify-between mb-3 relative z-10 w-full">
            <div class="flex items-center">
                <div class="bg-red-100 dark:bg-red-900/50 p-2.5 rounded-xl mr-3 text-red-600 dark:text-red-400">
                    <i data-lucide="trending-down" class="w-5 h-5"></i>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Pengeluaran Bulan Ini</p>
            </div>
            <i data-lucide="zoom-in"
                class="w-4 h-4 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white transition-colors relative z-10">Rp {{
            number_format($monthlyExpense, 0, ',', '.') }}</h3>
        <p class="text-xs mt-2 text-red-500 dark:text-red-400 flex items-center relative z-10">
            {{ $expensePct }}% rasio pemakaian. Klik untuk detail.
        </p>
    </button>

    {{-- MODAL Rincian Pengeluaran --}}
    <dialog id="expenseModal"
        class="bg-transparent m-auto p-0 rounded-2xl backdrop:bg-gray-900/50 backdrop:backdrop-blur-sm open:animate-in open:fade-in open:zoom-in-95 w-full max-w-md my-8">
        <div
            class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-xl overflow-hidden text-left flex flex-col max-h-[85vh]">
            {{-- Header --}}
            <div
                class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/50 shrink-0">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="trending-down" class="w-5 h-5 text-red-500"></i>
                    Riwayat Pengeluaran
                </h3>
                <button onclick="document.getElementById('expenseModal').close()"
                    class="text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- Body --}}
            <div class="p-0 overflow-y-auto">
                {{-- Total Besar --}}
                <div
                    class="p-6 text-center border-b border-gray-100 dark:border-gray-700 bg-red-50/30 dark:bg-red-900/10">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Total Bulan Ini</p>
                    <p class="text-3xl font-black text-red-600 dark:text-red-400">Rp {{ number_format($monthlyExpense,
                        0, ',', '.') }}</p>
                    <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-1">*Tidak termasuk transfer antar dompet
                        (Exclude Transfer)</p>
                </div>

                {{-- List Pengeluaran --}}
                <div class="divide-y divide-gray-100 dark:divide-gray-700/50 p-2">
                    @forelse($monthlyExpenseList as $expense)
                    <div
                        class="p-4 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors rounded-xl flex justify-between items-center group">
                        <div class="flex gap-3 items-center">
                            <div
                                class="bg-red-100 dark:bg-red-900/30 text-red-500 dark:text-red-400 p-2 rounded-lg shrink-0">
                                <i data-lucide="arrow-down-right" class="w-4 h-4"></i>
                            </div>
                            <div class="flex-1 truncate max-w-[150px] sm:max-w-xs">
                                <p class="font-bold text-gray-900 dark:text-gray-100 text-sm truncate"
                                    title="{{ $expense->description }}">
                                    {{ $expense->description ?: 'Pengeluaran' }}
                                </p>
                                <div
                                    class="flex items-center gap-2 mt-0.5 text-[11px] text-gray-500 dark:text-gray-400">
                                    <span class="bg-gray-200 dark:bg-gray-700 px-1.5 py-0.5 rounded">{{
                                        $expense->category ? $expense->category->name : 'Uncategorized' }}</span>
                                    <span>{{ \Carbon\Carbon::parse($expense->transaction_date)->format('d M') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="font-bold text-red-600 dark:text-red-400 text-sm">- Rp {{
                                number_format($expense->amount, 0, ',', '.') }}</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">{{ $expense->wallet ? $expense->wallet->name :
                                '-' }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                        <i data-lucide="check-circle"
                            class="w-10 h-10 mx-auto mb-3 text-green-400 dark:text-green-500"></i>
                        <p>Luar biasa! Belum ada pengeluaran di bulan ini.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Footer --}}
            <div
                class="px-6 py-4 bg-gray-50 dark:bg-gray-800/80 border-t border-gray-100 dark:border-gray-700 text-center shrink-0">
                <button onclick="document.getElementById('expenseModal').close()"
                    class="w-full bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium py-2 rounded-lg transition-colors text-sm">
                    Tutup
                </button>
            </div>
        </div>
    </dialog>

</div>