<?php

namespace App\Http\Controllers;

use App\FiatTransaction;
use App\WalletBalance;
use App\UserNetWorth;
use App\UserPortfolio;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController
{
    public function index()
    {
        $userId = session('user_id');

        // 1. Hitung Saldo Kas / Bank berdasarkan Database View `wallet_balances`
        $totalBalance = WalletBalance::where('user_id', $userId)->sum('balance');

        // 2. Hitung Pemasukan Bulan Ini (Exclude Transfer)
        $startOfMonth = Carbon::now()->startOfMonth()->toDateTimeString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateTimeString();

        $monthlyIncomeList = FiatTransaction::with(['category', 'wallet'])
            ->where('user_id', '=', $userId)
            ->where('transaction_type', '=', 'PEMASUKAN')
            ->whereNotNull('category_id') // Exclude transfer
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->orderBy('transaction_date', 'desc')
            ->get();

        $monthlyIncome = $monthlyIncomeList->sum('amount');

        // 3. Hitung Pengeluaran Bulan Ini (Exclude Transfer)

        // Ambil daftar utuh pengeluaran bulan ini (tidak termasuk transfer internal)
        // Note: Transfer biasanya dibedakan dari null category_id (sesuai db.sql)
        // Atau via description. Kita filter yang PENGELUARAN murni.
        $monthlyExpenseList = FiatTransaction::with(['category', 'wallet'])
            ->where('user_id', '=', $userId)
            ->where('transaction_type', '=', 'PENGELUARAN')
            ->whereNotNull('category_id') // Transfer selalu punya category_id NULL di db.sql
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->orderBy('transaction_date', 'desc')
            ->get();

        $monthlyExpense = $monthlyExpenseList->sum('amount');

        // 3. Ambil Portofolio Aktif untuk Hitung Distribusi (Alokasi) dan Breakdown UI
        $portfolios = UserPortfolio::with(['asset.latestValuation'])
            ->where('user_id', $userId)
            ->where('total_units', '>', 0)
            ->get();

        // 4. Kalkulasi Total Valuasi Aset dan Kekayaan Bersih (Net Worth)
        // Ambil dari Database View `user_net_worth`
        $userNetWorthView = UserNetWorth::where('user_id', $userId)->first();
        $totalAssetValue = $userNetWorthView ? $userNetWorthView->total_asset_value : 0;

        $netWorth = $totalBalance + $totalAssetValue;

        // Siapkan struktur array untuk Grafik ApexCharts (Labels dan Series)
        // Dimulai dengan 1 Irisan Utama = Total semua Saldo Kas / Bank
        $chartLabels = ['Total Kas & Bank'];
        $chartSeries = [(float)$totalBalance]; // Casting to float for JS

        // Dilanjutkan dengan irisan detail dari masing-masing portofolio investasinya
        foreach ($portfolios as $portfolio) {
            $asset = $portfolio->asset;
            $currentPrice = $asset->latestValuation ? $asset->latestValuation->price_per_unit : 0;
            $value = $portfolio->total_units * $currentPrice;

            if ($value > 0) {
                // Gunakan Ticker jika ada (misal BBCA, BTC), jika tidak nama panjang aset
                $label = $asset->ticker_symbol ?: $asset->name;
                $chartLabels[] = $label;
                $chartSeries[] = (float)$value;
            }
        }

        // 5. Ambil 5 Transaksi Terakhir (Fiat)
        $recentTransactions = FiatTransaction::with(['category', 'wallet'])
            ->where('user_id', $userId)
            ->orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Hitung persentase pengeluaran bln ini thd modal aktif saat ini
        $expensePct = 0;
        $totalCashBeforeExpense = $totalBalance + $monthlyExpense; // just a rough baseline
        if ($totalCashBeforeExpense > 0) {
            $expensePct = round(($monthlyExpense / $totalCashBeforeExpense) * 100, 1);
        }

        return view('dashboard.index', compact(
            'totalBalance',
            'totalAssetValue',
            'netWorth',
            'monthlyIncome',
            'monthlyIncomeList',
            'monthlyExpense',
            'monthlyExpenseList',
            'portfolios',
            'recentTransactions',
            'expensePct',
            'chartLabels',
            'chartSeries'
        ));
    }
}