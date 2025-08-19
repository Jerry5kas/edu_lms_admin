<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title', 'image_path', 'link_url',
        'is_active', 'sort_order', 'timings_json'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'timings_json' => 'array',
    ];
}
