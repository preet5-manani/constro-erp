<?php

namespace App\Traits;

use App\Observers\AuditObserver;
use Illuminate\Database\Eloquent\Model;

trait Auditable
{
    public static function bootAuditable(): void
    {
        static::created(fn (Model $model) => (new AuditObserver)->created($model));
        static::updated(fn (Model $model) => (new AuditObserver)->updated($model));
        static::deleted(fn (Model $model) => (new AuditObserver)->deleted($model));
    }
}
