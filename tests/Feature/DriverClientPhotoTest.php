<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DriverClientPhotoTest extends TestCase
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

    public function test_guest_cannot_delete_driver_or_client_photo(): void
    {
        $driver = Driver::factory()->create();
        $client = Client::factory()->create();

        $this->deleteJson(route('drivers.photo.destroy', $driver))
            ->assertStatus(401);

        $this->deleteJson(route('clients.photo.destroy', $client))
            ->assertStatus(401);
    }

    public function test_admin_can_delete_driver_profile_photo(): void
    {
        Storage::fake('public');

        $photoPath = UploadedFile::fake()->image('avatar.jpg')->store('drivers', 'public');

        $driver = Driver::factory()->create([
            'profile_photo_path' => $photoPath,
        ]);

        Storage::disk('public')->assertExists($photoPath);

        $response = $this->actingAs($this->admin)
            ->deleteJson(route('drivers.photo.destroy', $driver));

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $driver->refresh();
        $this->assertNull($driver->profile_photo_path);
        Storage::disk('public')->assertMissing($photoPath);
    }

    public function test_admin_can_delete_client_profile_photo(): void
    {
        Storage::fake('public');

        $photoPath = UploadedFile::fake()->image('avatar.jpg')->store('clients', 'public');

        $client = Client::factory()->create([
            'profile_photo_path' => $photoPath,
        ]);

        Storage::disk('public')->assertExists($photoPath);

        $response = $this->actingAs($this->admin)
            ->deleteJson(route('clients.photo.destroy', $client));

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $client->refresh();
        $this->assertNull($client->profile_photo_path);
        Storage::disk('public')->assertMissing($photoPath);
    }
}
