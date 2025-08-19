<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GdprRequest extends Model
{
    protected $fillable = [
        'user_id', 'type', 'status', 'requested_at', 'processed_at', 'notes'
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'processed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
