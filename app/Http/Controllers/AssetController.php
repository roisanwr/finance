<?php

namespace App\Http\Controllers;

use App\Asset;
use App\AssetValuation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AssetController
{
    // --- VIEW ---
    public function view()
    {
        return view('investments.assets');
    }

    // --- API ENDPOINTS ---

    public function index()
    {
        $userId = session('user_id');

        // Mengambil daftar aset beserta Harga Pasar Terkini (Latest Valuation)
        $assets = Asset::with('latestValuation')
            ->where('user_id', $userId)
            ->orderBy('name', 'asc')
            ->get();

        return response()->json($assets);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'asset_type' => 'required|in:KRIPTO,SAHAM,LOGAM_MULIA,PROPERTI,BISNIS,LAINNYA',
            'ticker_symbol' => 'nullable|string|max:50',
            'unit_name' => 'nullable|string|max:50',
            'initial_price' => 'nullable|numeric|min:0'
        ]);

        $userId = session('user_id');

        // Cek duplikasi jika ada ticker (hanya untuk tipe yang sama)
        if ($request->ticker_symbol) {
            $exists = Asset::where('user_id', $userId)
                ->where('asset_type', $request->asset_type)
                ->where('ticker_symbol', $request->ticker_symbol)
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => "Instrumen dengan Ticker {$request->ticker_symbol} sudah terdaftar di tipe {$request->asset_type}."
                ], 422);
            }
        }

        $asset = Asset::create([
            'id' => (string)Str::uuid(),
            'user_id' => $userId,
            'name' => $request->name,
            'asset_type' => $request->asset_type,
            'ticker_symbol' => $request->ticker_symbol,
            'unit_name' => $request->unit_name ?? 'unit',
            // source dibiarkan MANUAL sesuai default table
        ]);

        // Jika user mengisi harga awal, langsung catatkan ke tabel valuations
        if ($request->initial_price !== null && $request->initial_price >= 0) {
            AssetValuation::create([
                'id' => (string)Str::uuid(),
                'asset_id' => $asset->id,
                'price_per_unit' => $request->initial_price,
                'source' => 'MANUAL'
                // valuation_date otomatis NOW() via Database Defaults
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $asset->load('latestValuation')
        ]);
    }

    public function updateMarketPrice(Request $request, $id)
    {
        $request->validate([
            'price_per_unit' => 'required|numeric|min:0'
        ]);

        $userId = session('user_id');

        // Pastikan aset ini milik user ybs
        $asset = Asset::where('id', $id)->where('user_id', $userId)->first();

        if (!$asset) {
            return response()->json(['success' => false, 'message' => 'Aset tidak ditemukan'], 404);
        }

        // Simpan pergerakan harga historis baru
        $valuation = AssetValuation::create([
            'id' => (string)Str::uuid(),
            'asset_id' => $asset->id,
            'price_per_unit' => $request->price_per_unit,
            'source' => 'MANUAL'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Harga pasar berhasil diperbarui',
            'data' => $valuation
        ]);
    }

    public function destroy($id)
    {
        $userId = session('user_id');

        $asset = Asset::where('id', $id)->where('user_id', $userId)->first();

        if (!$asset) {
            return response()->json(['success' => false, 'message' => 'Aset tidak ditemukan'], 404);
        }

        $asset->delete();

        return response()->json([
            'success' => true,
            'message' => 'Aset berhasil dihapus'
        ]);
    }
}