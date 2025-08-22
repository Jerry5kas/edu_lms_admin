<?php

namespace App\Models;

use App\Traits\LogsAdminActions;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes, LogsAdminActions;


    protected $fillable = [
        'uuid', 'name', 'email', 'phone_e164', 'password', 'profile',
        'locale', 'timezone', 'country_code', 'date_of_birth',
        'marketing_opt_in', 'legal_acceptance_version',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'marketing_opt_in' => 'boolean',
    ];

// Relationships
    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function communicationPreferences()
    {
        return $this->hasOne(CommunicationPreference::class);
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function gdprRequests()
    {
        return $this->hasMany(GdprRequest::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    // link to notifications
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')
            ->orderBy('created_at', 'desc');
    }

    public function smsLogs()
    {
        return $this->hasMany(SmsLog::class);
    }

    public function emailLogs()
    {
        return $this->hasMany(EmailLog::class);
    }
}
