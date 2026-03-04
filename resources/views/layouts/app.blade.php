<!DOCTYPE html>
<html lang="id" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Dashboard - @yield('title', 'Overview')</title>
    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>
    {{-- Styles: Tailwind config, Google Fonts, CSS global --}}
    @include('layouts.partials.styles')
    @stack('styles')

    {{-- SweetAlert-Style Popup & Confirm Styles --}}
    <style>
        /* === Overlay Backdrop (shared) === */
        #swal-overlay,
        #confirm-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 15, 30, 0.5);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 9998;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.25s ease;
            pointer-events: none;
        }

        #confirm-overlay {
            z-index: 9999;
        }

        #swal-overlay.show,
        #confirm-overlay.show {
            opacity: 1;
            pointer-events: all;
        }

        /* === Popup Card (shared) === */
        #swal-box,
        #confirm-box {
            background: #fff;
            border-radius: 20px;
            padding: 44px 40px 36px;
            max-width: 380px;
            width: 90%;
            text-align: center;
            box-shadow: 0 32px 80px rgba(0, 0, 0, 0.2);
            transform: scale(0.75) translateY(30px);
            opacity: 0;
            transition: transform 0.38s cubic-bezier(.34, 1.56, .64, 1), opacity 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .dark #swal-box,
        .dark #confirm-box {
            background: #1f2937;
        }

        #swal-overlay.show #swal-box,
        #confirm-overlay.show #confirm-box {
            transform: scale(1) translateY(0);
            opacity: 1;
        }

        /* === Ikon Besar (shared) === */
        #swal-icon-wrap,
        #confirm-icon-wrap {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 22px;
        }

        #swal-icon-wrap svg,
        #confirm-icon-wrap svg {
            width: 42px;
            height: 42px;
            stroke-width: 2.5;
        }

        /* Warna ikon notifikasi */
        .swal-success #swal-icon-wrap {
            background: #dcfce7;
            color: #16a34a;
        }

        .swal-error #swal-icon-wrap {
            background: #fee2e2;
            color: #dc2626;
        }

        .swal-info #swal-icon-wrap {
            background: #e0e7ff;
            color: #4f46e5;
        }

        .swal-warning #swal-icon-wrap {
            background: #fef3c7;
            color: #d97706;
        }

        /* Warna ikon confirm (merah – hapus) */
        #confirm-icon-wrap {
            background: #fee2e2;
            color: #dc2626;
        }

        /* === Teks === */
        #swal-title,
        #confirm-title {
            font-size: 20px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .dark #swal-title,
        .dark #confirm-title {
            color: #f9fafb;
        }

        #swal-message,
        #confirm-message {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.65;
            margin-bottom: 28px;
        }

        .dark #swal-message,
        .dark #confirm-message {
            color: #9ca3af;
        }

        /* === Tombol OK (notifikasi) === */
        #swal-btn {
            padding: 11px 42px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            color: #fff;
            transition: filter 0.2s, transform 0.15s;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
        }

        #swal-btn:hover {
            filter: brightness(1.08);
            transform: translateY(-1px);
        }

        #swal-btn:active {
            transform: translateY(0);
        }

        .swal-success #swal-btn {
            background: linear-gradient(135deg, #16a34a, #22c55e);
        }

        .swal-error #swal-btn {
            background: linear-gradient(135deg, #dc2626, #ef4444);
        }

        .swal-info #swal-btn {
            background: linear-gradient(135deg, #4338ca, #6366f1);
        }

        .swal-warning #swal-btn {
            background: linear-gradient(135deg, #d97706, #f59e0b);
        }

        /* === Tombol konfirmasi (Batal & Hapus) === */
        #confirm-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        #confirm-cancel {
            padding: 11px 28px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            border: 2px solid #e5e7eb;
            background: transparent;
            color: #6b7280;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
        }

        #confirm-cancel:hover {
            background: #f3f4f6;
            color: #374151;
        }

        .dark #confirm-cancel {
            border-color: #374151;
            color: #9ca3af;
        }

        .dark #confirm-cancel:hover {
            background: #374151;
            color: #f9fafb;
        }

        #confirm-ok {
            padding: 11px 28px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            border: none;
            background: linear-gradient(135deg, #dc2626, #ef4444);
            color: #fff;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(220, 38, 38, 0.35);
            transition: filter 0.2s, transform 0.15s;
        }

        #confirm-ok:hover {
            filter: brightness(1.08);
            transform: translateY(-1px);
        }

        #confirm-ok:active {
            transform: translateY(0);
        }

        /* === Progress Bar Auto-Dismiss === */
        #swal-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 4px;
            width: 100%;
            transform-origin: left;
            border-radius: 0 0 4px 4px;
        }

        .swal-success #swal-progress {
            background: #22c55e;
        }

        .swal-error #swal-progress {
            background: #ef4444;
        }

        .swal-info #swal-progress {
            background: #6366f1;
        }

        .swal-warning #swal-progress {
            background: #f59e0b;
        }
    </style>
</head>

<body
    class="bg-[#f3f4f8] dark:bg-gray-900 text-gray-800 dark:text-gray-100 h-screen overflow-hidden flex flex-col transition-colors duration-200">

    {{-- Notifikasi Popup (showToast) --}}
    <div id="swal-overlay">
        <div id="swal-box">
            <div id="swal-icon-wrap"></div>
            <div id="swal-title"></div>
            <div id="swal-message"></div>
            <button id="swal-btn" onclick="closeSwal()">OK</button>
            <div id="swal-progress"></div>
        </div>
    </div>

    {{-- Konfirmasi Dialog (showConfirm) --}}
    <div id="confirm-overlay">
        <div id="confirm-box">
            <div id="confirm-icon-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="3 6 5 6 21 6" />
                    <path d="M19 6l-1 14H6L5 6" />
                    <path d="M10 11v6" />
                    <path d="M14 11v6" />
                    <path d="M9 6V4h6v2" />
                </svg>
            </div>
            <div id="confirm-title">Yakin ingin menghapus?</div>
            <div id="confirm-message"></div>
            <div id="confirm-actions">
                <button id="confirm-cancel" onclick="closeConfirm()">Batal</button>
                <button id="confirm-ok">Hapus</button>
            </div>
        </div>
    </div>

    {{-- HEADER --}}
    <div class="w-full shrink-0 z-40 transition-all duration-300"
        style="padding-top: var(--jarak-atas-header); padding-left: var(--jarak-kiri-kanan); padding-right: var(--jarak-kiri-kanan); padding-bottom: var(--jarak-antar-elemen);">
        @include('layouts.header')
    </div>

    {{-- MAIN CONTENT AREA --}}
    <div class="flex-1 flex overflow-hidden relative z-10">

        {{-- Overlay Sidebar Mobile --}}
        <div id="sidebarOverlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-20 hidden lg:hidden"
            onclick="toggleMobileSidebar()"></div>

        {{-- SIDEBAR --}}
        <div id="sidebarWrapper"
            class="absolute lg:relative inset-y-0 left-0 z-30 flex flex-col transition-all duration-300 ease-in-out -translate-x-full lg:translate-x-0"
            style="padding-left: var(--jarak-kiri-kanan); padding-bottom: var(--jarak-bawah);">
            @include('layouts.sidebar')
        </div>

        {{-- KONTEN HALAMAN --}}
        <main class="flex-1 overflow-y-auto"
            style="padding-right: var(--jarak-kiri-kanan); padding-bottom: var(--jarak-bawah); padding-left: var(--jarak-antar-elemen);">
            @yield('content')
        </main>
    </div>

    {{-- Modals: Tempat untuk injeksi popup modal dari view agar merender di luar stacking context konten utama --}}
    @stack('modals')

    {{-- Scripts: fungsi JS global layout --}}
    @include('layouts.partials.scripts')
    @stack('scripts')
</body>

</html>