<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Monitoring Produksi</title>
    <!-- Tailwind CSS untuk styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons untuk icon modern -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Konfigurasi warna kustom Tailwind -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        green: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        },
                        indigo: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                        },
                        gray: {
                            50: '#f9fafb',
                            100: '#f3f4f6',
                            200: '#e5e7eb',
                            400: '#9ca3af',
                            500: '#6b7280',
                            700: '#374151',
                            800: '#1f2937',
                            900: '#111827',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        /* Impor font Inter dari Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        
        :root {
            /* =========================================================
               🎛️ AREA PENGATURAN JARAK CUSTOM (UBAH ANGKA DI SINI)
               ========================================================= */
            --jarak-atas-header: 10px;  /* Jarak atap layar dengan Header */
            --jarak-kiri-kanan: 12px;   /* Jarak dari batas tepi kiri layar dan kanan layar */
            --jarak-bawah: 10px;        /* Jarak elemen dari dasar layar */
            --lebar-sidebar: 260px;     /* Lebar kotak sidebar */
            --jarak-antar-elemen: 20px; /* Jarak antara header & sidebar, atau sidebar & konten */
            --lengkung-kotak: 10px;     /* 🎛️ Atur seberapa melengkung ujung kotak di sini */
            
            /* Pengaturan Jarak Dalam Header */
            --jarak-kiri-menu: 8px;    /* 🎛️ Jarak dari ujung kiri kotak header ke icon menu (garis 3) */
            --jarak-kanan-profil: 12px; /* 🎛️ Jarak dari ujung kanan kotak header ke icon profil */
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        /* Class untuk menerapkan lengkungan kustom ke semua kotak utama */
        .sudut-custom {
            border-radius: var(--lengkung-kotak) !important;
        }

        /* Class khusus untuk animasi sidebar desktop saat disembunyikan.
           Nilainya otomatis dihitung dari lebar sidebar + jarak kiri agar benar-benar hilang dari layar */
        @media (min-width: 1024px) {
            .sidebar-desktop-closed {
                margin-left: calc(-1 * (var(--lebar-sidebar) + var(--jarak-kiri-kanan))) !important;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 10px;
        }
        .dark ::-webkit-scrollbar-thumb {
            background: #4b5563;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #d1d5db;
        }
        .dark ::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }
    </style>
</head>
<body class="bg-[#f3f4f8] dark:bg-gray-900 text-gray-800 dark:text-gray-100 h-screen overflow-hidden flex flex-col transition-colors duration-200">

    <!-- FLOATING HEADER WRAPPER (Statis & Penuh Lebarnya) -->
    <div class="w-full shrink-0 z-40 transition-all duration-300" style="padding-top: var(--jarak-atas-header); padding-left: var(--jarak-kiri-kanan); padding-right: var(--jarak-kiri-kanan); padding-bottom: var(--jarak-antar-elemen);">
        <!-- Header dengan style padding custom dari CSS variables -->
        <header class="bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 shadow-sm flex items-center justify-between py-3 transition-colors duration-200" style="padding-left: var(--jarak-kiri-menu); padding-right: var(--jarak-kanan-profil);">
            
            <!-- Left Side: Logo & Titles -->
            <div class="flex items-center space-x-3 sm:space-x-4">
                <!-- Mobile Sidebar Toggle -->
                <button onclick="toggleMobileSidebar()" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none lg:hidden mr-1">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
                <!-- Desktop Sidebar Toggle -->
                <button onclick="toggleDesktopSidebar()" class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 hidden lg:block focus:outline-none mr-1 transition-colors">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>

                <div class="flex items-center space-x-3">
                    <!-- Bitcoin Logo -->
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-full border-2 border-amber-400 bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-amber-500" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm1.646 13.29c-.407 1.628-3.1 1.083-3.976.856l.703-2.816c.876.218 3.69.65 3.273 1.96zm.38-3.437c-.37 1.484-2.658.74-3.4.554l.637-2.556c.742.186 3.133.53 2.763 2.002zm.857-3.387l-.08.32c1.157.29 1.856.989 1.69 2.184-.244 1.734-1.78 2.13-3.524 1.948l-.695 2.783-1.086-.27.683-2.739-.866-.216-.683 2.74-1.084-.27.695-2.784-1.734-.433.33-1.33s.8.2.79.187c.441.11.52-.16.537-.27l.891-3.576c-.028-.007-.056-.012-.083-.02l.002-.01c.022.005.044.012.067.017l.316-1.265c-.01-.262-.195-.56-.728-.693.015-.007-.792-.198-.792-.198l.274-1.097 1.733.432-.001.006.827.206.274-1.097 1.085.271-.268 1.072c.264.056.538.115.801.193 1.067.335 1.7 1.036 1.49 2.04z"/>
                        </svg>
                    </div>
                    <!-- Titles -->
                    <div class="hidden sm:block">
                        <h1 class="text-[17px] font-bold text-[#1e293b] dark:text-white leading-tight tracking-tight">Dashboard Monitoring Produksi</h1>
                        <p class="text-[13px] text-gray-500 dark:text-gray-400 leading-tight mt-0.5">Plant 4 - Plastic Injection</p>
                    </div>
                </div>
            </div>

            <!-- Center: Date & Time Pill -->
            <div class="hidden md:flex items-center bg-green-50 dark:bg-green-900/30 border border-green-100 dark:border-green-800/60 rounded-lg px-4 py-2 shadow-sm">
                <!-- Date -->
                <div class="flex items-center text-green-700 dark:text-green-400">
                    <i data-lucide="calendar" class="w-4 h-4 mr-2"></i>
                    <span id="current-date" class="text-sm font-semibold tracking-wide">Memuat...</span>
                </div>
                <!-- Divider -->
                <div class="w-px h-4 bg-green-200 dark:bg-green-700/60 mx-4"></div>
                <!-- Time -->
                <div class="flex items-center text-green-700 dark:text-green-400">
                    <i data-lucide="clock" class="w-4 h-4 mr-2"></i>
                    <span id="current-time" class="text-sm font-bold tracking-widest">00:00:00</span>
                </div>
            </div>

            <!-- Right Side Header -->
            <div class="flex items-center space-x-3 sm:space-x-5">
                <!-- Tools Wrapper -->
                <div class="flex items-center space-x-2 sm:space-x-3.5">
                    <!-- Toggle Switch (Mode Gelap) -->
                    <button onclick="toggleDarkMode()" class="w-[38px] h-5 bg-gray-500 dark:bg-green-600 rounded-full flex items-center px-0.5 focus:outline-none transition-colors duration-300 relative group">
                        <div id="theme-toggle-circle" class="w-4 h-4 bg-white rounded-full transform transition-transform duration-300 translate-x-0 dark:translate-x-[18px] shadow-sm"></div>
                    </button>
                    <!-- Sun/Moon Icon -->
                    <button onclick="toggleDarkMode()" class="text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white focus:outline-none transition-colors">
                        <i id="theme-icon" data-lucide="moon" class="w-5 h-5 fill-current"></i>
                    </button>
                    <!-- Bell Icon -->
                    <button class="relative text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 focus:outline-none transition-colors">
                        <i data-lucide="bell" class="w-[22px] h-[22px] fill-current"></i>
                        <span class="absolute top-0 right-0.5 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white dark:ring-gray-800"></span>
                    </button>
                    <!-- Fullscreen Icon -->
                    <button onclick="toggleFullScreen()" class="hidden sm:block text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none transition-colors">
                        <i id="fullscreen-icon" data-lucide="maximize" class="w-5 h-5 stroke-[2.5]"></i>
                    </button>
                </div>

                <!-- Vertical Divider -->
                <div class="hidden sm:block w-px h-8 bg-gray-200 dark:bg-gray-700 mx-1"></div>

                <!-- Profile User & Dropdown -->
                <div class="relative" id="user-menu-container">
                    <button onclick="toggleUserMenu()" class="flex items-center space-x-2 focus:outline-none group">
                        <div class="bg-[#2563eb] text-white rounded-full w-[38px] h-[38px] flex items-center justify-center font-bold text-[13px] tracking-wide shadow-sm group-hover:bg-blue-700 transition-colors">
                            HA
                        </div>
                        <div class="hidden md:flex items-center space-x-1 pl-1">
                            <span class="text-[15px] font-semibold text-gray-800 dark:text-gray-200">Hafizh Ayyasy</span>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-200 transition-colors"></i>
                        </div>
                    </button>
                    <!-- Dropdown Menu -->
                    <div id="user-dropdown" class="hidden absolute right-0 mt-3 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 border border-gray-200 dark:border-gray-700 z-50 transform origin-top-right transition-all">
                        <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 md:hidden">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Hafizh Ayyasy</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Administrator</p>
                        </div>
                        <a href="#" class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center transition-colors">
                            <i data-lucide="user" class="w-4 h-4 mr-2"></i> Profil Saya
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center transition-colors">
                                <i data-lucide="log-out" class="w-4 h-4 mr-2"></i> Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>
    </div>

    <!-- MAIN CONTENT AREA (Bawah Header) -->
    <div class="flex-1 flex overflow-hidden relative z-10">
        
        <!-- OVERLAY UNTUK MOBILE SIDEBAR -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-20 hidden lg:hidden" onclick="toggleMobileSidebar()"></div>

        <!-- FLOATING SIDEBAR WRAPPER -->
        <div id="sidebarWrapper" class="absolute lg:relative inset-y-0 left-0 z-30 flex flex-col transition-all duration-300 ease-in-out -translate-x-full lg:translate-x-0" style="padding-left: var(--jarak-kiri-kanan); padding-bottom: var(--jarak-bawah);">
            
            <!-- SIDEBAR CARD -->
            <aside class="flex-1 bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 shadow-sm flex flex-col overflow-hidden" style="width: var(--lebar-sidebar);">
                <!-- Menu Navigation Saja (Tanpa Logo) -->
                <div class="flex-1 overflow-y-auto py-4">
                    <ul class="space-y-1 px-3">
                        <!-- Dashboard (Active) -->
                        <li>
                            <a href="#" class="flex items-center px-3 py-2.5 bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-500 rounded-lg font-semibold transition-colors">
                                <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i>
                                Dashboard
                            </a>
                        </li>

                        <!-- Operasional Bengkel Section -->
                        <li class="pt-5 pb-2 px-3">
                            <span class="text-xs font-bold text-gray-400 dark:text-gray-500 tracking-wider">OPERASIONAL</span>
                        </li>
                        <li>
                            <a href="#" class="flex items-center px-3 py-2.5 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white rounded-lg transition-colors font-medium">
                                <i data-lucide="activity" class="w-5 h-5 mr-3"></i>
                                Monitoring
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center px-3 py-2.5 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white rounded-lg transition-colors font-medium">
                                <i data-lucide="clipboard-list" class="w-5 h-5 mr-3"></i>
                                Laporan Produksi
                            </a>
                        </li>

                        <!-- Master Data Section -->
                        <li class="pt-5 pb-2 px-3">
                            <span class="text-xs font-bold text-gray-400 dark:text-gray-500 tracking-wider">MASTER DATA</span>
                        </li>
                        <li>
                            <a href="#" class="flex items-center px-3 py-2.5 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white rounded-lg transition-colors font-medium">
                                <i data-lucide="box" class="w-5 h-5 mr-3"></i>
                                Data Mesin
                            </a>
                        </li>
                        <li>
                            <button onclick="toggleDropdown('menu-pengguna')" class="w-full flex items-center justify-between px-3 py-2.5 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white rounded-lg transition-colors font-medium">
                                <div class="flex items-center">
                                    <i data-lucide="users" class="w-5 h-5 mr-3"></i>
                                    Karyawan
                                </div>
                                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" id="icon-pengguna"></i>
                            </button>
                            <!-- Submenu (Hidden by default) -->
                            <ul id="menu-pengguna" class="hidden pl-11 pr-3 py-1 space-y-1">
                                <li><a href="#" class="block py-2 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">Operator</a></li>
                                <li><a href="#" class="block py-2 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">Supervisor</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </aside>
        </div>

        <!-- MAIN DASHBOARD CONTENT -->
        <main class="flex-1 overflow-y-auto" style="padding-right: var(--jarak-kiri-kanan); padding-bottom: var(--jarak-bawah); padding-left: var(--jarak-antar-elemen);">
            
            <!-- Page Title -->
            <div class="mb-6 flex justify-between items-end mt-2 lg:mt-0">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1 transition-colors">Ringkasan Hari Ini</h2>
                    <p class="text-gray-500 dark:text-gray-400 text-sm transition-colors">Data ditarik secara langsung (real-time).</p>
                </div>
                
                <button onclick="simulateNewData()" class="text-xs bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-400 px-3 py-1.5 rounded-lg hover:bg-indigo-200 dark:hover:bg-indigo-800/60 transition-colors font-medium border border-indigo-200 dark:border-indigo-800 flex items-center gap-1 shadow-sm shrink-0">
                    <i data-lucide="refresh-cw" class="w-3 h-3"></i> Segarkan Data
                </button>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
                <!-- Card 1 -->
                <div class="bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 p-5 flex items-center shadow-sm hover:shadow-md transition-all">
                    <div class="bg-green-100 dark:bg-green-900/50 p-3.5 rounded-xl mr-4 text-green-600 dark:text-green-400">
                        <i data-lucide="check-circle" class="w-7 h-7"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium mb-1">Target Tercapai</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white transition-colors" id="stat-revenue">85%</h3>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 p-5 flex items-center shadow-sm hover:shadow-md transition-all">
                    <div class="bg-blue-100 dark:bg-blue-900/50 p-3.5 rounded-xl mr-4 text-blue-600 dark:text-blue-400">
                        <i data-lucide="settings" class="w-7 h-7"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium mb-1">Mesin Aktif</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white transition-colors" id="stat-orders">12 / 14</h3>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 p-5 flex items-center shadow-sm hover:shadow-md transition-all">
                    <div class="bg-amber-100 dark:bg-amber-900/50 p-3.5 rounded-xl mr-4 text-amber-500 dark:text-amber-400">
                        <i data-lucide="alert-triangle" class="w-7 h-7"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium mb-1">Peringatan</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white transition-colors" id="stat-products">2</h3>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 p-5 flex items-center shadow-sm hover:shadow-md transition-all">
                    <div class="bg-purple-100 dark:bg-purple-900/50 p-3.5 rounded-xl mr-4 text-purple-600 dark:text-purple-400">
                        <i data-lucide="users" class="w-7 h-7"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium mb-1">Operator Bertugas</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white transition-colors" id="stat-customers">8</h3>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Table -->
            <div class="bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden transition-colors">
                <div class="flex justify-between items-center p-5 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-base font-bold text-gray-900 dark:text-white transition-colors">Log Aktivitas Terbaru</h2>
                    <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors">Lihat Laporan</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-800/50 text-gray-500 dark:text-gray-400 text-sm border-b border-gray-100 dark:border-gray-700 transition-colors">
                                <th class="py-3 px-5 font-semibold">ID Batch</th>
                                <th class="py-3 px-5 font-semibold">Nama Mesin</th>
                                <th class="py-3 px-5 font-semibold">Output (Pcs)</th>
                                <th class="py-3 px-5 font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody id="transaction-table-body">
                            <!-- State Kosong Default -->
                            <tr id="empty-state">
                                <td colspan="4" class="py-12 text-center text-sm text-gray-400 dark:text-gray-500">
                                    Belum ada data produksi baru.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    <!-- JAVASCRIPT LOGIC -->
    <script>
        // 1. Inisialisasi Lucide Icons
        lucide.createIcons();

        // 2. JAM & TANGGAL REAL-TIME
        function updateDateTime() {
            const now = new Date();
            const optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const dateStr = now.toLocaleDateString('id-ID', optionsDate);
            const timeStr = now.toLocaleTimeString('id-ID', { hour12: false });

            const dateEl = document.getElementById('current-date');
            const timeEl = document.getElementById('current-time');

            if(dateEl) dateEl.textContent = dateStr;
            if(timeEl) timeEl.textContent = timeStr;
        }

        setInterval(updateDateTime, 1000);
        updateDateTime(); 

        // 3. Fungsi Toggle Sidebar (Mobile)
        function toggleMobileSidebar() {
            const sidebarWrapper = document.getElementById('sidebarWrapper');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (sidebarWrapper.classList.contains('-translate-x-full')) {
                sidebarWrapper.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebarWrapper.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }

        // 4. Fungsi Toggle Sidebar (Desktop)
        function toggleDesktopSidebar() {
            const sidebarWrapper = document.getElementById('sidebarWrapper');
            // Menambahkan custom class yang mengandalkan kalkulasi CSS agar menyesuaikan otomatis
            sidebarWrapper.classList.toggle('sidebar-desktop-closed');
        }

        // 5. Fungsi Toggle Dropdown Menu (Sidebar)
        function toggleDropdown(menuId) {
            const menu = document.getElementById(menuId);
            const icon = document.getElementById('icon-' + menuId.split('-')[1]);
            
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                if(icon) icon.classList.add('rotate-180');
            } else {
                menu.classList.add('hidden');
                if(icon) icon.classList.remove('rotate-180');
            }
        }

        // 6. FUNGSI MODE GELAP (Dark Mode)
        function toggleDarkMode() {
            const htmlNode = document.documentElement;
            const themeIcon = document.getElementById('theme-icon');
            
            htmlNode.classList.toggle('dark');
            
            if (htmlNode.classList.contains('dark')) {
                themeIcon.setAttribute('data-lucide', 'sun');
            } else {
                themeIcon.setAttribute('data-lucide', 'moon');
            }
            
            lucide.createIcons();
        }

        // 7. FUNGSI LAYAR PENUH (Full Screen)
        function toggleFullScreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch((err) => {
                    console.log(`Gagal mengaktifkan mode layar penuh: ${err.message}`);
                });
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }

        document.addEventListener('fullscreenchange', () => {
            const icon = document.getElementById('fullscreen-icon');
            if (document.fullscreenElement) {
                icon.setAttribute('data-lucide', 'minimize');
            } else {
                icon.setAttribute('data-lucide', 'maximize');
            }
            lucide.createIcons();
        });

        // 8. FUNGSI DROPDOWN USER
        function toggleUserMenu() {
            const dropdown = document.getElementById('user-dropdown');
            dropdown.classList.toggle('hidden');
        }

        window.addEventListener('click', function(e) {
            const container = document.getElementById('user-menu-container');
            const dropdown = document.getElementById('user-dropdown');
            if (container && !container.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // ---------------------------------------------------------
        // FUNGSI SIMULASI DATA
        // ---------------------------------------------------------
        let appState = {
            transactions: []
        };

        function renderTable() {
            const tbody = document.getElementById('transaction-table-body');
            
            if (appState.transactions.length === 0) {
                tbody.innerHTML = `
                    <tr id="empty-state">
                        <td colspan="4" class="py-12 text-center text-sm text-gray-400 dark:text-gray-500">
                            Belum ada aktivitas produksi terbaru.
                        </td>
                    </tr>
                `;
                return;
            }

            let rowsHtml = '';
            appState.transactions.slice().reverse().forEach(trx => {
                let statusBadge = '';
                if(trx.status === 'Berjalan') {
                    statusBadge = `<span class="bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-400 px-2.5 py-1 rounded-md text-xs font-semibold">Berjalan</span>`;
                } else if (trx.status === 'Persiapan') {
                    statusBadge = `<span class="bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-400 px-2.5 py-1 rounded-md text-xs font-semibold">Persiapan</span>`;
                } else {
                    statusBadge = `<span class="bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-400 px-2.5 py-1 rounded-md text-xs font-semibold">Maintenance</span>`;
                }

                rowsHtml += `
                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        <td class="py-4 px-5 text-sm font-medium text-gray-900 dark:text-gray-200">#${trx.batchId}</td>
                        <td class="py-4 px-5 text-sm text-gray-600 dark:text-gray-400">${trx.machine}</td>
                        <td class="py-4 px-5 text-sm font-medium text-gray-900 dark:text-gray-200">${trx.output}</td>
                        <td class="py-4 px-5">
                            ${statusBadge}
                        </td>
                    </tr>
                `;
            });
            
            tbody.innerHTML = rowsHtml;
        }

        const mesinDummy = ["INJ-001 (Battenfeld)", "INJ-002 (Arburg)", "INJ-003 (Haitian)", "INJ-004 (Engel)"];
        let batchCounter = 5020;

        function simulateNewData() {
            const newTrx = {
                batchId: "B-" + batchCounter++,
                machine: mesinDummy[Math.floor(Math.random() * mesinDummy.length)],
                output: Math.floor(Math.random() * (5000 - 500 + 1) + 500),
                status: ['Berjalan', 'Berjalan', 'Persiapan', 'Maintenance'][Math.floor(Math.random() * 4)]
            };

            appState.transactions.push(newTrx);
            if(appState.transactions.length > 5) {
                appState.transactions.shift();
            }
            
            renderTable();
            
            const icon = document.querySelector('[data-lucide="refresh-cw"]');
            icon.classList.add('animate-spin');
            setTimeout(() => icon.classList.remove('animate-spin'), 500);
        }

    </script>
</body>
</html>