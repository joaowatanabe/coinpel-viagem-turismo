<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlaceholderPagesTest extends TestCase
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


    public function test_guests_cannot_access_packages_page(): void
    {
        $this->get(route('packages.index'))->assertRedirect(route('login'));
    }

    public function test_authenticated_admin_can_access_packages_page(): void
    {
        $response = $this->actingAs($this->admin)->get(route('packages.index'));
        $response->assertStatus(200);
        $response->assertSee('Módulo Pacotes');
        $response->assertSee('Este módulo está em desenvolvimento.');
    }

    public function test_guests_cannot_access_settings_page(): void
    {
        $this->get(route('settings.index'))->assertRedirect(route('login'));
    }

    public function test_authenticated_admin_can_access_settings_page(): void
    {
        $response = $this->actingAs($this->admin)->get(route('settings.index'));
        $response->assertStatus(200);
        $response->assertSee('Informações da Empresa');
        $response->assertSee('COINPEL Viagens e Turismo Ltda.');
        $response->assertSee('Preferências do Sistema');
        $response->assertSee('Notificações por e-mail');
    }
}
