<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-coinpel-bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>COINPEL — Painel Administrativo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900">
    <div class="flex h-full overflow-hidden">
        <div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 z-20 bg-black/50 hidden lg:hidden"></div>

        <aside id="sidebar" class="fixed inset-y-0 left-0 z-30 flex flex-col w-40 bg-coinpel-primary text-white shadow-xl transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shrink-0">
            <div class="flex items-center justify-center h-14 border-b border-white/10 shrink-0">
                <a href="{{ route('trips.index') }}" class="flex items-center gap-1.5 hover:opacity-95 transition-opacity">
                    <span class="flex items-center justify-center w-7 h-7 text-coinpel-primary bg-white rounded-lg shadow">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124l-.375-6a3.75 3.75 0 0 0-3.75-3.75H6.375c-.621 0-1.129.504-1.09 1.124l.375 6A3.75 3.75 0 0 0 9.42 15h4.16a3.75 3.75 0 0 0 3.75-3.75h0"></path>
                        </svg>
                    </span>
                    <span class="text-sm font-black tracking-wider uppercase font-sans">COINPEL</span>
                </a>
            </div>

            <nav class="flex-1 px-2.5 py-4 space-y-1 overflow-y-auto">
                <a href="#" 
                   class="flex flex-col items-center justify-center py-2.5 rounded-xl transition duration-150 ease-in-out gap-1 text-white/70 hover:bg-white/10 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"></path>
                    </svg>
                    <span class="text-[10px] font-medium tracking-wide">Clientes</span>
                </a>

                <a href="{{ route('drivers.index') }}" 
                   class="flex flex-col items-center justify-center py-2.5 rounded-xl transition duration-150 ease-in-out gap-1 {{ request()->routeIs('drivers.*') ? 'bg-white/15 text-white font-semibold shadow-inner' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0ZM6 15a3 3 0 0 1 6 0H6Z"></path>
                    </svg>
                    <span class="text-[10px] font-medium tracking-wide">Motoristas</span>
                </a>

                <a href="#" 
                   class="flex flex-col items-center justify-center py-2.5 rounded-xl transition duration-150 ease-in-out gap-1 text-white/70 hover:bg-white/10 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z"></path>
                    </svg>
                    <span class="text-[10px] font-medium tracking-wide">Estatísticas</span>
                </a>

                <a href="{{ route('vehicles.index') }}" 
                   class="flex flex-col items-center justify-center py-2.5 rounded-xl transition duration-150 ease-in-out gap-1 {{ request()->routeIs('vehicles.*') ? 'bg-white/15 text-white font-semibold shadow-inner' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0 1.232-.046 2.453-.138 3.662a4.006 4.006 0 0 1-3.7 3.7 48.656 48.656 0 0 1-7.324 0 4.006 4.006 0 0 1-3.7-3.7C4.547 14.453 4.5 13.232 4.5 12c0-1.232.046-2.453.138-3.662a4.006 4.006 0 0 1 3.7-3.7 48.656 48.656 0 0 1 7.324 0 4.006 4.006 0 0 1 3.7 3.7c.092 1.209.138 2.43.138 3.662Z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15.75a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Zm7.5 0a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Z"></path>
                    </svg>
                    <span class="text-[10px] font-medium tracking-wide">Veículos</span>
                </a>

                <a href="{{ route('trips.index') }}" 
                   class="flex flex-col items-center justify-center py-2.5 rounded-xl transition duration-150 ease-in-out gap-1 {{ request()->routeIs('trips.*') ? 'bg-white/15 text-white font-semibold shadow-inner' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25M2.25 17.25v-10.5A2.25 2.25 0 0 1 4.5 4.5h15a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25Z"></path>
                    </svg>
                    <span class="text-[10px] font-medium tracking-wide">Viagens</span>
                </a>

                <a href="#" 
                   class="flex flex-col items-center justify-center py-2.5 rounded-xl transition duration-150 ease-in-out gap-1 text-white/70 hover:bg-white/10 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"></path>
                    </svg>
                    <span class="text-[10px] font-medium tracking-wide">Contratos</span>
                </a>

                <a href="#" 
                   class="flex flex-col items-center justify-center py-2.5 rounded-xl transition duration-150 ease-in-out gap-1 text-white/70 hover:bg-white/10 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5h-18M21 12h-18m18 4.5h-18M3 5.25h18A2.25 2.25 0 0 1 22.25 7.5v9a2.25 2.25 0 0 1-2.25 2.25H3A2.25 2.25 0 0 1 .75 16.5v-9A2.25 2.25 0 0 1 3 5.25Z"></path>
                    </svg>
                    <span class="text-[10px] font-medium tracking-wide">Pacotes</span>
                </a>
            </nav>

            <div class="p-3 border-t border-white/10 text-center text-[9px] text-white/40 font-mono shrink-0">
                v1.2.0
            </div>
        </aside>

        <div class="flex-1 flex flex-col lg:pl-40 min-h-full overflow-hidden">
            <header class="flex items-center justify-between h-14 px-6 bg-white border-b border-gray-200 shrink-0">
                <button onclick="toggleSidebar()" class="lg:hidden p-1.5 text-gray-500 hover:bg-gray-100 rounded-lg focus:outline-none transition cursor-pointer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
                    </svg>
                </button>

                <div class="flex items-center">
                    <span class="text-xs font-semibold text-gray-400 font-sans tracking-wide uppercase hidden sm:inline">
                        COINPEL
                    </span>
                    <span class="mx-2 text-gray-300 hidden sm:inline">/</span>
                    <span class="text-sm font-bold text-gray-800 font-sans tracking-tight">
                        @yield('page-title', 'Painel')
                    </span>
                </div>

                <div class="flex items-center gap-4">
                    <button class="text-gray-400 hover:text-gray-600 focus:outline-none transition relative cursor-pointer">
                        <span class="absolute top-0.5 right-0.5 w-1.5 h-1.5 bg-coinpel-accent rounded-full"></span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"></path>
                        </svg>
                    </button>

                    <div class="w-px h-5 bg-gray-200"></div>

                    <div class="relative" id="profile-dropdown">
                        <button onclick="toggleDropdown(event)" class="flex items-center gap-2.5 focus:outline-none cursor-pointer group text-left">
                            <span class="flex items-center justify-center w-8 h-8 text-xs font-bold text-white rounded-full bg-coinpel-primary group-hover:bg-coinpel-primary-dark shadow shadow-coinpel-primary/20 transition uppercase">
                                {{ substr(auth()->user()->name, 0, 2) }}
                            </span>
                            
                            <div class="hidden md:flex flex-col">
                                <span class="text-xs font-semibold text-gray-800 leading-none group-hover:text-gray-950 transition">{{ auth()->user()->name }}</span>
                                <span class="text-[9px] font-medium text-gray-400 mt-1 leading-none">Administrador</span>
                            </div>
                            
                            <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-gray-600 transition" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"></path>
                            </svg>
                        </button>

                        <div id="dropdown-menu" class="hidden absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-lg border border-gray-100 py-1.5 z-50 transform origin-top-right">
                            <a href="{{ route('users.index') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 transition">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.089 21c-2.913 0-5.552-.843-7.76-2.3a4.125 4.125 0 0 1 7.533-2.493M15 9.75a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4.5 9.75a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"></path>
                                </svg>
                                <span>Usuários</span>
                            </a>
                            <div class="h-px bg-gray-100 my-1"></div>
                            <button onclick="document.getElementById('logout-form').submit();" class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 transition cursor-pointer">
                                <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75"></path>
                                </svg>
                                <span>Sair</span>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-6 overflow-y-auto bg-coinpel-bg">
                @if (session('status'))
                    <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-xl text-sm text-green-800 font-medium">
                        {{ session('status') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }

        function toggleDropdown(event) {
            event.stopPropagation();
            const menu = document.getElementById('dropdown-menu');
            menu.classList.toggle('hidden');
        }

        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById('profile-dropdown');
            const menu = document.getElementById('dropdown-menu');
            if (dropdown && !dropdown.contains(e.target) && menu) {
                menu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
