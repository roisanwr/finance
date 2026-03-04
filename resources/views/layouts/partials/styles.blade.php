{{-- ============================================================
     STYLES PARTIAL
     Berisi: konfigurasi Tailwind tema kustom, import font,
     dan semua CSS global untuk layout utama aplikasi.
     @include('layouts.partials.styles')
     ============================================================ --}}

{{-- Tailwind CSS CDN --}}
<script src="https://cdn.tailwindcss.com"></script>

{{-- Konfigurasi tema kustom Tailwind --}}
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

{{-- CSS Global --}}
<style>
    /* Import font Inter dari Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    /* ---- Variabel CSS Global ---- */
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

    /* ---- Utilitas ---- */
    .sudut-custom {
        border-radius: var(--lengkung-kotak) !important;
    }

    /* ---- Sidebar Desktop Toggle ---- */
    @media (min-width: 1024px) {
        .sidebar-desktop-closed {
            margin-left: calc(-1 * (var(--lebar-sidebar) + var(--jarak-kiri-kanan))) !important;
        }
    }

    /* ---- Custom Scrollbar ---- */
    ::-webkit-scrollbar         { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track   { background: transparent; }
    ::-webkit-scrollbar-thumb   { background: #e5e7eb; border-radius: 10px; }
    .dark ::-webkit-scrollbar-thumb { background: #4b5563; }
    ::-webkit-scrollbar-thumb:hover { background: #d1d5db; }
    .dark ::-webkit-scrollbar-thumb:hover { background: #6b7280; }
</style>
