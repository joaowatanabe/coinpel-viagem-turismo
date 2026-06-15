<?php

namespace Tests\Feature;

use App\Models\Driver;
use App\Models\Package;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PackageTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Trip $trip;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'must_change_password' => false,
            'is_blocked'           => false,
        ]);

        $vehicle = Vehicle::factory()->create();
        $driver = Driver::factory()->create();

        $this->trip = Trip::create([
            'name'            => 'Viagem de Teste',
            'rule'            => 'Turismo',
            'date'            => '2026-06-15',
            'departure_time'  => '08:00',
            'origin'          => 'Pelotas',
            'destination'     => 'Gramado',
            'ticket_price'    => 150.00,
            'passenger_count' => 20,
            'status'          => 'scheduled',
            'vehicle_id'      => $vehicle->id,
            'driver_id'       => $driver->id,
            'created_by'      => $this->admin->id,
        ]);
    }

    public function test_guests_cannot_access_packages_index(): void
    {
        $this->get(route('packages.index'))->assertRedirect(route('login'));
    }

    public function test_authenticated_admin_can_access_packages_index(): void
    {
        $response = $this->actingAs($this->admin)->get(route('packages.index'));
        $response->assertStatus(200);
        $response->assertSee('Adicionar pacote');
        $response->assertSee('Nenhum pacote cadastrado ainda.');
    }

    public function test_admin_can_store_package_via_ajax(): void
    {
        $payload = [
            'name'           => 'Pacote de Teste',
            'description'    => 'Descrição do pacote de teste',
            'trip_id'        => $this->trip->id,
            'price'          => '500.00',
            'includes_hotel' => true,
            'includes_meals' => false,
            'includes_guide' => true,
            'max_people'     => 10,
            'status'         => 'available',
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('packages.store'), $payload);

        $response->assertStatus(201);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('package.name', 'Pacote de Teste');

        $this->assertDatabaseHas('packages', [
            'name'           => 'Pacote de Teste',
            'trip_id'        => $this->trip->id,
            'price'          => 500.00,
            'includes_hotel' => 1,
            'includes_meals' => 0,
            'includes_guide' => 1,
            'max_people'     => 10,
            'status'         => 'available',
            'created_by'     => $this->admin->id,
        ]);
    }

    public function test_admin_cannot_store_package_with_invalid_data(): void
    {
        $payload = [
            'name'       => '',
            'price'      => 'invalid',
            'max_people' => 0,
            'status'     => 'invalid-status',
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('packages.store'), $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'price', 'max_people', 'status']);
    }

    public function test_admin_can_show_package(): void
    {
        $package = Package::create([
            'name'           => 'Pacote para Mostrar',
            'price'          => 300.00,
            'max_people'     => 5,
            'status'         => 'available',
            'created_by'     => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->getJson(route('packages.show', $package));

        $response->assertStatus(200);
        $response->assertJsonPath('package.name', 'Pacote para Mostrar');
    }

    public function test_admin_can_update_package_via_ajax(): void
    {
        $package = Package::create([
            'name'           => 'Pacote Original',
            'price'          => 300.00,
            'max_people'     => 5,
            'status'         => 'available',
            'created_by'     => $this->admin->id,
        ]);

        $payload = [
            'name'           => 'Pacote Atualizado',
            'price'          => '450.00',
            'max_people'     => 8,
            'status'         => 'sold_out',
            'includes_hotel' => true,
        ];

        $response = $this->actingAs($this->admin)
            ->putJson(route('packages.update', $package), $payload);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('package.name', 'Pacote Atualizado');
        $response->assertJsonPath('package.status', 'sold_out');
        $response->assertJsonPath('package.includes_hotel', true);
    }

    public function test_admin_can_delete_package(): void
    {
        $package = Package::create([
            'name'           => 'Pacote para Deletar',
            'price'          => 200.00,
            'max_people'     => 4,
            'status'         => 'available',
            'created_by'     => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->deleteJson(route('packages.destroy', $package));

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);

        $this->assertSoftDeleted('packages', [
            'id' => $package->id,
        ]);
    }

    public function test_packages_search_returns_matching_results(): void
    {
        Package::create([
            'name'           => 'Pacote Especial de Inverno',
            'price'          => 900.00,
            'max_people'     => 15,
            'status'         => 'available',
            'created_by'     => $this->admin->id,
        ]);

        Package::create([
            'name'           => 'Pacote Padrão de Verão',
            'price'          => 600.00,
            'max_people'     => 20,
            'status'         => 'available',
            'created_by'     => $this->admin->id,
        ]);

        // Search for 'Especial'
        $response = $this->actingAs($this->admin)
            ->getJson(route('packages.index') . '?search=Especial');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'packages');
        $response->assertJsonPath('packages.0.name', 'Pacote Especial de Inverno');
    }
}
