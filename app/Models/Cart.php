<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'price',
        'merchant_oid',
        'related_id',
    ];
    
    public function product()
    {
        return $this->hasOne(\App\Models\Product::class, 'id', 'product_id');
    }

    public function lesson()
    {
        return $this->hasOne(\App\Models\Calendar_lesson::class, 'id', 'related_id');
    }    
}
