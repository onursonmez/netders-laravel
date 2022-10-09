<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_detail extends Model
{
    use HasFactory;    

    protected $fillable = [
        'user_id',
        'phone_mobile',
        'birthday',
        'address',
        'city_id',
        'town_id',
        'gender',
        'profession_id',
        'title',
        'long_text',
        'reference_text',
        'company_title',
        'privacy_lastname',
        'privacy_phone',
        'privacy_age',
    ];

    public function city()
    {
        return $this->hasOne(\App\Models\City::class, 'id', 'city_id');
    }   
    
    public function town()
    {
        return $this->hasOne(\App\Models\Town::class, 'id', 'town_id');
    }        
}
