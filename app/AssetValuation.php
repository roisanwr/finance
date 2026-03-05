<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AssetValuation extends Model
{
    use HasUuids;

    protected $table = 'asset_valuations';

    public $timestamps = false;

    protected $fillable = [
        'asset_id',
        'price_per_unit',
        'source',
        'recorded_at'
    ];

    /**
     * Get the asset that owns the valuation.
     */
    public function asset()
    {
        return $this->belongsTo(Asset::class , 'asset_id');
    }
}