@extends('layouts.app')

@section('page-title', 'Veículos')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Veículos</h1>
            <p class="text-sm text-gray-500 mt-1">Gerencie a frota de ônibus e vans disponíveis para as viagens da COINPEL.</p>
        </div>
        <div>
            <button class="inline-flex items-center gap-2 px-4 py-2.5 bg-coinpel-primary hover:bg-coinpel-primary-dark text-white text-sm font-semibold rounded-xl transition shadow-lg shadow-coinpel-primary/20 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                </svg>
                Adicionar Veículo
            </button>
        </div>
    </div>

    <!-- Tabela Mock / Frota -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="relative w-full md:w-80">
                    <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.637 10.637Z"></path></svg>
                    </span>
                    <input type="text" placeholder="Buscar veículo por prefixo, placa, modelo..." class="block w-full pl-9 pr-4 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition duration-150">
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/75 border-b border-gray-100 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        <th class="px-6 py-4">Prefixo</th>
                        <th class="px-6 py-4">Placa</th>
                        <th class="px-6 py-4">Modelo</th>
                        <th class="px-6 py-4">Chassi</th>
                        <th class="px-6 py-4">Tipo</th>
                        <th class="px-6 py-4">Capacidade</th>
                        <th class="px-6 py-4">Ano</th>
                        <th class="px-6 py-4 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                    <tr class="hover:bg-gray-50/50 transition duration-150">
                        <td class="px-6 py-4 font-bold text-coinpel-primary">204</td>
                        <td class="px-6 py-4 font-medium text-gray-900">ABC-1234</td>
                        <td class="px-6 py-4">Marcopolo Paradiso G8</td>
                        <td class="px-6 py-4 text-xs font-mono text-gray-500">9382049102830912A</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-0.5 text-xs font-bold text-blue-800 bg-blue-50 rounded-full border border-blue-200">Ônibus</span>
                        </td>
                        <td class="px-6 py-4">46 passageiros</td>
                        <td class="px-6 py-4">2024</td>
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
