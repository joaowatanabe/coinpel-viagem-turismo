<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsTest extends TestCase
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

        $this->seed(\Database\Seeders\SettingsSeeder::class);
    }

    public function test_guests_cannot_access_settings_index(): void
    {
        $this->get(route('settings.index'))->assertRedirect(route('login'));
    }

    public function test_authenticated_admin_can_access_settings_index_with_seeded_values(): void
    {
        $response = $this->actingAs($this->admin)->get(route('settings.index'));

        $response->assertStatus(200);
        $response->assertSee('COINPEL');
        $response->assertSee('00.000.000/0001-00');
        $response->assertSee('contato@coinpel.com');
        $response->assertSee('(53) 3000-0000');
        $response->assertSee('Pelotas, RS');
    }

    public function test_admin_can_update_company_info(): void
    {
        $payload = [
            'company_name'    => 'COINPEL Viagens LTDA',
            'company_cnpj'    => '11.222.333/0001-44',
            'company_email'   => 'novocontato@coinpel.com',
            'company_phone'   => '(53) 3222-9999',
            'company_address' => 'Avenida Principal, 999',
        ];

        $response = $this->actingAs($this->admin)
            ->patchJson(route('settings.update'), $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Configurações salvas!',
        ]);

        $this->assertEquals('COINPEL Viagens LTDA', Setting::get('company_name'));
        $this->assertEquals('11.222.333/0001-44', Setting::get('company_cnpj'));
        $this->assertEquals('novocontato@coinpel.com', Setting::get('company_email'));
        $this->assertEquals('(53) 3222-9999', Setting::get('company_phone'));
        $this->assertEquals('Avenida Principal, 999', Setting::get('company_address'));
    }

    public function test_admin_can_update_preference_switches(): void
    {
        // Initial values:
        // allow_booking = 'true'
        // notify_on_new_trip = 'false'
        $this->assertEquals('true', Setting::get('allow_booking'));
        $this->assertEquals('false', Setting::get('notify_on_new_trip'));

        // Toggle allow_booking to false
        $response = $this->actingAs($this->admin)
            ->patchJson(route('settings.update'), [
                'allow_booking' => false,
            ]);

        $response->assertStatus(200);
        $this->assertEquals('false', Setting::get('allow_booking'));

        // Toggle notify_on_new_trip to true
        $response = $this->actingAs($this->admin)
            ->patchJson(route('settings.update'), [
                'notify_on_new_trip' => true,
            ]);

        $response->assertStatus(200);
        $this->assertEquals('true', Setting::get('notify_on_new_trip'));
    }
}
