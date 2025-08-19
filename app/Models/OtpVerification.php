<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    protected $fillable = [
        'phone_e164', 'code_hash', 'purpose', 'attempts',
        'expires_at', 'verified_at', 'meta'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
        'meta' => 'array',
    ];
}
