<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $fillable = [
        'payment_id', 'amount_cents', 'reason', 'gateway_refund_id', 'status', 'raw_payload'
    ];

    protected $casts = [
        'raw_payload' => 'array',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    // Accessor for formatted amount
    public function getAmountFormattedAttribute()
    {
        return number_format($this->amount_cents / 100, 2);
    }

    // Check if refund is successful
    public function isSuccessful()
    {
        return $this->status === 'processed';
    }
}
