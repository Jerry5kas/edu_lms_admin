<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'template_key',
        'subject',
        'status',
        'error_message',
        'sent_at',
        'response_json',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'response_json' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
