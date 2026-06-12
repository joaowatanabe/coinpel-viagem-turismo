<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ChangePasswordController extends Controller
{
    /**
     * Exibir o formulário de alteração de senha.
     */
    public function showChangePassword(): View
    {
        return view('auth.change-password');
    }

    /**
     * Alterar a senha do usuário.
     */
    public function changePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.required' => 'A senha é obrigatória.',
            'password.string' => 'A senha deve ser um texto.',
            'password.min' => 'A senha deve ter pelo menos :min caracteres.',
            'password.confirmed' => 'As senhas não coincidem.',
        ]);

        $user = Auth::user();
        
        // Atualizar senha e definir flag do primeiro acesso
        $user->password = Hash::make($request->password);
        $user->must_change_password = false;
        $user->save();

        return redirect()->route('trips.index')->with('status', 'Senha redefinida com sucesso.');
    }
}
