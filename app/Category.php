<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Category extends Model
{
    use HasUuids;

    protected $table = 'categories';

    protected $fillable = [
        'user_id',
        'name',
        'type', // PEMASUKAN, PENGELUARAN, TRANSFER
    ];
}
