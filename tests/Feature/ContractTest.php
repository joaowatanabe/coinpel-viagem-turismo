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

class ContractTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Client $client;
    protected Trip $trip;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'must_change_password' => false,
            'is_blocked'           => false,
        ]);

        $this->client = Client::factory()->create();

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

    public function test_guests_cannot_access_contracts_index(): void
    {
        $this->get(route('contracts.index'))->assertRedirect(route('login'));
    }

    public function test_authenticated_admin_can_access_contracts_index(): void
    {
        $response = $this->actingAs($this->admin)->get(route('contracts.index'));
        $response->assertStatus(200);
        $response->assertSee('Contratos');
        $response->assertSee('Adicionar contrato');
    }

    public function test_admin_can_store_contract_via_ajax(): void
    {
        $payload = [
            'number'      => 'CONT-2026-001',
            'client_id'   => $this->client->id,
            'trip_id'     => $this->trip->id,
            'description' => 'Contrato de transporte escolar',
            'start_date'  => '2026-06-15',
            'end_date'    => '2026-06-30',
            'value'       => '2500.00',
            'status'      => 'active',
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('contracts.store'), $payload);

        $response->assertStatus(201);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('contract.number', 'CONT-2026-001');

        $this->assertDatabaseHas('contracts', [
            'number' => 'CONT-2026-001',
            'client_id' => $this->client->id,
            'trip_id' => $this->trip->id,
            'created_by' => $this->admin->id,
        ]);
    }

    public function test_admin_cannot_store_duplicate_contract_number(): void
    {
        Contract::create([
            'number'     => 'CONT-2026-999',
            'client_id'  => $this->client->id,
            'trip_id'    => $this->trip->id,
            'start_date' => '2026-06-15',
            'end_date'   => '2026-06-30',
            'value'      => 1000.00,
            'status'     => 'active',
            'created_by' => $this->admin->id,
        ]);

        $payload = [
            'number'      => 'CONT-2026-999',
            'client_id'   => $this->client->id,
            'trip_id'     => $this->trip->id,
            'start_date'  => '2026-06-15',
            'end_date'    => '2026-06-30',
            'value'       => '1500.00',
            'status'      => 'active',
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('contracts.store'), $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['number']);
    }

    public function test_admin_can_show_contract(): void
    {
        $contract = Contract::create([
            'number'     => 'CONT-2026-002',
            'client_id'  => $this->client->id,
            'trip_id'    => $this->trip->id,
            'start_date' => '2026-06-15',
            'end_date'   => '2026-06-30',
            'value'      => 1000.00,
            'status'     => 'active',
            'created_by' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->getJson(route('contracts.show', $contract));

        $response->assertStatus(200);
        $response->assertJsonPath('contract.number', 'CONT-2026-002');
    }

    public function test_admin_can_update_contract_via_ajax(): void
    {
        $contract = Contract::create([
            'number'     => 'CONT-2026-003',
            'client_id'  => $this->client->id,
            'trip_id'    => $this->trip->id,
            'start_date' => '2026-06-15',
            'end_date'   => '2026-06-30',
            'value'      => 1000.00,
            'status'     => 'active',
            'created_by' => $this->admin->id,
        ]);

        $payload = [
            'number'     => 'CONT-2026-003-EDIT',
            'client_id'  => $this->client->id,
            'trip_id'    => $this->trip->id,
            'start_date' => '2026-06-15',
            'end_date'   => '2026-06-30',
            'value'      => '1200.00',
            'status'     => 'cancelled',
        ];

        $response = $this->actingAs($this->admin)
            ->putJson(route('contracts.update', $contract), $payload);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('contract.number', 'CONT-2026-003-EDIT');
        $response->assertJsonPath('contract.status', 'cancelled');
    }

    public function test_admin_can_delete_contract(): void
    {
        $contract = Contract::create([
            'number'     => 'CONT-2026-004',
            'client_id'  => $this->client->id,
            'trip_id'    => $this->trip->id,
            'start_date' => '2026-06-15',
            'end_date'   => '2026-06-30',
            'value'      => 1000.00,
            'status'     => 'active',
            'created_by' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->deleteJson(route('contracts.destroy', $contract));

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);

        $this->assertSoftDeleted('contracts', [
            'id' => $contract->id,
        ]);
    }

    public function test_contracts_search_returns_matching_results(): void
    {
        Contract::create([
            'number'     => 'CONT-SPECIAL-001',
            'client_id'  => $this->client->id,
            'trip_id'    => $this->trip->id,
            'start_date' => '2026-06-15',
            'end_date'   => '2026-06-30',
            'value'      => 1000.00,
            'status'     => 'active',
            'created_by' => $this->admin->id,
        ]);

        Contract::create([
            'number'     => 'CONT-NORMAL-002',
            'client_id'  => $this->client->id,
            'trip_id'    => $this->trip->id,
            'start_date' => '2026-06-15',
            'end_date'   => '2026-06-30',
            'value'      => 1000.00,
            'status'     => 'active',
            'created_by' => $this->admin->id,
        ]);

        // Search for 'SPECIAL'
        $response = $this->actingAs($this->admin)
            ->getJson(route('contracts.index') . '?search=SPECIAL');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'contracts');
        $response->assertJsonPath('contracts.0.number', 'CONT-SPECIAL-001');
    }
}
