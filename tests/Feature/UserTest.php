<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
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

    public function test_guests_cannot_access_users(): void
    {
        $this->get(route('users.index'))->assertRedirect(route('login'));
    }

    public function test_authenticated_admin_can_access_users_index(): void
    {
        $this->actingAs($this->admin)
            ->get(route('users.index'))
            ->assertStatus(200);
    }

    public function test_can_create_user(): void
    {
        $userData = [
            'name'       => 'New Admin',
            'email'      => 'new.admin@coinpel.com',
            'password'   => 'Secret@123',
            'is_blocked' => 0,
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('users.store'), $userData);

        $response->assertStatus(201)
            ->assertJsonStructure(['message', 'user']);

        $this->assertDatabaseHas('users', [
            'name'                 => 'New Admin',
            'email'                => 'new.admin@coinpel.com',
            'must_change_password' => true,
            'is_blocked'           => false,
        ]);
    }

    public function test_create_user_validation(): void
    {
        $response = $this->actingAs($this->admin)
            ->postJson(route('users.store'), []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password', 'is_blocked']);
    }

    public function test_can_update_user(): void
    {
        $targetUser = User::factory()->create([
            'name'       => 'Old User Name',
            'email'      => 'old.user@coinpel.com',
            'is_blocked' => false,
        ]);

        $updateData = [
            'name'       => 'Updated User Name',
            'email'      => 'updated.user@coinpel.com',
            'is_blocked' => 1,
        ];

        $response = $this->actingAs($this->admin)
            ->patchJson(route('users.update', $targetUser), $updateData);

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Usuário atualizado com sucesso.']);

        $this->assertDatabaseHas('users', [
            'id'         => $targetUser->id,
            'name'       => 'Updated User Name',
            'email'      => 'updated.user@coinpel.com',
            'is_blocked' => true,
        ]);
    }

    public function test_cannot_block_self(): void
    {
        $updateData = [
            'name'       => $this->admin->name,
            'email'      => $this->admin->email,
            'is_blocked' => 1,
        ];

        $response = $this->actingAs($this->admin)
            ->patchJson(route('users.update', $this->admin), $updateData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['is_blocked']);
    }

    public function test_can_delete_user(): void
    {
        $targetUser = User::factory()->create();

        $response = $this->actingAs($this->admin)
            ->deleteJson(route('users.destroy', $targetUser));

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Usuário excluído com sucesso.']);

        $this->assertSoftDeleted('users', [
            'id' => $targetUser->id,
        ]);
    }

    public function test_cannot_delete_self(): void
    {
        $response = $this->actingAs($this->admin)
            ->deleteJson(route('users.destroy', $this->admin));

        $response->assertStatus(422)
            ->assertJsonFragment(['message' => 'Você não pode excluir o seu próprio usuário.']);
    }
}
