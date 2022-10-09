<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'text_short',
        'text_long',
        'text_lesson',
        'text_reference',
        'company_name',
        'figures',
        'places',
        'times',
        'services',
        'genders',
        'discount1',
        'discount2',
        'discount3',
        'discount4',
        'discount5',
        'discount6',
        'discount7',
        'discount8',
        'discount9',
        'discount10',
        'discount11',
        'discount11_text',
        'discount12',
        'discount12_text',
        'discount13',
        'discount13_text',
        'privacy_lastname',
        'privacy_phone',
        'profession',
        'search_point',
    ];
  
    
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }         
    
}