<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ClientTest extends TestCase
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

    public function test_guests_cannot_access_clients(): void
    {
        $this->get(route('customers.index'))->assertRedirect(route('login'));
    }

    public function test_authenticated_admin_can_access_clients_index(): void
    {
        $this->actingAs($this->admin)
            ->get(route('customers.index'))
            ->assertStatus(200);
    }

    public function test_can_create_client(): void
    {
        Storage::fake('public');

        $photo = UploadedFile::fake()->image('client.jpg');

        $clientData = [
            'name'          => 'Jane Smith',
            'birth_date'    => '1990-08-20',
            'cpf'           => '987.654.321-99',
            'zip_code'      => '96010-123',
            'street'        => 'Rua de Teste',
            'number'        => '456',
            'city'          => 'Pelotas',
            'state'         => 'RS',
            'email'         => 'jane.smith@coinpel.com',
            'phone'         => '(53) 98888-7777',
            'profile_photo' => $photo,
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('customers.store'), $clientData);

        $response->assertStatus(201)
            ->assertJsonStructure(['message', 'client']);

        $this->assertDatabaseHas('clients', [
            'name'  => 'Jane Smith',
            'email' => 'jane.smith@coinpel.com',
        ]);

        $client = Client::where('email', 'jane.smith@coinpel.com')->first();
        $this->assertNotNull($client->profile_photo_path);
        Storage::disk('public')->assertExists($client->profile_photo_path);
    }

    public function test_create_client_validation(): void
    {
        $response = $this->actingAs($this->admin)
            ->postJson(route('customers.store'), []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'name', 'birth_date', 'cpf', 'zip_code', 'street',
                'number', 'city', 'state', 'email', 'phone'
            ]);
    }

    public function test_can_update_client(): void
    {
        $client = Client::factory()->create([
            'name'  => 'Old Name',
            'email' => 'old.client@coinpel.com',
        ]);

        $updateData = [
            'name'          => 'New Name',
            'birth_date'    => $client->birth_date->format('Y-m-d'),
            'cpf'           => $client->cpf,
            'zip_code'      => $client->zip_code,
            'street'        => $client->street,
            'number'        => $client->number,
            'city'          => $client->city,
            'state'         => $client->state,
            'email'         => 'new.client@coinpel.com',
            'phone'         => $client->phone,
        ];

        $response = $this->actingAs($this->admin)
            ->patchJson(route('customers.update', $client), $updateData);

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Cliente atualizado com sucesso.']);

        $this->assertDatabaseHas('clients', [
            'id'    => $client->id,
            'name'  => 'New Name',
            'email' => 'new.client@coinpel.com',
        ]);
    }

    public function test_can_delete_client(): void
    {
        $client = Client::factory()->create();

        $response = $this->actingAs($this->admin)
            ->deleteJson(route('customers.destroy', $client));

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Cliente excluído com sucesso.']);

        $this->assertSoftDeleted('clients', [
            'id' => $client->id,
        ]);
    }
}
