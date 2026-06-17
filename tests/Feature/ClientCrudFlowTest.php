<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientCrudFlowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Simular um POST para a rota de criação de clientes com os dados válidos,
     * e verificar se o banco de dados salvou a informação corretamente.
     */
    public function test_admin_can_create_client_via_drawer_with_address(): void
    {
        // Cria um usuário administrador para passar pelo bloqueio
        $admin = User::factory()->create([
            'must_change_password' => false,
            'is_blocked' => false,
        ]);

        // Dados simulados preenchidos no Formulário (Drawer)
        $clientData = [
            'name'       => 'João da Silva',
            'cpf'        => '123.456.789-00',
            'birth_date' => '1985-10-15',
            'email'      => 'joao.silva@exemplo.com',
            'phone'      => '(53) 99999-9999',
            
            // Dados de Endereço (via CEP)
            'zip_code'   => '96000-000',
            'city'       => 'Pelotas',
            'street'     => 'Rua XV de Novembro',
            'number'     => '100',
            'state'      => 'RS',
        ];

        // Simula a requisição POST feita pelo botão "Finalizar cadastro"
        $response = $this->actingAs($admin)
                         ->postJson(route('customers.store'), $clientData);

        // Verifica se a API retornou o código de sucesso (201 Created)
        $response->assertStatus(201);

        // Verifica se os dados realmente foram persistidos no banco de dados
        $this->assertDatabaseHas('clients', [
            'name'     => 'João da Silva',
            'cpf'      => '12345678900',
            'email'    => 'joao.silva@exemplo.com',
            'zip_code' => '96000000',
        ]);
    }
}
