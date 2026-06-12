<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-coinpel-bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>COINPEL — Painel Administrativo</title>
    <!-- Fonts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900">
    <div class="flex h-full">
        <!-- Sidebar esquerda fixa -->
        <aside class="fixed inset-y-0 left-0 z-20 flex flex-col w-[160px] bg-coinpel-primary text-white shadow-xl">
            <!-- Header do Sidebar / Logo -->
            <div class="flex items-center justify-center h-16 border-b border-white/10">
                <a href="{{ route('trips.index') }}" class="flex items-center gap-2 hover:opacity-95 transition-opacity">
                    <span class="flex items-center justify-center w-8 h-8 text-coinpel-primary bg-white rounded-lg shadow">
                        <!-- SVG do Ônibus Mini -->
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124l-.375-6a3.75 3.75 0 0 0-3.75-3.75H6.375c-.621 0-1.129.504-1.09 1.124l.375 6A3.75 3.75 0 0 0 9.42 15h4.16a3.75 3.75 0 0 0 3.75-3.75h0"></path>
                        </svg>
                    </span>
                    <span class="text-lg font-black tracking-wider uppercase font-sans">COINPEL</span>
                </a>
            </div>

            <!-- Links de Navegação -->
            <nav class="flex-1 px-3 py-6 space-y-2 overflow-y-auto">
                <!-- Viagens -->
                <a href="{{ route('trips.index') }}" 
                   class="flex flex-col items-center justify-center py-4 rounded-xl transition duration-150 ease-in-out gap-1.5 {{ request()->routeIs('trips.*') ? 'bg-white/15 text-white font-semibold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124l-.375-6a3.75 3.75 0 0 0-3.75-3.75H6.375c-.621 0-1.129.504-1.09 1.124l.375 6A3.75 3.75 0 0 0 9.42 15h4.16a3.75 3.75 0 0 0 3.75-3.75h0"></path>
                    </svg>
                    <span class="text-[11px] uppercase tracking-wider">Viagens</span>
                </a>

                <!-- Veículos -->
                <a href="{{ route('vehicles.index') }}" 
                   class="flex flex-col items-center justify-center py-4 rounded-xl transition duration-150 ease-in-out gap-1.5 {{ request()->routeIs('vehicles.*') ? 'bg-white/15 text-white font-semibold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.68-.34-1.34-.68-2-1.34m0 0C6 12.16 6 9.84 8.34 7.5m0 0c2.34-2.34 4.66-2.34 7 0m0 0C17.66 9.84 17.66 12.16 15.34 14.5m-7-2.34h7m-7 0L6 14.5m4.34-6.66l2 2"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0 1.232-.046 2.453-.138 3.662a4.006 4.006 0 0 1-3.7 3.7 48.656 48.656 0 0 1-7.324 0 4.006 4.006 0 0 1-3.7-3.7C4.547 14.453 4.5 13.232 4.5 12c0-1.232.046-2.453.138-3.662a4.006 4.006 0 0 1 3.7-3.7 48.656 48.656 0 0 1 7.324 0 4.006 4.006 0 0 1 3.7 3.7c.092 1.209.138 2.43.138 3.662Z"></path>
                    </svg>
                    <span class="text-[11px] uppercase tracking-wider">Veículos</span>
                </a>

                <!-- Motoristas -->
                <a href="{{ route('drivers.index') }}" 
                   class="flex flex-col items-center justify-center py-4 rounded-xl transition duration-150 ease-in-out gap-1.5 {{ request()->routeIs('drivers.*') ? 'bg-white/15 text-white font-semibold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"></path>
                    </svg>
                    <span class="text-[11px] uppercase tracking-wider">Motoristas</span>
                </a>

                <!-- Usuários -->
                <a href="{{ route('users.index') }}" 
                   class="flex flex-col items-center justify-center py-4 rounded-xl transition duration-150 ease-in-out gap-1.5 {{ request()->routeIs('users.*') ? 'bg-white/15 text-white font-semibold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.97 5.97 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"></path>
                    </svg>
                    <span class="text-[11px] uppercase tracking-wider">Usuários</span>
                </a>
            </nav>

            <!-- Rodapé / Versão -->
            <div class="p-4 border-t border-white/10 text-center text-[10px] text-white/40 font-mono">
                v1.1.0
            </div>
        </aside>

        <!-- Área Principal (com margem esquerda correspondente ao Sidebar fixo) -->
        <div class="flex-1 flex flex-col pl-[160px] min-h-full">
            <!-- Header superior -->
            <header class="flex items-center justify-between h-16 px-8 bg-white border-b border-gray-200">
                <!-- Lado Esquerdo: Rota atual / Título -->
                <div class="flex items-center">
                    <span class="text-sm font-semibold text-gray-500 font-sans tracking-wide uppercase">
                        COINPEL
                    </span>
                    <span class="mx-2 text-gray-300">/</span>
                    <span class="text-sm font-bold text-gray-800 font-sans tracking-tight">
                        @yield('page_title', 'Painel')
                    </span>
                </div>

                <!-- Lado Direito: Notificações, Perfil e Sair -->
                <div class="flex items-center gap-6">
                    <!-- Sino de Notificações -->
                    <button class="text-gray-400 hover:text-gray-600 focus:outline-none transition-colors duration-150 relative">
                        <span class="absolute top-0.5 right-0.5 w-2 h-2 bg-coinpel-accent rounded-full"></span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"></path>
                        </svg>
                    </button>

                    <!-- Divisor -->
                    <div class="w-px h-6 bg-gray-200"></div>

                    <!-- Perfil do Administrador -->
                    <div class="relative flex items-center gap-3" id="user-menu-trigger">
                        <!-- Foto / Iniciais do usuário -->
                        <span class="flex items-center justify-center w-9 h-9 text-xs font-bold text-white rounded-full bg-coinpel-primary shadow shadow-coinpel-primary/25 uppercase">
                            {{ substr(auth()->user()->name, 0, 2) }}
                        </span>
                        
                        <!-- Nome e Cargo -->
                        <div class="hidden md:flex flex-col text-left">
                            <span class="text-sm font-semibold text-gray-800 leading-none">{{ auth()->user()->name }}</span>
                            <span class="text-[10px] font-medium text-gray-400 mt-1 leading-none">Administrador</span>
                        </div>

                        <!-- Dropdown de Ações simples -->
                        <div class="flex items-center">
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="flex items-center gap-1 text-xs font-semibold text-red-600 hover:text-red-800 hover:bg-red-50 px-2.5 py-1.5 rounded-lg border border-red-200 transition duration-150 ease-in-out cursor-pointer focus:outline-none">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75"></path>
                                    </svg>
                                    <span>Sair</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Área de Conteúdo -->
            <main class="flex-1 p-8 bg-coinpel-bg">
                <!-- Alerts / Status Messages -->
                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-sm text-green-800 font-medium">
                        {{ session('status') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
