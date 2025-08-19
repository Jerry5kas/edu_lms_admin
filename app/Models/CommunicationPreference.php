<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunicationPreference extends Model
{
    protected $fillable = [
        'user_id', 'email_course_updates', 'email_promotions',
        'sms_otp', 'sms_marketing'
    ];

    protected $casts = [
        'email_course_updates' => 'boolean',
        'email_promotions' => 'boolean',
        'sms_otp' => 'boolean',
        'sms_marketing' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

