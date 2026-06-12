<?php

namespace Tests\Feature;

use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehicleTest extends TestCase
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

    public function test_guests_cannot_access_vehicles(): void
    {
        $this->get(route('vehicles.index'))->assertRedirect(route('login'));
    }

    public function test_authenticated_admin_can_access_vehicles_index(): void
    {
        $this->actingAs($this->admin)
            ->get(route('vehicles.index'))
            ->assertStatus(200);
    }

    public function test_can_create_vehicle(): void
    {
        $vehicleData = [
            'prefix'       => 120,
            'plate'        => 'ABC1D23',
            'model'        => 'Mercedes Sprinter',
            'chassis'      => '9384918239123',
            'capacity'     => 16,
            'vehicle_type' => array_keys(Vehicle::VEHICLE_TYPES)[0],
            'seat_type'    => array_keys(Vehicle::SEAT_TYPES)[0],
            'year'         => 2020,
            'has_wifi'     => 1,
            'has_wc'       => 0,
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('vehicles.store'), $vehicleData);

        $response->assertStatus(201)
            ->assertJsonStructure(['message', 'vehicle']);

        $this->assertDatabaseHas('vehicles', [
            'prefix' => 120,
            'plate'  => 'ABC1D23',
            'model'  => 'Mercedes Sprinter',
        ]);
    }

    public function test_create_vehicle_validation(): void
    {
        $response = $this->actingAs($this->admin)
            ->postJson(route('vehicles.store'), []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['prefix', 'plate', 'model', 'capacity', 'vehicle_type', 'seat_type', 'year']);
    }

    public function test_can_update_vehicle(): void
    {
        $vehicle = Vehicle::factory()->create([
            'model' => 'Old Model',
        ]);

        $updateData = [
            'prefix'       => $vehicle->prefix,
            'plate'        => $vehicle->plate,
            'model'        => 'New Model',
            'capacity'     => $vehicle->capacity,
            'vehicle_type' => $vehicle->vehicle_type,
            'seat_type'    => $vehicle->seat_type,
            'year'         => $vehicle->year,
        ];

        $response = $this->actingAs($this->admin)
            ->patchJson(route('vehicles.update', $vehicle), $updateData);

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Veículo atualizado com sucesso.']);

        $this->assertDatabaseHas('vehicles', [
            'id'    => $vehicle->id,
            'model' => 'New Model',
        ]);
    }

    public function test_can_delete_vehicle(): void
    {
        $vehicle = Vehicle::factory()->create();

        $response = $this->actingAs($this->admin)
            ->deleteJson(route('vehicles.destroy', $vehicle));

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Veículo excluído com sucesso.']);

        $this->assertSoftDeleted('vehicles', [
            'id' => $vehicle->id,
        ]);
    }
}
