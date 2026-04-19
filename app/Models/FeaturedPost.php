<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturedPost extends Model
{
    protected $fillable = [
        'title',
        'category',
        'author', 
        'image',
        'excerpt',
        'read_time',
        'published_date'
    ];

    protected $casts = [
        'published_date' => 'date'
    ];
}