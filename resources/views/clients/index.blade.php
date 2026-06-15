@extends('layouts.app')

@section('page-title', 'Clientes')

@section('header-left')
<div class="flex items-center gap-3">
    <button id="btn-add-client"
            class="inline-flex items-center gap-2 px-4 py-2 bg-coinpel-primary hover:opacity-95 text-white text-sm font-semibold rounded-lg transition shadow-sm shrink-0 cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Adicionar cliente
    </button>
</div>
@endsection

@section('header-right-action')
<form method="GET" action="{{ route('customers.index') }}" class="relative w-64 md:w-72">
    <input type="text"
           id="search"
           name="search"
           value="{{ $search ?? '' }}"
           placeholder="Pesquisar cliente"
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

    {{-- Card Grid / Main Body --}}
    <div class="flex-1 p-6 bg-coinpel-bg">
        @if($clients->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 bg-white border border-gray-100 rounded-2xl">
                <div class="flex items-center justify-center w-14 h-14 bg-purple-50 text-coinpel-primary rounded-full mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-800">Nenhum cliente cadastrado ainda.</h3>
                <p class="text-sm text-gray-500 mt-1 max-w-xs text-center">Não encontramos clientes que correspondam aos critérios de busca informados.</p>
                <button id="btn-add-client-empty" class="mt-4 px-4 py-2 bg-coinpel-primary hover:bg-coinpel-primary-dark text-white text-sm font-semibold rounded-lg transition shadow-sm cursor-pointer">
                    Adicionar cliente
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($clients as $client)
                    <div class="client-card relative p-6 bg-white border border-gray-100/80 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:border-coinpel-primary/20 hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] rounded-2xl flex items-center justify-between transition group cursor-pointer" data-id="{{ $client->id }}">
                        
                        <div class="flex items-center gap-6">
                            @if($client->profile_photo_path)
                                <img src="{{ Storage::url($client->profile_photo_path) }}" alt="{{ $client->name }}" class="w-[82px] h-[82px] rounded-full object-cover border border-gray-100 shrink-0 shadow-sm">
                            @else
                                <div class="flex items-center justify-center w-[82px] h-[82px] rounded-full bg-coinpel-primary/10 text-coinpel-primary font-bold text-2xl uppercase border border-coinpel-primary/20 shrink-0 shadow-sm">
                                    {{ substr($client->name, 0, 2) }}
                                </div>
                            @endif
                            <div class="flex flex-col justify-center">
                                <h3 class="font-bold text-coinpel-font-tertiary text-lg leading-tight">{{ $client->name }}</h3>
                                <span class="text-sm text-coinpel-font-primary mt-1">{{ $client->email }}</span>
                                <span class="text-xs text-coinpel-font-primary/80 mt-1.5 block">CPF: {{ $client->cpf }} &nbsp;•&nbsp; Tel: {{ $client->phone }}</span>
                            </div>
                        </div>

                        {{-- Dropdown de Ações --}}
                        <div class="absolute top-5 right-5 client-actions-wrapper">
                            <button class="client-actions-btn p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-50 transition focus:outline-none cursor-pointer">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                                </svg>
                            </button>
                            <div class="client-actions-menu hidden absolute right-0 mt-1.5 w-44 bg-white border border-gray-100 rounded-xl shadow-lg py-1.5 z-50">
                                <button type="button"
                                        class="btn-edit-client w-full text-left px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-gray-50 transition cursor-pointer flex items-center gap-2"
                                        data-id="{{ $client->id }}"
                                        data-name="{{ $client->name }}"
                                        data-birth_date="{{ $client->birth_date?->format('Y-m-d') }}"
                                        data-cpf="{{ $client->cpf }}"
                                        data-zip_code="{{ $client->zip_code }}"
                                        data-street="{{ $client->street }}"
                                        data-number="{{ $client->number }}"
                                        data-city="{{ $client->city }}"
                                        data-state="{{ $client->state }}"
                                        data-email="{{ $client->email }}"
                                        data-phone="{{ $client->phone }}"
                                        data-photo_url="{{ $client->profile_photo_path ? Storage::url($client->profile_photo_path) : '' }}">
                                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                                    </svg>
                                    Editar cliente
                                </button>
                                <button type="button"
                                        class="btn-delete-client w-full text-left px-4 py-2.5 text-xs font-semibold text-red-600 hover:bg-red-50 transition cursor-pointer flex items-center gap-2"
                                        data-id="{{ $client->id }}"
                                        data-name="{{ $client->name }}">
                                    <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.34 9m-4.78 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                    </svg>
                                    Deletar cliente
                                </button>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
            
            {{-- Paginação --}}
            <div class="mt-8 px-2">
                {{ $clients->links() }}
            </div>
        @endif
    </div>

</div>

{{-- Sliding Drawer Overlay --}}
<div id="drawer-overlay" class="fixed inset-0 bg-black/40 z-40 hidden opacity-0 transition-opacity duration-300"></div>

{{-- Sliding Drawer --}}
<div id="client-drawer" class="fixed inset-y-0 right-0 w-[480px] bg-white z-50 shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col h-full">
    
    {{-- Drawer Header --}}
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 shrink-0">
        <div class="flex items-center gap-2">
            <h2 class="text-lg font-bold text-gray-800">Cliente</h2>
            <button id="drawer-delete" class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition shrink-0 hidden cursor-pointer" title="Excluir cliente">
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
                           placeholder="Ex: Ana Souza">
                    <p id="err-name" class="hidden mt-1 text-xs text-red-600"></p>
                </div>

                {{-- Email & Phone --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="field-email" class="block text-xs font-semibold text-gray-500 mb-1.5">E-mail:</label>
                        <input id="field-email" name="email" type="email" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                               placeholder="Ex: ana@exemplo.com">
                        <p id="err-email" class="hidden mt-1 text-xs text-red-600"></p>
                    </div>
                    <div>
                        <label for="field-phone" class="block text-xs font-semibold text-gray-500 mb-1.5">Telefone:</label>
                        <input id="field-phone" name="phone" type="text" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                               placeholder="Ex: (53) 98765-4321">
                        <p id="err-phone" class="hidden mt-1 text-xs text-red-600"></p>
                    </div>
                </div>

                {{-- CPF & Birth Date --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="field-cpf" class="block text-xs font-semibold text-gray-500 mb-1.5">CPF:</label>
                        <input id="field-cpf" name="cpf" type="text" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                               placeholder="Ex: 987.654.321-00">
                        <p id="err-cpf" class="hidden mt-1 text-xs text-red-600"></p>
                    </div>
                    <div>
                        <label for="field-birth-date" class="block text-xs font-semibold text-gray-500 mb-1.5">Nascimento:</label>
                        <input id="field-birth-date" name="birth_date" type="date" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
                        <p id="err-birth-date" class="hidden mt-1 text-xs text-red-600"></p>
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
                        <label for="client_zip_code" class="block text-xs font-semibold text-gray-500 mb-1.5">CEP:</label>
                        <input id="client_zip_code" name="zip_code" type="text" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                               placeholder="Ex: 96010-000"
                               oninput="formatCepInput(this)"
                               onblur="fetchAddressByCep(this.value, 'client')">
                        <p id="err-client-zip-code" class="hidden mt-1 text-xs text-red-600"></p>
                    </div>
                    <div class="col-span-2">
                        <label for="client_city" class="block text-xs font-semibold text-gray-500 mb-1.5">Cidade:</label>
                        <input id="client_city" name="city" type="text" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                               placeholder="Ex: Pelotas">
                        <p id="err-client-city" class="hidden mt-1 text-xs text-red-600"></p>
                    </div>
                </div>

                {{-- Rua & Número & Estado --}}
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-7">
                        <label for="client_street" class="block text-xs font-semibold text-gray-500 mb-1.5">Rua:</label>
                        <input id="client_street" name="street" type="text" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                               placeholder="Ex: Rua Gonçalves Chaves">
                        <p id="err-client-street" class="hidden mt-1 text-xs text-red-600"></p>
                    </div>
                    <div class="col-span-3">
                        <label for="client_number" class="block text-xs font-semibold text-gray-500 mb-1.5">Número:</label>
                        <input id="client_number" name="number" type="text" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                               placeholder="Ex: 456">
                        <p id="err-client-number" class="hidden mt-1 text-xs text-red-600"></p>
                    </div>
                    <div class="col-span-2">
                        <label for="client_state" class="block text-xs font-semibold text-gray-500 mb-1.5">UF:</label>
                        <input id="client_state" name="state" type="text" required maxlength="2"
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition uppercase"
                               placeholder="RS">
                        <p id="err-client-state" class="hidden mt-1 text-xs text-red-600"></p>
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

{{-- Sliding Detail Drawer Overlay --}}
<div id="detail-drawer-overlay" class="fixed inset-0 bg-black/40 z-40 hidden opacity-0 transition-opacity duration-300"></div>

{{-- Sliding Detail Drawer --}}
<div id="client-detail-drawer" class="fixed inset-y-0 right-0 w-[480px] bg-white z-50 shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col h-full">
    
    {{-- Drawer Header --}}
    <div class="relative flex items-center justify-between px-6 py-4 border-b border-gray-100 shrink-0">
        <button id="detail-drawer-close" class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-50 transition cursor-pointer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
            </svg>
        </button>
        <h2 class="text-base font-bold text-gray-800 absolute left-1/2 -translate-x-1/2">Cliente</h2>
        <button id="detail-drawer-delete" class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition shrink-0 cursor-pointer" title="Excluir cliente">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.34 9m-4.78 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
            </svg>
        </button>
    </div>

    {{-- Error Display --}}
    <div id="detail-drawer-error" class="hidden mx-6 mt-4 p-4 bg-red-50 border border-red-200 rounded-lg text-sm text-red-800 font-medium shrink-0"></div>

    {{-- Drawer Scrollable Content --}}
    <div class="flex-1 overflow-y-auto px-6 py-6 space-y-6">
        
        {{-- Profile Photo --}}
        <div class="flex flex-col items-center gap-3">
            <div id="detail-avatar-container" class="w-[120px] h-[120px] rounded-full bg-coinpel-primary/10 text-coinpel-primary font-bold text-3xl uppercase border border-coinpel-primary/20 flex items-center justify-center overflow-hidden shadow-sm shrink-0">
                <!-- Imagem ou iniciais populadas dinamicamente -->
            </div>
            <div>
                <label for="detail-field-photo" class="text-sm font-semibold text-coinpel-primary hover:underline transition cursor-pointer">
                    Atualizar foto
                </label>
                <input id="detail-field-photo" name="profile_photo" type="file" accept="image/*" class="hidden">
            </div>
        </div>

        {{-- Seção: Dados pessoais --}}
        <div class="border-t border-gray-100 pt-5 section-container" id="section-personal">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xs font-bold text-coinpel-primary uppercase tracking-wider">Dados pessoais</h3>
                <button type="button" class="btn-edit-section p-1 text-gray-400 hover:text-coinpel-primary hover:bg-gray-50 rounded transition cursor-pointer" data-section="personal">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/>
                    </svg>
                </button>
            </div>
            
            {{-- View Mode --}}
            <div class="section-view space-y-3">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="block text-[10px] font-semibold text-gray-400 uppercase">Nome</span>
                        <span id="lbl-name" class="text-sm font-semibold text-gray-800 view-field" data-name="name">—</span>
                    </div>
                    <div>
                        <span class="block text-[10px] font-semibold text-gray-400 uppercase">Data de Nascimento</span>
                        <span id="lbl-birth_date" class="text-sm font-semibold text-gray-800 view-field" data-name="birth_date">—</span>
                    </div>
                </div>
                <div>
                    <span class="block text-[10px] font-semibold text-gray-400 uppercase">CPF</span>
                    <span id="lbl-cpf" class="text-sm font-semibold text-gray-800 view-field" data-name="cpf">—</span>
                </div>
            </div>

            {{-- Edit Mode --}}
            <div class="section-edit hidden space-y-4">
                <div>
                    <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">Nome</label>
                    <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
                    <p class="hidden mt-1 text-xs text-red-600 error-field" data-field="name"></p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">Nascimento</label>
                        <input type="date" name="birth_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
                        <p class="hidden mt-1 text-xs text-red-600 error-field" data-field="birth_date"></p>
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">CPF</label>
                        <input type="text" name="cpf" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
                        <p class="hidden mt-1 text-xs text-red-600 error-field" data-field="cpf"></p>
                    </div>
                </div>
                <div class="flex gap-2 justify-end pt-1">
                    <button type="button" class="btn-cancel-edit px-3 py-1.5 text-xs font-semibold text-gray-600 hover:bg-gray-100 rounded-lg transition cursor-pointer" data-section="personal">Cancelar</button>
                    <button type="button" class="btn-save-section px-3 py-1.5 text-xs font-semibold text-white bg-coinpel-primary hover:opacity-95 rounded-lg transition cursor-pointer" data-section="personal">Salvar</button>
                </div>
            </div>
        </div>

        {{-- Seção: Endereço --}}
        <div class="border-t border-gray-100 pt-5 section-container" id="section-address">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xs font-bold text-coinpel-primary uppercase tracking-wider">Endereço</h3>
                <button type="button" class="btn-edit-section p-1 text-gray-400 hover:text-coinpel-primary hover:bg-gray-50 rounded transition cursor-pointer" data-section="address">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/>
                    </svg>
                </button>
            </div>
            
            {{-- View Mode --}}
            <div class="section-view space-y-3">
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <span class="block text-[10px] font-semibold text-gray-400 uppercase">CEP</span>
                        <span id="lbl-zip_code" class="text-sm font-semibold text-gray-800 view-field" data-name="zip_code">—</span>
                    </div>
                    <div class="col-span-2">
                        <span class="block text-[10px] font-semibold text-gray-400 uppercase">Cidade/Estado</span>
                        <span id="lbl-city_state" class="text-sm font-semibold text-gray-800 view-field" data-name="city_state">—</span>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-2">
                        <span class="block text-[10px] font-semibold text-gray-400 uppercase">Endereço</span>
                        <span id="lbl-street" class="text-sm font-semibold text-gray-800 view-field" data-name="street">—</span>
                    </div>
                    <div>
                        <span class="block text-[10px] font-semibold text-gray-400 uppercase">Número</span>
                        <span id="lbl-number" class="text-sm font-semibold text-gray-800 view-field" data-name="number">—</span>
                    </div>
                </div>
            </div>

            {{-- Edit Mode --}}
            <div class="section-edit hidden space-y-4">
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">CEP</label>
                        <input type="text" name="zip_code" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                               oninput="formatCepInput(this)"
                               onblur="fetchAddressByCep(this.value, 'client_detail')">
                        <p class="hidden mt-1 text-xs text-red-600 error-field" data-field="zip_code"></p>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">Cidade</label>
                        <input type="text" name="city" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
                        <p class="hidden mt-1 text-xs text-red-600 error-field" data-field="city"></p>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-7">
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">Rua</label>
                        <input type="text" name="street" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
                        <p class="hidden mt-1 text-xs text-red-600 error-field" data-field="street"></p>
                    </div>
                    <div class="col-span-3">
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">Número</label>
                        <input type="text" name="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
                        <p class="hidden mt-1 text-xs text-red-600 error-field" data-field="number"></p>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">UF</label>
                        <input type="text" name="state" maxlength="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition uppercase">
                        <p class="hidden mt-1 text-xs text-red-600 error-field" data-field="state"></p>
                    </div>
                </div>
                <div class="flex gap-2 justify-end pt-1">
                    <button type="button" class="btn-cancel-edit px-3 py-1.5 text-xs font-semibold text-gray-600 hover:bg-gray-100 rounded-lg transition cursor-pointer" data-section="address">Cancelar</button>
                    <button type="button" class="btn-save-section px-3 py-1.5 text-xs font-semibold text-white bg-coinpel-primary hover:opacity-95 rounded-lg transition cursor-pointer" data-section="address">Salvar</button>
                </div>
            </div>
        </div>

        {{-- Seção: Contato --}}
        <div class="border-t border-gray-100 pt-5 section-container" id="section-contact">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xs font-bold text-coinpel-primary uppercase tracking-wider">Contato</h3>
                <button type="button" class="btn-edit-section p-1 text-gray-400 hover:text-coinpel-primary hover:bg-gray-50 rounded transition cursor-pointer" data-section="contact">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/>
                    </svg>
                </button>
            </div>
            
            {{-- View Mode --}}
            <div class="section-view space-y-3">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="block text-[10px] font-semibold text-gray-400 uppercase">E-mail</span>
                        <span id="lbl-email" class="text-sm font-semibold text-gray-800 view-field" data-name="email">—</span>
                    </div>
                    <div>
                        <span class="block text-[10px] font-semibold text-gray-400 uppercase">Telefone</span>
                        <span id="lbl-phone" class="text-sm font-semibold text-gray-800 view-field" data-name="phone">—</span>
                    </div>
                </div>
            </div>

            {{-- Edit Mode --}}
            <div class="section-edit hidden space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">E-mail</label>
                        <input type="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
                        <p class="hidden mt-1 text-xs text-red-600 error-field" data-field="email"></p>
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">Telefone</label>
                        <input type="text" name="phone" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
                        <p class="hidden mt-1 text-xs text-red-600 error-field" data-field="phone"></p>
                    </div>
                </div>
                <div class="flex gap-2 justify-end pt-1">
                    <button type="button" class="btn-cancel-edit px-3 py-1.5 text-xs font-semibold text-gray-600 hover:bg-gray-100 rounded-lg transition cursor-pointer" data-section="contact">Cancelar</button>
                    <button type="button" class="btn-save-section px-3 py-1.5 text-xs font-semibold text-white bg-coinpel-primary hover:opacity-95 rounded-lg transition cursor-pointer" data-section="contact">Salvar</button>
                </div>
            </div>
        </div>
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
    const drawer      = document.getElementById('client-drawer');
    const btnAdd      = document.getElementById('btn-add-client');
    const btnAddEmpty = document.getElementById('btn-add-client-empty');
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
        birth_date:   document.getElementById('field-birth-date'),
        cpf:          document.getElementById('field-cpf'),
        zip_code:     document.getElementById('client_zip_code'),
        city:         document.getElementById('client_city'),
        street:       document.getElementById('client_street'),
        number:       document.getElementById('client_number'),
        state:        document.getElementById('client_state'),
    };

    // ── Detail Drawer Element refs ───────────────────────────────────────
    const detailOverlay = document.getElementById('detail-drawer-overlay');
    const detailDrawer  = document.getElementById('client-detail-drawer');
    const btnDetailClose = document.getElementById('detail-drawer-close');
    const btnDetailDelete = document.getElementById('detail-drawer-delete');
    const detailError   = document.getElementById('detail-drawer-error');
    const fileDetailPhoto = document.getElementById('detail-field-photo');
    const detailAvatarContainer = document.getElementById('detail-avatar-container');

    let currentClient = null;

    // ── Photo Preview ───────────────────────────────────────────────────
    filePhoto.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewContainer.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover rounded-full">`;
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
                previewContainer.innerHTML = `<img src="${data.photo_url}" class="w-full h-full object-cover rounded-full">`;
            } else {
                const initials = data.name ? data.name.substring(0, 2) : 'CL';
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
            birth_date:   'err-birth-date',
            cpf:          'err-cpf',
            zip_code:     'err-client-zip-code',
            city:         'err-client-city',
            street:       'err-client-street',
            number:       'err-client-number',
            state:        'err-client-state',
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
        const url    = isEdit ? '/customers/' + editingId : '/customers';

        const formData = new FormData();
        Object.keys(fields).forEach(key => {
            if (fields[key]) {
                let val = fields[key].value;
                if (key === 'zip_code') val = val.replace(/\D/g, '');
                formData.append(key, val);
            }
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
                method: 'POST',
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
        if (!confirm('Confirma a exclusão deste cliente?')) return;

        btnDelete.disabled = true;
        try {
            const response = await fetch('/customers/' + editingId, {
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
    document.querySelectorAll('.btn-delete-client').forEach(btn => {
        btn.addEventListener('click', async function () {
            const id   = btn.dataset.id;
            const name = btn.dataset.name;
            if (!confirm(`Confirma a exclusão do cliente ${name}?`)) return;

            try {
                const response = await fetch('/customers/' + id, {
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
    document.querySelectorAll('.btn-edit-client').forEach(btn => {
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
        document.querySelectorAll('.client-actions-menu').forEach(m => m.classList.add('hidden'));
    }

    document.querySelectorAll('.client-actions-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const menu = btn.closest('.client-actions-wrapper').querySelector('.client-actions-menu');
            closeAllActionMenus();
            menu.classList.toggle('hidden');
        });
    });

    document.addEventListener('click', closeAllActionMenus);

    // ── Detail Drawer Functions ──────────────────────────────────────────
    async function openDetailDrawer(clientId) {
        detailError.classList.add('hidden');
        detailError.textContent = '';
        
        document.querySelectorAll('#client-detail-drawer .section-edit').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('#client-detail-drawer .section-view').forEach(el => el.classList.remove('hidden'));
        document.querySelectorAll('#client-detail-drawer .error-field').forEach(el => {
            el.classList.add('hidden');
            el.textContent = '';
        });

        try {
            const response = await fetch(`/customers/${clientId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });
            if (!response.ok) throw new Error('Não foi possível carregar os dados do cliente.');
            const json = await response.json();
            currentClient = json.client;
            
            populateDetailFields();

            detailOverlay.classList.remove('hidden');
            setTimeout(() => detailOverlay.classList.add('opacity-100'), 10);
            detailDrawer.classList.remove('translate-x-full');
            document.body.style.overflow = 'hidden';

        } catch (err) {
            alert(err.message);
        }
    }

    function closeDetailDrawer() {
        detailDrawer.classList.add('translate-x-full');
        detailOverlay.classList.remove('opacity-100');
        setTimeout(() => detailOverlay.classList.add('hidden'), 300);
        document.body.style.overflow = '';
        currentClient = null;
    }

    function populateDetailFields() {
        if (!currentClient) return;

        let formattedBirthDate = '—';
        if (currentClient.birth_date) {
            const parts = currentClient.birth_date.split('T')[0].split('-');
            if (parts.length === 3) {
                formattedBirthDate = `${parts[2]}/${parts[1]}/${parts[0]}`;
            }
        }

        document.querySelector('#lbl-name').textContent = currentClient.name || '—';
        document.querySelector('#lbl-birth_date').textContent = formattedBirthDate;
        document.querySelector('#lbl-cpf').textContent = currentClient.cpf || '—';
        document.querySelector('#lbl-zip_code').textContent = currentClient.zip_code || '—';
        document.querySelector('#lbl-city_state').textContent = `${currentClient.city || '—'} / ${currentClient.state || '—'}`;
        document.querySelector('#lbl-street').textContent = currentClient.street || '—';
        document.querySelector('#lbl-number').textContent = currentClient.number || '—';
        document.querySelector('#lbl-email').textContent = currentClient.email || '—';
        document.querySelector('#lbl-phone').textContent = currentClient.phone || '—';

        const personalForm = document.querySelector('#section-personal .section-edit');
        const addressForm = document.querySelector('#section-address .section-edit');
        const contactForm = document.querySelector('#section-contact .section-edit');

        personalForm.querySelector('[name="name"]').value = currentClient.name || '';
        personalForm.querySelector('[name="birth_date"]').value = currentClient.birth_date ? currentClient.birth_date.split('T')[0] : '';
        personalForm.querySelector('[name="cpf"]').value = currentClient.cpf || '';

        addressForm.querySelector('[name="zip_code"]').value = currentClient.zip_code || '';
        addressForm.querySelector('[name="city"]').value = currentClient.city || '';
        addressForm.querySelector('[name="street"]').value = currentClient.street || '';
        addressForm.querySelector('[name="number"]').value = currentClient.number || '';
        addressForm.querySelector('[name="state"]').value = currentClient.state || '';

        contactForm.querySelector('[name="email"]').value = currentClient.email || '';
        contactForm.querySelector('[name="phone"]').value = currentClient.phone || '';

        if (currentClient.profile_photo_path) {
            const url = currentClient.profile_photo_path.startsWith('http') 
                ? currentClient.profile_photo_path 
                : `/storage/${currentClient.profile_photo_path}`;
            detailAvatarContainer.innerHTML = `<img src="${url}" class="w-full h-full object-cover rounded-full">`;
        } else {
            const initials = currentClient.name ? currentClient.name.substring(0, 2) : 'CL';
            detailAvatarContainer.innerHTML = initials;
        }
    }

    function clearDetailErrors() {
        document.querySelectorAll('#client-detail-drawer .error-field').forEach(el => {
            el.classList.add('hidden');
            el.textContent = '';
        });
        document.querySelectorAll('#client-detail-drawer input').forEach(el => {
            el.classList.remove('border-red-400');
        });
    }

    function showDetailErrors(errors) {
        Object.entries(errors).forEach(([key, msgs]) => {
            const input = detailDrawer.querySelector(`input[name="${key}"]`);
            if (input) {
                input.classList.add('border-red-400');
                const container = input.closest('div');
                if (container) {
                    const errEl = container.querySelector('.error-field');
                    if (errEl) {
                        errEl.textContent = Array.isArray(msgs) ? msgs[0] : msgs;
                        errEl.classList.remove('hidden');
                    }
                }
            }
        });
    }

    function updateCardInList(client) {
        const card = document.querySelector(`.client-card[data-id="${client.id}"]`);
        if (!card) return;

        const nameEl = card.querySelector('h3');
        if (nameEl) nameEl.textContent = client.name;

        const emailEl = card.querySelector('.text-coinpel-font-primary');
        if (emailEl) emailEl.textContent = client.email;

        const detailsEl = card.querySelector('.text-xs');
        if (detailsEl) {
            detailsEl.innerHTML = `CPF: ${client.cpf} &nbsp;•&nbsp; Tel: ${client.phone}`;
        }

        const imgContainer = card.querySelector('.flex.items-center.gap-6');
        if (imgContainer) {
            const img = imgContainer.querySelector('img');
            const initialsDiv = imgContainer.querySelector('.bg-coinpel-primary\\/10');
            
            const photoUrl = client.profile_photo_path 
                ? (client.profile_photo_path.startsWith('http') ? client.profile_photo_path : `/storage/${client.profile_photo_path}`)
                : null;
                
            if (photoUrl) {
                if (img) {
                    img.src = photoUrl;
                } else if (initialsDiv) {
                    initialsDiv.outerHTML = `<img src="${photoUrl}" alt="${client.name}" class="w-[82px] h-[82px] rounded-full object-cover border border-gray-100 shrink-0 shadow-sm">`;
                }
            } else {
                const initials = client.name ? client.name.substring(0, 2) : 'CL';
                if (initialsDiv) {
                    initialsDiv.textContent = initials;
                } else if (img) {
                    img.outerHTML = `<div class="flex items-center justify-center w-[82px] h-[82px] rounded-full bg-coinpel-primary/10 text-coinpel-primary font-bold text-2xl uppercase border border-coinpel-primary/20 shrink-0 shadow-sm">${initials}</div>`;
                }
            }
        }
    }

    // ── Detail Drawer Event Listeners ────────────────────────────────────
    document.querySelectorAll('.client-card').forEach(card => {
        card.addEventListener('click', function (e) {
            if (e.target.closest('.client-actions-wrapper')) {
                return;
            }
            const clientId = card.dataset.id;
            openDetailDrawer(clientId);
        });
    });

    btnDetailClose.addEventListener('click', closeDetailDrawer);
    detailOverlay.addEventListener('click', closeDetailDrawer);

    document.querySelectorAll('#client-detail-drawer .btn-edit-section').forEach(btn => {
        btn.addEventListener('click', function () {
            const section = btn.dataset.section;
            const container = document.getElementById(`section-${section}`);
            container.querySelector('.section-view').classList.add('hidden');
            container.querySelector('.section-edit').classList.remove('hidden');
        });
    });

    document.querySelectorAll('#client-detail-drawer .btn-cancel-edit').forEach(btn => {
        btn.addEventListener('click', function () {
            const section = btn.dataset.section;
            const container = document.getElementById(`section-${section}`);
            populateDetailFields();
            container.querySelector('.section-view').classList.remove('hidden');
            container.querySelector('.section-edit').classList.add('hidden');
        });
    });

    document.querySelectorAll('#client-detail-drawer .btn-save-section').forEach(btn => {
        btn.addEventListener('click', async function () {
            clearDetailErrors();
            detailError.classList.add('hidden');
            detailError.textContent = '';

            const section = btn.dataset.section;
            
            const data = {
                name: detailDrawer.querySelector('[name="name"]').value,
                birth_date: detailDrawer.querySelector('[name="birth_date"]').value,
                cpf: detailDrawer.querySelector('[name="cpf"]').value,
                zip_code: detailDrawer.querySelector('[name="zip_code"]').value.replace(/\D/g, ''),
                city: detailDrawer.querySelector('[name="city"]').value,
                street: detailDrawer.querySelector('[name="street"]').value,
                number: detailDrawer.querySelector('[name="number"]').value,
                state: detailDrawer.querySelector('[name="state"]').value,
                email: detailDrawer.querySelector('[name="email"]').value,
                phone: detailDrawer.querySelector('[name="phone"]').value,
                _method: 'PATCH'
            };

            btn.disabled = true;
            const originalText = btn.textContent;
            btn.textContent = 'Salvando...';

            try {
                const response = await fetch(`/customers/${currentClient.id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(data)
                });
                
                const json = await response.json();
                
                if (!response.ok) {
                    if (response.status === 422 && json.errors) {
                        showDetailErrors(json.errors);
                    } else {
                        detailError.textContent = json.message || 'Ocorreu um erro ao atualizar.';
                        detailError.classList.remove('hidden');
                    }
                    return;
                }

                currentClient = json.client;
                populateDetailFields();

                const container = document.getElementById(`section-${section}`);
                container.querySelector('.section-view').classList.remove('hidden');
                container.querySelector('.section-edit').classList.add('hidden');

                updateCardInList(currentClient);

            } catch (err) {
                detailError.textContent = 'Erro de conexão. Tente novamente.';
                detailError.classList.remove('hidden');
            } finally {
                btn.disabled = false;
                btn.textContent = originalText;
            }
        });
    });

    fileDetailPhoto.addEventListener('change', async function () {
        const file = this.files[0];
        if (!file) return;

        clearDetailErrors();
        detailError.classList.add('hidden');
        detailError.textContent = '';

        detailAvatarContainer.innerHTML = '<span class="text-xs font-semibold text-gray-500">Enviando...</span>';

        const formData = new FormData();
        formData.append('profile_photo', file);
        formData.append('name', currentClient.name || '');
        formData.append('birth_date', currentClient.birth_date ? currentClient.birth_date.split('T')[0] : '');
        formData.append('cpf', currentClient.cpf || '');
        formData.append('zip_code', currentClient.zip_code || '');
        formData.append('city', currentClient.city || '');
        formData.append('street', currentClient.street || '');
        formData.append('number', currentClient.number || '');
        formData.append('state', currentClient.state || '');
        formData.append('email', currentClient.email || '');
        formData.append('phone', currentClient.phone || '');
        formData.append('_method', 'PATCH');

        try {
            const response = await fetch(`/customers/${currentClient.id}`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            });

            const json = await response.json();

            if (!response.ok) {
                if (response.status === 422 && json.errors) {
                    showDetailErrors(json.errors);
                } else {
                    detailError.textContent = json.message || 'Ocorreu um erro ao atualizar a foto.';
                    detailError.classList.remove('hidden');
                }
                populateDetailFields();
                return;
            }

            currentClient = json.client;
            populateDetailFields();
            updateCardInList(currentClient);

        } catch (err) {
            detailError.textContent = 'Erro ao enviar foto. Tente novamente.';
            detailError.classList.remove('hidden');
            populateDetailFields();
        }
    });

    btnDetailDelete.addEventListener('click', async function () {
        if (!currentClient) return;
        if (!confirm(`Confirma a exclusão do cliente ${currentClient.name}?`)) return;

        btnDetailDelete.disabled = true;
        try {
            const response = await fetch('/customers/' + currentClient.id, {
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
            btnDetailDelete.disabled = false;
        }
    });

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

})();
</script>
@endpush

@endsection
