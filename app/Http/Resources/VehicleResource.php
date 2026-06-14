<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'prefix' => $this->prefix,
            'plate' => $this->plate,
            'model' => $this->model,
            'capacity' => $this->capacity,
            'vehicle_type' => $this->vehicle_type,
            'seat_type' => $this->seat_type,
            'year' => $this->year,
            'has_wifi' => $this->has_wifi,
            'has_wc' => $this->has_wc,
            'has_outlet' => $this->has_outlet,
            'has_ac' => $this->has_ac,
            'has_fridge' => $this->has_fridge,
            'has_heating' => $this->has_heating,
            'has_video' => $this->has_video,
        ];
    }
}
