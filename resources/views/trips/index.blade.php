@extends('layouts.app')

@section('page_title', 'Viagens')

@section('content')
<div class="space-y-6">
    <!-- Topo da página -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Viagens</h1>
            <p class="text-sm text-gray-500 mt-1">Gerencie a escala e as rotas das viagens de turismo da COINPEL.</p>
        </div>
        <div>
            <button class="inline-flex items-center gap-2 px-4 py-2.5 bg-coinpel-primary hover:bg-coinpel-primary-dark text-white text-sm font-semibold rounded-xl transition shadow-lg shadow-coinpel-primary/20 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                </svg>
                Nova Viagem
            </button>
        </div>
    </div>

    <!-- Cards de Estatísticas rápidos -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
        <div class="p-5 bg-white rounded-2xl border border-gray-200/80 shadow-sm flex items-center gap-4">
            <span class="p-3 bg-coinpel-primary/10 text-coinpel-primary rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124l-.375-6a3.75 3.75 0 0 0-3.75-3.75H6.375c-.621 0-1.129.504-1.09 1.124l.375 6A3.75 3.75 0 0 0 9.42 15h4.16a3.75 3.75 0 0 0 3.75-3.75h0"></path></svg>
            </span>
            <div>
                <span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider">Total de Viagens</span>
                <span class="text-2xl font-bold text-gray-800 leading-tight">12</span>
            </div>
        </div>

        <div class="p-5 bg-white rounded-2xl border border-gray-200/80 shadow-sm flex items-center gap-4">
            <span class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path></svg>
            </span>
            <div>
                <span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider">Agendadas</span>
                <span class="text-2xl font-bold text-gray-800 leading-tight">5</span>
            </div>
        </div>

        <div class="p-5 bg-white rounded-2xl border border-gray-200/80 shadow-sm flex items-center gap-4">
            <span class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 0 1-5.84 0M19.5 12a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z"></path></svg>
            </span>
            <div>
                <span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider">Em Andamento</span>
                <span class="text-2xl font-bold text-gray-800 leading-tight">2</span>
            </div>
        </div>

        <div class="p-5 bg-white rounded-2xl border border-gray-200/80 shadow-sm flex items-center gap-4">
            <span class="p-3 bg-green-50 text-green-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path></svg>
            </span>
            <div>
                <span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider">Concluídas</span>
                <span class="text-2xl font-bold text-gray-800 leading-tight">5</span>
            </div>
        </div>
    </div>

    <!-- Tabela Mock / Tabela Principal -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="relative w-full md:w-80">
                    <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.637 10.637Z"></path></svg>
                    </span>
                    <input type="text" placeholder="Buscar viagem por nome, destino..." class="block w-full pl-9 pr-4 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition duration-150">
                </div>
                <button class="inline-flex items-center gap-1.5 px-3 py-2 border border-gray-300 hover:bg-gray-50 text-gray-600 rounded-xl text-sm font-semibold transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z"></path></svg>
                    Filtrar
                </button>
            </div>
            <span class="text-xs font-medium text-gray-400">Mostrando 1 de 1 viagens cadastradas</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/75 border-b border-gray-100 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Nome da Viagem</th>
                        <th class="px-6 py-4">Data</th>
                        <th class="px-6 py-4">Horário</th>
                        <th class="px-6 py-4">Rota</th>
                        <th class="px-6 py-4">Regra</th>
                        <th class="px-6 py-4">Motorista / Veículo</th>
                        <th class="px-6 py-4 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                    <tr class="hover:bg-gray-50/50 transition duration-150">
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold text-amber-800 bg-amber-50 rounded-full border border-amber-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                Em andamento
                            </span>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900">ChocoFest 2026</td>
                        <td class="px-6 py-4">25/06/2026</td>
                        <td class="px-6 py-4">08:00</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1.5">
                                <span class="font-medium">Pelotas</span>
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"></path></svg>
                                <span class="font-medium">Gramado</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 rounded-md">Turismo</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-medium text-gray-900">Carlos Silva</span>
                                <span class="text-xs text-gray-400">Prefixo: 204 (Placa: ABC-1234)</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button class="p-1 hover:bg-gray-100 text-gray-400 hover:text-gray-600 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"></path></svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
