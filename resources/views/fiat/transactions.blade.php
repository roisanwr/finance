@extends('layouts.app')
@section('title', 'Arus Kas')

@section('content')
<div class="mb-6 flex justify-between items-end mt-2 lg:mt-0">
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1 transition-colors">Arus Kas</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm transition-colors">Catat aktivitas uang masuk, keluar, dan
            transfer antar dompet.</p>
    </div>

    <button onclick="openTxModal()"
        class="text-sm bg-indigo-600 dark:bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 dark:hover:bg-indigo-600 transition-colors font-medium flex items-center gap-2 shadow-sm shrink-0">
        <i data-lucide="plus" class="w-4 h-4"></i> Catat Transaksi
    </button>
</div>

<!-- History Container -->
<div
    class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 sudut-custom overflow-hidden shadow-sm shadow-gray-200/50 dark:shadow-gray-900/50">
    <!-- Header Tabel -->
    <div
        class="grid grid-cols-12 gap-4 p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:grid">
        <div class="col-span-3 lg:col-span-2">Tanggal</div>
        <div class="col-span-4 lg:col-span-5">Keterangan / Dompet</div>
        <div class="col-span-2 text-right">Kategori</div>
        <div class="col-span-2 text-right">Nominal</div>
        <div class="col-span-1 text-center">Aksi</div>
    </div>

    <div id="transactions-container"
        class="divide-y divide-gray-100 dark:divide-gray-700/50 flex flex-col min-h-[100px] relative">
        <!-- Skeleton Loader -->
        <div class="p-4 flex items-center gap-4 animate-pulse">
            <div class="w-10 h-10 bg-gray-200 dark:bg-gray-700 rounded-full shrink-0"></div>
            <div class="flex-1 space-y-2">
                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-1/3"></div>
                <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded w-1/4"></div>
            </div>
            <div class="h-5 bg-gray-200 dark:bg-gray-700 rounded w-20"></div>
            <div class="h-5 bg-gray-200 dark:bg-gray-700 rounded w-24"></div>
        </div>
    </div>
</div>

@push('modals')
<!-- Modal Catat Transaksi -->
<div id="txModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-[60] hidden flex items-center justify-center p-4">
    <div
        class="bg-white dark:bg-gray-800 sudut-custom w-full max-w-lg shadow-xl border border-gray-200 dark:border-gray-700 flex flex-col max-h-full">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-5 border-b border-gray-100 dark:border-gray-700">
            <h3 class="font-bold text-lg text-gray-900 dark:text-white flex items-center gap-2">
                <i data-lucide="receipt" class="w-5 h-5 text-indigo-500"></i> Catat Transaksi
            </h3>
            <button onclick="closeTxModal()"
                class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Scrollable Modal Body -->
        <form id="txForm" onsubmit="submitTxForm(event)" class="flex flex-col flex-1 overflow-hidden">
            <div class="p-6 overflow-y-auto w-full">

                <!-- TIPE TRANSAKSI (Tab Style) -->
                <div class="flex p-1 bg-gray-100 dark:bg-gray-900/50 rounded-lg mb-6">
                    <label class="flex-1 text-center cursor-pointer">
                        <input type="radio" name="tx_type" value="PENGELUARAN" class="peer sr-only" checked
                            onchange="handleTypeChange()">
                        <div
                            class="py-2 text-sm font-medium text-gray-500 dark:text-gray-400 rounded-md transition-all peer-checked:bg-white peer-checked:dark:bg-gray-700 peer-checked:text-rose-600 peer-checked:dark:text-rose-400 peer-checked:shadow-sm">
                            Pengeluaran</div>
                    </label>
                    <label class="flex-1 text-center cursor-pointer">
                        <input type="radio" name="tx_type" value="PEMASUKAN" class="peer sr-only"
                            onchange="handleTypeChange()">
                        <div
                            class="py-2 text-sm font-medium text-gray-500 dark:text-gray-400 rounded-md transition-all peer-checked:bg-white peer-checked:dark:bg-gray-700 peer-checked:text-emerald-600 peer-checked:dark:text-emerald-400 peer-checked:shadow-sm">
                            Pemasukan</div>
                    </label>
                    <label class="flex-1 text-center cursor-pointer">
                        <input type="radio" name="tx_type" value="TRANSFER" class="peer sr-only"
                            onchange="handleTypeChange()">
                        <div
                            class="py-2 text-sm font-medium text-gray-500 dark:text-gray-400 rounded-md transition-all peer-checked:bg-white peer-checked:dark:bg-gray-700 peer-checked:text-blue-600 peer-checked:dark:text-blue-400 peer-checked:shadow-sm">
                            Transfer</div>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <!-- Tanggal -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal</label>
                        <input type="datetime-local" id="tx_date" required
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2 px-3 sm:text-sm">
                    </div>
                    <!-- Nominal -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nominal
                            (Rp)</label>
                        <input type="number" id="tx_amount" required min="1" step="any" placeholder="0"
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2 px-3 sm:text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4" id="wallet_section">
                    <!-- Dompet Sumber (Atau Dompet tujuan) -->
                    <div id="source_wallet_wrap">
                        <label id="lbl_source_wallet"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gunakan
                            Dompet</label>
                        <select id="tx_wallet" required
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2 px-3 sm:text-sm">
                            <option value="">Pilih Dompet...</option>
                        </select>
                    </div>

                    <!-- Kategori (Hide saat transfer) -->
                    <div id="category_wrap">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori</label>
                        <select id="tx_category"
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2 px-3 sm:text-sm">
                            <option value="">Pilih Kategori...</option>
                        </select>
                    </div>

                    <!-- Dompet Tujuan (Hide saat Bukan Transfer) -->
                    <div id="target_wallet_wrap" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ke Dompet</label>
                        <select id="tx_target_wallet"
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2 px-3 sm:text-sm">
                            <option value="">Pilih Dompet Tujuan...</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Keterangan /
                        Deskripsi</label>
                    <textarea id="tx_desc" rows="2" placeholder="Catatan tambahan (Opsional)"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2 px-3 sm:text-sm resize-none"></textarea>
                </div>
            </div>

            <!-- Modal Footer -->
            <div
                class="p-5 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-2 bg-gray-50/50 dark:bg-gray-800/30">
                <button type="button" onclick="closeTxModal()"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">Batal</button>
                <button type="submit" id="btnSubmitTx"
                    class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endpush

@endsection

@push('scripts')
<script>
    const headers = {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    };

    let walletsStore = [];
    let categoriesStore = [];
    let transactionsStore = [];

    // Formatter Rupiah
    const formatRp = (number) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
    // Formatter Date
    const formatDate = (dateString) => {
        const opt = { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' };
        return new Date(dateString).toLocaleDateString('id-ID', opt).replace('pukul', '|');
    };

    document.addEventListener("DOMContentLoaded", () => {
        loadReferences();
    });

    // Load master data (Wallet & Category) dan fetch transactions
    function loadReferences() {
        Promise.all([
            fetch('/api/wallets', { headers }).then(r => r.json()),
            fetch('/api/categories', { headers }).then(r => r.json()),
            fetch('/api/transactions', { headers }).then(r => r.json())
        ])
            .then(([wallets, categories, txs]) => {
                walletsStore = wallets;
                categoriesStore = categories;
                transactionsStore = txs;
                renderTransactions();
            })
            .catch(err => {
                console.error("Error loading references", err);
                showToast("Gagal memuat data fundamental. Muat ulang halaman.", "error");
            });
    }

    // Refresh history
    function fetchTransactions() {
        fetch('/api/transactions', { headers })
            .then(res => res.json())
            .then(data => {
                transactionsStore = data;
                renderTransactions();
            });
    }

    function renderTransactions() {
        const container = document.getElementById('transactions-container');
        container.innerHTML = '';

        if (transactionsStore.length === 0) {
            container.innerHTML = `
                <div class="py-10 text-center text-gray-500 dark:text-gray-400">
                    <i data-lucide="receipt" class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600"></i>
                    <p>Belum ada riwayat transaksi dicatat.</p>
                </div>
            `;
            lucide.createIcons();
            return;
        }

        transactionsStore.forEach(tx => {
            // Tentukan style berdasarkan tipe
            let iconText = 'P';
            let iconClass = 'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400';
            let amountSign = '';
            let amountColor = 'text-gray-900 dark:text-white';

            if (tx.transaction_type === 'PEMASUKAN') {
                iconText = '+';
                iconClass = 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/40 dark:text-emerald-400';
                amountSign = '+';
                amountColor = 'text-emerald-600 dark:text-emerald-400';
            } else if (tx.transaction_type === 'PENGELUARAN') {
                iconText = '-';
                iconClass = 'bg-rose-100 text-rose-600 dark:bg-rose-900/40 dark:text-rose-400';
                amountSign = '-';
            } else if (tx.transaction_type === 'TRANSFER') {
                iconText = '⇄';
                iconClass = 'bg-blue-100 text-blue-600 dark:bg-blue-900/40 dark:text-blue-400';
            }

            const catName = tx.category ? tx.category.name : '-';
            const walletName = tx.wallet ? tx.wallet.name : '?';
            const descHtml = tx.description ? `<p class="text-xs text-gray-500 mt-1 line-clamp-1">${tx.description}</p>` : '';

            const row = document.createElement('div');
            row.className = 'grid grid-cols-1 md:grid-cols-12 gap-y-2 gap-x-4 p-4 items-center hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors group';

            row.innerHTML = `
                <!-- Mobile Date / Kategori Tampil beda -->
                <div class="col-span-12 md:hidden flex justify-between items-center mb-1">
                    <span class="text-xs text-gray-500">${formatDate(tx.transaction_date)}</span>
                    <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">${catName}</span>
                </div>

                <!-- Desktop / Main Content -->
                <div class="col-span-3 lg:col-span-2 hidden md:flex flex-col">
                    <span class="text-sm text-gray-900 dark:text-white">${formatDate(tx.transaction_date).split(' | ')[0]}</span>
                    <span class="text-xs text-gray-500">${formatDate(tx.transaction_date).split(' | ')[1]}</span>
                </div>
                
                <div class="col-span-8 md:col-span-4 lg:col-span-5 flex items-start sm:items-center gap-3">
                    <div class="${iconClass} w-9 h-9 rounded-full flex items-center justify-center font-bold font-mono text-lg shrink-0">
                        ${iconText}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 line-clamp-1">
                            ${tx.transaction_type} ${walletName !== '?' ? '&middot; <span class="text-indigo-600 dark:text-indigo-400 font-medium"> ' + walletName + '</span>' : ''}
                        </p>
                        ${descHtml}
                    </div>
                </div>

                <div class="hidden md:flex col-span-2 justify-end items-center">
                    <span class="text-xs font-medium px-2 py-1 rounded-full bg-gray-100 dark:bg-gray-700/60 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300">
                        ${catName}
                    </span>
                </div>

                <div class="col-span-4 md:col-span-2 flex justify-end items-center md:items-end flex-col">
                    <span class="font-bold text-sm sm:text-base ${amountColor}">${amountSign}${formatRp(tx.amount)}</span>
                </div>

                <!-- Actions -->
                <div class="col-span-full md:col-span-1 flex md:justify-center justify-end">
                     <button onclick="deleteTx('${tx.id}')" class="p-1.5 md:opacity-0 group-hover:opacity-100 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20 text-red-500 dark:text-red-400 transition-all" title="Hapus Transaksi">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                     </button>
                </div>
            `;

            container.appendChild(row);
        });

        lucide.createIcons();
    }

    // ========== LOGIKA MODAL FORM ==========

    function openTxModal() {
        document.getElementById('txForm').reset();

        // Default dateTime is NOW()
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        document.getElementById('tx_date').value = now.toISOString().slice(0, 16);

        // Reset state
        document.querySelector('input[name="tx_type"][value="PENGELUARAN"]').checked = true;
        handleTypeChange();

        document.getElementById('txModal').classList.remove('hidden');
    }

    function closeTxModal() {
        document.getElementById('txModal').classList.add('hidden');
    }

    // Triggered when Radio Button is clicked
    function handleTypeChange() {
        const typeInputs = document.querySelectorAll('input[name="tx_type"]');
        let selectedType = 'PENGELUARAN';
        typeInputs.forEach(input => { if (input.checked) selectedType = input.value; });

        const isTransfer = (selectedType === 'TRANSFER');

        const catWrap = document.getElementById('category_wrap');
        const txCategory = document.getElementById('tx_category');
        const targetWrap = document.getElementById('target_wallet_wrap');
        const txTarget = document.getElementById('tx_target_wallet');
        const lblSource = document.getElementById('lbl_source_wallet');

        // Populate Dompet (Source)
        const walletSelect = document.getElementById('tx_wallet');
        walletSelect.innerHTML = '<option value="">Pilih Dompet...</option>';
        walletsStore.forEach(w => walletSelect.add(new Option(w.name, w.id)));

        if (isTransfer) {
            // TRANSFER MODE
            catWrap.classList.add('hidden');
            txCategory.removeAttribute('required');

            targetWrap.classList.remove('hidden');
            txTarget.setAttribute('required', 'required');
            lblSource.innerText = "Sumber Dana";

            // Populate Target Wallet
            txTarget.innerHTML = '<option value="">Pilih Dompet Tujuan...</option>';
            walletsStore.forEach(w => txTarget.add(new Option(w.name, w.id)));

        } else {
            // PENGELUARAN / PEMASUKAN MODE
            catWrap.classList.remove('hidden');
            txCategory.setAttribute('required', 'required');

            targetWrap.classList.add('hidden');
            txTarget.removeAttribute('required');
            lblSource.innerText = "Gunakan Dompet";

            // Populate Filtered Category
            txCategory.innerHTML = '<option value="">Pilih Kategori...</option>';
            categoriesStore.filter(c => c.type === selectedType).forEach(c => {
                txCategory.add(new Option(c.name, c.id));
            });
        }
    }

    function submitTxForm(e) {
        e.preventDefault();

        let selectedType = 'PENGELUARAN';
        document.querySelectorAll('input[name="tx_type"]').forEach(i => { if (i.checked) selectedType = i.value });

        const payload = {
            transaction_type: selectedType,
            transaction_date: document.getElementById('tx_date').value,
            amount: document.getElementById('tx_amount').value,
            wallet_id: document.getElementById('tx_wallet').value,
            description: document.getElementById('tx_desc').value
        };

        if (selectedType === 'TRANSFER') {
            payload.target_wallet_id = document.getElementById('tx_target_wallet').value;
            if (payload.wallet_id === payload.target_wallet_id) {
                return showToast("Dompet sumber dan dompet tujuan tidak boleh sama!", "warning");
            }
        } else {
            payload.category_id = document.getElementById('tx_category').value;
        }

        const btn = document.getElementById('btnSubmitTx');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin mr-2"></i>y...';
        btn.disabled = true;
        lucide.createIcons();

        fetch('/api/transactions', {
            method: 'POST',
            headers: headers,
            body: JSON.stringify(payload)
        })
            .then(async res => {
                const data = await res.json();
                if (!res.ok) throw new Error(data.message || 'Gagal menyimpan transaksi');
                return data;
            })
            .then(data => {
                if (data.success) {
                    closeTxModal();
                    fetchTransactions(); // resync history
                    showToast('Transaksi berhasil dicatat.', 'success');
                } else {
                    showToast(data.message || 'Gagal menyimpan transaksi', 'error');
                }
            })
            .catch(err => showToast(err.message, 'error'))
            .finally(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
    }

    window.deleteTx = function (id) {
        showConfirm("Yakin ingin menghapus historis transaksi ini? Arus saldo dompet tidak akan di-_revert_ secara otomatis di versi ini.").then(ok => {
            if (!ok) return;

            fetch(`/api/transactions/${id}`, {
                method: 'DELETE',
                headers: headers
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        fetchTransactions();
                        showToast('Transaksi dihapus.', 'warning');
                    } else {
                        showToast('Gagal menghapus.', 'error');
                    }
                })
                .catch(() => showToast('Terjadi kesalahan', 'error'));
        });
    }

</script>
@endpush