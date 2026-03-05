@extends('layouts.app')

@section('title', 'Portofolio Investasi')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Portofolio Saya</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Pantau performa dan alokasi aset investasi Anda
                saat ini.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <button onclick="openTransactionModal()"
                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors shadow-sm shadow-indigo-200 dark:shadow-none">
                <i data-lucide="plus" class="w-4 h-4"></i> Catat Transaksi Baru
            </button>
        </div>
    </div>

    {{-- Sub Nav/Tabs (Optional for future, maybe 'Equity', 'Crypto', etc) --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-1 flex gap-2 overflow-x-auto hide-scrollbar">
        <button id="tabSummary" onclick="switchTab('summary')"
            class="px-5 py-2 text-sm font-medium rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white transition-colors whitespace-nowrap">
            Ringkasan </button>
        <button id="tabHistory" onclick="switchTab('history')"
            class="px-5 py-2 text-sm font-medium rounded-xl text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors whitespace-nowrap">
            Riwayat Transaksi </button>
    </div>

    {{-- Grid Portofolio --}}
    <div id="portfolioGrid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        {{-- Skeleton Loading --}}
        @for($i=0; $i<3; $i++) <div
            class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 shadow-sm animate-pulse">
            <div class="flex justify-between items-start mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700"></div>
                    <div>
                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-24 mb-2"></div>
                        <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded w-16"></div>
                    </div>
                </div>
                <div class="h-8 w-8 bg-gray-200 dark:bg-gray-700 rounded-lg"></div>
            </div>
            <div class="space-y-3 mt-6">
                <div class="flex justify-between">
                    <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded w-20"></div>
                    <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded w-24"></div>
                </div>
                <div class="flex justify-between">
                    <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded w-16"></div>
                    <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded w-20"></div>
                </div>
            </div>
    </div>
    @endfor
</div>

{{-- Container Histori Transaksi Keseluruhan (Hidden by default) --}}
<div id="portfolioHistory" class="hidden">
    <div
        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800/50">
                    <tr>
                        <th
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Tanggal</th>
                        <th
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Aset</th>
                        <th
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Aksi</th>
                        <th
                            class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Unit</th>
                        <th
                            class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Harga/Unit</th>
                        <th
                            class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Total Rp</th>
                    </tr>
                </thead>
                <tbody id="historyTableBody" class="divide-y divide-gray-200 dark:divide-gray-800">
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">Memuat profil transaksi aset...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Empty State Template --}}
<template id="tmplEmptyPortfolio">
    <div
        class="col-span-full py-16 px-4 text-center rounded-3xl border border-dashed border-gray-300 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/20">
        <div
            class="mx-auto w-16 h-16 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center shadow-sm mb-4 border border-gray-100 dark:border-gray-700">
            <i data-lucide="pie-chart" class="w-8 h-8 text-gray-400"></i>
        </div>
        <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-1">Portofolio Masih Kosong</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 max-w-sm mx-auto">Anda belum memiliki saldo aset apa
            pun. Silakan catat transaksi pembelian pertama Anda.</p>
        <button onclick="openTransactionModal()"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm font-medium rounded-xl transition-colors shadow-sm">
            <i data-lucide="plus" class="w-4 h-4"></i> Catat Pembelian
        </button>
    </div>
</template>

</div>
@endsection

@push('modals')
{{-- TODO: Insert modals block --}}
@include('investments.partials.portfolio-modals')
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
        loadPortfolios();
    });

    const formatRupiah = (number) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);

    let listPortfolios = [];

    function switchTab(tab) {
        const grid = document.getElementById('portfolioGrid');
        const historyContainer = document.getElementById('portfolioHistory');
        const tabSummary = document.getElementById('tabSummary');
        const tabHistory = document.getElementById('tabHistory');

        const activeClass = ['bg-gray-100', 'dark:bg-gray-700', 'text-gray-900', 'dark:text-white'];
        const inactiveClass = ['text-gray-500', 'hover:text-gray-900', 'dark:text-gray-400', 'dark:hover:text-white', 'hover:bg-gray-50', 'dark:hover:bg-gray-700/50'];

        if (tab === 'summary') {
            grid.classList.remove('hidden');
            historyContainer.classList.add('hidden');

            tabSummary.classList.add(...activeClass);
            tabSummary.classList.remove(...inactiveClass);
            tabHistory.classList.add(...inactiveClass);
            tabHistory.classList.remove(...activeClass);
        } else {
            grid.classList.add('hidden');
            historyContainer.classList.remove('hidden');

            tabHistory.classList.add(...activeClass);
            tabHistory.classList.remove(...inactiveClass);
            tabSummary.classList.add(...inactiveClass);
            tabSummary.classList.remove(...activeClass);

            loadAllAssetTransactions();
        }
    }

    async function loadPortfolios() {
        const grid = document.getElementById('portfolioGrid');

        try {
            const res = await fetch('/api/portfolios');
            const data = await res.json();

            grid.innerHTML = '';

            if (data.length === 0) {
                const tmpl = document.getElementById('tmplEmptyPortfolio');
                grid.appendChild(tmpl.content.cloneNode(true));
                lucide.createIcons();
                listPortfolios = [];
                return;
            }

            listPortfolios = data; // Save to global for history fetcher

            data.forEach(p => {
                const asset = p.asset;
                const typeInfo = getAssetTypeInfo(asset.asset_type);

                // Kalkulasi nilai
                const currentPrice = asset.latest_valuation ? parseFloat(asset.latest_valuation.price_per_unit) : 0;
                const avgBuyPrice = parseFloat(p.average_buy_price);
                const totalUnits = parseFloat(p.total_units);

                const totalValue = currentPrice * totalUnits;
                const totalCost = avgBuyPrice * totalUnits;
                const profitUnrealized = totalValue - totalCost;

                // Safe division by 0
                const returnPercentage = totalCost > 0 ? (profitUnrealized / totalCost) * 100 : 0;

                const isProfit = profitUnrealized >= 0;
                const returnColorClass = isProfit ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-500 dark:text-red-400';
                const returnIcon = isProfit ? 'trending-up' : 'trending-down';
                const returnPrefix = isProfit ? '+' : '';

                const cardHtml = `
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow cursor-pointer relative group">
                        
                        <div class="flex justify-between items-start mb-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center ${typeInfo.bgClass} ${typeInfo.textClass}">
                                    <i data-lucide="${typeInfo.icon}" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white leading-tight">${asset.name}</h3>
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">${asset.ticker_symbol || asset.asset_type}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Nilai Sekarang</p>
                            <h4 class="text-xl font-bold text-gray-900 dark:text-white">${formatRupiah(totalValue)}</h4>
                        </div>
                        
                        <hr class="border-gray-100 dark:border-gray-700 mb-4">

                        <div class="space-y-3 relative z-10">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Kepemilikan</span>
                                <span class="font-semibold text-gray-900 dark:text-white">${totalUnits} ${asset.unit_name}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Harga Rata-rata</span>
                                <span class="font-semibold text-gray-900 dark:text-white">${formatRupiah(avgBuyPrice)}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Return (Unrealized)</span>
                                <div class="flex items-center gap-1 ${returnColorClass} font-semibold bg-gray-50 dark:bg-gray-900/50 px-2 py-0.5 rounded-md">
                                    <i data-lucide="${returnIcon}" class="w-3 h-3"></i>
                                    <span>${returnPrefix}${formatRupiah(profitUnrealized)} (${returnPrefix}${returnPercentage.toFixed(2)}%)</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Overlay gradient on hover (subtle) -->
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-transparent to-indigo-50/10 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                    </div>
                `;

                const wrapper = document.createElement('div');
                wrapper.innerHTML = cardHtml.trim();
                grid.appendChild(wrapper.firstChild);
            });

            lucide.createIcons();

        } catch (err) {
            console.error(err);
            grid.innerHTML = `< div class="col-span-full py-8 text-center text-red-500 text-sm" > Gagal memuat portofolio: \${ err.message }</div >`;
        }
    }

    // Helper design: sama persis seperti di katalog aset
    function getAssetTypeInfo(type) {
        const types = {
            'KRIPTO': { icon: 'bitcoin', bgClass: 'bg-orange-100 dark:bg-orange-900/30', textClass: 'text-orange-600 dark:text-orange-400' },
            'SAHAM': { icon: 'trending-up', bgClass: 'bg-blue-100 dark:bg-blue-900/30', textClass: 'text-blue-600 dark:text-blue-400' },
            'LOGAM_MULIA': { icon: 'gem', bgClass: 'bg-yellow-100 dark:bg-yellow-900/30', textClass: 'text-yellow-600 dark:text-yellow-400' },
            'PROPERTI': { icon: 'home', bgClass: 'bg-emerald-100 dark:bg-emerald-900/30', textClass: 'text-emerald-600 dark:text-emerald-400' },
            'BISNIS': { icon: 'briefcase', bgClass: 'bg-purple-100 dark:bg-purple-900/30', textClass: 'text-purple-600 dark:text-purple-400' },
            'LAINNYA': { icon: 'box', bgClass: 'bg-gray-100 dark:bg-gray-700', textClass: 'text-gray-600 dark:text-gray-400' }
        };
        return types[type] || types['LAINNYA'];
    }

    async function loadAllAssetTransactions() {
        const tbody = document.getElementById('historyTableBody');
        tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-8 text-center text-gray-500"><i data-lucide="loader-2" class="w-6 h-6 animate-spin mx-auto mb-2"></i> Mensinkronisasi transaksi investasi...</td></tr>';
        lucide.createIcons();

        try {
            // Karena backend portfolio transaction API membutuhkan ID portfolio (/api/portfolios/{id}/transactions)
            // Kita akan loop list portfolios dan load semuanya lalu digabung
            if (listPortfolios.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">Anda belum memiliki aset sama sekali.</td></tr>';
                return;
            }

            let allTx = [];
            for (const pf of listPortfolios) {
                const res = await fetch('/api/portfolios/' + pf.id + '/transactions');
                const txData = await res.json();

                // Tambahkan nama aset untuk UI
                txData.forEach(tx => {
                    tx.asset_name = pf.asset.name;
                    tx.asset_ticker = pf.asset.ticker_symbol || pf.asset.asset_type;
                });

                allTx = allTx.concat(txData);
            }

            // Urutkan ulang berdasarkan tanggal terbaru
            allTx.sort((a, b) => new Date(b.transaction_date) - new Date(a.transaction_date));

            tbody.innerHTML = '';
            if (allTx.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada riwayat tercatat.</td></tr>';
                return;
            }

            allTx.forEach(tx => {
                const dateObj = new Date(tx.transaction_date);
                const dateStr = dateObj.toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' });

                let typeColor = 'text-gray-500';
                if (tx.transaction_type === 'BELI') typeColor = 'text-emerald-600 dark:text-emerald-500';
                if (tx.transaction_type === 'JUAL') typeColor = 'text-red-500 dark:text-red-400';
                if (tx.transaction_type === 'SALDO_AWAL') typeColor = 'text-blue-500 dark:text-blue-400';

                tbody.innerHTML += `
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${dateStr}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">${tx.asset_name}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">${tx.asset_ticker}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold ${typeColor}">${tx.transaction_type}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900 dark:text-white font-medium">${tx.units}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-500 dark:text-gray-400">${formatRupiah(tx.price_per_unit)}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-gray-900 dark:text-white">${formatRupiah(tx.total_amount)}</td>
                    </tr>
                `;
            });

        } catch (e) {
            console.error(e);
            tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-8 text-center text-red-500">Terjadi kesalahan pada server saat memuat transaksi.</td></tr>';
        }
    }
</script>
@endpush