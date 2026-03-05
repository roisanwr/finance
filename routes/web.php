<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\PortfolioController;

// Route Login
Route::get('/login', [AuthController::class , 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class , 'login'])->name('login.post');
Route::post('/logout', [AuthController::class , 'logout'])->name('logout');

// Route Register
Route::get('/register', [AuthController::class , 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class , 'register'])->name('register.post');

// Protected Routes (session sudah tersedia di sini karena web middleware group)
Route::middleware('supabase.auth')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class , 'index'])->name('dashboard');

    // Manajemen Kas - Halaman
    Route::get('/wallets', function () {
            return view('fiat.wallets');
        }
        )->name('wallets');

        // Kategori - Halaman
        Route::get('/categories', [CategoryController::class , 'view'])->name('categories');

        // Arus Kas - Halaman
        Route::get('/transactions', [TransactionController::class , 'view'])->name('transactions');

        // Katalog Aset - Halaman
        Route::get('/assets', [AssetController::class , 'view'])->name('assets');

        // Portofolio & Transaksi Investasi - Halaman
        Route::get('/portfolios', [PortfolioController::class , 'view'])->name('portfolios');

        // ---- API Routes ----
        // Sengaja ditaruh di web.php (bukan api.php) agar session user_id otomatis tersedia.
        // api.php di Laravel 11 bersifat stateless dan tidak bisa baca session.
        Route::prefix('api')->group(function () {

            // Wallets CRUD
            Route::get('/wallets', [WalletController::class , 'index']);
            Route::post('/wallets', [WalletController::class , 'store']);
            Route::put('/wallets/{id}', [WalletController::class , 'update']);
            Route::delete('/wallets/{id}', [WalletController::class , 'destroy']);

            // Categories CRUD
            Route::get('/categories', [CategoryController::class , 'index']);
            Route::post('/categories', [CategoryController::class , 'store']);
            Route::put('/categories/{id}', [CategoryController::class , 'update']);
            Route::delete('/categories/{id}', [CategoryController::class , 'destroy']);

            // Transactions CRUD
            Route::get('/transactions', [TransactionController::class , 'index']);
            Route::post('/transactions', [TransactionController::class , 'store']);
            Route::delete('/transactions/{id}', [TransactionController::class , 'destroy']);

            // Assets CRUD
            Route::get('/assets', [AssetController::class , 'index']);
            Route::post('/assets', [AssetController::class , 'store']);
            Route::put('/assets/{id}/price', [AssetController::class , 'updateMarketPrice']);
            Route::delete('/assets/{id}', [AssetController::class , 'destroy']);

            // Portfolios & Equity Transactions
            Route::get('/portfolios', [PortfolioController::class , 'index']);
            Route::get('/portfolios/{id}/transactions', [PortfolioController::class , 'transactions']);
            Route::post('/transactions/equity', [PortfolioController::class , 'storeTransaction']);
        }
        );

    });