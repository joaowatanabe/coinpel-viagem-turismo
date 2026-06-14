<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DriverResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'birth_date' => $this->birth_date ? $this->birth_date->format('Y-m-d') : null,
            'email' => $this->email,
            'phone' => $this->phone,
            'registration' => $this->registration,
            'profile_photo_path' => $this->profile_photo_path,
            'profile_photo_url' => $this->profile_photo_path 
                ? Storage::url($this->profile_photo_path) 
                : null,
        ];
    }
}
