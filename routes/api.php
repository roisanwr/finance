<?php

use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

/*
 |--------------------------------------------------------------------------
 | API Routes
 |--------------------------------------------------------------------------
 |
 | Semua route API di bawah ini dilindungi oleh middleware `supabase.auth`.
 | Middleware ini mengecek session Supabase, dan untuk request API (JSON),
 | akan mengembalikan response 401 JSON alih-alih redirect ke halaman login.
 | Prefix otomatis: /api
 |
 */

Route::middleware('supabase.auth')->group(function () {

    // ---- Manajemen Dompet (Wallets) ----
    Route::get('/wallets', [WalletController::class , 'index']);
    Route::post('/wallets', [WalletController::class , 'store']);
    Route::put('/wallets/{id}', [WalletController::class , 'update']);
    Route::delete('/wallets/{id}', [WalletController::class , 'destroy']);

});