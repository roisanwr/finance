{{-- ============================================================
DASHBOARD PARTIAL: Page Header
Menampilkan judul halaman & tombol aksi utama.
@include('dashboard.partials.page-header')
============================================================ --}}
<div class="mb-6 flex justify-between items-end mt-2 lg:mt-0">
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1 transition-colors">Ringkasan Keuangan Anda</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm transition-colors">Data ditarik secara langsung berdasarkan
            kurs terkini.</p>
    </div>

    <button
        class="text-xs bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-400 px-3 py-1.5 rounded-lg hover:bg-indigo-200 dark:hover:bg-indigo-800/60 transition-colors font-medium border border-indigo-200 dark:border-indigo-800 flex items-center gap-1 shadow-sm shrink-0">
        <i data-lucide="refresh-cw" class="w-3 h-3"></i> Segarkan Data
    </button>
</div>