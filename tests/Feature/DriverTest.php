<?php

namespace Tests\Feature;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DriverTest extends TestCase
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

    public function test_guests_cannot_access_drivers(): void
    {
        $this->get(route('drivers.index'))->assertRedirect(route('login'));
    }

    public function test_authenticated_admin_can_access_drivers_index(): void
    {
        $this->actingAs($this->admin)
            ->get(route('drivers.index'))
            ->assertStatus(200);
    }

    public function test_can_create_driver(): void
    {
        Storage::fake('public');

        $photo = UploadedFile::fake()->image('driver.jpg');

        $driverData = [
            'name'          => 'John Doe',
            'birth_date'    => '1985-05-15',
            'registration'  => '987654321',
            'cpf'           => '123.456.789-10',
            'rg'            => '123456789',
            'zip_code'      => '96010-000',
            'street'        => 'Rua das Flores',
            'number'        => '123',
            'city'          => 'Pelotas',
            'state'         => 'RS',
            'email'         => 'john.doe@coinpel.com',
            'phone'         => '(53) 99999-8888',
            'profile_photo' => $photo,
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('drivers.store'), $driverData);

        $response->assertStatus(201)
            ->assertJsonStructure(['message', 'driver']);

        $this->assertDatabaseHas('drivers', [
            'name'         => 'John Doe',
            'registration' => '987654321',
            'email'        => 'john.doe@coinpel.com',
        ]);

        $driver = Driver::where('email', 'john.doe@coinpel.com')->first();
        $this->assertNotNull($driver->profile_photo_path);
        Storage::disk('public')->assertExists($driver->profile_photo_path);
    }

    public function test_create_driver_validation(): void
    {
        $response = $this->actingAs($this->admin)
            ->postJson(route('drivers.store'), []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'name', 'birth_date', 'registration', 'cpf', 'rg',
                'zip_code', 'street', 'number', 'city', 'state', 'email', 'phone'
            ]);
    }

    public function test_can_update_driver(): void
    {
        $driver = Driver::factory()->create([
            'name'  => 'Old Name',
            'email' => 'old@coinpel.com',
        ]);

        $updateData = [
            'name'          => 'New Name',
            'birth_date'    => $driver->birth_date->format('Y-m-d'),
            'registration'  => $driver->registration,
            'cpf'           => $driver->cpf,
            'rg'            => $driver->rg,
            'zip_code'      => $driver->zip_code,
            'street'        => $driver->street,
            'number'        => $driver->number,
            'city'          => $driver->city,
            'state'         => $driver->state,
            'email'         => 'new@coinpel.com',
            'phone'         => $driver->phone,
        ];

        $response = $this->actingAs($this->admin)
            ->patchJson(route('drivers.update', $driver), $updateData);

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Motorista atualizado com sucesso.']);

        $this->assertDatabaseHas('drivers', [
            'id'    => $driver->id,
            'name'  => 'New Name',
            'email' => 'new@coinpel.com',
        ]);
    }

    public function test_can_delete_driver(): void
    {
        $driver = Driver::factory()->create();

        $response = $this->actingAs($this->admin)
            ->deleteJson(route('drivers.destroy', $driver));

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Motorista excluído com sucesso.']);

        $this->assertSoftDeleted('drivers', [
            'id' => $driver->id,
        ]);
    }
}
