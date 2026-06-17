<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationFlowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Garantir que um usuário não autenticado seja redirecionado
     * para a tela de login ao tentar acessar a rota /dashboard.
     */
    public function test_unauthenticated_user_is_redirected_to_login_from_dashboard(): void
    {
        $response = $this->get(route('dashboard'));
        
        $response->assertRedirect(route('login'));
    }

    /**
     * Garantir que um usuário não autenticado seja redirecionado
     * para a tela de login ao tentar acessar a rota de clientes.
     */
    public function test_unauthenticated_user_is_redirected_to_login_from_clients(): void
    {
        $response = $this->get(route('customers.index'));
        
        $response->assertRedirect(route('login'));
    }
}
