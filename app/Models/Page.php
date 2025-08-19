<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug', 'title', 'body', 'is_published',
        'published_at', 'locale', 'meta'
    ];

    protected $casts = [
        'meta' => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];
}
