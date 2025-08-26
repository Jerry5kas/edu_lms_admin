<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id', 'user_id', 'amount_cents', 'currency', 'gateway', 'gateway_payment_id',
        'gateway_signature', 'method', 'status', 'error_code', 'error_description',
        'captured_at', 'refunded_at', 'raw_payload'
    ];

    protected $casts = [
        'raw_payload' => 'array',
        'captured_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Check if payment is successful
    public function isSuccessful()
    {
        return in_array($this->status, ['authorized', 'captured']);
    }

}

