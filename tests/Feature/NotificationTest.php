<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Contract;
use App\Models\Driver;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Vehicle $vehicle;
    protected Driver $driver;
    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'must_change_password' => false,
            'is_blocked'           => false,
        ]);

        $this->vehicle = Vehicle::factory()->create();
        $this->driver = Driver::factory()->create();
        $this->client = Client::factory()->create();
    }

    public function test_guest_cannot_access_notifications(): void
    {
        $this->getJson(route('notifications.index'))
            ->assertStatus(401);
    }

    public function test_admin_can_retrieve_notifications(): void
    {
        // 1. Create a trip within the last 24h (new_trip)
        $newTrip = Trip::create([
            'name'            => 'Viagem Recente',
            'rule'            => 'Turismo',
            'date'            => now()->addDays(10)->format('Y-m-d'),
            'departure_time'  => '08:00',
            'origin'          => 'Pelotas',
            'destination'     => 'Porto Alegre',
            'ticket_price'    => 100.00,
            'passenger_count' => 15,
            'status'          => Trip::STATUS_SCHEDULED,
            'vehicle_id'      => $this->vehicle->id,
            'driver_id'       => $this->driver->id,
            'created_by'      => $this->admin->id,
        ]);
        
        // Overwrite created_at to simulate 2 hours ago
        $newTrip->created_at = now()->subHours(2);
        $newTrip->save();

        // 2. Create a trip in progress
        $inProgressTrip = Trip::create([
            'name'            => 'Viagem em Andamento',
            'rule'            => 'Turismo',
            'date'            => now()->addDays(10)->format('Y-m-d'),
            'departure_time'  => '10:00',
            'origin'          => 'Pelotas',
            'destination'     => 'Gramado',
            'ticket_price'    => 150.00,
            'passenger_count' => 20,
            'status'          => Trip::STATUS_IN_PROGRESS,
            'vehicle_id'      => $this->vehicle->id,
            'driver_id'       => $this->driver->id,
            'created_by'      => $this->admin->id,
        ]);

        $inProgressTrip->updated_at = now()->subMinutes(15);
        $inProgressTrip->save();

        // 3. Create a driver without trips in the next 7 days (driver_available)
        $availableDriver = Driver::factory()->create([
            'name'       => 'Motorista Disponivel',
            'created_at' => now()->subDays(5),
        ]);

        // 4. Create a user with must_change_password = true (password_pending)
        $pendingUser = User::factory()->create([
            'name'                 => 'Usuario Pendente',
            'must_change_password' => true,
            'is_blocked'           => false,
            'created_at'           => now()->subDays(2),
        ]);

        // 5. Create a contract expiring in 5 days (contract_expiring)
        $expiringContract = Contract::create([
            'number'      => 'CON-EXP-123',
            'client_id'   => $this->client->id,
            'trip_id'     => $newTrip->id,
            'description' => 'Contrato Expirando',
            'start_date'  => now()->subDays(5)->format('Y-m-d'),
            'end_date'    => now()->addDays(5)->format('Y-m-d'),
            'value'       => 5000.00,
            'status'      => 'active',
            'created_by'  => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->getJson(route('notifications.index'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'count',
                'items' => [
                    '*' => [
                        'type',
                        'message',
                        'link',
                        'created_at',
                    ]
                ]
            ]);

        $items = $response->json('items');
        
        $this->assertNotEmpty($items);

        $types = collect($items)->pluck('type')->toArray();
        $this->assertContains('new_trip', $types);
        $this->assertContains('in_progress', $types);
        $this->assertContains('driver_available', $types);
        $this->assertContains('password_pending', $types);
        $this->assertContains('contract_expiring', $types);

        // Verify ordering: The contract end_date (in the future) should sort it to the top.
        $this->assertEquals('contract_expiring', $items[0]['type']);
        $this->assertStringContainsString('expirando em', $items[0]['message']);
    }

    public function test_driver_with_scheduled_trip_is_not_available_notification(): void
    {
        // Create driver
        $driver = Driver::factory()->create();

        // Create a scheduled trip for this driver tomorrow
        Trip::create([
            'name'            => 'Viagem Ocupada',
            'rule'            => 'Turismo',
            'date'            => now()->addDay()->format('Y-m-d'),
            'departure_time'  => '14:00',
            'origin'          => 'Pelotas',
            'destination'     => 'Porto Alegre',
            'ticket_price'    => 100.00,
            'passenger_count' => 15,
            'status'          => Trip::STATUS_SCHEDULED,
            'vehicle_id'      => $this->vehicle->id,
            'driver_id'       => $driver->id,
            'created_by'      => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->getJson(route('notifications.index'));

        $items = $response->json('items');
        
        // Verify this driver is NOT shown as driver_available
        $driverMessages = collect($items)
            ->where('type', 'driver_available')
            ->filter(fn($item) => str_contains($item['message'], $driver->name));
            
        $this->assertEmpty($driverMessages);
    }
}
