@extends('layouts.app')

@section('page-title', 'Viagens')

@section('header-left')
<div class="flex items-center gap-3">
    <a href="{{ route('trips.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-coinpel-primary hover:opacity-95 text-white text-sm font-semibold rounded-lg transition shadow-sm shrink-0">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Adicionar viagem
    </a>

    <button id="filter-toggle"
            class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-lg transition shrink-0 cursor-pointer">
        <svg class="w-4 h-4 text-gray-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9"/>
        </svg>
        Filtrar
    </button>
</div>
@endsection

@section('header-right-action')
<form method="GET" action="{{ route('trips.index') }}" class="relative w-64 md:w-72">
    @foreach(request()->except(['search']) as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach
    <input type="text"
           id="search"
           name="search"
           value="{{ $search ?? '' }}"
           placeholder="Pesquisar viagem"
           class="block w-full pl-4 pr-10 py-2 border border-gray-200 rounded-lg text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
    <span class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-400">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.637 10.637Z"/>
        </svg>
    </span>
</form>
@endsection

@section('content')
<div class="flex flex-col flex-1 gap-0 -m-6">

    {{-- Filter Panel (hidden by default) --}}
    <div id="filter-panel" class="{{ request()->hasAny(['status', 'date_from', 'date_to']) ? '' : 'hidden' }} px-6 py-4 bg-gray-50 border-b border-gray-100">
        <form method="GET" action="{{ route('trips.index') }}" class="flex flex-wrap items-end gap-4">
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Status</label>
                <select name="status"
                        class="px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-coinpel-primary bg-white">
                    <option value="">Todos os status</option>
                    @foreach(\App\Models\Trip::STATUSES as $value => $label)
                        <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Data inicial</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                       class="px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-coinpel-primary bg-white">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Data final</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                       class="px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-coinpel-primary bg-white">
            </div>
            <button type="submit"
                    class="px-4 py-2 bg-coinpel-primary text-white text-sm font-semibold rounded-lg hover:bg-coinpel-primary-dark transition cursor-pointer">
                Aplicar filtros
            </button>
            <a href="{{ route('trips.index') }}"
               class="px-4 py-2 bg-white border border-gray-300 text-gray-600 text-sm font-semibold rounded-lg hover:bg-gray-50 transition">
                Limpar
            </a>
        </form>
    </div>

    {{-- Table --}}
    <div class="flex-1 bg-white pb-12">
        <div class="overflow-visible relative">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Status</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Nome</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Data</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Horário</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Rota</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Veículo</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Regra</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Motorista</th>
                    <th class="px-6 py-3 w-12"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($trips as $trip)
                    <tr class="hover:bg-gray-50/60 transition">

                        {{-- Status --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClasses = match($trip->status_color) {
                                    'amber' => 'text-coinpel-in-progress',
                                    'green' => 'text-coinpel-completed',
                                    'red'   => 'text-coinpel-cancelled',
                                    'blue'  => 'text-blue-500',
                                    default => 'text-gray-500',
                                };
                            @endphp
                            <span class="text-sm {{ $statusClasses }}">{{ $trip->status_label }}</span>
                        </td>

                        {{-- Nome --}}
                        <td class="px-6 py-4 text-sm font-medium text-gray-800 whitespace-nowrap">
                            {{ $trip->name }}
                        </td>

                        {{-- Data --}}
                        <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                            {{ $trip->date->format('d/m/Y') }}
                        </td>

                        {{-- Horário --}}
                        <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                            {{ substr($trip->departure_time, 0, 5) }}
                        </td>

                        {{-- Rota --}}
                        <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                            <div class="flex items-center gap-1.5">
                                <span>{{ $trip->origin }}</span>
                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                                </svg>
                                <span class="max-w-[120px] truncate" title="{{ $trip->destination }}">{{ $trip->destination }}</span>
                            </div>
                        </td>

                        {{-- Veículo --}}
                        <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                            @if ($trip->vehicle)
                                {{ $trip->vehicle->prefix }} - {{ $trip->vehicle->model }}
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>

                        {{-- Regra --}}
                        <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                            {{ $trip->rule }}
                        </td>

                        {{-- Motorista --}}
                        <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                            @if ($trip->driver)
                                {{ Str::before($trip->driver->name, ' ') }}
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>

                        {{-- Ações --}}
                        <td class="px-4 py-4 text-right whitespace-nowrap">
                            <div class="relative inline-block trip-actions-wrapper">
                                <button type="button"
                                        class="trip-actions-btn p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition cursor-pointer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                                    </svg>
                                </button>

                                <div class="trip-actions-menu hidden absolute right-0 top-full mt-1 w-44 bg-white rounded-xl shadow-lg border border-gray-100 py-1.5 z-50">
                                    <a href="{{ route('trips.edit', $trip) }}"
                                       class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/>
                                        </svg>
                                        Editar viagem
                                    </a>
                                    <div class="h-px bg-gray-100 mx-2 my-1"></div>
                                    <form method="POST" action="{{ route('trips.destroy', $trip) }}"
                                          onsubmit="return confirm('Confirma a exclusão da viagem \'{{ addslashes($trip->name) }}\'?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="flex items-center gap-2.5 w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition cursor-pointer">
                                            <svg class="w-4 h-4 text-red-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                            </svg>
                                            Deletar viagem
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-gray-400">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124l-.375-6a3.75 3.75 0 0 0-3.75-3.75H6.375c-.621 0-1.129.504-1.09 1.124l.375 6A3.75 3.75 0 0 0 9.42 15h4.16a3.75 3.75 0 0 0 3.75-3.75h0"/>
                                </svg>
                                <p class="text-sm font-medium">
                                    @if($search ?? false)
                                        Nenhuma viagem encontrada para "{{ $search }}"
                                    @else
                                        Nenhuma viagem cadastrada ainda.
                                    @endif
                                </p>
                                @if(!($search ?? false))
                                    <a href="{{ route('trips.create') }}"
                                       class="text-sm font-semibold text-coinpel-primary hover:underline">
                                        + Adicionar primeira viagem
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>{{-- /overflow-visible --}}
    </div>

    {{-- Pagination --}}
    @if ($trips->hasPages())
        <div class="px-6 py-4 bg-white border-t border-gray-100">
            {{ $trips->links() }}
        </div>
    @endif

</div>

@push('scripts')
<script>
    document.getElementById('filter-toggle')?.addEventListener('click', function () {
        document.getElementById('filter-panel')?.classList.toggle('hidden');
    });

    document.querySelectorAll('.trip-actions-btn').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const menu = btn.closest('.trip-actions-wrapper').querySelector('.trip-actions-menu');
            document.querySelectorAll('.trip-actions-menu').forEach(function (m) {
                if (m !== menu) m.classList.add('hidden');
            });
            menu.classList.toggle('hidden');
        });
    });

    document.addEventListener('click', function () {
        document.querySelectorAll('.trip-actions-menu').forEach(function (m) {
            m.classList.add('hidden');
        });
    });
</script>
@endpush
@endsection
