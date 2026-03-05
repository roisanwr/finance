<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WalletBalance extends Model
{
    protected $table = 'wallet_balances';
    public $timestamps = false;
    protected $guarded = [];

    // Jika id bukan integer/primary key standar, tambahkan ini supaya tidak error
    protected $primaryKey = 'wallet_id';
    public $incrementing = false;
    protected $keyType = 'string';
}
