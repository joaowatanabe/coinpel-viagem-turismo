<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'rule' => $this->rule,
            'date' => $this->date ? $this->date->format('Y-m-d') : null,
            'departure_time' => $this->departure_time,
            'origin' => $this->origin,
            'destination' => $this->destination,
            'ticket_price' => $this->ticket_price ? (float) $this->ticket_price : 0.0,
            'passenger_count' => $this->passenger_count,
            'status' => $this->status,
            'status_label' => $this->status_label,
            'vehicle' => new VehicleResource($this->whenLoaded('vehicle')),
            'driver' => new DriverResource($this->whenLoaded('driver')),
        ];
    }
}
