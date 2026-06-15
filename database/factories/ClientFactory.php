<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'name'         => fake()->name(),
            'birth_date'   => fake()->date('Y-m-d', '2000-01-01'),
            'cpf'          => fake()->unique()->numerify('###.###.###-##'),
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
