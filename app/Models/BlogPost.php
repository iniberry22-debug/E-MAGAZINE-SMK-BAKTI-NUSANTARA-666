<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = [
        'title',
        'category', 
        'author',
        'image',
        'excerpt',
        'content',
        'read_time',
        'views',
        'published_date',
        'is_featured'
    ];

    protected $casts = [
        'published_date' => 'date',
        'is_featured' => 'boolean'
    ];
}
