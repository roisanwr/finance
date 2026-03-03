@extends('layouts.app')
@section('title', 'Ringkasan Portofolio')

@section('content')
<div class="mb-6 flex justify-between items-end mt-2 lg:mt-0">
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1 transition-colors">Ringkasan Keuangan Anda</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm transition-colors">Data ditarik secara langsung berdasarkan kurs terkini.</p>
    </div>
    
    <button class="text-xs bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-400 px-3 py-1.5 rounded-lg hover:bg-indigo-200 dark:hover:bg-indigo-800/60 transition-colors font-medium border border-indigo-200 dark:border-indigo-800 flex items-center gap-1 shadow-sm shrink-0">
        <i data-lucide="refresh-cw" class="w-3 h-3"></i> Segarkan Data
    </button>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
    <!-- Card 1: Total Net Worth -->
    <div class="bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 p-5 flex flex-col shadow-sm hover:shadow-md transition-all">
        <div class="flex items-center mb-3">
            <div class="bg-indigo-100 dark:bg-indigo-900/50 p-2.5 rounded-xl mr-3 text-indigo-600 dark:text-indigo-400">
                <i data-lucide="wallet" class="w-5 h-5"></i>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Kekayaan (Net Worth)</p>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white transition-colors">Rp 150.000.000</h3>
        <p class="text-xs mt-2 text-green-600 dark:text-green-400 flex items-center"><i data-lucide="trending-up" class="w-3 h-3 mr-1"></i> +2.5% bulan ini</p>
    </div>

    <!-- Card 2: Saldo Tunai -->
    <div class="bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 p-5 flex flex-col shadow-sm hover:shadow-md transition-all">
        <div class="flex items-center mb-3">
            <div class="bg-green-100 dark:bg-green-900/50 p-2.5 rounded-xl mr-3 text-green-600 dark:text-green-400">
                <i data-lucide="banknote" class="w-5 h-5"></i>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Saldo Kas / Bank</p>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white transition-colors">Rp 25.500.000</h3>
        <p class="text-xs mt-2 text-gray-500 dark:text-gray-400">Dari 3 rekening</p>
    </div>

    <!-- Card 3: Valuasi Aset / Portofolio -->
    <div class="bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 p-5 flex flex-col shadow-sm hover:shadow-md transition-all">
        <div class="flex items-center mb-3">
            <div class="bg-amber-100 dark:bg-amber-900/50 p-2.5 rounded-xl mr-3 text-amber-500 dark:text-amber-400">
                <i data-lucide="pie-chart" class="w-5 h-5"></i>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Valuasi Aset</p>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white transition-colors">Rp 124.500.000</h3>
        <p class="text-xs mt-2 text-green-600 dark:text-green-400">Floating Profit: Rp 14.500.000</p>
    </div>

    <!-- Card 4: Pengeluaran Bulan Ini -->
    <div class="bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 p-5 flex flex-col shadow-sm hover:shadow-md transition-all">
        <div class="flex items-center mb-3">
            <div class="bg-red-100 dark:bg-red-900/50 p-2.5 rounded-xl mr-3 text-red-600 dark:text-red-400">
                <i data-lucide="trending-down" class="w-5 h-5"></i>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Pengeluaran Bulan Ini</p>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white transition-colors">Rp 4.250.000</h3>
        <p class="text-xs mt-2 text-red-500 dark:text-red-400">Sisa budget: Rp 750.000</p>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Transaksi Terakhir (Kiri, Lebih Lebar) -->
    <div class="lg:col-span-2 bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden transition-colors">
        <div class="flex justify-between items-center p-5 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-base font-bold text-gray-900 dark:text-white transition-colors">Transaksi Terakhir</h2>
            <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors">Lihat Semua</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800/50 text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider border-b border-gray-100 dark:border-gray-700 transition-colors">
                        <th class="py-3 px-5 font-semibold">Tanggal</th>
                        <th class="py-3 px-5 font-semibold">Keterangan</th>
                        <th class="py-3 px-5 font-semibold">Kategori</th>
                        <th class="py-3 px-5 font-semibold text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        <td class="py-3 px-5 text-sm font-medium text-gray-900 dark:text-gray-200">Hari ini</td>
                        <td class="py-3 px-5 text-sm text-gray-600 dark:text-gray-400">Beli Reksadana Sucor</td>
                        <td class="py-3 px-5 text-sm"><span class="bg-indigo-100 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-400 px-2.5 py-1 rounded-md text-xs font-semibold">Investasi</span></td>
                        <td class="py-3 px-5 text-sm font-bold text-red-600 dark:text-red-400 text-right">- Rp 1.000.000</td>
                    </tr>
                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        <td class="py-3 px-5 text-sm font-medium text-gray-900 dark:text-gray-200">Kemarin</td>
                        <td class="py-3 px-5 text-sm text-gray-600 dark:text-gray-400">Makan Siang</td>
                        <td class="py-3 px-5 text-sm"><span class="bg-amber-100 text-amber-700 dark:bg-amber-900/50 dark:text-amber-400 px-2.5 py-1 rounded-md text-xs font-semibold">Konsumsi</span></td>
                        <td class="py-3 px-5 text-sm font-bold text-red-600 dark:text-red-400 text-right">- Rp 55.000</td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        <td class="py-3 px-5 text-sm font-medium text-gray-900 dark:text-gray-200">12 Okt 2026</td>
                        <td class="py-3 px-5 text-sm text-gray-600 dark:text-gray-400">Gaji Bulanan</td>
                        <td class="py-3 px-5 text-sm"><span class="bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-400 px-2.5 py-1 rounded-md text-xs font-semibold">Pemasukan</span></td>
                        <td class="py-3 px-5 text-sm font-bold text-green-600 dark:text-green-400 text-right">+ Rp 15.000.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Alokasi Aset (Kanan) -->
    <div class="bg-white dark:bg-gray-800 sudut-custom border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden transition-colors">
        <div class="flex justify-between items-center p-5 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-base font-bold text-gray-900 dark:text-white transition-colors">Alokasi Investasi</h2>
        </div>
        <div class="p-5">
            <!-- Dummy Progress Bars -->
            <div class="mb-4">
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600 dark:text-gray-400 font-medium">Saham</span>
                    <span class="text-gray-900 dark:text-gray-200 font-bold">55%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: 55%"></div>
                </div>
            </div>
            
            <div class="mb-4">
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600 dark:text-gray-400 font-medium">Kripto</span>
                    <span class="text-gray-900 dark:text-gray-200 font-bold">25%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-amber-500 h-2 rounded-full" style="width: 25%"></div>
                </div>
            </div>

            <div class="mb-4">
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600 dark:text-gray-400 font-medium">Reksa Dana Pasar Uang</span>
                    <span class="text-gray-900 dark:text-gray-200 font-bold">15%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: 15%"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600 dark:text-gray-400 font-medium">Logam Mulia</span>
                    <span class="text-gray-900 dark:text-gray-200 font-bold">5%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-yellow-400 h-2 rounded-full" style="width: 5%"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection