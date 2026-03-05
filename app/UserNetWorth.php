<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNetWorth extends Model
{
    protected $table = 'user_net_worth';
    public $timestamps = false;
    protected $guarded = [];

    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';
}
