{{-- ============================================================
DASHBOARD PARTIAL: Recent Transactions
Menampilkan tabel transaksi terbaru (kolom: 2/3 lebar).
@include('dashboard.partials.recent-transactions')
============================================================ --}}
<div
    class="lg:col-span-2 bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden transition-colors flex flex-col">
    <div class="flex justify-between items-center p-5 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-base font-bold text-gray-900 dark:text-white transition-colors flex items-center gap-2">
            <i data-lucide="clock" class="w-4 h-4 text-indigo-500"></i> Transaksi Terakhir
        </h2>
        <a href="{{ route('transactions') }}"
            class="text-sm font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors flex items-center gap-1">
            Lihat Semua <i data-lucide="chevron-right" class="w-4 h-4"></i>
        </a>
    </div>

    <div class="overflow-x-auto flex-1">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr
                    class="bg-gray-50 dark:bg-gray-800/80 text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider border-b border-gray-100 dark:border-gray-700 transition-colors">
                    <th class="py-3 px-5 font-semibold">Tanggal</th>
                    <th class="py-3 px-5 font-semibold">Tipe & Keterangan</th>
                    <th class="py-3 px-5 font-semibold">Kategori</th>
                    <th class="py-3 px-5 font-semibold text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTransactions as $tx)
                @php
                // Styling berdasarkan Tipe
                $amountClass = 'text-gray-900 dark:text-white';
                $amountSign = '';
                $typeLabelClass = 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300';

                if($tx->transaction_type == 'PEMASUKAN') {
                $amountClass = 'text-emerald-600 dark:text-emerald-400';
                $amountSign = '+';
                $typeLabelClass = 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400';
                } elseif ($tx->transaction_type == 'PENGELUARAN') {
                $amountClass = 'text-gray-900 dark:text-white';
                $amountSign = '-';
                $typeLabelClass = 'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-400';
                } elseif ($tx->transaction_type == 'TRANSFER') {
                $amountClass = 'text-gray-900 dark:text-white';
                $typeLabelClass = 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400';
                }
                @endphp
                <tr
                    class="border-b border-gray-100 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors group">
                    <td class="py-3 px-5 text-sm font-medium text-gray-900 dark:text-gray-200">
                        {{ \Carbon\Carbon::parse($tx->transaction_date)->format('d M Y') }}
                        <div class="text-xs text-gray-400 font-normal">{{
                            \Carbon\Carbon::parse($tx->transaction_date)->format('H:i') }}</div>
                    </td>
                    <td class="py-3 px-5">
                        <div class="flex items-center gap-2">
                            <span
                                class="{{ $typeLabelClass }} px-2 py-0.5 rounded text-[10px] font-bold tracking-wider">{{
                                $tx->transaction_type }}</span>
                            <span class="text-sm text-gray-600 dark:text-gray-300 line-clamp-1 max-w-[200px]"
                                title="{{ $tx->description }}">
                                {{ $tx->description ?: 'Tanpa keterangan' }}
                            </span>
                        </div>
                    </td>
                    <td class="py-3 px-5">
                        @if($tx->transaction_type !== 'TRANSFER' && $tx->category)
                        <span
                            class="bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 px-2.5 py-1 rounded-md text-xs font-semibold whitespace-nowrap">
                            {{ $tx->category->name }}
                        </span>
                        @else
                        <span class="text-xs text-gray-400 italic">N/A</span>
                        @endif
                    </td>
                    <td class="py-3 px-5 text-sm font-bold text-right {{ $amountClass }} whitespace-nowrap">
                        {{ $amountSign }} Rp {{ number_format($tx->amount, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-12 text-center text-gray-500 dark:text-gray-400">
                        <i data-lucide="inbox" class="w-10 h-10 mx-auto mb-3 text-gray-300 dark:text-gray-600"></i>
                        <p>Belum ada riwayat transaksi</p>
                        <a href="{{ route('transactions') }}"
                            class="mt-3 inline-block text-sm text-indigo-600 hover:underline">Catat sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>