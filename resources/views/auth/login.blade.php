@extends('layouts.auth')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-bold tracking-tight text-gray-900 font-sans">
            Faça login:
        </h2>
    </div>

    <form action="{{ url('/login') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700">E-mail</label>
            <div class="mt-1.5">
                <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                    class="block w-full px-4 py-2.5 text-gray-900 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition duration-150 ease-in-out text-sm"
                    placeholder="E-mail">
            </div>
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700">Senha</label>
            <div class="mt-1.5">
                <input id="password" name="password" type="password" autocomplete="current-password" required
                    class="block w-full px-4 py-2.5 text-gray-900 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition duration-150 ease-in-out text-sm"
                    placeholder="Senha">
            </div>
        </div>

        <div class="flex items-center">
            <input id="remember" name="remember" type="checkbox"
                class="w-4 h-4 text-coinpel-primary border-gray-300 rounded focus:ring-coinpel-primary cursor-pointer">
            <label for="remember" class="block ml-2 text-sm text-gray-600 cursor-pointer">Lembrar-me</label>
        </div>

        <div>
            <button type="submit"
                class="flex justify-center w-full px-4 py-2.5 text-sm font-semibold text-white transition duration-150 ease-in-out border border-transparent rounded-xl bg-coinpel-primary hover:bg-coinpel-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-coinpel-primary shadow-lg shadow-coinpel-primary/25 cursor-pointer">
                Entrar
            </button>
        </div>
        
        @if ($errors->any())
            <div class="p-3.5 rounded-xl bg-red-50 border border-red-200">
                <div class="flex">
                    <div class="shrink-0">
                        <svg class="w-5 h-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-2.5">
                        <h3 class="text-xs font-semibold text-red-800">
                            {{ $errors->first() }}
                        </h3>
                    </div>
                </div>
            </div>
        @endif
    </form>
</div>
@endsection
