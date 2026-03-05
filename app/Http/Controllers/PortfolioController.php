<?php

namespace App\Http\Controllers;

use App\UserPortfolio;
use App\AssetTransaction;
use App\AssetValuation;
use App\Asset;
use App\FiatTransaction;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PortfolioController
{
    // --- VIEW ---
    public function view()
    {
        return view('investments.portfolios');
    }

    // --- API ENDPOINTS ---

    public function index()
    {
        $userId = session('user_id');

        // Fetch portfolios with their assets and the asset's latest valuation
        $portfolios = UserPortfolio::with(['asset.latestValuation', 'asset'])
            ->where('user_id', $userId)
            ->where('total_units', '>', 0) // Only show active holdings by default
            ->get();

        return response()->json($portfolios);
    }

    public function transactions($portfolioId)
    {
        $userId = session('user_id');

        // Verify ownership
        $portfolio = UserPortfolio::where('id', $portfolioId)
            ->where('user_id', $userId)
            ->first();

        if (!$portfolio) {
            return response()->json(['success' => false, 'message' => 'Portofolio tidak ditemukan'], 404);
        }

        $transactions = AssetTransaction::with(['linkedFiatTransaction.wallet'])
            ->where('portfolio_id', $portfolioId)
            ->orderBy('transaction_date', 'desc')
            ->get();

        return response()->json($transactions);
    }

    public function storeTransaction(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|uuid',
            'transaction_type' => 'required|in:BELI,JUAL,SALDO_AWAL',
            'units' => 'required|numeric|min:0.00000001',
            'price_per_unit' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'transaction_date' => 'nullable|date',

            // Integration fields
            'link_to_wallet' => 'nullable|boolean',
            'wallet_id' => 'nullable|required_if:link_to_wallet,true|uuid'
        ]);

        $userId = session('user_id');
        $assetId = $request->asset_id;
        $type = $request->transaction_type;
        $units = (float)$request->units;
        $pricePerUnit = (float)$request->price_per_unit;
        $totalAmount = $units * $pricePerUnit;
        $txDate = $request->transaction_date ? date('Y-m-d H:i:s', strtotime($request->transaction_date)) : now();

        DB::beginTransaction();
        try {
            // 1. Dapatkan atau Buat record Portofolio
            $portfolio = UserPortfolio::firstOrCreate(
            ['user_id' => $userId, 'asset_id' => $assetId],
            ['id' => (string)Str::uuid(), 'total_units' => 0, 'average_buy_price' => 0]
            );

            // Validasi saldo Unit jika JUAL
            if ($type === 'JUAL' && $portfolio->total_units < $units) {
                return response()->json([
                    'success' => false,
                    'message' => "Unit tidak cukup. Anda hanya memiliki {$portfolio->total_units} unit."
                ], 422);
            }

            $linkedFiatTxId = null;

            // 2. Hubungkan ke Uang Kas (Fiat) jika diminta
            if ($request->link_to_wallet && $request->wallet_id) {
                // Verifikasi dompet
                $wallet = Wallet::where('id', $request->wallet_id)->where('user_id', $userId)->first();
                if (!$wallet) {
                    throw new \Exception("Dompet tidak ditemukan.");
                }

                $assetInfo = Asset::find($assetId);
                $assetName = $assetInfo ? $assetInfo->name : 'Aset';

                if ($type === 'BELI') {
                    // Cek saldo kas secara dinamis
                    $in = $wallet->fiatTransactions()->where('transaction_type', 'PEMASUKAN')->sum('amount');
                    $out = $wallet->fiatTransactions()->where('transaction_type', 'PENGELUARAN')->sum('amount');
                    $currentBalance = $in - $out;

                    if ($currentBalance < $totalAmount) {
                        throw new \Exception("Saldo dompet ({$wallet->name}) tidak cukup untuk pembelian ini.");
                    }

                    // Beli Aset = Pengeluaran Uang Kas
                    $fiatTx = FiatTransaction::create([
                        'id' => (string)Str::uuid(),
                        'user_id' => $userId,
                        'wallet_id' => $wallet->id,
                        'transaction_type' => 'PENGELUARAN',
                        'amount' => $totalAmount,
                        'description' => "Pembelian $assetName ($units unit)",
                        'transaction_date' => $txDate
                    ]);
                    $linkedFiatTxId = $fiatTx->id;

                // Note: Wallet balance is auto-deducted via existing triggers
                }
                elseif ($type === 'JUAL') {
                    // Jual Aset = Pemasukan Uang Kas
                    $fiatTx = FiatTransaction::create([
                        'id' => (string)Str::uuid(),
                        'user_id' => $userId,
                        'wallet_id' => $wallet->id,
                        'transaction_type' => 'PEMASUKAN',
                        'amount' => $totalAmount,
                        'description' => "Penjualan $assetName ($units unit)",
                        'transaction_date' => $txDate
                    ]);
                    $linkedFiatTxId = $fiatTx->id;
                }
            }

            // 3. Catat di Asset Transactions
            $assetTx = AssetTransaction::create([
                'id' => (string)Str::uuid(),
                'user_id' => $userId,
                'portfolio_id' => $portfolio->id,
                'transaction_type' => $type,
                'units' => $units,
                'price_per_unit' => $pricePerUnit,
                'total_amount' => $totalAmount,
                'linked_fiat_transaction_id' => $linkedFiatTxId,
                'notes' => $request->notes,
                'transaction_date' => $txDate
            ]);

            // Database Trigger `update_portfolio_stats` akan otomatis mengupdate 
            // `total_units` & `average_buy_price` di tabel `user_portfolios`.

            // Catat harga terbaru ini ke Valuasi Aset juga (supaya grafik harga up-to-date)
            AssetValuation::create([
                'id' => (string)Str::uuid(),
                'asset_id' => $assetId,
                'price_per_unit' => $pricePerUnit,
                'source' => 'MANUAL',
                'recorded_at' => $txDate
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi aset berhasil dicatat!',
                'data' => $assetTx
            ]);

        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal transaksi: ' . $e->getMessage()
            ], 500);
        }
    }
}