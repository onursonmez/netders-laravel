<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
class Price extends Model
{
    use HasFactory, Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'subject_id',
        'level_id',
        'price_private',
        'price_live',
        'title',
        'description',
        'slug',
        'status',
    ];    

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['title', 'id']
            ]
        ];
    }    

    public function subject()
    {
        return $this->belongsTo(\App\Models\Subject::class);
    }

    public function level()
    {
        return $this->belongsTo(\App\Models\Level::class);
    }    

    public function subjects()
    {
        return $this->hasMany(\App\Models\Subject::class, 'id', 'subject_id');
    }   

    public function levels()
    {
        return $this->hasMany(\App\Models\Level::class, 'id', 'level_id');
    } 
    
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }     

}
