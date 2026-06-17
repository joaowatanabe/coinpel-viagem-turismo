<?php

namespace Database\Factories;

use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Trip>
 */
class TripFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'           => fake()->sentence(3),
            'rule'           => 'general',
            'date'           => fake()->date(),
            'departure_time' => fake()->time('H:i'),
            'origin'         => fake()->city(),
            'destination'    => fake()->city(),
            'ticket_price'   => fake()->randomFloat(2, 50, 500),
            'passenger_count'=> fake()->numberBetween(10, 40),
            'status'         => \App\Models\Trip::STATUS_SCHEDULED,
            'vehicle_id'     => \App\Models\Vehicle::factory(),
            'driver_id'      => \App\Models\Driver::factory(),
            'created_by'     => \App\Models\User::factory(),
        ];
    }
}
