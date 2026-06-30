<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Floor extends Model
{
    use Auditable;

    protected $fillable = [
        'tower_id',
        'floor_number',
    ];

    protected $casts = [
        'floor_number' => 'integer',
    ];

    public function tower(): BelongsTo
    {
        return $this->belongsTo(Tower::class);
    }

    public function flats(): HasMany
    {
        return $this->hasMany(Flat::class);
    }
}
