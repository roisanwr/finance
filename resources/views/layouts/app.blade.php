<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Dashboard - @yield('title', 'Overview')</title>
    <!-- Tailwind CSS untuk styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons untuk icon modern -->
    <script src="https://unpkg.com/lucide@latest"></script>
    @stack('styles')
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
            --jarak-atas-header: 10px;
            --jarak-kiri-kanan: 12px;
            --jarak-bawah: 10px;
            --lebar-sidebar: 260px;
            --jarak-antar-elemen: 20px;
            --lengkung-kotak: 10px;
            
            --jarak-kiri-menu: 8px;
            --jarak-kanan-profil: 12px;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .sudut-custom {
            border-radius: var(--lengkung-kotak) !important;
        }

        @media (min-width: 1024px) {
            .sidebar-desktop-closed {
                margin-left: calc(-1 * (var(--lebar-sidebar) + var(--jarak-kiri-kanan))) !important;
            }
        }

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

    <!-- HEADER WRAPPER -->
    <div class="w-full shrink-0 z-40 transition-all duration-300" style="padding-top: var(--jarak-atas-header); padding-left: var(--jarak-kiri-kanan); padding-right: var(--jarak-kiri-kanan); padding-bottom: var(--jarak-antar-elemen);">
        @include('layouts.header')
    </div>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex overflow-hidden relative z-10">
        
        <!-- OVERLAY MOBILE SIDEBAR -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-20 hidden lg:hidden" onclick="toggleMobileSidebar()"></div>

        <!-- SIDEBAR WRAPPER -->
        <div id="sidebarWrapper" class="absolute lg:relative inset-y-0 left-0 z-30 flex flex-col transition-all duration-300 ease-in-out -translate-x-full lg:translate-x-0" style="padding-left: var(--jarak-kiri-kanan); padding-bottom: var(--jarak-bawah);">
            @include('layouts.sidebar')
        </div>

        <!-- MAIN DASHBOARD CONTENT -->
        <main class="flex-1 overflow-y-auto" style="padding-right: var(--jarak-kiri-kanan); padding-bottom: var(--jarak-bawah); padding-left: var(--jarak-antar-elemen);">
            @yield('content')
        </main>
    </div>

    <!-- JAVASCRIPT LOGIC -->
    <script>
        lucide.createIcons();

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

        function toggleDesktopSidebar() {
            const sidebarWrapper = document.getElementById('sidebarWrapper');
            sidebarWrapper.classList.toggle('sidebar-desktop-closed');
        }

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

        function toggleUserMenu() {
            const dropdown = document.getElementById('user-dropdown');
            dropdown.classList.toggle('hidden');
        }

        window.addEventListener('click', function(e) {
            const container = document.getElementById('user-menu-container');
            const dropdown = document.getElementById('user-dropdown');
            if (container && dropdown && !container.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
