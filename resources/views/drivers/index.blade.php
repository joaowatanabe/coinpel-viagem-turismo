@extends('layouts.app')

@section('page-title', 'Motoristas')

@section('header-left')
<div class="flex items-center gap-3">
    <button id="btn-add-driver"
            class="inline-flex items-center gap-2 px-4 py-2 bg-coinpel-primary hover:opacity-95 text-white text-sm font-semibold rounded-lg transition shadow-sm shrink-0 cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        + Adicionar motorista
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
<form method="GET" action="{{ route('drivers.index') }}" class="relative w-64 md:w-72">
    <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-gray-400">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.637 10.637Z"/>
        </svg>
    </span>
    <input type="text"
           id="search"
           name="search"
           value="{{ $search ?? '' }}"
           placeholder="Pesquisar motorista"
           class="block w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
</form>
@endsection

@section('content')
<div class="flex flex-col flex-1 gap-0 -m-6">

    {{-- Filter Panel --}}
    <div id="filter-panel" class="{{ request()->hasAny(['name', 'registration']) ? '' : 'hidden' }} px-6 py-4 bg-gray-50 border-b border-gray-100">
        <form method="GET" action="{{ route('drivers.index') }}" class="flex flex-wrap items-end gap-4">
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Nome</label>
                <input type="text" name="name" value="{{ request('name') }}"
                       class="px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-coinpel-primary bg-white"
                       placeholder="Ex: Carlos...">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Matrícula</label>
                <input type="text" name="registration" value="{{ request('registration') }}"
                       class="px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-coinpel-primary bg-white"
                       placeholder="Ex: 12548793">
            </div>
            <button type="submit"
                    class="px-4 py-2 bg-coinpel-primary text-white text-sm font-semibold rounded-lg hover:opacity-95 transition cursor-pointer">
                Aplicar filtros
            </button>
            <a href="{{ route('drivers.index') }}"
               class="px-4 py-2 bg-white border border-gray-300 text-gray-600 text-sm font-semibold rounded-lg hover:bg-gray-50 transition">
                Limpar
            </a>
        </form>
    </div>

    {{-- Card Grid / Main Body --}}
    <div class="flex-1 p-6 bg-coinpel-bg">
        @if($drivers->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 bg-white border border-gray-100 rounded-2xl">
                <div class="flex items-center justify-center w-14 h-14 bg-purple-50 text-coinpel-primary rounded-full mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-800">Nenhum motorista cadastrado</h3>
                <p class="text-sm text-gray-500 mt-1 max-w-xs text-center">Não encontramos motoristas que correspondam aos filtros ou critérios de busca informados.</p>
                <button id="btn-add-driver-empty" class="mt-4 px-4 py-2 bg-coinpel-primary hover:bg-coinpel-primary-dark text-white text-sm font-semibold rounded-lg transition shadow-sm cursor-pointer">
                    Adicionar motorista
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($drivers as $driver)
                    <div class="relative p-6 bg-white border border-gray-100/80 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:border-coinpel-primary/20 hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] rounded-2xl flex items-center justify-between transition group">
                        
                        <div class="flex items-center gap-6">
                            @if($driver->profile_photo_path)
                                <img src="{{ Storage::url($driver->profile_photo_path) }}" alt="{{ $driver->name }}" class="w-[82px] h-[82px] rounded-full object-cover border border-gray-100 shrink-0 shadow-sm">
                            @else
                                <div class="flex items-center justify-center w-[82px] h-[82px] rounded-full bg-coinpel-primary/10 text-coinpel-primary font-bold text-2xl uppercase border border-coinpel-primary/20 shrink-0 shadow-sm">
                                    {{ substr($driver->name, 0, 2) }}
                                </div>
                            @endif
                            <div class="flex flex-col justify-center">
                                <h3 class="font-bold text-coinpel-font-tertiary text-lg leading-tight">{{ $driver->name }}</h3>
                                <span class="text-sm text-coinpel-font-primary mt-1">{{ $driver->email }}</span>
                                <span class="text-xs text-coinpel-font-primary/80 mt-1.5 block">Matrícula: {{ $driver->registration }} &nbsp;•&nbsp; Tel: {{ $driver->phone }}</span>
                            </div>
                        </div>

                        {{-- Dropdown de Ações --}}
                        <div class="absolute top-5 right-5 driver-actions-wrapper">
                            <button class="driver-actions-btn p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-50 transition focus:outline-none cursor-pointer">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                                </svg>
                            </button>
                            <div class="driver-actions-menu hidden absolute right-0 mt-1.5 w-44 bg-white border border-gray-100 rounded-xl shadow-lg py-1.5 z-10">
                                <button type="button"
                                        class="btn-edit-driver w-full text-left px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-gray-50 transition cursor-pointer flex items-center gap-2"
                                        data-id="{{ $driver->id }}"
                                        data-name="{{ $driver->name }}"
                                        data-birth_date="{{ $driver->birth_date?->format('Y-m-d') }}"
                                        data-registration="{{ $driver->registration }}"
                                        data-cpf="{{ $driver->cpf }}"
                                        data-rg="{{ $driver->rg }}"
                                        data-zip_code="{{ $driver->zip_code }}"
                                        data-street="{{ $driver->street }}"
                                        data-number="{{ $driver->number }}"
                                        data-city="{{ $driver->city }}"
                                        data-state="{{ $driver->state }}"
                                        data-email="{{ $driver->email }}"
                                        data-phone="{{ $driver->phone }}"
                                        data-photo_url="{{ $driver->profile_photo_path ? Storage::url($driver->profile_photo_path) : '' }}">
                                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                                    </svg>
                                    Editar motorista
                                </button>
                                <button type="button"
                                        class="btn-delete-driver w-full text-left px-4 py-2.5 text-xs font-semibold text-red-600 hover:bg-red-50 transition cursor-pointer flex items-center gap-2"
                                        data-id="{{ $driver->id }}"
                                        data-name="{{ $driver->name }}">
                                    <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.34 9m-4.78 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                    </svg>
                                    Deletar motorista
                                </button>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
            
            {{-- Paginação --}}
            <div class="mt-8 px-2">
                {{ $drivers->links() }}
            </div>
        @endif
    </div>

</div>

{{-- Sliding Drawer Overlay --}}
<div id="drawer-overlay" class="fixed inset-0 bg-black/40 z-40 hidden opacity-0 transition-opacity duration-300"></div>

{{-- Sliding Drawer --}}
<div id="driver-drawer" class="fixed inset-y-0 right-0 w-[480px] bg-white z-50 shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col h-full">
    
    {{-- Drawer Header --}}
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 shrink-0">
        <div class="flex items-center gap-2">
            <h2 class="text-lg font-bold text-gray-800">Motorista</h2>
            <button id="drawer-delete" class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition shrink-0 hidden cursor-pointer" title="Excluir motorista">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.34 9m-4.78 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                </svg>
            </button>
        </div>
        <button id="drawer-close" class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-50 transition cursor-pointer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Error Display --}}
    <div id="drawer-error" class="hidden mx-6 mt-4 p-4 bg-red-50 border border-red-200 rounded-lg text-sm text-red-800 font-medium shrink-0"></div>

    {{-- Drawer Scrollable Content --}}
    <div class="flex-1 overflow-y-auto px-6 py-4 space-y-6">
        
        {{-- Section 1: Personal Info --}}
        <div>
            <h3 class="text-xs font-bold text-coinpel-primary uppercase tracking-wider mb-4">Informações Pessoais</h3>
            <div class="grid grid-cols-1 gap-4">
                
                {{-- Profile Photo Upload --}}
                <div class="flex items-center gap-4">
                    <div id="avatar-preview-container" class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 text-lg uppercase font-bold overflow-hidden border border-gray-200 shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z"/>
                        </svg>
                    </div>
                    <div>
                        <label for="field-photo" class="block text-xs font-semibold text-gray-700 hover:text-coinpel-primary transition cursor-pointer bg-white border border-gray-300 rounded-lg px-3 py-1.5 shadow-sm text-center">
                            Escolher foto
                        </label>
                        <input id="field-photo" name="profile_photo" type="file" accept="image/*" class="hidden">
                        <p class="text-[10px] text-gray-400 mt-1">PNG, JPG de até 2MB</p>
                        <p id="err-profile-photo" class="hidden mt-1 text-xs text-red-600"></p>
                    </div>
                </div>

                {{-- Name --}}
                <div>
                    <label for="field-name" class="block text-xs font-semibold text-gray-500 mb-1.5">Nome:</label>
                    <input id="field-name" name="name" type="text" required
                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                           placeholder="Ex: Carlos Silva">
                    <p id="err-name" class="hidden mt-1 text-xs text-red-600"></p>
                </div>

                {{-- Email & Phone --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="field-email" class="block text-xs font-semibold text-gray-500 mb-1.5">E-mail:</label>
                        <input id="field-email" name="email" type="email" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                               placeholder="Ex: carlos@coinpel.com">
                        <p id="err-email" class="hidden mt-1 text-xs text-red-600"></p>
                    </div>
                    <div>
                        <label for="field-phone" class="block text-xs font-semibold text-gray-500 mb-1.5">Telefone:</label>
                        <input id="field-phone" name="phone" type="text" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                               placeholder="Ex: (53) 99123-4567">
                        <p id="err-phone" class="hidden mt-1 text-xs text-red-600"></p>
                    </div>
                </div>

                {{-- Matrícula & Birth Date --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="field-registration" class="block text-xs font-semibold text-gray-500 mb-1.5">Matrícula:</label>
                        <input id="field-registration" name="registration" type="text" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                               placeholder="Ex: 12548793">
                        <p id="err-registration" class="hidden mt-1 text-xs text-red-600"></p>
                    </div>
                    <div>
                        <label for="field-birth-date" class="block text-xs font-semibold text-gray-500 mb-1.5">Nascimento:</label>
                        <input id="field-birth-date" name="birth_date" type="date" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
                        <p id="err-birth-date" class="hidden mt-1 text-xs text-red-600"></p>
                    </div>
                </div>

                {{-- CPF & RG --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="field-cpf" class="block text-xs font-semibold text-gray-500 mb-1.5">CPF:</label>
                        <input id="field-cpf" name="cpf" type="text" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                               placeholder="Ex: 123.456.789-00">
                        <p id="err-cpf" class="hidden mt-1 text-xs text-red-600"></p>
                    </div>
                    <div>
                        <label for="field-rg" class="block text-xs font-semibold text-gray-500 mb-1.5">RG:</label>
                        <input id="field-rg" name="rg" type="text" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                               placeholder="Ex: 1234567890">
                        <p id="err-rg" class="hidden mt-1 text-xs text-red-600"></p>
                    </div>
                </div>

            </div>
        </div>

        {{-- Section 2: Address --}}
        <div class="pt-6 border-t border-gray-100">
            <h3 class="text-xs font-bold text-coinpel-primary uppercase tracking-wider mb-4">Endereço</h3>
            <div class="grid grid-cols-1 gap-4">
                
                {{-- CEP & Cidade --}}
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-1">
                        <label for="field-zip-code" class="block text-xs font-semibold text-gray-500 mb-1.5">CEP:</label>
                        <input id="field-zip-code" name="zip_code" type="text" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                               placeholder="Ex: 96010-000">
                        <p id="err-zip-code" class="hidden mt-1 text-xs text-red-600"></p>
                    </div>
                    <div class="col-span-2">
                        <label for="field-city" class="block text-xs font-semibold text-gray-500 mb-1.5">Cidade:</label>
                        <input id="field-city" name="city" type="text" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                               placeholder="Ex: Pelotas">
                        <p id="err-city" class="hidden mt-1 text-xs text-red-600"></p>
                    </div>
                </div>

                {{-- Rua & Número & Estado --}}
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-7">
                        <label for="field-street" class="block text-xs font-semibold text-gray-500 mb-1.5">Rua:</label>
                        <input id="field-street" name="street" type="text" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                               placeholder="Ex: Av. Bento Gonçalves">
                        <p id="err-street" class="hidden mt-1 text-xs text-red-600"></p>
                    </div>
                    <div class="col-span-3">
                        <label for="field-number" class="block text-xs font-semibold text-gray-500 mb-1.5">Número:</label>
                        <input id="field-number" name="number" type="text" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                               placeholder="Ex: 1234">
                        <p id="err-number" class="hidden mt-1 text-xs text-red-600"></p>
                    </div>
                    <div class="col-span-2">
                        <label for="field-state" class="block text-xs font-semibold text-gray-500 mb-1.5">UF:</label>
                        <input id="field-state" name="state" type="text" required maxlength="2"
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition uppercase"
                               placeholder="RS">
                        <p id="err-state" class="hidden mt-1 text-xs text-red-600"></p>
                    </div>
                </div>

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
    const drawer      = document.getElementById('driver-drawer');
    const btnAdd      = document.getElementById('btn-add-driver');
    const btnAddEmpty = document.getElementById('btn-add-driver-empty');
    const btnClose    = document.getElementById('drawer-close');
    const btnCancel   = document.getElementById('drawer-cancel');
    const btnSubmit   = document.getElementById('drawer-submit');
    const btnDelete   = document.getElementById('drawer-delete');
    const drawerError = document.getElementById('drawer-error');

    const filePhoto    = document.getElementById('field-photo');
    const previewContainer = document.getElementById('avatar-preview-container');

    const fields = {
        name:         document.getElementById('field-name'),
        email:        document.getElementById('field-email'),
        phone:        document.getElementById('field-phone'),
        registration: document.getElementById('field-registration'),
        birth_date:   document.getElementById('field-birth-date'),
        cpf:          document.getElementById('field-cpf'),
        rg:           document.getElementById('field-rg'),
        zip_code:     document.getElementById('field-zip-code'),
        city:         document.getElementById('field-city'),
        street:       document.getElementById('field-street'),
        number:       document.getElementById('field-number'),
        state:        document.getElementById('field-state'),
    };

    // ── Photo Preview ───────────────────────────────────────────────────
    filePhoto.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewContainer.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
            }
            reader.readAsDataURL(file);
        }
    });

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

            if (data.photo_url) {
                previewContainer.innerHTML = `<img src="${data.photo_url}" class="w-full h-full object-cover">`;
            } else {
                const initials = data.name ? data.name.substring(0, 2) : 'MO';
                previewContainer.innerHTML = initials;
            }

            btnDelete.classList.remove('hidden');
            btnSubmit.textContent = 'Salvar alterações';
        } else {
            btnDelete.classList.add('hidden');
            btnSubmit.textContent = 'Finalizar cadastro';
            previewContainer.innerHTML = `<svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z"/></svg>`;
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

    // ── Reset form ──────────────────────────────────────────────────────
    function resetForm() {
        Object.values(fields).forEach(f => { if (f) f.value = ''; });
        filePhoto.value = '';
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
            name:         'err-name',
            email:        'err-email',
            phone:        'err-phone',
            registration: 'err-registration',
            birth_date:   'err-birth-date',
            cpf:          'err-cpf',
            rg:           'err-rg',
            zip_code:     'err-zip-code',
            city:         'err-city',
            street:       'err-street',
            number:       'err-number',
            state:        'err-state',
            profile_photo: 'err-profile-photo',
        };
        Object.entries(errors).forEach(([key, msgs]) => {
            const errEl = document.getElementById(map[key]);
            const fieldEl = fields[key] || (key === 'profile_photo' ? filePhoto : null);
            if (errEl) {
                errEl.textContent = Array.isArray(msgs) ? msgs[0] : msgs;
                errEl.classList.remove('hidden');
            }
            if (fieldEl && fieldEl.classList) {
                fieldEl.classList.add('border-red-400');
            }
        });
    }

    // ── Submit ───────────────────────────────────────────────────────────
    btnSubmit.addEventListener('click', async function () {
        clearErrors();
        drawerError.classList.add('hidden');

        const isEdit = editingId !== null;
        const url    = isEdit ? '/drivers/' + editingId : '/drivers';

        const formData = new FormData();
        Object.keys(fields).forEach(key => {
            if (fields[key]) formData.append(key, fields[key].value);
        });

        if (filePhoto.files[0]) {
            formData.append('profile_photo', filePhoto.files[0]);
        }

        if (isEdit) {
            formData.append('_method', 'PATCH');
        }

        btnSubmit.disabled = true;
        btnSubmit.textContent = 'Salvando...';

        try {
            const response = await fetch(url, {
                method: 'POST', // always POST when sending files, overridden by Laravel _method
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: formData,
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
        if (!confirm('Confirma a exclusão deste motorista?')) return;

        btnDelete.disabled = true;
        try {
            const response = await fetch('/drivers/' + editingId, {
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

    // ── Delete from card actions ──────────────────────────────────────────
    document.querySelectorAll('.btn-delete-driver').forEach(btn => {
        btn.addEventListener('click', async function () {
            const id   = btn.dataset.id;
            const name = btn.dataset.name;
            if (!confirm(`Confirma a exclusão do motorista ${name}?`)) return;

            try {
                const response = await fetch('/drivers/' + id, {
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

    // ── Edit from card actions ────────────────────────────────────────────
    document.querySelectorAll('.btn-edit-driver').forEach(btn => {
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
        document.querySelectorAll('.driver-actions-menu').forEach(m => m.classList.add('hidden'));
    }

    document.querySelectorAll('.driver-actions-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const menu = btn.closest('.driver-actions-wrapper').querySelector('.driver-actions-menu');
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
