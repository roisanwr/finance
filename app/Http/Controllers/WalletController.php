<?php

namespace App\Http\Controllers;

use App\Wallet;
use Illuminate\Http\Request;

class WalletController
{
    // --- VIEW / HALAMAN ---
    public function view()
    {
        return view('fiat.wallets');
    }

    // --- API LIST DATA ---
    public function index()
    {
        $userId = session('user_id');

        $wallets = Wallet::where('user_id', $userId)
            ->withSum(['fiatTransactions as total_in' => function ($query) {
            $query->where('transaction_type', 'PEMASUKAN');
        }], 'amount')
            ->withSum(['fiatTransactions as total_out' => function ($query) {
            $query->where('transaction_type', 'PENGELUARAN');
        }], 'amount')
            ->get();

        // Kalkulasi field tambahan "balance" (saldo akhir)
        $wallets->each(function ($wallet) {
            $in = $wallet->total_in ?? 0;
            $out = $wallet->total_out ?? 0;
            $wallet->balance = $in - $out;
        });

        return response()->json($wallets);
    }

    // --- API TAMBAH DATA ---
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:TUNAI,BANK,DOMPET_DIGITAL',
            'currency' => 'nullable|string|max:10'
        ]);

        $userId = session('user_id');

        $wallet = Wallet::create([
            'user_id' => $userId,
            'name' => $request->name,
            'type' => $request->type,
            'currency' => $request->currency ?? 'IDR'
        ]);

        return response()->json(['success' => true, 'data' => $wallet]);
    }

    // --- API UPDATE DATA ---
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:TUNAI,BANK,DOMPET_DIGITAL',
            'currency' => 'nullable|string|max:10'
        ]);

        $userId = session('user_id');
        $wallet = Wallet::where('id', $id)->where('user_id', $userId)->firstOrFail();

        $wallet->update([
            'name' => $request->name,
            'type' => $request->type,
            'currency' => $request->currency ?? 'IDR'
        ]);

        return response()->json(['success' => true, 'data' => $wallet]);
    }

    // --- API HAPUS DATA ---
    public function destroy($id)
    {
        $userId = session('user_id');
        $wallet = Wallet::where('id', $id)->where('user_id', $userId)->firstOrFail();
        $wallet->delete();

        return response()->json(['success' => true, 'message' => 'Wallet deleted.']);
    }
}