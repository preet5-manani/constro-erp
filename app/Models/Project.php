<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'name',
        'location',
        'start_date',
        'end_date',
        'status',
        'budget',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'budget' => 'decimal:2',
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function towers(): HasMany
    {
        return $this->hasMany(Tower::class);
    }
}
