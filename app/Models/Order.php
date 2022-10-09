<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->hasOne(\App\Models\Product::class, 'id', 'product_id');
    }    

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }        
}
