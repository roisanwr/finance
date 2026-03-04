<?php

namespace App\Http\Controllers;

use App\FiatTransaction;
use App\Wallet;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController
{
    public function index()
    {
        $userId = session('user_id');

        // 1. Hitung Saldo Kas / Bank saat ini
        // Mengingat dompet adalah akumulasi dari semua transaksi Pemasukan - Pengeluaran
        // Saldo = Total Pemasukan - Total Pengeluaran

        $pemasukan = FiatTransaction::where('user_id', $userId)
            ->where('transaction_type', 'PEMASUKAN')
            ->sum('amount');

        $pengeluaran = FiatTransaction::where('user_id', $userId)
            ->where('transaction_type', 'PENGELUARAN')
            ->sum('amount');

        // Transfer tidak mengubah saldo global (karena pindah dompet saja)
        $totalBalance = $pemasukan - $pengeluaran;

        // 2. Hitung Pengeluaran Bulan Ini
        $startOfMonth = Carbon::now()->startOfMonth()->toDateTimeString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateTimeString();

        $monthlyExpense = FiatTransaction::where('user_id', $userId)
            ->where('transaction_type', 'PENGELUARAN')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // 3. Ambil 5 Transaksi Terakhir
        $recentTransactions = FiatTransaction::with(['category', 'wallet'])
            ->where('user_id', $userId)
            ->orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 4. Hitung persentase pengeluaran bln ini thd saldo + pengeluaran bulan ini
        // (opsional utk text tambahan, hindari division by zero)
        $expensePct = 0;
        $totalCashBeforeExpense = $totalBalance + $monthlyExpense;
        if ($totalCashBeforeExpense > 0) {
            $expensePct = round(($monthlyExpense / $totalCashBeforeExpense) * 100, 1);
        }

        return view('dashboard.index', compact(
            'totalBalance',
            'monthlyExpense',
            'recentTransactions',
            'expensePct'
        ));
    }
}