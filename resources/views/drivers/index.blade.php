@extends('layouts.app')

@section('page_title', 'Motoristas')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Motoristas</h1>
            <p class="text-sm text-gray-500 mt-1">Gerencie a equipe de condutores e seus cadastros profissionais.</p>
        </div>
        <div>
            <button class="inline-flex items-center gap-2 px-4 py-2.5 bg-coinpel-primary hover:bg-coinpel-primary-dark text-white text-sm font-semibold rounded-xl transition shadow-lg shadow-coinpel-primary/20 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                </svg>
                Adicionar Motorista
            </button>
        </div>
    </div>

    <!-- Barra de busca e filtros -->
    <div class="p-6 bg-white rounded-2xl border border-gray-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="relative w-full md:w-80">
            <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.637 10.637Z"></path></svg>
            </span>
            <input type="text" placeholder="Buscar motorista por nome, matrícula..." class="block w-full pl-9 pr-4 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition duration-150">
        </div>
    </div>

    <!-- Grid de cards (2 colunas) conforme requisitado pelo Figma -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Card 1 -->
        <div class="p-6 bg-white rounded-2xl border border-gray-200/80 shadow-sm flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <!-- Foto circular / iniciais -->
                <div class="flex items-center justify-center w-16 h-16 rounded-full bg-coinpel-primary/10 text-coinpel-primary font-bold text-xl uppercase border border-coinpel-primary/20">
                    CS
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-base">Carlos Silva</h3>
                    <p class="text-sm text-gray-400 mt-0.5">Matrícula: 12548793</p>
                    <p class="text-xs text-gray-500 mt-1">carlos.silva@coinpel.com</p>
                </div>
            </div>
            <div>
                <button class="p-1.5 hover:bg-gray-100 text-gray-400 hover:text-gray-600 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"></path></svg>
                </button>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="p-6 bg-white rounded-2xl border border-gray-200/80 shadow-sm flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-center w-16 h-16 rounded-full bg-coinpel-primary/10 text-coinpel-primary font-bold text-xl uppercase border border-coinpel-primary/20">
                    JS
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-base">João Santos</h3>
                    <p class="text-sm text-gray-400 mt-0.5">Matrícula: 12548794</p>
                    <p class="text-xs text-gray-500 mt-1">joao.santos@coinpel.com</p>
                </div>
            </div>
            <div>
                <button class="p-1.5 hover:bg-gray-100 text-gray-400 hover:text-gray-600 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"></path></svg>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
