<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractorTask extends Model
{
    use Auditable;

    protected $fillable = [
        'contractor_id',
        'task_id',
        'status',
        'progress',
    ];

    protected $casts = [
        'progress' => 'integer',
    ];

    public function contractor(): BelongsTo
    {
        return $this->belongsTo(Contractor::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
