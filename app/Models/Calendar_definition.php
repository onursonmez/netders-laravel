<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar_definition extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'd1_from',
        'd1_to',
        'd2_from',
        'd2_to',        
        'd3_from',
        'd3_to',        
        'd4_from',
        'd4_to',
        'd5_from',
        'd5_to',        
        'd6_from',
        'd6_to',        
        'd7_from',
        'd7_to',        
        'lesson_min_minute',
        'lesson_max_minute',
    ];    
}
