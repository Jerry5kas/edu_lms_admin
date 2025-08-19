<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    protected $fillable = [
        'user_id','provider','provider_user_id',
        'provider_email','avatar_url','raw_json'
    ];

    protected $casts = ['raw_json' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

