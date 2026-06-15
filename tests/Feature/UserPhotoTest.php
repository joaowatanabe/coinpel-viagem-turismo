<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserPhotoTest extends TestCase
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

    public function test_guest_cannot_manage_user_photos(): void
    {
        $user = User::factory()->create(['is_blocked' => false]);

        $this->deleteJson(route('users.photo.destroy', $user))
            ->assertStatus(401);
    }

    public function test_admin_can_create_user_with_profile_photo(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->actingAs($this->admin)
            ->postJson(route('users.store'), [
                'name'          => 'New User',
                'email'         => 'newuser@coinpel.com',
                'password'      => 'secret123',
                'is_blocked'    => false,
                'profile_photo' => $file,
            ]);

        $response->assertStatus(201);

        $user = User::where('email', 'newuser@coinpel.com')->first();
        $this->assertNotNull($user->profile_photo_path);

        Storage::disk('public')->assertExists($user->profile_photo_path);
    }

    public function test_admin_can_update_user_profile_photo(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'profile_photo_path' => null,
            'is_blocked' => false,
        ]);

        $newFile = UploadedFile::fake()->image('new_avatar.png');

        // Note: Laravel patch/put file uploads in JSON/multipart require POST with spoofing or FormData.
        // In Laravel controller we support multipart update using method spoofing.
        $response = $this->actingAs($this->admin)
            ->postJson(route('users.update', $user), [
                '_method'       => 'PATCH',
                'name'          => $user->name,
                'email'         => $user->email,
                'is_blocked'    => $user->is_blocked,
                'profile_photo' => $newFile,
            ]);

        $response->assertStatus(200);

        $user->refresh();
        $this->assertNotNull($user->profile_photo_path);
        Storage::disk('public')->assertExists($user->profile_photo_path);
    }

    public function test_admin_can_update_user_profile_photo_replaces_old_one(): void
    {
        Storage::fake('public');

        $oldPhotoPath = UploadedFile::fake()->image('old.jpg')->store('users', 'public');

        $user = User::factory()->create([
            'profile_photo_path' => $oldPhotoPath,
            'is_blocked' => false,
        ]);

        Storage::disk('public')->assertExists($oldPhotoPath);

        $newFile = UploadedFile::fake()->image('new.png');

        $response = $this->actingAs($this->admin)
            ->postJson(route('users.update', $user), [
                '_method'       => 'PATCH',
                'name'          => $user->name,
                'email'         => $user->email,
                'is_blocked'    => $user->is_blocked,
                'profile_photo' => $newFile,
            ]);

        $response->assertStatus(200);

        Storage::disk('public')->assertMissing($oldPhotoPath);

        $user->refresh();
        Storage::disk('public')->assertExists($user->profile_photo_path);
    }

    public function test_admin_can_delete_user_profile_photo(): void
    {
        Storage::fake('public');

        $photoPath = UploadedFile::fake()->image('avatar.jpg')->store('users', 'public');

        $user = User::factory()->create([
            'profile_photo_path' => $photoPath,
            'is_blocked' => false,
        ]);

        Storage::disk('public')->assertExists($photoPath);

        $response = $this->actingAs($this->admin)
            ->deleteJson(route('users.photo.destroy', $user));

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $user->refresh();
        $this->assertNull($user->profile_photo_path);
        Storage::disk('public')->assertMissing($photoPath);
    }

    public function test_profile_photo_validation_rejects_invalid_type(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('doc.pdf', 500, 'application/pdf');

        $response = $this->actingAs($this->admin)
            ->postJson(route('users.store'), [
                'name'          => 'New User',
                'email'         => 'newuser@coinpel.com',
                'password'      => 'secret123',
                'is_blocked'    => false,
                'profile_photo' => $file,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['profile_photo']);
    }

    public function test_profile_photo_validation_rejects_large_file(): void
    {
        Storage::fake('public');

        // Max is 2048 KB, let's create a file of 3000 KB
        $file = UploadedFile::fake()->image('huge.jpg')->size(3000);

        $response = $this->actingAs($this->admin)
            ->postJson(route('users.store'), [
                'name'          => 'New User',
                'email'         => 'newuser@coinpel.com',
                'password'      => 'secret123',
                'is_blocked'    => false,
                'profile_photo' => $file,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['profile_photo']);
    }
}
