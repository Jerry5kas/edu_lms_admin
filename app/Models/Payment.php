<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id','user_id','amount_cents','currency','gateway',
        'gateway_payment_id','gateway_signature','method','status',
        'error_code','error_description','captured_at','refunded_at','raw_payload'
    ];

    protected $casts = [
        'captured_at' => 'datetime',
        'refunded_at' => 'datetime',
        'raw_payload' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }
}

