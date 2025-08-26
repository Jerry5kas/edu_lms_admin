<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'order_id', 'invoice_no', 'issued_at', 'billing_name', 'address_json',
        'line_items_json', 'totals_json', 'pdf_path'
    ];

    protected $casts = [
        'address_json' => 'array',
        'line_items_json' => 'array',
        'totals_json' => 'array',
        'issued_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Generate invoice number
    public static function generateInvoiceNumber()
    {
        $lastInvoice = self::latest()->first();
        $lastNumber = $lastInvoice ? (int) substr($lastInvoice->invoice_no, 3) : 0;
        return 'INV' . str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
    }

    // Get PDF URL
    public function getPdfUrlAttribute()
    {
        if ($this->pdf_path) {
            return asset('storage/' . $this->pdf_path);
        }
        return null;
    }
}
