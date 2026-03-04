{{-- ============================================================
DASHBOARD PARTIAL: Recent Transactions
Menampilkan tabel transaksi terbaru (kolom: 2/3 lebar).
@include('dashboard.partials.recent-transactions')
============================================================ --}}
<div
    class="lg:col-span-2 bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden transition-colors">
    <div class="flex justify-between items-center p-5 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-base font-bold text-gray-900 dark:text-white transition-colors">Transaksi Terakhir</h2>
        <a href="#"
            class="text-sm font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors">Lihat
            Semua</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr
                    class="bg-gray-50 dark:bg-gray-800/50 text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider border-b border-gray-100 dark:border-gray-700 transition-colors">
                    <th class="py-3 px-5 font-semibold">Tanggal</th>
                    <th class="py-3 px-5 font-semibold">Keterangan</th>
                    <th class="py-3 px-5 font-semibold">Kategori</th>
                    <th class="py-3 px-5 font-semibold text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                    <td class="py-3 px-5 text-sm font-medium text-gray-900 dark:text-gray-200">Hari ini</td>
                    <td class="py-3 px-5 text-sm text-gray-600 dark:text-gray-400">Beli Reksadana Sucor</td>
                    <td class="py-3 px-5 text-sm"><span
                            class="bg-indigo-100 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-400 px-2.5 py-1 rounded-md text-xs font-semibold">Investasi</span>
                    </td>
                    <td class="py-3 px-5 text-sm font-bold text-red-600 dark:text-red-400 text-right">- Rp 1.000.000
                    </td>
                </tr>
                <tr
                    class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                    <td class="py-3 px-5 text-sm font-medium text-gray-900 dark:text-gray-200">Kemarin</td>
                    <td class="py-3 px-5 text-sm text-gray-600 dark:text-gray-400">Makan Siang</td>
                    <td class="py-3 px-5 text-sm"><span
                            class="bg-amber-100 text-amber-700 dark:bg-amber-900/50 dark:text-amber-400 px-2.5 py-1 rounded-md text-xs font-semibold">Konsumsi</span>
                    </td>
                    <td class="py-3 px-5 text-sm font-bold text-red-600 dark:text-red-400 text-right">- Rp 55.000</td>
                </tr>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                    <td class="py-3 px-5 text-sm font-medium text-gray-900 dark:text-gray-200">12 Okt 2026</td>
                    <td class="py-3 px-5 text-sm text-gray-600 dark:text-gray-400">Gaji Bulanan</td>
                    <td class="py-3 px-5 text-sm"><span
                            class="bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-400 px-2.5 py-1 rounded-md text-xs font-semibold">Pemasukan</span>
                    </td>
                    <td class="py-3 px-5 text-sm font-bold text-green-600 dark:text-green-400 text-right">+ Rp
                        15.000.000</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>