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
    'created_by'
])]
class Trip extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date' => 'date',
            'ticket_price' => 'decimal:2',
            'passenger_count' => 'integer',
            'vehicle_id' => 'integer',
            'driver_id' => 'integer',
            'created_by' => 'integer',
        ];
    }

    /**
     * Obter o motorista da viagem.
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Obter o veículo da viagem.
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Obter o usuário que criou a viagem.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
