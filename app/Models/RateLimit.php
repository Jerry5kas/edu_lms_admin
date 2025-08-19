<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RateLimit extends Model
{
    protected $fillable = [
        'key', 'period', 'max_requests', 'window_started_at', 'request_count'
    ];

    protected $casts = [
        'window_started_at' => 'datetime',
    ];
}
