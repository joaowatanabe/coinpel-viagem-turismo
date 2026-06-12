<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'name',
    'rule',
    'date',
    'departure_time',
    'origin',
    'destination',
    'ticket_price',
    'passenger_count',
    'status',
    'vehicle_id',
    'driver_id',
    'created_by',
])]
class Trip extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_SCHEDULED  = 'scheduled';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED  = 'completed';
    const STATUS_CANCELLED  = 'cancelled';

    const STATUSES = [
        self::STATUS_SCHEDULED   => 'Agendada',
        self::STATUS_IN_PROGRESS => 'Em andamento',
        self::STATUS_COMPLETED   => 'Concluída',
        self::STATUS_CANCELLED   => 'Cancelada',
    ];

    const STATUS_COLORS = [
        self::STATUS_SCHEDULED   => 'blue',
        self::STATUS_IN_PROGRESS => 'amber',
        self::STATUS_COMPLETED   => 'green',
        self::STATUS_CANCELLED   => 'red',
    ];

    protected function casts(): array
    {
        return [
            'date'            => 'date',
            'departure_time'  => 'string',
            'ticket_price'    => 'decimal:2',
            'passenger_count' => 'integer',
            'vehicle_id'      => 'integer',
            'driver_id'       => 'integer',
            'created_by'      => 'integer',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'gray';
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
