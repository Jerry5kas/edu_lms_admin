<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminActionAudit extends Model
{
    protected $table = 'admin_actions_audit';

    protected $fillable = [
        'admin_id', 'action', 'target_type', 'target_id',
        'before_json', 'after_json'
    ];

    protected $casts = [
        'before_json' => 'array',
        'after_json' => 'array',
    ];

    public $timestamps = false; // only created_at

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
