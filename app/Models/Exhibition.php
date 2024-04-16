<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exhibition extends Model
{
    protected $table = 'exhibition';

    protected $fillable = [
        'exhibition_start_time', 
        'exhibition_end_time', 
        'title', 
        'excerpt',
        'content',
        'location',
        'link',
        'status'
    ];

    
}