<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>COINPEL — Autenticação</title>
    <!-- Fonts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900">
    <div class="flex min-h-full">
        <!-- Painel Esquerdo: Branco (~50% em lg, centraliza logo e conteúdo) -->
        <div class="flex flex-col justify-center flex-1 px-4 py-12 sm:px-6 lg:flex-none lg:w-1/2 lg:px-20 xl:px-24 bg-white">
            <div class="w-full max-w-sm mx-auto">
                <!-- Logo da COINPEL Centralizada -->
                <div class="flex items-center justify-center gap-3 mb-8">
                    <span class="flex items-center justify-center w-12 h-12 text-white rounded-xl bg-coinpel-primary shadow-lg shadow-coinpel-primary/30">
                        <!-- SVG do Ônibus -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124l-.375-6a3.75 3.75 0 0 0-3.75-3.75H6.375c-.621 0-1.129.504-1.09 1.124l.375 6A3.75 3.75 0 0 0 9.42 15h4.16a3.75 3.75 0 0 0 3.75-3.75h0"></path>
                        </svg>
                    </span>
                    <span class="text-2xl font-bold tracking-wider text-gray-900 font-sans">COINPEL</span>
                </div>

                <!-- Área de Injeção do Formulário -->
                @yield('content')
            </div>
        </div>

        <!-- Painel Direito: Roxo (~50% em lg, oculto em telas menores) -->
        <div class="relative hidden lg:block lg:w-1/2 bg-coinpel-primary overflow-hidden">
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
                <div class="flex items-center gap-2">
                    <span class="text-xl font-bold tracking-widest uppercase opacity-75">COINPEL Turismo</span>
                </div>

                <!-- Destaques Visuais -->
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

                <!-- Rodapé -->
                <div class="text-sm text-white/60">
                    &copy; 2026 COINPEL. Todos os direitos reservados.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
