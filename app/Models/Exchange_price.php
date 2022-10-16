<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exchange_price extends Model
{
    use HasFactory;

    protected $fillable = [
        'interval',
        'symbol',
        'open_time',
        'open',
        'high',
        'low',
        'close',
        'close_time',
        'quote_asset_volume',
        'number_of_trades',
        'taker_buy_base_asset_volume',
        'taker_buy_qoute_asset_volume',
        'ignore',
    ];     
}
