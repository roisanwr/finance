<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class UserPortfolio extends Model
{
    use HasUuids;

    protected $table = 'user_portfolios';

    // Disable default Laravel timestamps since DB handles them (created_at, updated_at, opened_at, closed_at)
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'asset_id',
        'total_units',
        'average_buy_price',
        'opened_at',
        'closed_at'
    ];

    protected $casts = [
        'total_units' => 'decimal:8',
        'average_buy_price' => 'decimal:2',
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the asset associated with this portfolio record.
     */
    public function asset()
    {
        return $this->belongsTo(Asset::class , 'asset_id');
    }

    /**
     * Get the user that owns this portfolio.
     */
    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    /**
     * Get all transactions for this portfolio asset.
     */
    public function transactions()
    {
        return $this->hasMany(AssetTransaction::class , 'portfolio_id')->orderBy('transaction_date', 'desc');
    }
}