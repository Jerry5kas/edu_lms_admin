<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'user_id', 'course_id', 'source', 'status',
        'activated_at', 'expires_at', 'revoked_at',
        'payment_id', 'meta'
    ];

    protected $casts = [
        'activated_at' => 'datetime',
        'expires_at' => 'datetime',
        'revoked_at' => 'datetime',
        'meta' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function certificate()
    {
        return $this->hasOne(Certificate::class);
    }
}
