<?php

use App\Http\Controllers\Api\AssetTransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Semua route di bawah ini membutuhkan autentikasi via Sanctum.
| Prefix otomatis: /api
|
*/

Route::middleware('auth:sanctum')->group(function () {

    // User info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Asset Transactions
    Route::post('/assets/transaction', [AssetTransactionController::class, 'store'])
        ->name('assets.transaction.store');
});
