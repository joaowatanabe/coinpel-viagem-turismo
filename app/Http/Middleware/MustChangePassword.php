<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MustChangePassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Se o usuário está autenticado e precisa alterar a senha
        if (Auth::check() && Auth::user()->must_change_password) {
            // Se a rota atual não for de alteração de senha ou logout, redireciona
            if (!$request->routeIs('change-password.show', 'change-password.update', 'logout')) {
                return redirect()->route('change-password.show');
            }
        }

        return $next($request);
    }
}
