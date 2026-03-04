{{-- ============================================================
SCRIPTS PARTIAL
Berisi: semua fungsi JavaScript global layout aplikasi.
- Inisialisasi Lucide Icons
- Live Date & Time di header
- Toggle Sidebar (mobile & desktop)
- Toggle Dark Mode
- Toggle Fullscreen
- Toggle Dropdown User Menu
@include('layouts.partials.scripts')
============================================================ --}}
<script>
    // =============================================
    //  GLOBAL POPUP NOTIFICATION (SweetAlert-style)
    //  Cara pakai: showToast('Pesan', 'success')
    //  Tipe: 'success' | 'error' | 'info' | 'warning'
    // =============================================
    const _swalIcons = {
        success: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>`,
        error: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>`,
        info: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`,
        warning: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>`,
    };
    const _swalTitles = { success: 'Berhasil!', error: 'Oops!', info: 'Info', warning: 'Perhatian!' };
    let _swalTimer = null;

    function showToast(message, type = 'info', duration = 3500) {
        const overlay = document.getElementById('swal-overlay');
        const box = document.getElementById('swal-box');
        const iconWrap = document.getElementById('swal-icon-wrap');
        const title = document.getElementById('swal-title');
        const msg = document.getElementById('swal-message');
        const progress = document.getElementById('swal-progress');
        if (!overlay) return;

        // Reset tipe lama
        box.className = `swal-${type}`;

        // Isi konten
        iconWrap.innerHTML = _swalIcons[type] || _swalIcons.info;
        title.textContent = _swalTitles[type] || 'Notifikasi';
        msg.textContent = message;

        // Progress bar animasi
        progress.style.transition = 'none';
        progress.style.transform = 'scaleX(1)';
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                progress.style.transition = `transform ${duration}ms linear`;
                progress.style.transform = 'scaleX(0)';
            });
        });

        // Tampilkan popup
        overlay.classList.add('show');

        // Clear timer lama jika ada
        if (_swalTimer) clearTimeout(_swalTimer);
        _swalTimer = setTimeout(closeSwal, duration);
    }

    function closeSwal() {
        const overlay = document.getElementById('swal-overlay');
        if (overlay) overlay.classList.remove('show');
        if (_swalTimer) { clearTimeout(_swalTimer); _swalTimer = null; }
    }

    // Tutup jika klik di luar box
    document.addEventListener('click', function (e) {
        const overlay = document.getElementById('swal-overlay');
        const box = document.getElementById('swal-box');
        if (overlay && overlay.classList.contains('show') && !box.contains(e.target)) {
            closeSwal();
        }
    });

    // =============================================
    //  GLOBAL CONFIRM DIALOG (pengganti confirm() browser)
    //  Cara pakai: showConfirm('Pesan').then(ok => { if(ok) hapusSesuatu() })
    // =============================================
    function showConfirm(message, title = 'Yakin ingin menghapus?') {
        return new Promise((resolve) => {
            const overlay = document.getElementById('confirm-overlay');
            const titleEl = document.getElementById('confirm-title');
            const msgEl = document.getElementById('confirm-message');
            let okBtn = document.getElementById('confirm-ok');
            let cancelBtn = document.getElementById('confirm-cancel');
            if (!overlay) { resolve(false); return; }

            titleEl.textContent = title;
            msgEl.textContent = message;
            overlay.classList.add('show');

            // Clone untuk buang event listener lama
            const freshOk = okBtn.cloneNode(true);
            const freshCancel = cancelBtn.cloneNode(true);
            okBtn.replaceWith(freshOk);
            cancelBtn.replaceWith(freshCancel);

            function handle(result) {
                overlay.classList.remove('show');
                resolve(result);
            }

            freshOk.addEventListener('click', () => handle(true));
            freshCancel.addEventListener('click', () => handle(false));
            overlay.addEventListener('click', function onBackdrop(e) {
                if (e.target === overlay) {
                    overlay.removeEventListener('click', onBackdrop);
                    handle(false);
                }
            });
        });
    }

    function closeConfirm() {
        const overlay = document.getElementById('confirm-overlay');
        if (overlay) overlay.classList.remove('show');
    }

    // ----- Inisialisasi Icon -----
    lucide.createIcons();

    // ----- Live Date & Time -----
    function updateDateTime() {
        const now = new Date();
        const optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const dateStr = now.toLocaleDateString('id-ID', optionsDate);
        const timeStr = now.toLocaleTimeString('id-ID', { hour12: false });

        const dateEl = document.getElementById('current-date');
        const timeEl = document.getElementById('current-time');

        if (dateEl) dateEl.textContent = dateStr;
        if (timeEl) timeEl.textContent = timeStr;
    }
    setInterval(updateDateTime, 1000);
    updateDateTime();

    // ----- Toggle Sidebar Mobile -----
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

    // ----- Toggle Sidebar Desktop -----
    function toggleDesktopSidebar() {
        const sidebarWrapper = document.getElementById('sidebarWrapper');
        sidebarWrapper.classList.toggle('sidebar-desktop-closed');
    }

    // ----- Toggle Dropdown Menu Sidebar -----
    function toggleDropdown(menuId) {
        const menu = document.getElementById(menuId);
        const icon = document.getElementById('icon-' + menuId.split('-')[1]);

        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
            if (icon) icon.classList.add('rotate-180');
        } else {
            menu.classList.add('hidden');
            if (icon) icon.classList.remove('rotate-180');
        }
    }

    // ----- Toggle Dark Mode -----
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

    // ----- Toggle Fullscreen -----
    function toggleFullScreen() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen().catch((err) => {
                console.log(`Gagal mengaktifkan mode layar penuh: ${err.message}`);
            });
        } else {
            if (document.exitFullscreen) document.exitFullscreen();
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

    // ----- Toggle User Dropdown -----
    function toggleUserMenu() {
        const dropdown = document.getElementById('user-dropdown');
        dropdown.classList.toggle('hidden');
    }

    window.addEventListener('click', function (e) {
        const container = document.getElementById('user-menu-container');
        const dropdown = document.getElementById('user-dropdown');
        if (container && dropdown && !container.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>