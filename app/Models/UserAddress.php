<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id', 'type', 'name', 'line1', 'line2',
        'city', 'postal_code', 'region', 'country_code', 'vat_id', 'is_default'
    ];

    protected $casts = ['is_default' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
