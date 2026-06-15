<?php

namespace Tests\Feature;

use App\Models\Driver;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatisticsTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'must_change_password' => false,
            'is_blocked'           => false,
        ]);
    }

    public function test_guests_cannot_access_statistics(): void
    {
        $this->get(route('statistics.index'))->assertRedirect(route('login'));
    }

    public function test_authenticated_admin_can_access_statistics(): void
    {
        // Arrange
        $vehicle = Vehicle::factory()->create();
        $driver = Driver::factory()->create();

        // Create some trips with various dates and statuses to test calculations using Trip::create
        Trip::create([
            'name' => 'Viagem Sul',
            'rule' => 'Turismo',
            'date' => now()->subDays(10)->format('Y-m-d'),
            'departure_time' => '08:00:00',
            'origin' => 'Pelotas - RS',
            'destination' => 'Rio Grande - RS',
            'ticket_price' => 100.00,
            'passenger_count' => 10,
            'status' => 'completed',
            'driver_id' => $driver->id,
            'vehicle_id' => $vehicle->id,
            'created_by' => $this->admin->id,
        ]);

        Trip::create([
            'name' => 'Viagem Norte',
            'rule' => 'Turismo',
            'date' => now()->subDays(40)->format('Y-m-d'), // More than 30 days ago
            'departure_time' => '10:00:00',
            'origin' => 'Pelotas - RS',
            'destination' => 'Porto Alegre - RS',
            'ticket_price' => 50.00,
            'passenger_count' => 5,
            'status' => 'cancelled',
            'driver_id' => $driver->id,
            'vehicle_id' => $vehicle->id,
            'created_by' => $this->admin->id,
        ]);

        // Act
        $response = $this->actingAs($this->admin)
            ->get(route('statistics.index'));

        // Assert
        $response->assertStatus(200);

        // Verify the HTML contains calculated values
        $response->assertSee('Estatísticas');
        $response->assertSee('Total de Viagens');
        $response->assertSee('Motoristas Ativos');
        $response->assertSee('Total de Veículos');
        $response->assertSee('Receita Estimada');
        
        // Total trips = 2, trips in last 30 days = 1
        $response->assertSee('2');
        $response->assertSee('1 nos últimos 30 dias');
        
        // Revenue estimated: (100 * 10) + (50 * 5) = 1000 + 250 = 1250
        $response->assertSee('R$ 1.250,00');

        // Verify status counters are visible
        $response->assertSee('Concluídas');
        $response->assertSee('Canceladas');
    }
}
