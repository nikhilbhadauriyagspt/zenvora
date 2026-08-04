<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformCard extends Model
{
    protected $fillable = [
        'title', 'slug', 'subtitle', 'description', 'image_url', 
        'points', 'detailed_content', 'status', 'sort_order'
    ];

    protected $casts = [
        'points' => 'array'
    ];
}
