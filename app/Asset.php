<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Asset extends Model
{
    use HasUuids;

    protected $table = 'assets';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'name',
        'asset_type',
        'ticker_symbol',
        'unit_name',
        'price_source'
    ];

    /**
     * Get all valuations for this asset.
     */
    public function valuations()
    {
        return $this->hasMany(AssetValuation::class , 'asset_id')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get the latest valuation easily.
     * NOTE: We use hasOne->latest instead of ofMany because ofMany internally
     * uses MAX(id) as tiebreaker — which fails on UUID primary keys in PostgreSQL.
     */
    public function latestValuation()
    {
        return $this->hasOne(AssetValuation::class , 'asset_id')
            ->latest('recorded_at');
    }
}