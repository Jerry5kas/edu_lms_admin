<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification; // extendable

/**
 * Custom Notification model extending Laravel's DatabaseNotification.
 * This lets us use ->notify() and still have access to our custom fields.
 */
class Notification extends DatabaseNotification
{
    use HasFactory;

    protected $table = 'notifications'; // unified table

    protected $fillable = [
        'id',
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at',
        'channel',
        'category',
        'subject',
        'body',
        'meta',
        'scheduled_for',
        'sent_at',
        'failed_at',
        'error_message',
        'created_by',
    ];

    protected $casts = [
        'data' => 'array',
        'meta' => 'array',
        'scheduled_for' => 'datetime',
        'sent_at' => 'datetime',
        'failed_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    /** 🔗 Relationships */

    // The user/dashboard who will receive this notification
    public function notifiable()
    {
        return $this->morphTo();
    }

    // The user/dashboard who created/sent this notification
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Announcement targets (if broadcast)
    public function announcementTargets()
    {
        return $this->hasMany(AnnouncementTarget::class, 'announcement_id');
    }
}
