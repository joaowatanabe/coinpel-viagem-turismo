<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vehicle>
 */
class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition(): array
    {
        return [
            'prefix'       => fake()->unique()->numberBetween(100, 9999),
            'plate'        => fake()->unique()->regexify('[A-Z]{3}[0-9][A-Z][0-9]{2}'), // Mercosul plate format
            'model'        => fake()->randomElement(['Marcopolo Paradiso 1200', 'Marcopolo Viaggio 900', 'Volare W9', 'Mercedes-Benz Sprinter']),
            'chassis'      => fake()->numerify('#################'),
            'capacity'     => fake()->randomElement([20, 36, 44, 46, 50]),
            'vehicle_type' => fake()->randomElement(array_keys(Vehicle::VEHICLE_TYPES)),
            'seat_type'    => fake()->randomElement(array_keys(Vehicle::SEAT_TYPES)),
            'year'         => fake()->numberBetween(2010, date('Y')),
            'has_wifi'     => fake()->boolean(),
            'has_wc'       => fake()->boolean(),
            'has_outlet'   => fake()->boolean(),
            'has_ac'       => fake()->boolean(),
            'has_fridge'   => fake()->boolean(),
            'has_heating'  => fake()->boolean(),
            'has_video'    => fake()->boolean(),
        ];
    }
}
