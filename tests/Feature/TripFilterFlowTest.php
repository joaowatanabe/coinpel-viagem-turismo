<?php

namespace Tests\Feature;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TripFilterFlowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Simular uma requisição GET para a rota de viagens enviando parâmetros de filtro
     * na query string e garantir que a resposta retorna o dado esperado na view.
     */
    public function test_user_can_filter_trips_by_status(): void
    {
        $admin = User::factory()->create([
            'must_change_password' => false,
            'is_blocked' => false,
        ]);

        // Insere viagens simuladas no banco de dados para o teste
        $tripCompleted = Trip::factory()->create([
            'status' => 'completed',
            'name'   => 'Viagem Concluída Teste',
        ]);

        $tripCancelled = Trip::factory()->create([
            'status' => 'cancelled',
            'name'   => 'Viagem Cancelada Teste',
        ]);

        // Simula o acesso à página de Viagens aplicando o filtro de status via Query String
        $response = $this->actingAs($admin)
                         ->get(route('trips.index', ['status' => 'cancelled']));

        // Verifica se a página carregou corretamente (HTTP 200 OK)
        $response->assertStatus(200);

        // Garante que a viagem com status "cancelada" apareceu na listagem da tabela HTML
        $response->assertSee('Viagem Cancelada Teste');

        // Garante que a viagem com status "concluída" não apareceu na listagem (filtro funcionou)
        $response->assertDontSee('Viagem Concluída Teste');
    }
}
