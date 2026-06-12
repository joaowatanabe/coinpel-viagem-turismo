@extends('layouts.auth')

@section('content')
<!-- Painel Esquerdo: Formulário -->
<div class="flex flex-col justify-center flex-1 px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-white">
    <div class="w-full max-w-sm mx-auto lg:w-96">
        <div>
            <!-- Logo da COINPEL -->
            <div class="flex items-center gap-3">
                <span class="flex items-center justify-center w-12 h-12 text-white rounded-xl bg-coinpel-primary shadow-lg shadow-coinpel-primary/30">
                    <!-- SVG do Ônibus / Logo -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124l-.375-6a3.75 3.75 0 0 0-3.75-3.75H6.375c-.621 0-1.129.504-1.09 1.124l.375 6A3.75 3.75 0 0 0 9.42 15h4.16a3.75 3.75 0 0 0 3.75-3.75h0"></path>
                    </svg>
                </span>
                <span class="text-2xl font-bold tracking-wider text-gray-900 font-sans">COINPEL</span>
            </div>
            <h2 class="mt-8 text-3xl font-extrabold tracking-tight text-gray-900">
                Iniciar Sessão
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Painel administrativo de controle de viagens de turismo.
            </p>
        </div>

        <div class="mt-10">
            <form action="{{ url('/login') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Exibição de Erros Globais -->
                @if ($errors->any())
                    <div class="p-4 rounded-xl bg-red-50 border border-red-200">
                        <div class="flex">
                            <div class="shrink-0">
                                <svg class="w-5 h-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    {{ $errors->first() }}
                                </h3>
                            </div>
                        </div>
                    </div>
                @endif

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700">E-mail</label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                            class="block w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition duration-150 ease-in-out sm:text-sm"
                            placeholder="exemplo@coinpel.com">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700">Senha</label>
                    <div class="mt-2">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="block w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition duration-150 ease-in-out sm:text-sm"
                            placeholder="Sua senha">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                            class="w-4 h-4 text-coinpel-primary border-gray-300 rounded focus:ring-coinpel-primary">
                        <label for="remember" class="block ml-2 text-sm text-gray-600">Lembrar-me</label>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="flex justify-center w-full px-4 py-3 text-sm font-semibold text-white transition duration-150 ease-in-out border border-transparent rounded-xl bg-coinpel-primary hover:bg-coinpel-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-coinpel-primary shadow-lg shadow-coinpel-primary/25 cursor-pointer">
                        Entrar no sistema
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Painel Direito: Ilustrativo / Branding -->
<div class="relative flex-1 hidden w-0 lg:block bg-coinpel-primary overflow-hidden">
    <!-- Efeito de Gradients de Fundo -->
    <div class="absolute inset-0 bg-radial-[circle_at_top_right,_var(--tw-gradient-stops)] from-[#7c3aed] via-coinpel-primary to-coinpel-primary-dark opacity-90"></div>
    
    <!-- Linhas e Formas Abstratas de Conectividade de Rotas -->
    <svg class="absolute inset-0 w-full h-full opacity-20" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5" />
            </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#grid)" />
        <path d="M-100 300 C 200 150, 400 600, 800 200 S 1200 400, 1600 100" fill="none" stroke="white" stroke-width="2" stroke-dasharray="10 5" />
        <path d="M-100 500 C 300 350, 600 700, 1000 400 S 1300 200, 1700 600" fill="none" stroke="white" stroke-width="1.5" stroke-dasharray="5 5" />
    </svg>

    <div class="relative flex flex-col justify-between h-full p-16 text-white z-10">
        <!-- Logo Text -->
        <div class="flex items-center gap-2">
            <span class="text-xl font-bold tracking-widest uppercase opacity-75">COINPEL Turismo</span>
        </div>

        <!-- Conteúdo de Destaque -->
        <div class="max-w-md space-y-6">
            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold tracking-wide text-white uppercase rounded-full bg-white/10 backdrop-blur-md border border-white/20">
                Sistema de Viagens
            </span>
            <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl leading-tight">
                Conectando rotas, simplificando destinos.
            </h1>
            <p class="text-lg text-white/80 leading-relaxed">
                Gerenciamento ágil de frotas, motoristas cadastrados e escalas de viagens em tempo real em uma única plataforma integrada.
            </p>
        </div>

        <!-- Footer Text -->
        <div class="text-sm text-white/60">
            &copy; 2026 COINPEL. Todos os direitos reservados.
        </div>
    </div>
</div>
@endsection
