@extends('layouts.app')
@section('title', 'Daftar Dompet')

@section('content')
<div class="mb-6 flex justify-between items-end mt-2 lg:mt-0">
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1 transition-colors">Daftar Dompet</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm transition-colors">Manajemen dompet kas, rekening bank, dan
            dompet digital Anda.</p>
    </div>

    <button onclick="openWalletModal()"
        class="text-sm bg-indigo-600 dark:bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 dark:hover:bg-indigo-600 transition-colors font-medium flex items-center gap-2 shadow-sm shrink-0">
        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Dompet
    </button>
</div>

<!-- Container Grid untuk Daftar Dompet -->
<div id="wallets-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
    <!-- Skeleton loader untuk initial loading -->
    <div class="bg-gray-200 dark:bg-gray-800 animate-pulse h-32 sudut-custom"></div>
    <div class="bg-gray-200 dark:bg-gray-800 animate-pulse h-32 sudut-custom"></div>
    <div class="bg-gray-200 dark:bg-gray-800 animate-pulse h-32 sudut-custom"></div>
</div>

@push('modals')
<!-- Modal Form -->
<div id="walletModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-[60] hidden flex items-center justify-center">
    <div
        class="bg-white dark:bg-gray-800 sudut-custom p-6 w-full max-w-md shadow-xl border border-gray-200 dark:border-gray-700">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-gray-900 dark:text-white" id="modalTitle">Tambah Dompet Baru</h3>
            <button onclick="closeWalletModal()"
                class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="walletForm" onsubmit="submitWalletForm(event)">
            <input type="hidden" id="wallet_id" name="id">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Dompet /
                    Rekening</label>
                <input type="text" id="wallet_name" name="name" required
                    placeholder="Cth: BCA Pribadi, Gopay, Dompet Fisik"
                    class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2 px-3">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipe</label>
                <select id="wallet_type" name="type" required
                    class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2 px-3">
                    <option value="BANK">Bank</option>
                    <option value="DOMPET_DIGITAL">Dompet Digital</option>
                    <option value="TUNAI">Tunai</option>
                </select>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mata Uang</label>
                <input type="text" id="wallet_currency" name="currency" value="IDR"
                    class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2 px-3 uppercase">
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeWalletModal()"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">Batal</button>
                <button type="submit" id="btnSubmit"
                    class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Histori -->
<div id="historyModal"
    class="fixed inset-0 bg-gray-900 bg-opacity-50 z-[60] hidden flex items-center justify-center p-4">
    <div
        class="bg-white dark:bg-gray-800 sudut-custom p-6 w-full max-w-3xl shadow-xl border border-gray-200 dark:border-gray-700 flex flex-col max-h-[90vh]">
        <div class="flex justify-between items-center mb-4 shrink-0">
            <div>
                <h3 class="font-bold text-lg text-gray-900 dark:text-white" id="historyModalTitle">Histori Dompet</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400" id="historyModalSubtitle">Sisa Saldo: Rp 0</p>
            </div>
            <button onclick="closeHistoryModal()"
                class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <div class="overflow-y-auto flex-1 border border-gray-200 dark:border-gray-700 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800/50 sticky top-0">
                    <tr>
                        <th
                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Tanggal</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Deskripsi</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Tipe</th>
                        <th
                            class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Nominal</th>
                    </tr>
                </thead>
                <tbody id="historyTableBody"
                    class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-500">Memuat data...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endpush

@endsection

@push('scripts')
<script>
    // Konfigurasi CSRF Token untuk Laravel
    const headers = {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    };

    // Saat JS load, ambil data dompet
    document.addEventListener("DOMContentLoaded", fetchWallets);

    function fetchWallets() {
        fetch('/api/wallets', { headers })
            .then(res => res.json())
            .then(data => {
                renderWallets(data);
            })
            .catch(error => {
                console.error('Error mengambil data:', error);
                showToast('Gagal mengambil data dompet.', 'error');
                document.getElementById('wallets-container').innerHTML = '';
            });
    }

    function renderWallets(wallets) {
        const container = document.getElementById('wallets-container');
        container.innerHTML = ''; // Kosongkan loading

        if (wallets.length === 0) {
            container.innerHTML = `
                <div class="col-span-full bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 p-8 text-center text-gray-500 dark:text-gray-400">
                    Belum ada dompet. Silakan tambahkan dompet pertama Anda.
                </div>
            `;
            return;
        }

        wallets.forEach(wallet => {
            let icon = 'wallet';
            let colorClass = 'text-indigo-500 bg-indigo-100 dark:bg-indigo-900/50';

            if (wallet.type === 'BANK') {
                icon = 'building';
                colorClass = 'text-blue-500 bg-blue-100 dark:bg-blue-900/50';
            } else if (wallet.type === 'DOMPET_DIGITAL') {
                icon = 'smartphone';
                colorClass = 'text-purple-500 bg-purple-100 dark:bg-purple-900/50';
            } else if (wallet.type === 'TUNAI') {
                icon = 'banknote';
                colorClass = 'text-green-500 bg-green-100 dark:bg-green-900/50';
            }

            const card = document.createElement('div');
            card.className = 'bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 p-5 flex flex-col shadow-sm hover:shadow-md transition-all relative group';

            // Simpan data di atribut elemen untuk form edit
            card.dataset.id = wallet.id;
            card.dataset.name = wallet.name;
            card.dataset.type = wallet.type;
            card.dataset.currency = wallet.currency;

            card.innerHTML = `
                <div class="absolute top-4 right-4 hidden group-hover:flex space-x-2">
                    <button onclick="openHistoryModal('${wallet.id}', '${wallet.name}', ${wallet.balance || 0})" class="text-gray-400 hover:text-indigo-600 transition-colors" title="Lihat Histori"><i data-lucide="history" class="w-4 h-4"></i></button>
                    <button onclick="editWallet(this)" class="text-gray-400 hover:text-indigo-600 transition-colors" title="Edit"><i data-lucide="edit-2" class="w-4 h-4"></i></button>
                    <button onclick="deleteWallet('${wallet.id}')" class="text-gray-400 hover:text-red-600 transition-colors" title="Hapus"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                </div>
                <div class="flex items-center mb-3 pr-8">
                    <div class="p-2.5 rounded-xl mr-3 ${colorClass}">
                        <i data-lucide="${icon}" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 dark:text-white leading-tight">${wallet.name}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">${wallet.type}</p>
                    </div>
                </div>
                <div class="mt-auto pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-between items-end">
                    <span class="text-xs text-gray-500 dark:text-gray-400">${wallet.currency}</span>
                    <span class="font-bold ${(wallet.balance || 0) >= 0 ? 'text-gray-900 dark:text-white' : 'text-red-500'}">${formatRp(wallet.balance || 0)}</span> 
                </div>
            `;
            container.appendChild(card);
        });

        lucide.createIcons();
    }

    function openWalletModal() {
        document.getElementById('walletForm').reset();
        document.getElementById('wallet_id').value = '';
        document.getElementById('modalTitle').textContent = 'Tambah Dompet Baru';
        document.getElementById('walletModal').classList.remove('hidden');
    }

    function closeWalletModal() {
        document.getElementById('walletModal').classList.add('hidden');
    }

    function formatRp(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);
    }

    function openHistoryModal(walletId, walletName, balance) {
        document.getElementById('historyModalTitle').textContent = 'Riwayat Kas: ' + walletName;
        document.getElementById('historyModalSubtitle').textContent = 'Sisa Saldo: ' + formatRp(balance || 0);
        document.getElementById('historyTableBody').innerHTML = '<tr><td colspan="4" class="px-4 py-8 text-center text-gray-500"><i data-lucide="loader-2" class="w-6 h-6 animate-spin mx-auto mb-2"></i> Memuat riwayat...</td></tr>';
        lucide.createIcons();
        document.getElementById('historyModal').classList.remove('hidden');

        fetch('/api/transactions?wallet_id=' + walletId, { headers })
            .then(res => res.json())
            .then(data => {
                const tbody = document.getElementById('historyTableBody');
                tbody.innerHTML = '';

                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" class="px-4 py-8 text-center text-gray-500">Belum ada histori transaksi untuk dompet ini.</td></tr>';
                    return;
                }

                data.forEach(tx => {
                    let typeColor = 'text-gray-500';
                    let amountPrefix = '';
                    if (tx.transaction_type === 'PEMASUKAN') {
                        typeColor = 'text-green-600 dark:text-green-500';
                        amountPrefix = '+ ';
                    } else if (tx.transaction_type === 'PENGELUARAN') {
                        typeColor = 'text-red-600 dark:text-red-500';
                        amountPrefix = '- ';
                    } else {
                        typeColor = 'text-blue-600 dark:text-blue-500';
                    }

                    const dateObj = new Date(tx.transaction_date);
                    const dateStr = dateObj.toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' });
                    const desc = tx.description || (tx.category ? tx.category.name : 'Aktivitas Transfer');

                    tbody.innerHTML += '<tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">' +
                        '<td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">' + dateStr + '</td>' +
                        '<td class="px-4 py-3 text-sm text-gray-900 dark:text-white border-l border-gray-100 dark:border-gray-800 pl-4">' + desc + '</td>' +
                        '<td class="px-4 py-3 whitespace-nowrap text-sm font-medium ' + typeColor + '">' + tx.transaction_type + '</td>' +
                        '<td class="px-4 py-3 whitespace-nowrap text-sm text-right font-medium ' + typeColor + '">' + amountPrefix + formatRp(tx.amount) + '</td>' +
                        '</tr>';
                });
            })
            .catch(err => {
                console.error(err);
                document.getElementById('historyTableBody').innerHTML = '<tr><td colspan="4" class="px-4 py-8 text-center text-red-500">Gagal memuat histori.</td></tr>';
            });
    }

    function closeHistoryModal() {
        document.getElementById('historyModal').classList.add('hidden');
    }

    function editWallet(btn) {
        const card = btn.closest('.bg-white');
        document.getElementById('wallet_id').value = card.dataset.id;
        document.getElementById('wallet_name').value = card.dataset.name;
        document.getElementById('wallet_type').value = card.dataset.type;
        document.getElementById('wallet_currency').value = card.dataset.currency;

        document.getElementById('modalTitle').textContent = 'Edit Dompet';
        document.getElementById('walletModal').classList.remove('hidden');
    }

    function submitWalletForm(e) {
        e.preventDefault();
        const id = document.getElementById('wallet_id').value;
        const submitData = {
            name: document.getElementById('wallet_name').value,
            type: document.getElementById('wallet_type').value,
            currency: document.getElementById('wallet_currency').value
        };

        const method = id ? 'PUT' : 'POST';
        const url = id ? `/api/wallets/${id}` : `/api/wallets`;

        const btn = document.getElementById('btnSubmit');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 mr-2 animate-spin"></i> Menyimpan...';
        btn.disabled = true;
        lucide.createIcons();

        fetch(url, {
            method: method,
            headers: headers,
            body: JSON.stringify(submitData)
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    closeWalletModal();
                    fetchWallets();
                    showToast(id ? 'Dompet berhasil diperbarui!' : 'Dompet berhasil ditambahkan!', 'success');
                } else {
                    showToast('Gagal menyimpan dompet. Coba lagi.', 'error');
                }
            })
            .catch(err => {
                console.error(err);
                showToast('Terjadi kesalahan. Cek koneksi.', 'error');
            })
            .finally(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
    }

    function deleteWallet(id) {
        showConfirm('Semua histori transaksi pada dompet ini juga akan ikut terhapus permanen.').then(ok => {
            if (!ok) return;
            fetch(`/api/wallets/${id}`, {
                method: 'DELETE',
                headers: headers
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        fetchWallets();
                        showToast('Dompet berhasil dihapus.', 'warning');
                    } else {
                        showToast('Gagal menghapus dompet.', 'error');
                    }
                })
                .catch(() => showToast('Terjadi kesalahan saat menghapus.', 'error'));
        });
    }
</script>
@endpush