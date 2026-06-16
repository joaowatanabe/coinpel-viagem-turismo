@extends('layouts.app')

@section('page-title', 'Estatísticas')

@section('header-left')
<div class="flex items-center gap-3">
    <span class="text-sm font-bold text-gray-800 font-sans tracking-tight">Estatísticas</span>
</div>
@endsection

@section('header-right-action')
<a href="{{ route('dashboard') }}"
   class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-lg transition shrink-0">
    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
    </svg>
    Dashboard
</a>
@endsection

@section('content')
    {{-- Cards de Resumo --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        {{-- Card: Total de Viagens --}}
        <div class="bg-white rounded-2xl border border-gray-100/80 shadow-[0_8px_30px_rgb(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:border-gray-200/50 transition-all duration-300 p-6 flex items-center gap-4.5 group">
            <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-coinpel-primary/10 text-coinpel-primary shrink-0 transition duration-150 group-hover:scale-105">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25M2.25 17.25v-10.5A2.25 2.25 0 0 1 4.5 4.5h15a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25Z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total de Viagens</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="text-2xl font-bold text-gray-800 tracking-tight leading-tight">{{ $totalTrips }}</span>
                    <span class="text-xs text-gray-400 font-normal">({{ $tripsLast30Days }} nos últimos 30 dias)</span>
                </div>
            </div>
        </div>

        {{-- Card: Motoristas Ativos --}}
        <div class="bg-white rounded-2xl border border-gray-100/80 shadow-[0_8px_30px_rgb(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:border-gray-200/50 transition-all duration-300 p-6 flex items-center gap-4.5 group">
            <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 shrink-0 transition duration-150 group-hover:scale-105">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0ZM6 15a3 3 0 0 1 6 0H6Z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Motoristas Ativos</p>
                <p class="text-2xl font-bold text-gray-800 tracking-tight leading-tight mt-1">{{ $activeDriversCount }}</p>
            </div>
        </div>

        {{-- Card: Veículos --}}
        <div class="bg-white rounded-2xl border border-gray-100/80 shadow-[0_8px_30px_rgb(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:border-gray-200/50 transition-all duration-300 p-6 flex items-center gap-4.5 group">
            <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-blue-50 text-blue-500 shrink-0 transition duration-150 group-hover:scale-105">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124l-.375-6a3.75 3.75 0 0 0-3.75-3.75H6.375c-.621 0-1.129.504-1.09 1.124l.375 6A3.75 3.75 0 0 0 9.42 15h4.16" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total de Veículos</p>
                <p class="text-2xl font-bold text-gray-800 tracking-tight leading-tight mt-1">{{ $vehiclesCount }}</p>
            </div>
        </div>

        {{-- Card: Receita Estimada --}}
        <div class="bg-white rounded-2xl border border-gray-100/80 shadow-[0_8px_30px_rgb(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:border-gray-200/50 transition-all duration-300 p-6 flex items-center gap-4.5 group">
            <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-amber-50 text-amber-600 shrink-0 transition duration-150 group-hover:scale-105">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-1.958-.659-1.091-.91-1.091-2.386 0-3.296C10.564 7.604 11.282 7.5 12 7.5c1.026 0 2.037.224 2.87.659" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Receita Estimada</p>
                <p class="text-2xl font-bold text-gray-800 tracking-tight leading-tight mt-1">R$ {{ number_format($estimatedRevenue, 2, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- Seção: Status das viagens --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] p-6 mb-8">
        <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-6">Status das Viagens</h2>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Concluídas --}}
            <div class="flex flex-col p-4 bg-emerald-50/40 border border-emerald-100/30 rounded-2xl">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Concluídas</span>
                <span class="text-3xl font-extrabold text-coinpel-completed mt-2">{{ $completedCount }}</span>
            </div>
            
            {{-- Em andamento --}}
            <div class="flex flex-col p-4 bg-amber-50/40 border border-amber-100/30 rounded-2xl">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Em andamento</span>
                <span class="text-3xl font-extrabold text-coinpel-in-progress mt-2">{{ $inProgressCount }}</span>
            </div>
            
            {{-- Agendadas --}}
            <div class="flex flex-col p-4 bg-blue-50/40 border border-blue-100/30 rounded-2xl">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Agendadas</span>
                <span class="text-3xl font-extrabold text-blue-500 mt-2">{{ $scheduledCount }}</span>
            </div>

            {{-- Canceladas --}}
            <div class="flex flex-col p-4 bg-red-50/40 border border-red-100/30 rounded-2xl">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Canceladas</span>
                <span class="text-3xl font-extrabold text-coinpel-cancelled mt-2">{{ $cancelledCount }}</span>
            </div>
        </div>
    </div>

    {{-- Tabela de Viagens Recentes --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Viagens Recentes</h2>
            <a href="{{ route('trips.index') }}" class="text-xs font-semibold text-coinpel-primary hover:underline flex items-center gap-1">
                Ver todas as viagens
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>
        <div class="overflow-visible relative">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/50">
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Nome</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Origem → Destino</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Data</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Motorista</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($recentTrips as $trip)
                        <tr class="hover:bg-gray-50/40 transition">
                            {{-- Nome --}}
                            <td class="px-6 py-4 text-sm font-semibold text-gray-800 whitespace-nowrap">
                                {{ $trip->name }}
                            </td>
                            
                            {{-- Origem → Destino --}}
                            <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                                <div class="flex items-center gap-1.5">
                                    <span class="font-medium">{{ $trip->origin }}</span>
                                    <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                                    </svg>
                                    <span class="font-medium truncate max-w-[150px]" title="{{ $trip->destination }}">{{ $trip->destination }}</span>
                                </div>
                            </td>

                            {{-- Data --}}
                            <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                                {{ $trip->date->format('d/m/Y') }}
                                <span class="text-xs text-gray-400 font-normal">às {{ substr($trip->departure_time, 0, 5) }}</span>
                            </td>

                            {{-- Motorista --}}
                            <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                                @if ($trip->driver)
                                    {{ $trip->driver->name }}
                                @else
                                    <span class="text-gray-400 font-normal">—</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClasses = match($trip->status_color) {
                                        'amber' => 'bg-coinpel-in-progress/10 text-coinpel-in-progress',
                                        'green' => 'bg-coinpel-completed/10 text-coinpel-completed',
                                        'red'   => 'bg-coinpel-cancelled/10 text-coinpel-cancelled',
                                        'blue'  => 'bg-blue-50 text-blue-500',
                                        default => 'bg-gray-50 text-gray-500',
                                    };
                                @endphp
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusClasses }}">
                                    {{ $trip->status_label }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-3 text-gray-400">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124l-.375-6a3.75 3.75 0 0 0-3.75-3.75H6.375c-.621 0-1.129.504-1.09 1.124l.375 6A3.75 3.75 0 0 0 9.42 15h4.16"/>
                                    </svg>
                                    <p class="text-sm font-medium">Nenhuma viagem recente encontrada.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
