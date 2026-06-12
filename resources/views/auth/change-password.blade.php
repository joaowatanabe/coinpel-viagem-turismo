@extends('layouts.auth')

@section('content')
<!-- Modal Centralizado que cobre a tela inteira e borra o layout de login de fundo -->
<div class="absolute inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-md">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden transform transition-all duration-300">
        <!-- Barra de Destaque Superior -->
        <div class="h-2 bg-coinpel-primary"></div>
        
        <div class="p-8">
            <!-- Ícone e Título -->
            <div class="flex items-center gap-3">
                <span class="flex items-center justify-center w-10 h-10 text-coinpel-primary bg-coinpel-primary/10 rounded-xl">
                    <!-- Ícone de Chave/Segurança -->
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.02 5.912L9 17.25H7.5v-1.5M9 15.75H7.5v-1.5M7.5 14.25H6v-1.5H4.5v-1.5a4.833 4.833 0 0 1 1.14-3.14l4.58-4.58a5 5 0 0 1 7.15 7.15l-1.12 1.12Z"></path>
                    </svg>
                </span>
                <h2 class="text-xl font-bold text-gray-900 font-sans tracking-tight">Crie uma nova senha:</h2>
            </div>

            <p class="mt-4 text-sm text-gray-600 leading-relaxed">
                No seu primeiro acesso é necessário trocar a senha provisória. É obrigatório que a senha tenha no mínimo 8 caracteres.
            </p>

            <!-- Formulário -->
            <form action="{{ url('/change-password') }}" method="POST" class="mt-6 space-y-5">
                @csrf

                <!-- Exibição de Erros -->
                @if ($errors->any())
                    <div class="p-3.5 rounded-xl bg-red-50 border border-red-200">
                        <div class="flex">
                            <div class="shrink-0">
                                <svg class="w-5 h-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-2.5">
                                <span class="text-xs font-semibold text-red-800">
                                    {{ $errors->first() }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Nova Senha -->
                <div>
                    <label for="new_password" class="block text-xs font-bold uppercase tracking-wider text-gray-500">Nova Senha</label>
                    <div class="mt-1.5">
                        <input id="new_password" name="new_password" type="password" required minlength="8"
                            class="block w-full px-4 py-2.5 text-gray-900 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition duration-150 ease-in-out text-sm"
                            placeholder="Mínimo 8 caracteres">
                    </div>
                </div>

                <!-- Confirmar Senha -->
                <div>
                    <label for="new_password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-gray-500">Repetir Senha</label>
                    <div class="mt-1.5">
                        <input id="new_password_confirmation" name="new_password_confirmation" type="password" required minlength="8"
                            class="block w-full px-4 py-2.5 text-gray-900 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition duration-150 ease-in-out text-sm"
                            placeholder="Repita a nova senha">
                    </div>
                </div>

                <!-- Ações -->
                <div class="flex flex-col gap-3 pt-3">
                    <button type="submit"
                        class="flex justify-center w-full px-4 py-3 text-sm font-semibold text-white transition duration-150 ease-in-out border border-transparent rounded-xl bg-coinpel-primary hover:bg-coinpel-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-coinpel-primary shadow-lg shadow-coinpel-primary/25 cursor-pointer">
                        Confirmar
                    </button>
                    
                    <!-- Botão Sair / Voltar ao login -->
                    <button type="button" onclick="document.getElementById('logout-form').submit();"
                        class="flex justify-center w-full px-4 py-2.5 text-xs font-semibold text-gray-500 hover:text-gray-700 transition duration-150 ease-in-out border border-gray-200 rounded-xl bg-white hover:bg-gray-50 cursor-pointer">
                        Cancelar e Sair
                    </button>
                </div>
            </form>
            
            <!-- Form de logout invisível -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection
