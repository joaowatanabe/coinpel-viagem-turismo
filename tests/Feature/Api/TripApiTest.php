<?php

namespace Tests\Feature\Api;

use App\Models\Driver;
use App\Models\Trip;
use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TripApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_trips_via_api(): void
    {
        // 1. Create a User, Vehicle, and Driver
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create([
            'prefix' => 4002,
            'plate' => 'ABC1234',
            'model' => 'Mercedes-Benz O500',
            'chassis' => '9384918239123', // sensitive
        ]);
        $driver = Driver::factory()->create([
            'name' => 'Adalberto Silva',
            'email' => 'adalberto@coinpel.com',
            'phone' => '(53) 98765-4321',
            'registration' => 'DRV123',
            'cpf' => '123.456.789-00', // sensitive
            'rg' => '1234567890', // sensitive
            'street' => 'Rua Marechal Deodoro', // sensitive
        ]);

        // 2. Create a Trip
        $trip = Trip::create([
            'name' => 'Viagem de Estudos Pelotas - POA',
            'rule' => 'Faculdade',
            'date' => '2026-07-20',
            'departure_time' => '08:00:00',
            'origin' => 'Pelotas - RS',
            'destination' => 'Porto Alegre - RS',
            'ticket_price' => 75.50,
            'passenger_count' => 32,
            'status' => 'scheduled',
            'vehicle_id' => $vehicle->id,
            'driver_id' => $driver->id,
            'created_by' => $user->id,
        ]);

        // 3. Make GET request to /api/trips
        $response = $this->getJson('/api/trips');

        // 4. Assert response status and structure
        $response->assertStatus(200);

        // Check structure and content
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'rule',
                    'date',
                    'departure_time',
                    'origin',
                    'destination',
                    'ticket_price',
                    'passenger_count',
                    'status',
                    'status_label',
                    'vehicle' => [
                        'id',
                        'prefix',
                        'plate',
                        'model',
                        'capacity',
                        'vehicle_type',
                        'seat_type',
                        'year',
                    ],
                    'driver' => [
                        'id',
                        'name',
                        'birth_date',
                        'email',
                        'phone',
                        'registration',
                        'profile_photo_path',
                        'profile_photo_url',
                    ],
                ]
            ]
        ]);

        // Assert specific values
        $response->assertJsonFragment([
            'name' => 'Viagem de Estudos Pelotas - POA',
            'rule' => 'Faculdade',
            'date' => '2026-07-20',
            'origin' => 'Pelotas - RS',
            'destination' => 'Porto Alegre - RS',
            'ticket_price' => 75.5,
            'passenger_count' => 32,
            'status' => 'scheduled',
            'status_label' => 'Agendada',
        ]);

        // Assert vehicle and driver nested attributes
        $response->assertJsonFragment([
            'prefix' => 4002,
            'plate' => 'ABC1234',
            'model' => 'Mercedes-Benz O500',
        ]);

        $response->assertJsonFragment([
            'name' => 'Adalberto Silva',
            'email' => 'adalberto@coinpel.com',
            'registration' => 'DRV123',
        ]);

        // Assert sensitive information is NOT exposed
        $response->assertJsonMissingPath('data.0.vehicle.chassis');
        $response->assertJsonMissingPath('data.0.driver.cpf');
        $response->assertJsonMissingPath('data.0.driver.rg');
        $response->assertJsonMissingPath('data.0.driver.street');
    }
}
