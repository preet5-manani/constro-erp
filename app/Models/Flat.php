<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Flat extends Model
{
    use Auditable;

    protected $fillable = [
        'floor_id',
        'flat_number',
        'area',
        'price',
        'status',
    ];

    protected $casts = [
        'area' => 'decimal:2',
        'price' => 'decimal:2',
    ];

    public function floor(): BelongsTo
    {
        return $this->belongsTo(Floor::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
