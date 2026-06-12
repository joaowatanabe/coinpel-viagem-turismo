@extends('layouts.auth')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-bold text-gray-800 tracking-tight font-sans">
            Crie uma nova senha:
        </h2>
        <button type="button" onclick="document.getElementById('logout-form').submit();" class="text-gray-400 hover:text-gray-600 focus:outline-none transition cursor-pointer" title="Cancelar e Sair">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <p class="text-xs text-gray-500 leading-relaxed">
        No seu primeiro acesso é necessário trocar a senha provisória. A senha deve ter no mínimo 8 caracteres.
    </p>

    <form action="{{ url('/change-password') }}" method="POST" class="space-y-4">
        @csrf

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

        <div>
            <input id="new_password" name="new_password" type="password" required minlength="8"
                class="block w-full px-4 py-2.5 text-gray-900 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition text-sm bg-white placeholder-gray-400"
                placeholder="Nova Senha (Mínimo 8 caracteres)">
        </div>

        <div>
            <input id="new_password_confirmation" name="new_password_confirmation" type="password" required minlength="8"
                class="block w-full px-4 py-2.5 text-gray-900 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition text-sm bg-white placeholder-gray-400"
                placeholder="Repetir Senha">
        </div>

        <div class="flex flex-col gap-3 pt-2">
            <button type="submit"
                class="flex justify-center w-full px-4 py-2.5 text-sm font-semibold text-white transition duration-150 ease-in-out border border-transparent rounded-xl bg-coinpel-primary hover:bg-coinpel-primary-dark focus:outline-none focus:ring-2 focus:ring-coinpel-primary cursor-pointer">
                Confirmar
            </button>
            
            <button type="button" onclick="document.getElementById('logout-form').submit();"
                class="flex justify-center w-full px-4 py-2 text-xs font-semibold text-gray-500 hover:text-gray-700 transition duration-150 ease-in-out border border-gray-200 rounded-xl bg-white hover:bg-gray-50 cursor-pointer">
                Cancelar e Sair
            </button>
        </div>
    </form>
    
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</div>
@endsection
