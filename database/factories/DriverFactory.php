<?php

namespace Database\Factories;

use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Driver>
 */
class DriverFactory extends Factory
{
    protected $model = Driver::class;

    public function definition(): array
    {
        return [
            'name'         => fake()->name(),
            'birth_date'   => fake()->date('Y-m-d', '2000-01-01'),
            'registration' => fake()->unique()->numerify('########'),
            'cpf'          => fake()->unique()->numerify('###.###.###-##'),
            'rg'           => fake()->numerify('##########'),
            'zip_code'     => fake()->numerify('#####-###'),
            'street'       => fake()->streetName(),
            'number'       => fake()->buildingNumber(),
            'city'         => fake()->city(),
            'state'        => fake()->stateAbbr(),
            'email'        => fake()->unique()->safeEmail(),
            'phone'        => fake()->phoneNumber(),
        ];
    }
}
