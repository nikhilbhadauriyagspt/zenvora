<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'category_id', 'title', 'slug', 'tagline', 'description', 
        'starting_price', 'average_duration', 'hero_image', 'what_is_brief',
        'docs_title', 'docs_subtitle', 'pillars_json', 'steps_json', 
        'deliverables_json', 'pricing_packages_json', 'faqs_json', 'docs_json'
    ];

    protected $casts = [
        'pillars_json' => 'array',
        'steps_json' => 'array',
        'deliverables_json' => 'array',
        'pricing_packages_json' => 'array',
        'faqs_json' => 'array',
        'docs_json' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }
}
