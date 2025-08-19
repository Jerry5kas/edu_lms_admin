<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'order_id', 'invoice_no', 'issued_at',
        'billing_name', 'address_json', 'line_items_json', 'totals_json', 'pdf_path'
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'address_json' => 'array',
        'line_items_json' => 'array',
        'totals_json' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
