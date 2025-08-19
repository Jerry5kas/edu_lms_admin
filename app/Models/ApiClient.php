<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiClient extends Model
{
    protected $fillable = [
        'name', 'key', 'scopes', 'is_active', 'last_used_at'
    ];

    protected $casts = [
        'scopes' => 'array',
        'is_active' => 'boolean',
        'last_used_at' => 'datetime',
    ];
}
