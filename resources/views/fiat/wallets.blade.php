@extends('layouts.app')
@section('title', 'Daftar Dompet')

@section('content')
<div class="mb-6 flex justify-between items-end mt-2 lg:mt-0">
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1 transition-colors">Daftar Dompet</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm transition-colors">Manajemen dompet kas, rekening bank, dan dompet digital Anda.</p>
    </div>
    
    <button onclick="openWalletModal()" class="text-sm bg-indigo-600 dark:bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 dark:hover:bg-indigo-600 transition-colors font-medium flex items-center gap-2 shadow-sm shrink-0">
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

<!-- Modal Form -->
<div id="walletModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 sudut-custom p-6 w-full max-w-md shadow-xl border border-gray-200 dark:border-gray-700">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg text-gray-900 dark:text-white" id="modalTitle">Tambah Dompet Baru</h3>
            <button onclick="closeWalletModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        
        <form id="walletForm" onsubmit="submitWalletForm(event)">
            <input type="hidden" id="wallet_id" name="id">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Dompet / Rekening</label>
                <input type="text" id="wallet_name" name="name" required placeholder="Cth: BCA Pribadi, Gopay, Dompet Fisik" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2 px-3">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipe</label>
                <select id="wallet_type" name="type" required class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2 px-3">
                    <option value="BANK">Bank</option>
                    <option value="DOMPET_DIGITAL">Dompet Digital</option>
                    <option value="TUNAI">Tunai</option>
                </select>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mata Uang</label>
                <input type="text" id="wallet_currency" name="currency" value="IDR" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2 px-3 uppercase">
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeWalletModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">Batal</button>
                <button type="submit" id="btnSubmit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

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
                console.error("Error mengambil dta:", error);
                document.getElementById('wallets-container').innerHTML = '<p class="text-red-500">Gagal mengambil data dompet.</p>';
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
            
            if(wallet.type === 'BANK') {
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
                    <button onclick="editWallet(this)" class="text-gray-400 hover:text-indigo-600 transition-colors"><i data-lucide="edit-2" class="w-4 h-4"></i></button>
                    <button onclick="deleteWallet('${wallet.id}')" class="text-gray-400 hover:text-red-600 transition-colors"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
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
                    <span class="font-bold text-gray-900 dark:text-white">...</span> 
                    <!-- Nanti bisa di-load dari view wallet_balances, tapi kita taruh placeholder dulu karena kita belum bikin controller get balance -->
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
            if(data.success) {
                closeWalletModal();
                fetchWallets(); // Reload list
            } else {
                alert('Gagal menyimpan dompet.');
            }
        })
        .catch(err => console.error(err))
        .finally(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }

    function deleteWallet(id) {
        if(confirm('Apakah Anda yakin ingin menghapus dompet ini? Semua data histori akan terhapus juga!')) {
            fetch(`/api/wallets/${id}`, {
                method: 'DELETE',
                headers: headers
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    fetchWallets();
                }
            });
        }
    }
</script>
@endpush
