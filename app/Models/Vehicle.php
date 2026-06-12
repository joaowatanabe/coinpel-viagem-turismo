<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'prefix',
    'plate',
    'model',
    'chassis',
    'capacity',
    'vehicle_type',
    'seat_type',
    'year',
    'has_wifi',
    'has_wc',
    'has_outlet',
    'has_ac',
    'has_fridge',
    'has_heating',
    'has_video',
])]
class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    const VEHICLE_TYPES = [
        'bus' => 'Ônibus',
        'van' => 'Van',
    ];

    const SEAT_TYPES = [
        'reclining' => 'Convencional',
        'semi_bed'  => 'Semi-Leito',
        'bed'       => 'Leito',
    ];

    const AMENITIES = [
        'has_wifi'    => ['label' => 'Internet',       'icon' => 'wifi'],
        'has_wc'      => ['label' => 'WC',             'icon' => 'wc'],
        'has_outlet'  => ['label' => 'Tomada',         'icon' => 'outlet'],
        'has_ac'      => ['label' => 'Ar Condicionado','icon' => 'ac'],
        'has_fridge'  => ['label' => 'Geladeira',      'icon' => 'fridge'],
        'has_heating' => ['label' => 'Calefação',      'icon' => 'heating'],
        'has_video'   => ['label' => 'Vídeo',          'icon' => 'video'],
    ];

    protected function casts(): array
    {
        return [
            'prefix'      => 'integer',
            'capacity'    => 'integer',
            'year'        => 'integer',
            'has_wifi'    => 'boolean',
            'has_wc'      => 'boolean',
            'has_outlet'  => 'boolean',
            'has_ac'      => 'boolean',
            'has_fridge'  => 'boolean',
            'has_heating' => 'boolean',
            'has_video'   => 'boolean',
        ];
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }
}
