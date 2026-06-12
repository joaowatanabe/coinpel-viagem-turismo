<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'name',
    'birth_date',
    'registration',
    'cpf',
    'rg',
    'zip_code',
    'street',
    'number',
    'city',
    'state',
    'email',
    'phone',
    'profile_photo_path'
])]
class Driver extends Model
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
            'birth_date' => 'date',
        ];
    }

    /**
     * Obter as viagens associadas a este motorista.
     */
    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }
}
