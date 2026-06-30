<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contractor extends Model
{
    use Auditable;

    protected $fillable = [
        'name',
        'specialization',
        'phone',
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(ContractorTask::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(ContractorPayment::class);
    }
}
