<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title', 'slug', 'category', 'category_slug', 'date', 'author', 
        'author_role', 'author_avatar', 'read_time', 'image', 'excerpt', 
        'content', 'status'
    ];
}
