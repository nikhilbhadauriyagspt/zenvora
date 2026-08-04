<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingPackage extends Model
{
    protected $fillable = [
        'title', 'subtitle', 'price', 'tax_note', 'description', 'deliverables', 'badge', 'status', 'sort_order'
    ];
}
