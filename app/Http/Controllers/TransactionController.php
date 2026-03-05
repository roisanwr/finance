<?php

namespace App\Http\Controllers;

use App\FiatTransaction;
use App\Wallet;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TransactionController
{
    // --- VIEW ---
    public function view()
    {
        return view('fiat.transactions');
    }

    // --- API ENDPOINTS ---

    public function index(Request $request)
    {
        $userId = session('user_id');

        $query = FiatTransaction::with(['wallet', 'category'])
            ->where('user_id', $userId);

        // Filter opsional berdasarkan dompet
        if ($request->has('wallet_id') && $request->wallet_id) {
            $query->where('wallet_id', $request->wallet_id);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($transactions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_type' => 'required|in:PEMASUKAN,PENGELUARAN,TRANSFER',
            'wallet_id' => 'required|uuid',
            'amount' => 'required|numeric|min:1',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string'
        ]);

        $userId = session('user_id');

        // Pengecekan Kategori hanya berlaku jika BUKAN TRANSFER
        if ($request->transaction_type !== 'TRANSFER') {
            $request->validate(['category_id' => 'required|uuid']);
            // Cek milik siapa kategorinya
            $catMatch = Category::where('id', $request->category_id)->where('user_id', $userId)->exists();
            if (!$catMatch) {
                return response()->json(['success' => false, 'message' => 'Kategori tidak valid'], 422);
            }
        }

        // Cek milik siapa dompet sumbernya
        $sourceWallet = Wallet::where('id', $request->wallet_id)->where('user_id', $userId)->first();
        if (!$sourceWallet) {
            return response()->json(['success' => false, 'message' => 'Dompet sumber tidak valid'], 422);
        }

        // Logika Eksekusi Transaksi

        $date = Carbon::parse($request->transaction_date)->toDateTimeString();

        if ($request->transaction_type === 'TRANSFER') {

            $request->validate(['target_wallet_id' => 'required|uuid|different:wallet_id']);

            $targetWallet = Wallet::where('id', $request->target_wallet_id)->where('user_id', $userId)->first();
            if (!$targetWallet) {
                return response()->json(['success' => false, 'message' => 'Dompet tujuan tidak valid'], 422);
            }

            // Transfer memecah ke dalam 2 row transaksi
            $descOut = $request->description ? $request->description : "Transfer uang ke " . $targetWallet->name;
            $txOut = FiatTransaction::create([
                'id' => (string)Str::uuid(),
                'user_id' => $userId,
                'wallet_id' => $sourceWallet->id,
                'category_id' => null, // null untuk transfer
                'transaction_type' => 'PENGELUARAN',
                'amount' => $request->amount,
                'description' => $descOut,
                'transaction_date' => $date
            ]);

            $descIn = $request->description ? $request->description : "Transfer uang dari " . $sourceWallet->name;
            $txIn = FiatTransaction::create([
                'id' => (string)Str::uuid(),
                'user_id' => $userId,
                'wallet_id' => $targetWallet->id,
                'category_id' => null, // null untuk transfer
                'transaction_type' => 'PEMASUKAN',
                'amount' => $request->amount,
                'description' => $descIn,
                'transaction_date' => $date
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Transfer berhasil dicatat'
            ]);

        }
        else {

            // Pemasukan & Pengeluaran Normal (1 row)
            $tx = FiatTransaction::create([
                'id' => (string)Str::uuid(),
                'user_id' => $userId,
                'wallet_id' => $sourceWallet->id,
                'category_id' => $request->category_id,
                'transaction_type' => $request->transaction_type,
                'amount' => $request->amount,
                'description' => $request->description,
                'transaction_date' => $date
            ]);

            return response()->json([
                'success' => true,
                'data' => $tx->load(['wallet', 'category'])
            ]);
        }
    }

    public function destroy($id)
    {
        $userId = session('user_id');

        $transaction = FiatTransaction::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$transaction) {
            return response()->json(['success' => false, 'message' => 'Transaksi tidak ditemukan'], 404);
        }

        // Kalau transfer, karena tadi disimpan terpisah tanpa link, yang terhapus cuma row yang diklik saja.
        // Di aplikasi mutakhir biasanya saling linked, tapi ini sudah cukup untuk versi basic

        $transaction->delete();

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dihapus'
        ]);
    }
}