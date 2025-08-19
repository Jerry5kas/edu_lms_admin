<?php

namespace App\Traits;

use App\Models\AdminActionAudit;
use Illuminate\Support\Facades\Auth;

trait LogsAdminActions
{
    public static function bootLogsAdminActions()
    {
        static::created(function ($model) {
            self::logAction('created', $model, null, $model->toArray());
        });

        static::updated(function ($model) {
            self::logAction('updated', $model, $model->getOriginal(), $model->getDirty());
        });

        static::deleted(function ($model) {
            self::logAction('deleted', $model, $model->toArray(), null);
        });
    }

    protected static function logAction($action, $model, $before, $after)
    {
        $admin = Auth::user();

        // Only log if an admin is logged in
        if (!$admin || !$admin->hasRole('Admin')) {
            return;
        }

        AdminActionAudit::create([
            'admin_id' => $admin->id,
            'action' => $action . '_' . strtolower(class_basename($model)),
            'target_type' => get_class($model),
            'target_id' => $model->id ?? null,
            'before_json' => $before ? json_encode($before) : null,
            'after_json' => $after ? json_encode($after) : null,
        ]);
    }
}
