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
            <!-- App Logo (Wallet Icon) -->
            <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-full border-2 border-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center shrink-0">
                <i data-lucide="wallet" class="w-6 h-6 text-indigo-500"></i>
            </div>
            <!-- Titles -->
            <div class="hidden sm:block">
                <h1 class="text-[17px] font-bold text-[#1e293b] dark:text-white leading-tight tracking-tight">Personal Finance</h1>
                <p class="text-[13px] text-gray-500 dark:text-gray-400 leading-tight mt-0.5">Investment Tracker</p>
            </div>
        </div>
    </div>

    <!-- Center: Date & Time Pill -->
    <div class="hidden md:flex items-center bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800/60 rounded-lg px-4 py-2 shadow-sm">
        <!-- Date -->
        <div class="flex items-center text-indigo-700 dark:text-indigo-400">
            <i data-lucide="calendar" class="w-4 h-4 mr-2"></i>
            <span id="current-date" class="text-sm font-semibold tracking-wide">Memuat...</span>
        </div>
        <!-- Divider -->
        <div class="w-px h-4 bg-indigo-200 dark:bg-indigo-700/60 mx-4"></div>
        <!-- Time -->
        <div class="flex items-center text-indigo-700 dark:text-indigo-400">
            <i data-lucide="clock" class="w-4 h-4 mr-2"></i>
            <span id="current-time" class="text-sm font-bold tracking-widest">00:00:00</span>
        </div>
    </div>

    <!-- Right Side Header -->
    <div class="flex items-center space-x-3 sm:space-x-5">
        <!-- Tools Wrapper -->
        <div class="flex items-center space-x-2 sm:space-x-3.5">
            <!-- Toggle Switch (Mode Gelap) -->
            <button onclick="toggleDarkMode()" class="w-[38px] h-5 bg-gray-500 dark:bg-indigo-600 rounded-full flex items-center px-0.5 focus:outline-none transition-colors duration-300 relative group">
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
                <div class="bg-indigo-600 text-white rounded-full w-[38px] h-[38px] flex items-center justify-center font-bold text-[13px] tracking-wide shadow-sm group-hover:bg-indigo-700 transition-colors">
                    US
                </div>
                <div class="hidden md:flex items-center space-x-1 pl-1">
                    <span class="text-[15px] font-semibold text-gray-800 dark:text-gray-200">{{ auth()->user()->name ?? 'User' }}</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-200 transition-colors"></i>
                </div>
            </button>
            <!-- Dropdown Menu -->
            <div id="user-dropdown" class="hidden absolute right-0 mt-3 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 border border-gray-200 dark:border-gray-700 z-50 transform origin-top-right transition-all">
                <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 md:hidden">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ auth()->user()->name ?? 'User' }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email ?? 'user@example.com' }}</p>
                </div>
                <a href="#" class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center transition-colors">
                    <i data-lucide="user" class="w-4 h-4 mr-2"></i> Profil Saya
                </a>
                <a href="#" class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center transition-colors">
                    <i data-lucide="settings" class="w-4 h-4 mr-2"></i> Pengaturan
                </a>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center transition-colors border-t border-gray-100 dark:border-gray-700 mt-1">
                        <i data-lucide="log-out" class="w-4 h-4 mr-2"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
