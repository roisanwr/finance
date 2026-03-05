@extends('layouts.app')
@section('title', 'Katalog Master Aset')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white transition-colors">Instrumen
            Investasi</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Daftar aset investasi yang Anda pantau pergerakan
            harganya.</p>
    </div>
    <button onclick="openAssetModal()"
        class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-xl shadow-sm hover:shadow-md transition-all flex items-center justify-center min-w-[140px]">
        <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Tambah Aset
    </button>
</div>

<!-- Filter Box -->
<div
    class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 mb-6 flex gap-2 overflow-x-auto hide-scrollbar">
    <button onclick="filterAssets('ALL')"
        class="asset-filter-btn px-4 py-1.5 rounded-lg text-sm font-semibold bg-gray-900 text-white dark:bg-gray-100 dark:text-gray-900 whitespace-nowrap"
        data-filter="ALL">Semua</button>
    <button onclick="filterAssets('KRIPTO')"
        class="asset-filter-btn px-4 py-1.5 rounded-lg text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 whitespace-nowrap"
        data-filter="KRIPTO">Kripto</button>
    <button onclick="filterAssets('SAHAM')"
        class="asset-filter-btn px-4 py-1.5 rounded-lg text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 whitespace-nowrap"
        data-filter="SAHAM">Saham</button>
    <button onclick="filterAssets('LOGAM_MULIA')"
        class="asset-filter-btn px-4 py-1.5 rounded-lg text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 whitespace-nowrap"
        data-filter="LOGAM_MULIA">Emas/Logam</button>
    <button onclick="filterAssets('PROPERTI')"
        class="asset-filter-btn px-4 py-1.5 rounded-lg text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 whitespace-nowrap"
        data-filter="PROPERTI">Properti</button>
    <button onclick="filterAssets('LAINNYA')"
        class="asset-filter-btn px-4 py-1.5 rounded-lg text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 whitespace-nowrap"
        data-filter="LAINNYA">Lainnya</button>
</div>

<!-- Assets Grid -->
<div id="assetsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Diisi oleh JS -->
</div>

<!-- Empty State Template -->
<div id="emptyState"
    class="hidden text-center py-12 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 border-dashed rounded-xl">
    <i data-lucide="folder-open" class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-500 mb-4"></i>
    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Tidak ada aset</h3>
    <p class="text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">Tambahkan instrumen investasi pertama Anda untuk
        mulai melacak nilainya.</p>
</div>

@push('modals')
@include('investments.partials.asset-modals')
@endpush

@push('scripts')
<script>
    let globalAssets = [];
    let currentFilter = 'ALL';

    const typeIcons = {
        'KRIPTO': 'bitcoin',
        'SAHAM': 'bar-chart-2',
        'LOGAM_MULIA': 'box',
        'PROPERTI': 'home',
        'BISNIS': 'briefcase',
        'LAINNYA': 'pie-chart'
    };

    const typeColors = {
        'KRIPTO': 'text-amber-500 bg-amber-100 dark:bg-amber-900/30 dark:text-amber-400',
        'SAHAM': 'text-blue-500 bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400',
        'LOGAM_MULIA': 'text-yellow-600 bg-yellow-100 dark:bg-yellow-900/30 dark:text-yellow-400',
        'PROPERTI': 'text-emerald-500 bg-emerald-100 dark:bg-emerald-900/30 dark:text-emerald-400',
        'BISNIS': 'text-indigo-500 bg-indigo-100 dark:bg-indigo-900/30 dark:text-indigo-400',
        'LAINNYA': 'text-gray-500 bg-gray-100 dark:bg-gray-800 dark:text-gray-400'
    };

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(number);
    }

    async function loadAssets() {
        try {
            const response = await fetch('/api/assets');
            globalAssets = await response.json();
            renderAssets();
        } catch (error) {
            showToast('Gagal memuat daftar aset', 'error');
        }
    }

    function filterAssets(type) {
        currentFilter = type;

        // Update button UI
        document.querySelectorAll('.asset-filter-btn').forEach(btn => {
            if (btn.dataset.filter === type) {
                btn.className = 'asset-filter-btn px-4 py-1.5 rounded-lg text-sm font-semibold bg-gray-900 text-white dark:bg-gray-100 dark:text-gray-900 whitespace-nowrap';
            } else {
                btn.className = 'asset-filter-btn px-4 py-1.5 rounded-lg text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 whitespace-nowrap';
            }
        });

        renderAssets();
    }

    function renderAssets() {
        const grid = document.getElementById('assetsGrid');
        const emptyState = document.getElementById('emptyState');
        grid.innerHTML = '';

        const displayAssets = currentFilter === 'ALL' ? globalAssets : globalAssets.filter(a => a.asset_type === currentFilter);

        if (displayAssets.length === 0) {
            grid.classList.add('hidden');
            emptyState.classList.remove('hidden');
        } else {
            grid.classList.remove('hidden');
            emptyState.classList.add('hidden');

            displayAssets.forEach(asset => {
                const latestPrice = asset.latest_valuation ? asset.latest_valuation.price_per_unit : 0;
                const formattedPrice = latestPrice > 0 ? formatRupiah(latestPrice) : 'Harga belum diset';
                const iconName = typeIcons[asset.asset_type] || 'circle';
                const colorClass = typeColors[asset.asset_type] || typeColors['LAINNYA'];

                const cardHtml = `
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-all flex flex-col overflow-hidden group">
                        <div class="p-5 flex-1 relative">
                            <!-- Quick Delete Button (Hover) -->
                            <button onclick="confirmDeleteAsset('${asset.id}', '${asset.name}')" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity p-1 bg-white dark:bg-gray-800 rounded-full">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>

                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center ${colorClass}">
                                    <i data-lucide="${iconName}" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white text-lg leading-tight line-clamp-1">${asset.name}</h3>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs font-semibold px-2 py-0.5 rounded bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 uppercase tracking-wide">${asset.asset_type}</span>
                                        ${asset.ticker_symbol ? `<span class="text-xs text-gray-500 font-mono border border-gray-200 dark:border-gray-600 rounded px-1.5">${asset.ticker_symbol}</span>` : ''}
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Harga Pasar (per ${asset.unit_name})</p>
                                <p class="text-xl font-black text-gray-900 dark:text-white ${latestPrice === 0 ? 'text-gray-400 italic font-medium text-sm' : ''}">${formattedPrice}</p>
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-100 dark:border-gray-700/60 bg-gray-50 dark:bg-gray-800/50 p-3 flex justify-between">
                            <button onclick="openValuationModal('${asset.id}', '${asset.name}', '${latestPrice}')" class="flex-1 flex justify-center items-center gap-2 text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 py-1.5 transition-colors">
                                <i data-lucide="refresh-cw" class="w-4 h-4"></i> Update Harga
                            </button>
                        </div>
                    </div>
                `;
                grid.insertAdjacentHTML('beforeend', cardHtml);
            });
            lucide.createIcons();
        }
    }

    async function confirmDeleteAsset(id, name) {
        showConfirm('Hapus Aset?', `Yakin ingin menghapus aset investasi "${name}"? Seluruh riwayat harga & transaksinya akan terhapus.`, 'Ya, Hapus', async () => {
            try {
                const response = await fetch(`/api/assets/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });

                const result = await response.json();
                if (result.success) {
                    showToast('Aset dihapus!', 'success');
                    loadAssets();
                } else {
                    showToast(result.message, 'error');
                }
            } catch (e) {
                showToast('Terjadi kesalahan jaringan', 'error');
            }
        });
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        loadAssets();
    });
</script>
@endpush
@endsection