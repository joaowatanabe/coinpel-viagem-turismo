<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'name',
    'description',
    'trip_id',
    'price',
    'includes_hotel',
    'includes_meals',
    'includes_guide',
    'max_people',
    'status',
    'created_by',
])]
class Package extends Model
{
    use HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'price'          => 'decimal:2',
            'includes_hotel' => 'boolean',
            'includes_meals' => 'boolean',
            'includes_guide' => 'boolean',
            'max_people'     => 'integer',
        ];
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
