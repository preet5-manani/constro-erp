<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditObserver
{
    /**
     * Attributes that should never be stored in the audit trail.
     */
    protected array $globalExcluded = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    public function created(Model $model): void
    {
        $this->writeLog('created', $model, [], $this->clean($model->getAttributes(), $model));
    }

    public function updated(Model $model): void
    {
        $changes = $this->clean($model->getChanges(), $model);

        if (empty($changes)) {
            return;
        }

        $old = array_intersect_key($model->getOriginal(), $changes);

        $this->writeLog('updated', $model, $old, $changes);
    }

    public function deleted(Model $model): void
    {
        $this->writeLog('deleted', $model, $this->clean($model->getOriginal(), $model), []);
    }

    protected function clean(array $attributes, Model $model): array
    {
        $excluded = array_merge($this->globalExcluded, $model->auditExclude ?? []);

        return array_diff_key($attributes, array_flip($excluded));
    }

    protected function writeLog(string $event, Model $model, array $old, array $new): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'event' => $event,
            'auditable_type' => $model->getMorphClass(),
            'auditable_id' => $model->getKey(),
            'old_values' => $old ?: null,
            'new_values' => $new ?: null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
