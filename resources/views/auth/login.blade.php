<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dashboard Monitoring Produksi</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        green: {
                            50: '#f0fdf4', 100: '#dcfce7', 200: '#bbf7d0',
                            500: '#22c55e', 600: '#16a34a', 700: '#15803d',
                            800: '#166534', 900: '#14532d',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 min-h-screen flex items-center justify-center p-4 transition-colors duration-300">

    <!-- Theme Toggle Floating -->
    <button onclick="toggleDarkMode()" class="absolute top-6 right-6 p-2 rounded-full bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors focus:outline-none">
        <i id="theme-icon" data-lucide="moon" class="w-5 h-5"></i>
    </button>

    <div class="w-full max-w-md">
        <!-- Card Container -->
        <div class="bg-white dark:bg-gray-800 rounded-[14px] shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden transition-colors duration-300">
            
            <!-- Header Section -->
            <div class="px-8 pt-8 pb-6 text-center">
                <div class="w-16 h-16 mx-auto bg-amber-50 dark:bg-amber-900/30 rounded-full flex items-center justify-center mb-4 border border-amber-100 dark:border-amber-800/50">
                    <svg class="w-9 h-9 text-amber-500" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm1.646 13.29c-.407 1.628-3.1 1.083-3.976.856l.703-2.816c.876.218 3.69.65 3.273 1.96zm.38-3.437c-.37 1.484-2.658.74-3.4.554l.637-2.556c.742.186 3.133.53 2.763 2.002zm.857-3.387l-.08.32c1.157.29 1.856.989 1.69 2.184-.244 1.734-1.78 2.13-3.524 1.948l-.695 2.783-1.086-.27.683-2.739-.866-.216-.683 2.74-1.084-.27.695-2.784-1.734-.433.33-1.33s.8.2.79.187c.441.11.52-.16.537-.27l.891-3.576c-.028-.007-.056-.012-.083-.02l.002-.01c.022.005.044.012.067.017l.316-1.265c-.01-.262-.195-.56-.728-.693.015-.007-.792-.198-.792-.198l.274-1.097 1.733.432-.001.006.827.206.274-1.097 1.085.271-.268 1.072c.264.056.538.115.801.193 1.067.335 1.7 1.036 1.49 2.04z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Selamat Datang Kembali</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Silakan masuk ke akun Anda untuk melanjutkan</p>
            </div>

            <!-- Form Section -->
            <div class="px-8 pb-8">
                <!-- Session Status / Error Display -->
                @if (session('status'))
                    <div class="mb-4 bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-400 p-3 rounded-lg text-sm border border-green-200 dark:border-green-800/50">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 p-3 rounded-lg text-sm border border-red-200 dark:border-red-800/50">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5 flex items-center">
                            Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i data-lucide="mail" class="w-5 h-5"></i>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 transition-colors"
                                placeholder="nama@perusahaan.com">
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Password
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs font-semibold text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 transition-colors">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i data-lucide="lock" class="w-5 h-5"></i>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="block w-full pl-10 pr-10 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 transition-colors"
                                placeholder="••••••••">
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none">
                                <i id="eye-icon" data-lucide="eye" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 accent-green-600">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-600 dark:text-gray-400">
                            Ingat saya
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-amber-500 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors duration-200 dark:focus:ring-offset-gray-800 relative group overflow-hidden">
                            <span class="relative z-10 flex items-center">
                                Masuk ke Dashboard
                                <i data-lucide="arrow-right" class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform"></i>
                            </span>
                            <div class="absolute inset-0 h-full w-0 bg-amber-700 transition-[width] ease-out duration-300 group-hover:w-full z-0"></div>
                        </button>
                    </div>

                    <!-- Divider -->
                    <div class="flex items-center">
                        <div class="flex-1 h-px bg-gray-200 dark:bg-gray-700"></div>
                        <span class="px-3 text-xs text-gray-400 dark:text-gray-500">atau</span>
                        <div class="flex-1 h-px bg-gray-200 dark:bg-gray-700"></div>
                    </div>

                    <!-- Link ke Register -->
                    <div>
                        <a href="{{ route('register') }}" class="w-full flex justify-center py-2.5 px-4 border border-gray-200 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            Belum punya akun? <span class="ml-1 font-semibold text-amber-600 dark:text-amber-400">Daftar di sini</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-xs text-gray-500 dark:text-gray-400 mt-6">
            &copy; 2024 Dashboard Produksi. Membutuhkan bantuan? <a href="#" class="font-medium text-green-600 hover:text-green-500 dark:text-green-400 dark:hover:text-green-300">Hubungi IT Support</a>.
        </p>
    </div>

    <!-- Scripts -->
    <script>
        lucide.createIcons();

        // Toggle Password Visibility
        function togglePassword() {
            const pwd = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                pwd.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }

        // Dark Mode Logic
        function toggleDarkMode() {
            const htmlNode = document.documentElement;
            const themeIcon = document.getElementById('theme-icon');
            
            htmlNode.classList.toggle('dark');
            
            const isDark = htmlNode.classList.contains('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            
            themeIcon.setAttribute('data-lucide', isDark ? 'sun' : 'moon');
            lucide.createIcons();
        }

        // Initialize Theme from localStorage
        const svTheme = localStorage.getItem('theme');
        if (svTheme === 'dark' || (!svTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            document.getElementById('theme-icon').setAttribute('data-lucide', 'sun');
        } else {
            document.documentElement.classList.remove('dark');
            document.getElementById('theme-icon').setAttribute('data-lucide', 'moon');
        }
        lucide.createIcons();
    </script>
</body>
</html>
