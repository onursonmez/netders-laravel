<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'city_id',
        'town_id',
    ];  
    
    public function city()
    {
        return $this->belongsTo(\App\Models\City::class);
    }

    public function town()
    {
        return $this->belongsTo(\App\Models\Town::class);
    }     
    
    public function towns()
    {
        return $this->hasMany(\App\Models\Town::class, 'id', 'town_id');
    }           
}
