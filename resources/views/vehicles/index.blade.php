@extends('layouts.app')

@section('page-title', 'Veículos')

@section('header-left')
<div class="flex items-center gap-3">
    <button id="btn-add-vehicle"
            class="inline-flex items-center gap-2 px-4 py-2 bg-coinpel-primary hover:opacity-95 text-white text-sm font-semibold rounded-lg transition shadow-sm shrink-0 cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Adicionar veículo
    </button>

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
<form method="GET" action="{{ route('vehicles.index') }}" class="relative w-64 md:w-72">
    <input type="text"
           id="search"
           name="search"
           value="{{ $search ?? '' }}"
           placeholder="Pesquisar veículo"
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

    {{-- Filter Panel --}}
    <div id="filter-panel" class="{{ request()->hasAny(['vehicle_type', 'seat_type']) ? '' : 'hidden' }} px-6 py-4 bg-gray-50 border-b border-gray-100">
        <form method="GET" action="{{ route('vehicles.index') }}" class="flex flex-wrap items-end gap-4">
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Tipo de veículo</label>
                <select name="vehicle_type"
                        class="px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-coinpel-primary bg-white">
                    <option value="">Todos os tipos</option>
                    @foreach($vehicleTypes as $value => $label)
                        <option value="{{ $value }}" {{ request('vehicle_type') === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Bancada</label>
                <select name="seat_type"
                        class="px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-coinpel-primary bg-white">
                    <option value="">Todas as bancadas</option>
                    @foreach($seatTypes as $value => $label)
                        <option value="{{ $value }}" {{ request('seat_type') === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit"
                    class="px-4 py-2 bg-coinpel-primary text-white text-sm font-semibold rounded-lg hover:bg-coinpel-primary-dark transition cursor-pointer">
                Aplicar filtros
            </button>
            <a href="{{ route('vehicles.index') }}"
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
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Prefixo</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Placa</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Modelo</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Chassi</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tipo de veículo</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Capacidade</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Ano</th>
                    <th class="px-6 py-3 w-12"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($vehicles as $vehicle)
                    <tr class="hover:bg-gray-50/60 transition">
                        <td class="px-6 py-4 text-sm font-bold text-coinpel-primary whitespace-nowrap">
                            {{ $vehicle->prefix }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-800 whitespace-nowrap">
                            {{ $vehicle->plate }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                            {{ $vehicle->model }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 font-mono whitespace-nowrap">
                            {{ $vehicle->chassis ?? '—' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                            {{ \App\Models\Vehicle::VEHICLE_TYPES[$vehicle->vehicle_type] ?? $vehicle->vehicle_type }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                            {{ $vehicle->capacity }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                            {{ $vehicle->year }}
                        </td>

                        {{-- Ações --}}
                        <td class="px-4 py-4 text-right whitespace-nowrap">
                            <div class="relative inline-block vehicle-actions-wrapper">
                                <button type="button"
                                        class="vehicle-actions-btn p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition cursor-pointer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                                    </svg>
                                </button>

                                <div class="vehicle-actions-menu hidden absolute right-0 top-full mt-1 w-44 bg-white rounded-xl shadow-lg border border-gray-100 py-1.5 z-50">
                                    <button type="button"
                                            class="btn-edit-vehicle flex items-center gap-2.5 w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition cursor-pointer"
                                            data-id="{{ $vehicle->id }}"
                                            data-prefix="{{ $vehicle->prefix }}"
                                            data-plate="{{ $vehicle->plate }}"
                                            data-model="{{ $vehicle->model }}"
                                            data-chassis="{{ $vehicle->chassis }}"
                                            data-capacity="{{ $vehicle->capacity }}"
                                            data-vehicle-type="{{ $vehicle->vehicle_type }}"
                                            data-seat-type="{{ $vehicle->seat_type }}"
                                            data-year="{{ $vehicle->year }}"
                                            data-has-wifi="{{ $vehicle->has_wifi ? '1' : '0' }}"
                                            data-has-wc="{{ $vehicle->has_wc ? '1' : '0' }}"
                                            data-has-outlet="{{ $vehicle->has_outlet ? '1' : '0' }}"
                                            data-has-ac="{{ $vehicle->has_ac ? '1' : '0' }}"
                                            data-has-fridge="{{ $vehicle->has_fridge ? '1' : '0' }}"
                                            data-has-heating="{{ $vehicle->has_heating ? '1' : '0' }}"
                                            data-has-video="{{ $vehicle->has_video ? '1' : '0' }}">
                                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/>
                                        </svg>
                                        Editar veículo
                                    </button>
                                    <div class="h-px bg-gray-100 mx-2 my-1"></div>
                                    <button type="button"
                                            class="btn-delete-vehicle flex items-center gap-2.5 w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition cursor-pointer"
                                            data-id="{{ $vehicle->id }}"
                                            data-prefix="{{ $vehicle->prefix }}"
                                            data-plate="{{ $vehicle->plate }}">
                                        <svg class="w-4 h-4 text-red-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                        </svg>
                                        Deletar veículo
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-gray-400">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 1-.859-4.395"/>
                                </svg>
                                <p class="text-sm font-medium">
                                    @if($search ?? false)
                                        Nenhum veículo encontrado para "{{ $search }}"
                                    @else
                                        Nenhum veículo cadastrado ainda.
                                    @endif
                                </p>
                                @if(!($search ?? false))
                                    <button id="btn-add-vehicle-empty"
                                            class="text-sm font-semibold text-coinpel-primary hover:underline cursor-pointer">
                                        + Adicionar primeiro veículo
                                    </button>
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
    @if ($vehicles->hasPages())
        <div class="px-6 py-4 bg-white border-t border-gray-100">
            {{ $vehicles->links() }}
        </div>
    @endif

</div>

{{-- ============================================================ --}}
{{-- Drawer Overlay                                               --}}
{{-- ============================================================ --}}
<div id="drawer-overlay"
     class="fixed inset-0 bg-black/40 z-40 hidden transition-opacity duration-300 opacity-0"></div>

{{-- ============================================================ --}}
{{-- Drawer Panel                                                 --}}
{{-- ============================================================ --}}
<div id="vehicle-drawer"
     class="fixed top-0 right-0 h-full w-full max-w-md bg-white shadow-2xl z-50 flex flex-col transform translate-x-full transition-transform duration-300 ease-in-out">

    {{-- Drawer Header --}}
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 shrink-0">
        <button id="drawer-close"
                class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition cursor-pointer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
            </svg>
        </button>
        <h2 class="text-base font-bold text-gray-900">Veículo</h2>
        <button id="drawer-delete"
                class="hidden p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition cursor-pointer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
            </svg>
        </button>
    </div>

    {{-- Drawer Body --}}
    <div class="flex-1 overflow-y-auto px-6 py-5 space-y-4">

        {{-- Global error --}}
        <div id="drawer-error" class="hidden p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700"></div>

        {{-- Prefix --}}
        <div>
            <label for="field-prefix" class="block text-xs font-semibold text-gray-500 mb-1.5">Prefixo (nome de identificação):</label>
            <input id="field-prefix" name="prefix" type="number" min="1"
                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                   placeholder="Ex: 202">
            <p id="err-prefix" class="hidden mt-1 text-xs text-red-600"></p>
        </div>

        {{-- Plate --}}
        <div>
            <label for="field-plate" class="block text-xs font-semibold text-gray-500 mb-1.5">Placa:</label>
            <input id="field-plate" name="plate" type="text"
                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                   placeholder="Ex: IVS-2622">
            <p id="err-plate" class="hidden mt-1 text-xs text-red-600"></p>
        </div>

        {{-- Model --}}
        <div>
            <label for="field-model" class="block text-xs font-semibold text-gray-500 mb-1.5">Modelo:</label>
            <input id="field-model" name="model" type="text"
                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                   placeholder="Ex: Marcopolo Paradiso">
            <p id="err-model" class="hidden mt-1 text-xs text-red-600"></p>
        </div>

        {{-- Chassis --}}
        <div>
            <label for="field-chassis" class="block text-xs font-semibold text-gray-500 mb-1.5">Chassi:</label>
            <input id="field-chassis" name="chassis" type="text"
                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                   placeholder="Ex: Scania">
            <p id="err-chassis" class="hidden mt-1 text-xs text-red-600"></p>
        </div>

        {{-- Capacity --}}
        <div>
            <label for="field-capacity" class="block text-xs font-semibold text-gray-500 mb-1.5">Capacidade:</label>
            <input id="field-capacity" name="capacity" type="number" min="1"
                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                   placeholder="Ex: 45">
            <p id="err-capacity" class="hidden mt-1 text-xs text-red-600"></p>
        </div>

        {{-- Vehicle Type --}}
        <div>
            <label for="field-vehicle-type" class="block text-xs font-semibold text-gray-500 mb-1.5">Tipo de ônibus:</label>
            <select id="field-vehicle-type" name="vehicle_type"
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition bg-white">
                <option value="">Selecione...</option>
                @foreach($vehicleTypes as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
            <p id="err-vehicle-type" class="hidden mt-1 text-xs text-red-600"></p>
        </div>

        {{-- Seat Type --}}
        <div>
            <label for="field-seat-type" class="block text-xs font-semibold text-gray-500 mb-1.5">Bancada:</label>
            <select id="field-seat-type" name="seat_type"
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition bg-white">
                <option value="">Selecione...</option>
                @foreach($seatTypes as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
            <p id="err-seat-type" class="hidden mt-1 text-xs text-red-600"></p>
        </div>

        {{-- Year --}}
        <div>
            <label for="field-year" class="block text-xs font-semibold text-gray-500 mb-1.5">Ano:</label>
            <input id="field-year" name="year" type="number" min="1900" max="{{ date('Y') + 1 }}"
                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                   placeholder="Ex: 2006">
            <p id="err-year" class="hidden mt-1 text-xs text-red-600"></p>
        </div>

        {{-- Amenities --}}
        <div>
            <p class="text-xs font-semibold text-gray-500 mb-3">Comodidades:</p>
            <div class="grid grid-cols-2 gap-2">
                {{-- Internet --}}
                <button type="button" class="amenity-btn flex items-center gap-2 px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-600 hover:border-coinpel-primary transition cursor-pointer" data-amenity="has_wifi">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 0 1 7.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 0 1 1.06 0Z"/>
                    </svg>
                    Internet
                </button>
                {{-- WC --}}
                <button type="button" class="amenity-btn flex items-center gap-2 px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-600 hover:border-coinpel-primary transition cursor-pointer" data-amenity="has_wc">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                    </svg>
                    WC
                </button>
                {{-- Tomada --}}
                <button type="button" class="amenity-btn flex items-center gap-2 px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-600 hover:border-coinpel-primary transition cursor-pointer" data-amenity="has_outlet">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5 10.5 21l6.75-7.5m-6.75-9 6.75 7.5-6.75 7.5"/>
                    </svg>
                    Tomada
                </button>
                {{-- Ar Condicionado --}}
                <button type="button" class="amenity-btn flex items-center gap-2 px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-600 hover:border-coinpel-primary transition cursor-pointer" data-amenity="has_ac">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/>
                    </svg>
                    Ar Condicionado
                </button>
                {{-- Geladeira --}}
                <button type="button" class="amenity-btn flex items-center gap-2 px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-600 hover:border-coinpel-primary transition cursor-pointer" data-amenity="has_fridge">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5 10.5 21l-9-13.5M20.25 7.5H3.75m16.5 0v9.75a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V7.5"/>
                    </svg>
                    Geladeira
                </button>
                {{-- Calefação --}}
                <button type="button" class="amenity-btn flex items-center gap-2 px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-600 hover:border-coinpel-primary transition cursor-pointer" data-amenity="has_heating">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z"/>
                    </svg>
                    Calefação
                </button>
                {{-- Vídeo --}}
                <button type="button" class="amenity-btn col-span-2 flex items-center justify-center gap-2 px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-600 hover:border-coinpel-primary transition cursor-pointer" data-amenity="has_video">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z"/>
                    </svg>
                    Vídeo
                </button>
            </div>
        </div>

    </div>

    {{-- Drawer Footer --}}
    <div class="shrink-0 px-6 py-4 border-t border-gray-100 space-y-2">
        <button id="drawer-submit"
                class="w-full py-2.5 bg-coinpel-primary hover:bg-coinpel-primary-dark text-white text-sm font-semibold rounded-lg transition cursor-pointer">
            Finalizar cadastro
        </button>
        <button id="drawer-cancel"
                class="w-full py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 transition cursor-pointer">
            Cancelar
        </button>
    </div>

</div>

@push('scripts')
<script>
(function () {
    // ── State ───────────────────────────────────────────────────────────
    let editingId = null;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content
                    || '{{ csrf_token() }}';

    // ── Element refs ────────────────────────────────────────────────────
    const overlay     = document.getElementById('drawer-overlay');
    const drawer      = document.getElementById('vehicle-drawer');
    const btnAdd      = document.getElementById('btn-add-vehicle');
    const btnAddEmpty = document.getElementById('btn-add-vehicle-empty');
    const btnClose    = document.getElementById('drawer-close');
    const btnCancel   = document.getElementById('drawer-cancel');
    const btnSubmit   = document.getElementById('drawer-submit');
    const btnDelete   = document.getElementById('drawer-delete');
    const drawerError = document.getElementById('drawer-error');

    const fields = {
        prefix:       document.getElementById('field-prefix'),
        plate:        document.getElementById('field-plate'),
        model:        document.getElementById('field-model'),
        chassis:      document.getElementById('field-chassis'),
        capacity:     document.getElementById('field-capacity'),
        vehicle_type: document.getElementById('field-vehicle-type'),
        seat_type:    document.getElementById('field-seat-type'),
        year:         document.getElementById('field-year'),
    };

    const amenityBtns = document.querySelectorAll('.amenity-btn');

    // ── Drawer open/close ───────────────────────────────────────────────
    function openDrawer(mode, data) {
        editingId = mode === 'edit' ? data.id : null;

        // Reset
        clearErrors();
        resetForm();

        if (mode === 'edit') {
            Object.keys(fields).forEach(key => {
                if (fields[key]) fields[key].value = data[key] ?? '';
            });
            amenityBtns.forEach(btn => {
                const key = 'has' + btn.dataset.amenity.replace('has', '').replace(/([A-Z])/g, '_$1').toLowerCase();
                const amenityKey = btn.dataset.amenity;
                const isActive = data[amenityKey] === '1';
                setAmenityState(btn, isActive);
            });
            btnDelete.classList.remove('hidden');
            btnSubmit.textContent = 'Salvar alterações';
        } else {
            btnDelete.classList.add('hidden');
            btnSubmit.textContent = 'Finalizar cadastro';
        }

        overlay.classList.remove('hidden');
        setTimeout(() => overlay.classList.add('opacity-100'), 10);
        drawer.classList.remove('translate-x-full');
        document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
        drawer.classList.add('translate-x-full');
        overlay.classList.remove('opacity-100');
        setTimeout(() => overlay.classList.add('hidden'), 300);
        document.body.style.overflow = '';
        editingId = null;
    }

    // ── Amenity toggle ──────────────────────────────────────────────────
    function setAmenityState(btn, active) {
        if (active) {
            btn.classList.add('border-coinpel-primary', 'text-coinpel-primary', 'bg-coinpel-primary/5');
            btn.classList.remove('border-gray-300', 'text-gray-600');
            btn.dataset.active = '1';
        } else {
            btn.classList.remove('border-coinpel-primary', 'text-coinpel-primary', 'bg-coinpel-primary/5');
            btn.classList.add('border-gray-300', 'text-gray-600');
            btn.dataset.active = '0';
        }
    }

    amenityBtns.forEach(btn => {
        btn.dataset.active = '0';
        btn.addEventListener('click', () => {
            setAmenityState(btn, btn.dataset.active !== '1');
        });
    });

    // ── Reset form ──────────────────────────────────────────────────────
    function resetForm() {
        Object.values(fields).forEach(f => { if (f) f.value = ''; });
        amenityBtns.forEach(btn => setAmenityState(btn, false));
        drawerError.classList.add('hidden');
        drawerError.textContent = '';
    }

    // ── Error display ────────────────────────────────────────────────────
    function clearErrors() {
        document.querySelectorAll('[id^="err-"]').forEach(el => {
            el.classList.add('hidden');
            el.textContent = '';
        });
        Object.values(fields).forEach(f => {
            if (f) f.classList.remove('border-red-400', 'focus:ring-red-400', 'focus:border-red-400');
        });
    }

    function showErrors(errors) {
        const map = {
            prefix:       'err-prefix',
            plate:        'err-plate',
            model:        'err-model',
            chassis:      'err-chassis',
            capacity:     'err-capacity',
            vehicle_type: 'err-vehicle-type',
            seat_type:    'err-seat-type',
            year:         'err-year',
        };
        Object.entries(errors).forEach(([key, msgs]) => {
            const errEl = document.getElementById(map[key]);
            const fieldEl = fields[key];
            if (errEl) {
                errEl.textContent = Array.isArray(msgs) ? msgs[0] : msgs;
                errEl.classList.remove('hidden');
            }
            if (fieldEl) {
                fieldEl.classList.add('border-red-400');
            }
        });
    }

    // ── Collect form data ────────────────────────────────────────────────
    function collectData() {
        const data = {};
        Object.keys(fields).forEach(key => {
            if (fields[key]) data[key] = fields[key].value;
        });
        amenityBtns.forEach(btn => {
            data[btn.dataset.amenity] = btn.dataset.active === '1' ? '1' : '0';
        });
        return data;
    }

    // ── Submit ───────────────────────────────────────────────────────────
    btnSubmit.addEventListener('click', async function () {
        clearErrors();
        drawerError.classList.add('hidden');

        const data = collectData();
        const isEdit = editingId !== null;
        const url    = isEdit ? '/vehicles/' + editingId : '/vehicles';
        const method = isEdit ? 'PATCH' : 'POST';

        if (isEdit) data['_method'] = 'PATCH';

        btnSubmit.disabled = true;
        btnSubmit.textContent = 'Salvando...';

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-HTTP-Method-Override': method,
                },
                body: JSON.stringify(data),
            });

            const json = await response.json();

            if (!response.ok) {
                if (response.status === 422 && json.errors) {
                    showErrors(json.errors);
                } else {
                    drawerError.textContent = json.message || 'Ocorreu um erro. Tente novamente.';
                    drawerError.classList.remove('hidden');
                }
                return;
            }

            sessionStorage.setItem('flash_status', json.message);
            window.location.reload();

        } catch (err) {
            drawerError.textContent = 'Erro de conexão. Tente novamente.';
            drawerError.classList.remove('hidden');
        } finally {
            btnSubmit.disabled = false;
            btnSubmit.textContent = editingId ? 'Salvar alterações' : 'Finalizar cadastro';
        }
    });

    // ── Delete from drawer ───────────────────────────────────────────────
    btnDelete.addEventListener('click', async function () {
        if (!editingId) return;
        if (!confirm('Confirma a exclusão deste veículo?')) return;

        btnDelete.disabled = true;
        try {
            const response = await fetch('/vehicles/' + editingId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ _method: 'DELETE' }),
            });
            const json = await response.json();
            if (response.ok) {
                sessionStorage.setItem('flash_status', json.message);
                window.location.reload();
            } else {
                alert(json.message || 'Erro ao excluir. Tente novamente.');
            }
        } catch {
            alert('Erro de conexão. Tente novamente.');
        } finally {
            btnDelete.disabled = false;
        }
    });

    // ── Delete from table row ─────────────────────────────────────────────
    document.querySelectorAll('.btn-delete-vehicle').forEach(btn => {
        btn.addEventListener('click', async function () {
            const id     = btn.dataset.id;
            const prefix = btn.dataset.prefix;
            const plate  = btn.dataset.plate;
            if (!confirm(`Confirma a exclusão do veículo ${prefix} (${plate})?`)) return;

            try {
                const response = await fetch('/vehicles/' + id, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ _method: 'DELETE' }),
                });
                const json = await response.json();
                if (response.ok) {
                    sessionStorage.setItem('flash_status', json.message);
                    window.location.reload();
                } else {
                    alert(json.message || 'Erro ao excluir. Tente novamente.');
                }
            } catch {
                alert('Erro de conexão. Tente novamente.');
            }
        });
    });

    // ── Edit from table row ───────────────────────────────────────────────
    document.querySelectorAll('.btn-edit-vehicle').forEach(btn => {
        btn.addEventListener('click', function () {
            closeAllActionMenus();
            openDrawer('edit', btn.dataset);
        });
    });

    // ── Open events ───────────────────────────────────────────────────────
    if (btnAdd) btnAdd.addEventListener('click', () => openDrawer('create'));
    if (btnAddEmpty) btnAddEmpty.addEventListener('click', () => openDrawer('create'));

    // ── Close events ──────────────────────────────────────────────────────
    btnClose.addEventListener('click', closeDrawer);
    btnCancel.addEventListener('click', closeDrawer);
    overlay.addEventListener('click', closeDrawer);

    // ── Action menus ──────────────────────────────────────────────────────
    function closeAllActionMenus() {
        document.querySelectorAll('.vehicle-actions-menu').forEach(m => m.classList.add('hidden'));
    }

    document.querySelectorAll('.vehicle-actions-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const menu = btn.closest('.vehicle-actions-wrapper').querySelector('.vehicle-actions-menu');
            closeAllActionMenus();
            menu.classList.toggle('hidden');
        });
    });

    document.addEventListener('click', closeAllActionMenus);

    // ── Flash from sessionStorage ──────────────────────────────────────────
    const flash = sessionStorage.getItem('flash_status');
    if (flash) {
        sessionStorage.removeItem('flash_status');
        const flashEl = document.createElement('div');
        flashEl.className = 'fixed bottom-6 right-6 z-[100] px-5 py-3.5 bg-green-600 text-white text-sm font-semibold rounded-xl shadow-lg flex items-center gap-3 animate-fade-in';
        flashEl.innerHTML = `<svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>${flash}`;
        document.body.appendChild(flashEl);
        setTimeout(() => flashEl.remove(), 4000);
    }

    // ── Filter toggle ─────────────────────────────────────────────────────
    document.getElementById('filter-toggle')?.addEventListener('click', function () {
        document.getElementById('filter-panel')?.classList.toggle('hidden');
    });

})();
</script>
@endpush

@endsection
