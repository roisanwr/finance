<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class FiatTransaction extends Model
{
    use HasUuids;

    protected $table = 'fiat_transactions';

    protected $fillable = [
        'user_id',
        'wallet_id',
        'category_id',
        'transaction_type', // PEMASUKAN, PENGELUARAN, TRANSFER
        'amount',
        'description',
        'transaction_date',
    ];

    /**
     * Get the wallet that owns the transaction.
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * Get the category that owns the transaction.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
