<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Wallet extends Model
{
    use HasUuids;

    protected $table = 'wallets';

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'currency',
    ];

    /**
     * Get the fiat transactions for the wallet.
     */
    public function fiatTransactions()
    {
        return $this->hasMany(FiatTransaction::class);
    }
}
