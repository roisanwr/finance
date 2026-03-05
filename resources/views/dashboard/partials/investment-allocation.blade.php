{{-- ============================================================
DASHBOARD PARTIAL: Investment Allocation (HTML ONLY - no scripts)
============================================================ --}}
<div role="button" tabindex="0" onclick="document.getElementById('allocationModal').showModal()"
    class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col h-full w-full text-left hover:shadow-md transition-shadow group relative overflow-hidden cursor-pointer">

    <div
        class="absolute inset-0 bg-gray-50/0 group-hover:bg-gray-50/50 dark:bg-gray-900/0 dark:group-hover:bg-gray-900/20 transition-colors pointer-events-none">
    </div>

    <div
        class="p-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center w-full z-10 relative pointer-events-none">
        <div>
            <h3 class="font-bold text-gray-900 dark:text-white">Alokasi Kekayaan</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Distribusi penempatan dana Anda saat ini</p>
        </div>
        <div class="text-gray-400 group-hover:text-indigo-600 transition-colors opacity-0 group-hover:opacity-100">
            <i data-lucide="zoom-in" class="w-5 h-5"></i>
        </div>
    </div>

    <div class="p-6 flex-1 flex flex-col justify-center relative w-full z-10 pointer-events-none">
        <div id="allocationChart" class="w-full flex justify-center items-center h-64"></div>
    </div>
</div>

{{-- MODAL Rincian Alokasi --}}
<dialog id="allocationModal"
    class="bg-transparent m-auto p-0 rounded-2xl backdrop:bg-gray-900/50 backdrop:backdrop-blur-sm open:animate-in open:fade-in open:zoom-in-95 w-full max-w-md my-8">
    <div
        class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-xl overflow-hidden text-left flex flex-col max-h-[85vh]">
        {{-- Header --}}
        <div
            class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/50 shrink-0">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <i data-lucide="pie-chart" class="w-5 h-5 text-indigo-500"></i>
                Detail Alokasi Kekayaan
            </h3>
            <button onclick="document.getElementById('allocationModal').close()"
                class="text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        {{-- Body --}}
        <div class="p-0 overflow-y-auto">
            {{-- Kas Global --}}
            <div
                class="p-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-green-50/30 dark:bg-green-900/10">
                <div class="flex items-center gap-3">
                    <div
                        class="bg-green-100 dark:bg-green-800/50 text-green-600 dark:text-green-400 p-2 rounded-lg shrink-0">
                        <i data-lucide="wallet" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 dark:text-gray-100 text-sm">Kas & Bank Global</p>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">Total saldo di seluruh dompet</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-bold text-green-600 dark:text-green-400 text-sm">Rp {{ number_format($totalBalance,
                        0, ',', '.') }}</p>
                </div>
            </div>

            {{-- List Aset --}}
            <div class="divide-y divide-gray-100 dark:divide-gray-700/50 p-2">
                @forelse($portfolios as $portfolio)
                @php
                $currentPrice = $portfolio->asset->latestValuation ? $portfolio->asset->latestValuation->price_per_unit
                : 0;
                $value = $portfolio->total_units * $currentPrice;
                @endphp
                <div
                    class="p-4 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors rounded-xl flex justify-between items-center group">
                    <div class="flex items-center gap-3">
                        <div
                            class="bg-amber-100 dark:bg-amber-900/30 text-amber-500 dark:text-amber-400 p-2 rounded-lg shrink-0">
                            <i data-lucide="boxes" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-gray-100 text-sm flex items-center gap-2">
                                {{ $portfolio->asset->name }}
                                @if($portfolio->asset->ticker_symbol)
                                <span
                                    class="text-[10px] bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-1.5 py-0.5 rounded uppercase">{{
                                    $portfolio->asset->ticker_symbol }}</span>
                                @endif
                            </h4>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">
                                {{ number_format($portfolio->total_units, 4, ',', '.') }} {{
                                $portfolio->asset->unit_name }} &times; Rp {{ number_format($currentPrice, 0, ',', '.')
                                }}
                            </p>
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="font-bold text-gray-900 dark:text-gray-200 text-sm">Rp {{ number_format($value, 0,
                            ',', '.') }}</p>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                    <p class="text-sm">Belum ada portofolio investasi aktif.</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Footer --}}
        <div
            class="px-6 py-4 bg-gray-50 dark:bg-gray-800/80 border-t border-gray-100 dark:border-gray-700 text-center shrink-0">
            <button onclick="document.getElementById('allocationModal').close()"
                class="w-full bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium py-2 rounded-lg transition-colors text-sm">
                Tutup
            </button>
        </div>
    </div>
</dialog>