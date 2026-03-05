<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AssetTransaction extends Model
{
    use HasUuids;

    protected $table = 'asset_transactions';

    // Disable default Laravel timestamps since DB handles them (transaction_date, created_at)
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'portfolio_id',
        'transaction_type', // BUY, SELL, INITIAL
        'units',
        'price_per_unit',
        'total_amount',
        'linked_fiat_transaction_id',
        'notes',
        'transaction_date',
    ];

    protected $casts = [
        'units' => 'decimal:8',
        'price_per_unit' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'transaction_date' => 'datetime',
        'created_at' => 'datetime',
    ];

    /**
     * Get the portfolio this transaction belongs to.
     */
    public function portfolio()
    {
        return $this->belongsTo(UserPortfolio::class , 'portfolio_id');
    }

    /**
     * Get the fiat transaction linked to this asset transaction
     * (e.g., if buying stock deducted money from a wallet).
     */
    public function linkedFiatTransaction()
    {
        return $this->belongsTo(FiatTransaction::class , 'linked_fiat_transaction_id');
    }
}