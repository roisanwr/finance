<!-- Modal Tambah Aset -->
<div id="assetModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-900/75 dark:bg-gray-900/90 transition-opacity backdrop-blur-sm"
            aria-hidden="true" onclick="closeAssetModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-gray-100 dark:border-gray-700">

            <div class="bg-indigo-600 dark:bg-indigo-700 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white flex items-center gap-2" id="modal-title">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i> Tambah Aset Baru
                </h3>
                <button type="button" onclick="closeAssetModal()"
                    class="text-indigo-200 hover:text-white transition-colors focus:outline-none">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form id="assetForm" onsubmit="submitAssetForm(event)" class="px-6 py-6 sm:p-6 sm:pb-4 space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Nama
                        Aset <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" required placeholder="Cth: Bitcoin, BBCA, Antam 10g"
                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5 bg-gray-50">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="asset_type"
                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Kategori / Tipe
                            <span class="text-red-500">*</span></label>
                        <select name="asset_type" id="asset_type" required
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5 bg-gray-50">
                            <option value="KRIPTO">Kripto</option>
                            <option value="SAHAM">Saham</option>
                            <option value="LOGAM_MULIA">Emas / Logam Mulia</option>
                            <option value="PROPERTI">Properti</option>
                            <option value="BISNIS">Bisnis</option>
                            <option value="LAINNYA">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label for="ticker_symbol"
                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Ticker /
                            Simbol</label>
                        <input type="text" name="ticker_symbol" id="ticker_symbol" placeholder="Cth: BTC, TLKM"
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5 text-transform: uppercase bg-gray-50 uppercase">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="initial_price"
                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Harga Pasar Saat
                            Ini</label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <span class="text-gray-500 dark:text-gray-400 sm:text-sm font-medium">Rp</span>
                            </div>
                            <input type="number" name="initial_price" id="initial_price" min="0" placeholder="0"
                                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm pl-11 pr-4 py-2.5 bg-gray-50">
                        </div>
                    </div>
                    <div>
                        <label for="unit_name"
                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Satuan <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="unit_name" id="unit_name" value="unit" required
                            placeholder="lot, koin, gram"
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5 bg-gray-50">
                    </div>
                </div>

                <div class="mt-6 sm:mt-8 flex flex-row-reverse gap-3">
                    <button type="submit" id="btnSubmitAsset"
                        class="w-full inline-flex justify-center rounded-xl border border-transparent bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto transition-colors">
                        Simpan Aset
                    </button>
                    <button type="button" onclick="closeAssetModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-200 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:w-auto transition-colors">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Update Harga -->
<div id="valuationModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-900/75 dark:bg-gray-900/90 transition-opacity backdrop-blur-sm"
            aria-hidden="true" onclick="closeValuationModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full border border-gray-100 dark:border-gray-700">

            <form id="valuationForm" onsubmit="submitValuationForm(event)" class="px-6 py-6 sm:p-6 space-y-4">
                @csrf
                <input type="hidden" id="vl_asset_id">

                <div class="text-center mb-6">
                    <div
                        class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 dark:bg-indigo-900/50 mb-4">
                        <i data-lucide="trending-up" class="h-6 w-6 text-indigo-600 dark:text-indigo-400"></i>
                    </div>
                    <h3 class="text-lg leading-6 font-bold text-gray-900 dark:text-white" id="vl_asset_name">Update
                        Harga</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Perbarui rekam jejak harga pasar terkini.
                    </p>
                </div>

                <div>
                    <label for="price_per_unit"
                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Harga Pasar
                        Baru</label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                            <span class="text-gray-500 dark:text-gray-400 sm:text-sm font-medium">Rp</span>
                        </div>
                        <input type="number" name="price_per_unit" id="vl_price" min="0" required
                            class="w-full font-bold text-lg rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 pl-12 pr-4 py-3 bg-gray-50">
                    </div>
                </div>

                <div class="mt-8 flex flex-col gap-3">
                    <button type="submit" id="btnSubmitValuation"
                        class="w-full inline-flex justify-center items-center rounded-xl border border-transparent bg-indigo-600 px-5 py-3 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                        Simpan Pembaruan Harga
                    </button>
                    <button type="button" onclick="closeValuationModal()"
                        class="w-full inline-flex justify-center rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-5 py-3 text-sm font-medium text-gray-700 dark:text-gray-200 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openAssetModal() {
        document.getElementById('assetForm').reset();
        document.getElementById('assetModal').classList.remove('hidden');
    }

    function closeAssetModal() {
        document.getElementById('assetModal').classList.add('hidden');
    }

    function openValuationModal(id, name, currentPrice) {
        document.getElementById('vl_asset_id').value = id;
        document.getElementById('vl_asset_name').textContent = "Update Harga: " + name;
        document.getElementById('vl_price').value = currentPrice > 0 ? currentPrice : '';
        document.getElementById('valuationModal').classList.remove('hidden');

        // Focus automatically
        setTimeout(() => document.getElementById('vl_price').focus(), 100);
    }

    function closeValuationModal() {
        document.getElementById('valuationModal').classList.add('hidden');
    }

    async function submitAssetForm(event) {
        event.preventDefault();
        const form = event.target;
        const submitBtn = document.getElementById('btnSubmitAsset');
        const formData = new FormData(form);

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 mr-2 animate-spin"></i> Menyimpan...';
        lucide.createIcons();

        try {
            const data = Object.fromEntries(formData.entries());

            const response = await fetch('/api/assets', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': formData.get('_token')
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.success) {
                showToast('Aset baru berhasil ditambahkan!', 'success');
                closeAssetModal();
                loadAssets(); // Reload grid
            } else {
                showToast(result.message || 'Gagal menyimpan data.', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('Terjadi kesalahan sistem.', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Simpan Aset';
        }
    }

    async function submitValuationForm(event) {
        event.preventDefault();
        const form = event.target;
        const submitBtn = document.getElementById('btnSubmitValuation');
        const formData = new FormData(form);
        const assetId = document.getElementById('vl_asset_id').value;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 mr-2 animate-spin"></i> Memperbarui...';
        lucide.createIcons();

        try {
            const data = Object.fromEntries(formData.entries());

            const response = await fetch(`/api/assets/${assetId}/price`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': formData.get('_token')
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.success) {
                showToast('Harga pasar berhasil diperbarui!', 'success');
                closeValuationModal();
                loadAssets(); // Reload grid for new prices
            } else {
                showToast(result.message || 'Gagal perbarui harga.', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('Terjadi kesalahan sistem.', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Simpan Pembaruan Harga';
        }
    }
</script>