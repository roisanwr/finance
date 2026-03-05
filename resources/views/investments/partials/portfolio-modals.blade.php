<!-- Modal Transaksi Portofolio -->
<div id="transactionModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-900/75 dark:bg-gray-900/90 transition-opacity backdrop-blur-sm"
            aria-hidden="true" onclick="closeTransactionModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div
            class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-gray-100 dark:border-gray-700">
            <div class="bg-indigo-600 dark:bg-indigo-700 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <i data-lucide="activity" class="w-5 h-5"></i> Catat Transaksi Aset
                </h3>
                <button type="button" onclick="closeTransactionModal()"
                    class="text-indigo-200 hover:text-white transition-colors focus:outline-none">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form id="transactionForm" onsubmit="submitTransactionForm(event)"
                class="px-6 py-6 sm:p-6 sm:pb-4 space-y-5">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Aksi <span
                                class="text-red-500">*</span></label>
                        <select name="transaction_type" id="tx_type" required onchange="toggleWalletSection()"
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5 bg-gray-50">
                            <option value="BELI">Beli Aset</option>
                            <option value="JUAL">Jual Aset</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Instrumen
                            Aset <span class="text-red-500">*</span></label>
                        <select name="asset_id" id="pf_asset_id" required
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5 bg-gray-50">
                            <option value="" disabled selected>Memuat daftar aset...</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Jumlah Unit
                            <span class="text-red-500">*</span></label>
                        <input type="number" name="units" id="tx_units" step="0.00000001" min="0" required
                            placeholder="0.0" oninput="calculateTotalAmount()"
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5 bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Harga per
                            Unit <span class="text-red-500">*</span></label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <span class="text-gray-500 dark:text-gray-400 sm:text-sm font-medium">Rp</span>
                            </div>
                            <input type="number" name="price_per_unit" id="tx_price" min="0" required placeholder="0"
                                oninput="calculateTotalAmount()"
                                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm pl-11 pr-4 py-2.5 bg-gray-50">
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gray-50 dark:bg-gray-900/50 p-3 rounded-xl flex justify-between items-center border border-gray-100 dark:border-gray-700">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Transaksi</span>
                    <span class="text-lg font-bold text-gray-900 dark:text-white" id="tx_total_amount_display">Rp
                        0</span>
                </div>

                <div
                    class="bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800 rounded-xl p-4">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="link_to_wallet" id="link_to_wallet" value="true"
                            onchange="toggleWalletSection()"
                            class="w-5 h-5 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700">
                        <span class="text-sm font-semibold text-indigo-900 dark:text-indigo-300"
                            id="lbl_link_wallet">Potong Saldo dari Dompet Kas</span>
                    </label>

                    <div id="wallet_selection_box" class="mt-3 hidden transition-all">
                        <label class="block text-xs font-semibold text-indigo-800 dark:text-indigo-400 mb-1.5"
                            id="lbl_select_wallet">Pilih Dompet Sumber Dana</label>
                        <select name="wallet_id" id="pf_wallet_id"
                            class="w-full rounded-xl border-indigo-200 dark:border-indigo-800 dark:bg-gray-800 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5 bg-white">
                            <option value="" disabled selected>Memuat daftar dompet...</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Tanggal &
                            Waktu</label>
                        <input type="datetime-local" name="transaction_date" id="tx_date" required
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5 bg-gray-50">
                    </div>
                </div>

                <div class="mt-6 sm:mt-8 flex flex-row-reverse gap-3">
                    <button type="submit" id="btnSubmitTx"
                        class="w-full inline-flex justify-center rounded-xl border border-transparent bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto transition-colors">
                        Simpan Transaksi
                    </button>
                    <button type="button" onclick="closeTransactionModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-200 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:w-auto transition-colors">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let dynamicAssetsLoaded = false;
    let dynamicWalletsLoaded = false;

    // Set default datetime to now
    document.addEventListener('DOMContentLoaded', () => {
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        document.getElementById('tx_date').value = now.toISOString().slice(0, 16);
    });

    function calculateTotalAmount() {
        const units = parseFloat(document.getElementById('tx_units').value) || 0;
        const price = parseFloat(document.getElementById('tx_price').value) || 0;
        const total = units * price;
        document.getElementById('tx_total_amount_display').innerText = formatRupiah(total);
    }

    function toggleWalletSection() {
        const isLinked = document.getElementById('link_to_wallet').checked;
        const txType = document.getElementById('tx_type').value;
        const walletBox = document.getElementById('wallet_selection_box');
        const walletSelect = document.getElementById('pf_wallet_id');

        // Update Labels based on Buy/Sell
        const lblLink = document.getElementById('lbl_link_wallet');
        const lblSelect = document.getElementById('lbl_select_wallet');

        if (txType === 'BUY') {
            lblLink.innerText = "Potong Saldo dari Dompet Kas";
            lblSelect.innerText = "Pilih Dompet Sumber Dana (Pengeluaran)";
        } else {
            lblLink.innerText = "Simpan Hasil Jual ke Dompet Kas";
            lblSelect.innerText = "Pilih Dompet Tujuan (Pemasukan)";
        }

        if (isLinked) {
            walletBox.classList.remove('hidden');
            walletSelect.setAttribute('required', 'required');
            if (!dynamicWalletsLoaded) fetchWalletsForTx();
        } else {
            walletBox.classList.add('hidden');
            walletSelect.removeAttribute('required');
        }
    }

    async function fetchAssetsForTx() {
        try {
            const res = await fetch('/api/assets');
            const data = await res.json();
            const select = document.getElementById('pf_asset_id');
            select.innerHTML = '<option value="" disabled selected>-- Pilih Aset --</option>';
            data.forEach(a => {
                const label = a.name + ' (' + (a.ticker_symbol || a.asset_type) + ')';
                select.innerHTML += '<option value="' + a.id + '">' + label + '</option>';
            });
            dynamicAssetsLoaded = true;
        } catch (e) {
            console.error('Failed to load assets:', e);
            document.getElementById('pf_asset_id').innerHTML = '<option disabled>Gagal memuat aset</option>';
        }
    }

    async function fetchWalletsForTx() {
        try {
            const res = await fetch('/api/wallets');
            const data = await res.json();
            const select = document.getElementById('pf_wallet_id');
            select.innerHTML = '<option value="" disabled selected>-- Pilih Dompet --</option>';
            data.forEach(w => {
                const balFormatted = formatRupiah(w.balance || 0);
                select.innerHTML += '<option value="' + w.id + '">' + w.name + ' (Saldo: ' + balFormatted + ')</option>';
            });
            dynamicWalletsLoaded = true;
        } catch (e) {
            console.error('Failed to load wallets:', e);
            document.getElementById('pf_wallet_id').innerHTML = '<option disabled>Gagal memuat dompet</option>';
        }
    }

    function openTransactionModal() {
        document.getElementById('transactionForm').reset();
        calculateTotalAmount();
        toggleWalletSection();

        if (!dynamicAssetsLoaded) fetchAssetsForTx();

        // Reset datetime
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        document.getElementById('tx_date').value = now.toISOString().slice(0, 16);

        document.getElementById('transactionModal').classList.remove('hidden');
    }

    function closeTransactionModal() {
        document.getElementById('transactionModal').classList.add('hidden');
    }

    async function submitTransactionForm(event) {
        event.preventDefault();
        const form = event.target;
        const submitBtn = document.getElementById('btnSubmitTx');
        const formData = new FormData(form);

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 mr-2 animate-spin"></i> Memproses...';
        lucide.createIcons();

        try {
            // Handle unchecked checkbox explicitly 
            // FormData doesn't include unchecked checkboxes.
            const linkWallet = document.getElementById('link_to_wallet').checked;

            const payload = {
                asset_id: formData.get('asset_id'),
                transaction_type: formData.get('transaction_type'),
                units: formData.get('units'),
                price_per_unit: formData.get('price_per_unit'),
                transaction_date: formData.get('transaction_date'),
                notes: formData.get('notes') || '',
                link_to_wallet: linkWallet
            };

            if (linkWallet) {
                payload.wallet_id = formData.get('wallet_id');
            }

            const response = await fetch('/api/transactions/equity', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': formData.get('_token')
                },
                body: JSON.stringify(payload)
            });

            const result = await response.json();

            if (result.success) {
                showToast(result.message, 'success');
                closeTransactionModal();
                if (typeof loadPortfolios === 'function') loadPortfolios();
            } else {
                showToast(result.message || 'Gagal memproses transaksi.', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('Terjadi kesalahan sistem.', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Simpan Transaksi';
        }
    }
</script>