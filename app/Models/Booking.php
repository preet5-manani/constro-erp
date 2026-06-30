<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use Auditable;

    protected $fillable = [
        'customer_id',
        'flat_id',
        'booking_date',
        'token_amount',
        'status',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'token_amount' => 'decimal:2',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function flat(): BelongsTo
    {
        return $this->belongsTo(Flat::class);
    }

    public function installments(): HasMany
    {
        return $this->hasMany(Installment::class);
    }
}
