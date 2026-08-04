<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSeo extends Model
{
    protected $table = 'page_seo';

    protected $fillable = [
        'page_key', 'page_name', 'meta_title', 'meta_description', 
        'meta_keywords', 'canonical_url', 'schema_markup'
    ];
}
