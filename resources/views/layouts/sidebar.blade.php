<aside class="flex-1 bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 shadow-sm flex flex-col overflow-hidden" style="width: var(--lebar-sidebar);">
    <div class="flex-1 overflow-y-auto py-4">
        <ul class="space-y-1 px-3">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2.5 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-500 font-semibold' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white font-medium' }} rounded-lg transition-colors">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i>
                    Dashboard
                </a>
            </li>

            <!-- Manajemen Kas Section -->
            <li class="pt-5 pb-2 px-3">
                <span class="text-xs font-bold text-gray-400 dark:text-gray-500 tracking-wider">MANAJEMEN KAS</span>
            </li>
            <li>
                <a href="#" class="flex items-center px-3 py-2.5 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white rounded-lg transition-colors font-medium">
                    <i data-lucide="credit-card" class="w-5 h-5 mr-3"></i>
                    Daftar Dompet
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-3 py-2.5 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white rounded-lg transition-colors font-medium">
                    <i data-lucide="tags" class="w-5 h-5 mr-3"></i>
                    Kategori
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-3 py-2.5 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white rounded-lg transition-colors font-medium">
                    <i data-lucide="arrow-left-right" class="w-5 h-5 mr-3"></i>
                    Arus Kas
                </a>
            </li>

            <!-- Master Aset Section -->
            <li class="pt-5 pb-2 px-3">
                <span class="text-xs font-bold text-gray-400 dark:text-gray-500 tracking-wider">MASTER ASET</span>
            </li>
            <li>
                <a href="#" class="flex items-center px-3 py-2.5 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white rounded-lg transition-colors font-medium">
                    <i data-lucide="database" class="w-5 h-5 mr-3"></i>
                    Katalog Aset
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-3 py-2.5 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white rounded-lg transition-colors font-medium">
                    <i data-lucide="line-chart" class="w-5 h-5 mr-3"></i>
                    Harga Pasar
                </a>
            </li>

            <!-- Portofolio Section -->
            <li class="pt-5 pb-2 px-3">
                <span class="text-xs font-bold text-gray-400 dark:text-gray-500 tracking-wider">PORTOFOLIO & INVESTASI</span>
            </li>
            <li>
                <a href="#" class="flex items-center px-3 py-2.5 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white rounded-lg transition-colors font-medium">
                    <i data-lucide="pie-chart" class="w-5 h-5 mr-3"></i>
                    Portofolio Saya
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-3 py-2.5 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white rounded-lg transition-colors font-medium">
                    <i data-lucide="trending-up" class="w-5 h-5 mr-3"></i>
                    Transaksi Aset
                </a>
            </li>
        </ul>
    </div>
</aside>
