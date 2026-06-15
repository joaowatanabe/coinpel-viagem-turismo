<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'name',
    'email',
    'phone',
    'cpf',
    'birth_date',
    'zip_code',
    'street',
    'number',
    'city',
    'state',
    'profile_photo_path'
])]
class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }
}
