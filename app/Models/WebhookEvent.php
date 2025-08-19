<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebhookEvent extends Model
{
    public $timestamps = false; // custom timestamps

    protected $fillable = [
        'provider', 'event_type', 'event_id', 'payload',
        'processed_at', 'processing_status', 'error_message', 'received_at'
    ];

    protected $casts = [
        'payload' => 'array',
        'processed_at' => 'datetime',
        'received_at' => 'datetime',
    ];
}

