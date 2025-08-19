<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'currency', 'amount_cents', 'discount_cents', 'tax_cents', 'total_cents',
        'status', 'gateway', 'gateway_order_id', 'notes', 'placed_at', 'paid_at',
        'failed_at', 'cancelled_at', 'refunded_at'
    ];

    protected $casts = [
        'notes' => 'array',
        'placed_at' => 'datetime',
        'paid_at' => 'datetime',
        'failed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
