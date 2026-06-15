@extends('layouts.app')

@section('page-title', 'Pacotes')

@section('header-left')
<div class="flex items-center gap-3">
    <button id="btn-add-package"
            class="inline-flex items-center gap-2 px-4 py-2 bg-coinpel-primary hover:opacity-95 text-white text-sm font-semibold rounded-lg transition shadow-sm shrink-0 cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Adicionar pacote
    </button>
</div>
@endsection

@section('header-right-action')
<div class="relative w-64 md:w-72">
    <input type="text"
           id="search"
           name="search"
           value="{{ $search ?? '' }}"
           placeholder="Pesquisar pacote..."
           class="block w-full pl-4 pr-10 py-2 border border-gray-200 rounded-lg text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
    <span class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-400">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.637 10.637Z"/>
        </svg>
    </span>
</div>
@endsection

@section('content')
<div class="flex flex-col flex-1 gap-0 -m-6">

    {{-- Main Container --}}
    <div id="packages-container" class="flex-1 p-6 bg-coinpel-bg">
        @if($packages->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 bg-white border border-gray-100 rounded-2xl shadow-sm">
                <div class="flex items-center justify-center w-14 h-14 bg-purple-50 text-coinpel-primary rounded-full mb-3 animate-pulse">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 .621-.504 1.125-1.125 1.125H4.875A1.125 1.125 0 0 1 3.75 18.4V14.15m16.5 0a9 9 0 0 0-16.5 0m16.5 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 14.15M12 3.75V1.5m0 0a1.125 1.125 0 0 1 1.125 1.125V3.75m-1.125-2.25a1.125 1.125 0 0 0-1.125 1.125V3.75m1.125 0h.75A2.25 2.25 0 0 1 15 6v2.25H9V6a2.25 2.25 0 0 1 2.25-2.25h.75"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-800">Nenhum pacote cadastrado ainda.</h3>
                <p class="text-sm text-gray-500 mt-1 max-w-xs text-center">Não encontramos pacotes que correspondam à sua pesquisa ou não há cadastros.</p>
                <button id="btn-add-package-empty" class="mt-4 px-4 py-2 bg-coinpel-primary hover:opacity-95 text-white text-sm font-semibold rounded-lg transition shadow-sm cursor-pointer">
                    Adicionar pacote
                </button>
            </div>
        @else
            <div id="packages-grid" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($packages as $package)
                    <div class="package-card relative p-6 bg-white border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:border-coinpel-primary/20 hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] rounded-2xl flex items-center justify-between transition group cursor-pointer" data-id="{{ $package->id }}">
                        
                        <div class="flex items-center gap-6">
                            <div class="flex items-center justify-center w-[82px] h-[82px] rounded-full bg-coinpel-primary/10 text-coinpel-primary border border-coinpel-primary/20 shrink-0 shadow-sm">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M20.25 14.15v4.25c0 .621-.504 1.125-1.125 1.125H4.875A1.125 1.125 0 0 1 3.75 18.4V14.15m16.5 0a9 9 0 0 0-16.5 0m16.5 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 14.15M12 3.75V1.5m0 0a1.125 1.125 0 0 1 1.125 1.125V3.75m-1.125-2.25a1.125 1.125 0 0 0-1.125 1.125V3.75m1.125 0h.75A2.25 2.25 0 0 1 15 6v2.25H9V6a2.25 2.25 0 0 1 2.25-2.25h.75" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="flex flex-col justify-center">
                                <h3 class="font-bold text-coinpel-font-tertiary text-lg leading-tight">{{ $package->name }}</h3>
                                <span class="text-sm font-bold text-coinpel-primary mt-1">R$ {{ number_format($package->price, 2, ',', '.') }}</span>
                                
                                {{-- Badges --}}
                                <div class="flex flex-wrap gap-1.5 mt-2">
                                    {{-- Status Badge --}}
                                    @if($package->status === 'available')
                                        <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-bold text-emerald-700 bg-emerald-50 rounded-full border border-emerald-200">Disponível</span>
                                    @elseif($package->status === 'sold_out')
                                        <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-bold text-amber-700 bg-amber-50 rounded-full border border-amber-200">Esgotado</span>
                                    @elseif($package->status === 'inactive')
                                        <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-bold text-gray-500 bg-gray-50 rounded-full border border-gray-200">Inativo</span>
                                    @endif

                                    {{-- Feature Badges --}}
                                    @if($package->includes_hotel)
                                        <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-semibold text-blue-700 bg-blue-50 rounded-full border border-blue-200">Hotel Incluso</span>
                                    @endif
                                    @if($package->includes_meals)
                                        <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-semibold text-orange-700 bg-orange-50 rounded-full border border-orange-200">Refeições</span>
                                    @endif
                                    @if($package->includes_guide)
                                        <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-semibold text-indigo-700 bg-indigo-50 rounded-full border border-indigo-200">Guia Incluso</span>
                                    @endif
                                </div>

                                <span class="text-xs text-gray-500 mt-2 block">
                                    Viagem: {{ $package->trip ? $package->trip->name : 'Nenhuma vinculada' }}
                                </span>
                            </div>
                        </div>

                        {{-- Action Menu --}}
                        <div class="absolute top-5 right-5 package-actions-wrapper">
                            <button class="package-actions-btn p-1.5 text-gray-400 hover:text-gray-655 rounded-lg hover:bg-gray-50 transition focus:outline-none cursor-pointer">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                                </svg>
                            </button>
                            <div class="package-actions-menu hidden absolute right-0 mt-1.5 w-44 bg-white border border-gray-100 rounded-xl shadow-lg py-1.5 z-50">
                                <button type="button"
                                        class="btn-edit-package w-full text-left px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-gray-50 transition cursor-pointer flex items-center gap-2"
                                        data-id="{{ $package->id }}">
                                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                                    </svg>
                                    Editar pacote
                                </button>
                                @if($package->status !== 'inactive')
                                    <button type="button"
                                            class="btn-inactivate-package w-full text-left px-4 py-2.5 text-xs font-semibold text-amber-600 hover:bg-amber-50/50 transition cursor-pointer flex items-center gap-2"
                                            data-id="{{ $package->id }}">
                                        <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"/>
                                        </svg>
                                        Inativar pacote
                                    </button>
                                @endif
                                <button type="button"
                                        class="btn-delete-package w-full text-left px-4 py-2.5 text-xs font-semibold text-red-600 hover:bg-red-50 transition cursor-pointer flex items-center gap-2"
                                        data-id="{{ $package->id }}"
                                        data-name="{{ $package->name }}">
                                    <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.34 9m-4.78 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                    </svg>
                                    Deletar pacote
                                </button>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div id="packages-pagination" class="mt-8 px-2">
                {{ $packages->links() }}
            </div>
        @endif
    </div>

</div>

{{-- Drawer Overlay --}}
<div id="drawer-overlay" class="fixed inset-0 bg-black/40 z-40 hidden opacity-0 transition-opacity duration-300"></div>

{{-- Drawer Panel --}}
<div id="package-drawer" class="fixed inset-y-0 right-0 w-[480px] bg-white z-50 shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col h-full">
    
    {{-- Drawer Header --}}
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 shrink-0">
        <div class="flex items-center gap-2">
            <h2 id="drawer-title" class="text-lg font-bold text-gray-800">Novo pacote</h2>
            <button id="drawer-delete" class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition shrink-0 hidden cursor-pointer" title="Excluir pacote">
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

    {{-- Global Error Display --}}
    <div id="drawer-error" class="hidden mx-6 mt-4 p-4 bg-red-50 border border-red-200 rounded-lg text-sm text-red-800 font-medium shrink-0"></div>

    {{-- Drawer Scrollable Body --}}
    <div class="flex-1 overflow-y-auto px-6 py-4 space-y-5">
        
        {{-- Name --}}
        <div>
            <label for="field-name" class="block text-xs font-semibold text-gray-500 mb-1.5">Nome do pacote:</label>
            <input id="field-name" name="name" type="text" required
                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                   placeholder="Ex: Pacote Litoral Sul">
            <p id="err-name" class="hidden mt-1 text-xs text-red-600"></p>
        </div>

        {{-- Description --}}
        <div>
            <label for="field-description" class="block text-xs font-semibold text-gray-500 mb-1.5">Descrição:</label>
            <textarea id="field-description" name="description" rows="3"
                      class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition placeholder-gray-400"
                      placeholder="Descreva as atrações e detalhes do pacote..."></textarea>
            <p id="err-description" class="hidden mt-1 text-xs text-red-600"></p>
        </div>

        {{-- Trip selection --}}
        <div>
            <label for="field-trip_id" class="block text-xs font-semibold text-gray-500 mb-1.5">Viagem incluída:</label>
            <select id="field-trip_id" name="trip_id"
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-850 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition bg-white">
                <option value="">Selecione uma viagem</option>
                @foreach ($trips as $trip)
                    <option value="{{ $trip->id }}">{{ $trip->name }} ({{ $trip->origin }} → {{ $trip->destination }})</option>
                @endforeach
            </select>
            <p id="err-trip_id" class="hidden mt-1 text-xs text-red-600"></p>
        </div>

        {{-- Price & Max People --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="field-price" class="block text-xs font-semibold text-gray-500 mb-1.5">Preço (R$):</label>
                <input id="field-price" name="price" type="number" step="0.01" min="0" required
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                       placeholder="Ex: 850.00">
                <p id="err-price" class="hidden mt-1 text-xs text-red-600"></p>
            </div>
            <div>
                <label for="field-max_people" class="block text-xs font-semibold text-gray-500 mb-1.5">Capacidade máx. (pessoas):</label>
                <input id="field-max_people" name="max_people" type="number" min="1" required
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                       placeholder="Ex: 20">
                <p id="err-max_people" class="hidden mt-1 text-xs text-red-600"></p>
            </div>
        </div>

        {{-- Features Checkboxes --}}
        <div class="pt-4 border-t border-gray-100 space-y-3">
            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Serviços Inclusos</h4>
            
            <label class="flex items-center gap-2.5 cursor-pointer">
                <input id="field-includes_hotel" name="includes_hotel" type="checkbox"
                       class="w-4.5 h-4.5 rounded text-coinpel-primary focus:ring-coinpel-primary border-gray-300 transition">
                <span class="text-sm text-gray-700 font-medium">Hospedagem / Hotel</span>
            </label>

            <label class="flex items-center gap-2.5 cursor-pointer">
                <input id="field-includes_meals" name="includes_meals" type="checkbox"
                       class="w-4.5 h-4.5 rounded text-coinpel-primary focus:ring-coinpel-primary border-gray-300 transition">
                <span class="text-sm text-gray-700 font-medium">Refeições (Almoço/Jantar)</span>
            </label>

            <label class="flex items-center gap-2.5 cursor-pointer">
                <input id="field-includes_guide" name="includes_guide" type="checkbox"
                       class="w-4.5 h-4.5 rounded text-coinpel-primary focus:ring-coinpel-primary border-gray-300 transition">
                <span class="text-sm text-gray-700 font-medium">Guia de Turismo</span>
            </label>
        </div>

        {{-- Status --}}
        <div>
            <label for="field-status" class="block text-xs font-semibold text-gray-500 mb-1.5">Status:</label>
            <select id="field-status" name="status"
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-850 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition bg-white">
                <option value="available">Disponível</option>
                <option value="sold_out">Esgotado</option>
                <option value="inactive">Inativo</option>
            </select>
            <p id="err-status" class="hidden mt-1 text-xs text-red-600"></p>
        </div>

    </div>

    {{-- Drawer Footer --}}
    <div class="shrink-0 px-6 py-4 border-t border-gray-100 space-y-2">
        <button id="drawer-submit"
                class="w-full py-2.5 bg-coinpel-primary hover:opacity-95 text-white text-sm font-semibold rounded-lg transition cursor-pointer">
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
    'use strict';

    let editingId = null;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

    // Element Refs
    const overlay      = document.getElementById('drawer-overlay');
    const drawer       = document.getElementById('package-drawer');
    const drawerTitle  = document.getElementById('drawer-title');
    const btnAdd       = document.getElementById('btn-add-package');
    const btnAddEmpty  = document.getElementById('btn-add-package-empty');
    const btnClose     = document.getElementById('drawer-close');
    const btnCancel    = document.getElementById('drawer-cancel');
    const btnSubmit    = document.getElementById('drawer-submit');
    const btnDelete    = document.getElementById('drawer-delete');
    const drawerError  = document.getElementById('drawer-error');
    const searchEl     = document.getElementById('search');

    const fields = {
        name:           document.getElementById('field-name'),
        description:    document.getElementById('field-description'),
        trip_id:        document.getElementById('field-trip_id'),
        price:          document.getElementById('field-price'),
        max_people:     document.getElementById('field-max_people'),
        includes_hotel: document.getElementById('field-includes_hotel'),
        includes_meals: document.getElementById('field-includes_meals'),
        includes_guide: document.getElementById('field-includes_guide'),
        status:         document.getElementById('field-status'),
    };

    function formatCurrency(val) {
        const num = parseFloat(val);
        if (isNaN(num)) return 'R$ 0,00';
        return num.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    }

    function closeAllActionMenus() {
        document.querySelectorAll('.package-actions-menu').forEach(m => m.classList.add('hidden'));
    }

    function bindRowEvents() {
        // Toggle action dropdown menus
        document.querySelectorAll('.package-actions-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                const menu = btn.closest('.package-actions-wrapper').querySelector('.package-actions-menu');
                const isHidden = menu.classList.contains('hidden');
                closeAllActionMenus();
                if (isHidden) {
                    menu.classList.remove('hidden');
                }
            });
        });

        // Edit Package Click
        document.querySelectorAll('.btn-edit-package').forEach(btn => {
            btn.addEventListener('click', async function () {
                const id = btn.dataset.id;
                closeAllActionMenus();
                await openDrawer('edit', id);
            });
        });

        // Inactivate Package Click
        document.querySelectorAll('.btn-inactivate-package').forEach(btn => {
            btn.addEventListener('click', async function () {
                const id = btn.dataset.id;
                closeAllActionMenus();
                if (!confirm('Deseja realmente inativar este pacote?')) return;
                await updatePackageStatus(id, 'inactive');
            });
        });

        // Delete Package Click
        document.querySelectorAll('.btn-delete-package').forEach(btn => {
            btn.addEventListener('click', async function () {
                const id = btn.dataset.id;
                const name = btn.dataset.name;
                closeAllActionMenus();
                if (!confirm(`Deseja realmente excluir o pacote "${name}"?`)) return;
                await deletePackage(id);
            });
        });
    }

    // Drawer triggers
    async function openDrawer(mode, id = null) {
        editingId = id;
        clearErrors();
        resetForm();

        if (mode === 'edit') {
            drawerTitle.textContent = 'Editar pacote';
            btnSubmit.textContent = 'Salvar alterações';
            btnDelete.classList.remove('hidden');

            try {
                const response = await fetch(`/packages/${id}`, {
                    headers: { 'Accept': 'application/json' }
                });
                if (!response.ok) throw new Error('Erro ao carregar dados do pacote.');
                const res = await response.json();
                const p = res.package;

                fields.name.value = p.name || '';
                fields.description.value = p.description || '';
                fields.trip_id.value = p.trip_id || '';
                fields.price.value = p.price || '';
                fields.max_people.value = p.max_people || '';
                fields.includes_hotel.checked = !!p.includes_hotel;
                fields.includes_meals.checked = !!p.includes_meals;
                fields.includes_guide.checked = !!p.includes_guide;
                fields.status.value = p.status || 'available';

            } catch (err) {
                drawerError.textContent = err.message || 'Erro ao carregar o pacote.';
                drawerError.classList.remove('hidden');
            }
        } else {
            drawerTitle.textContent = 'Novo pacote';
            btnSubmit.textContent = 'Finalizar cadastro';
            btnDelete.classList.add('hidden');
            fields.status.value = 'available';
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

    function resetForm() {
        Object.keys(fields).forEach(key => {
            if (fields[key]) {
                if (fields[key].type === 'checkbox') {
                    fields[key].checked = false;
                } else {
                    fields[key].value = '';
                }
            }
        });
        drawerError.classList.add('hidden');
        drawerError.textContent = '';
    }

    function clearErrors() {
        document.querySelectorAll('[id^="err-"]').forEach(el => {
            el.classList.add('hidden');
            el.textContent = '';
        });
        Object.values(fields).forEach(f => {
            if (f && f.classList) {
                f.classList.remove('border-red-400', 'focus:ring-red-400');
            }
        });
    }

    function showErrors(errors) {
        const map = {
            name:           'err-name',
            description:    'err-description',
            trip_id:        'err-trip_id',
            price:          'err-price',
            max_people:     'err-max_people',
            status:         'err-status',
        };
        Object.entries(errors).forEach(([key, msgs]) => {
            const errEl = document.getElementById(map[key]);
            const fieldEl = fields[key];
            if (errEl) {
                errEl.textContent = Array.isArray(msgs) ? msgs[0] : msgs;
                errEl.classList.remove('hidden');
            }
            if (fieldEl && fieldEl.classList) {
                fieldEl.classList.add('border-red-400');
            }
        });
    }

    function collectFormData() {
        const data = {};
        Object.keys(fields).forEach(key => {
            if (fields[key]) {
                if (fields[key].type === 'checkbox') {
                    data[key] = fields[key].checked ? '1' : '0';
                } else {
                    data[key] = fields[key].value;
                }
            }
        });
        return data;
    }

    // Submit Drawer Data
    btnSubmit.addEventListener('click', async function () {
        clearErrors();
        drawerError.classList.add('hidden');

        // Frontend validation
        let hasFrontError = false;
        if (!fields.name.value.trim()) {
            document.getElementById('err-name').textContent = 'O nome do pacote é obrigatório.';
            document.getElementById('err-name').classList.remove('hidden');
            fields.name.classList.add('border-red-400');
            hasFrontError = true;
        }
        if (!fields.price.value.trim() || isNaN(parseFloat(fields.price.value))) {
            document.getElementById('err-price').textContent = 'O preço do pacote é obrigatório.';
            document.getElementById('err-price').classList.remove('hidden');
            fields.price.classList.add('border-red-400');
            hasFrontError = true;
        }

        if (hasFrontError) return;

        const data = collectFormData();
        const isEdit = editingId !== null;
        const url = isEdit ? `/packages/${editingId}` : '/packages';
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
                },
                body: JSON.stringify(data),
            });

            const json = await response.json();

            if (!response.ok) {
                if (response.status === 422 && json.errors) {
                    showErrors(json.errors);
                } else {
                    drawerError.textContent = json.message || 'Ocorreu um erro ao salvar o pacote.';
                    drawerError.classList.remove('hidden');
                }
                return;
            }

            showFlashNotification(json.message);
            closeDrawer();
            fetchPackages(searchEl.value);

        } catch (err) {
            drawerError.textContent = 'Erro de conexão. Tente novamente.';
            drawerError.classList.remove('hidden');
        } finally {
            btnSubmit.disabled = false;
            btnSubmit.textContent = isEdit ? 'Salvar alterações' : 'Finalizar cadastro';
        }
    });

    // Delete Package API
    async function deletePackage(id) {
        try {
            const response = await fetch(`/packages/${id}`, {
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
                showFlashNotification(json.message);
                closeDrawer();
                fetchPackages(searchEl.value);
            } else {
                alert(json.message || 'Erro ao excluir o pacote.');
            }
        } catch {
            alert('Erro de conexão ao excluir.');
        }
    }

    // Inactivate Package quickly
    async function updatePackageStatus(id, newStatus) {
        try {
            // First fetch complete details to preserve existing validated fields
            const getRes = await fetch(`/packages/${id}`, { headers: { 'Accept': 'application/json' } });
            const getData = await getRes.json();
            const payload = getData.package;

            payload.status = newStatus;
            payload['_method'] = 'PATCH';

            const patchRes = await fetch(`/packages/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(payload)
            });

            const json = await patchRes.json();
            if (patchRes.ok) {
                showFlashNotification(json.message);
                fetchPackages(searchEl.value);
            } else {
                alert(json.message || 'Erro ao atualizar o status do pacote.');
            }
        } catch (err) {
            alert('Erro de conexão ao atualizar status.');
        }
    }

    // Drawer delete trigger
    btnDelete.addEventListener('click', async function () {
        if (!editingId) return;
        const name = fields.name.value;
        if (!confirm(`Deseja realmente excluir o pacote "${name}"?`)) return;
        btnDelete.disabled = true;
        await deletePackage(editingId);
        btnDelete.disabled = false;
    });

    // Live Search
    async function fetchPackages(query = '') {
        try {
            const response = await fetch(`/packages?search=${encodeURIComponent(query)}`, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });
            if (!response.ok) throw new Error();
            const res = await response.json();

            // Handle pagination element visibility
            const paginationEl = document.getElementById('packages-pagination');
            if (query) {
                if (paginationEl) paginationEl.classList.add('hidden');
            } else {
                if (paginationEl) paginationEl.classList.remove('hidden');
            }

            renderGrid(res.packages);
        } catch (err) {
            console.error('Erro ao pesquisar pacotes:', err);
        }
    }

    // Render HTML card grid
    function renderGrid(packages) {
        const container = document.getElementById('packages-container');
        
        if (packages.length === 0) {
            container.innerHTML = `
                <div class="flex flex-col items-center justify-center py-16 bg-white border border-gray-100 rounded-2xl shadow-sm">
                    <div class="flex items-center justify-center w-14 h-14 bg-purple-50 text-coinpel-primary rounded-full mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 .621-.504 1.125-1.125 1.125H4.875A1.125 1.125 0 0 1 3.75 18.4V14.15m16.5 0a9 9 0 0 0-16.5 0m16.5 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 14.15M12 3.75V1.5m0 0a1.125 1.125 0 0 1 1.125 1.125V3.75m-1.125-2.25a1.125 1.125 0 0 0-1.125 1.125V3.75m1.125 0h.75A2.25 2.25 0 0 1 15 6v2.25H9V6a2.25 2.25 0 0 1 2.25-2.25h.75"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-800">Nenhum pacote cadastrado ainda.</h3>
                    <p class="text-sm text-gray-500 mt-1 max-w-xs text-center">Não encontramos pacotes que correspondam à sua pesquisa.</p>
                    ${!searchEl.value ? `
                    <button id="btn-add-package-empty" class="mt-4 px-4 py-2 bg-coinpel-primary hover:opacity-95 text-white text-sm font-semibold rounded-lg transition shadow-sm cursor-pointer">
                        Adicionar pacote
                    </button>
                    ` : ''}
                </div>
            `;

            const btnAddEmpty = document.getElementById('btn-add-package-empty');
            if (btnAddEmpty) {
                btnAddEmpty.addEventListener('click', () => openDrawer('create'));
            }
            return;
        }

        // Rebuild grid structure
        container.innerHTML = `<div id="packages-grid" class="grid grid-cols-1 lg:grid-cols-2 gap-6"></div>`;
        const grid = document.getElementById('packages-grid');

        packages.forEach(pkg => {
            const card = document.createElement('div');
            card.className = 'package-card relative p-6 bg-white border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:border-coinpel-primary/20 hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] rounded-2xl flex items-center justify-between transition group cursor-pointer';
            card.dataset.id = pkg.id;

            const tripLabel = pkg.trip ? pkg.trip.name : 'Nenhuma vinculada';
            const priceVal = formatCurrency(pkg.price);

            let statusBadge = '';
            if (pkg.status === 'available') {
                statusBadge = `<span class="inline-flex items-center px-2 py-0.5 text-[10px] font-bold text-emerald-700 bg-emerald-50 rounded-full border border-emerald-200">Disponível</span>`;
            } else if (pkg.status === 'sold_out') {
                statusBadge = `<span class="inline-flex items-center px-2 py-0.5 text-[10px] font-bold text-amber-700 bg-amber-50 rounded-full border border-amber-200">Esgotado</span>`;
            } else if (pkg.status === 'inactive') {
                statusBadge = `<span class="inline-flex items-center px-2 py-0.5 text-[10px] font-bold text-gray-500 bg-gray-50 rounded-full border border-gray-200">Inativo</span>`;
            }

            let hotelBadge = pkg.includes_hotel ? `<span class="inline-flex items-center px-2 py-0.5 text-[10px] font-semibold text-blue-700 bg-blue-50 rounded-full border border-blue-200">Hotel Incluso</span>` : '';
            let mealsBadge = pkg.includes_meals ? `<span class="inline-flex items-center px-2 py-0.5 text-[10px] font-semibold text-orange-700 bg-orange-50 rounded-full border border-orange-200">Refeições</span>` : '';
            let guideBadge = pkg.includes_guide ? `<span class="inline-flex items-center px-2 py-0.5 text-[10px] font-semibold text-indigo-700 bg-indigo-50 rounded-full border border-indigo-200">Guia Incluso</span>` : '';

            card.innerHTML = `
                <div class="flex items-center gap-6">
                    <div class="flex items-center justify-center w-[82px] h-[82px] rounded-full bg-coinpel-primary/10 text-coinpel-primary border border-coinpel-primary/20 shrink-0 shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M20.25 14.15v4.25c0 .621-.504 1.125-1.125 1.125H4.875A1.125 1.125 0 0 1 3.75 18.4V14.15m16.5 0a9 9 0 0 0-16.5 0m16.5 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 14.15M12 3.75V1.5m0 0a1.125 1.125 0 0 1 1.125 1.125V3.75m-1.125-2.25a1.125 1.125 0 0 0-1.125 1.125V3.75m1.125 0h.75A2.25 2.25 0 0 1 15 6v2.25H9V6a2.25 2.25 0 0 1 2.25-2.25h.75" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="flex flex-col justify-center">
                        <h3 class="font-bold text-coinpel-font-tertiary text-lg leading-tight">${pkg.name}</h3>
                        <span class="text-sm font-bold text-coinpel-primary mt-1">${priceVal}</span>
                        <div class="flex flex-wrap gap-1.5 mt-2">
                            ${statusBadge}
                            ${hotelBadge}
                            ${mealsBadge}
                            ${guideBadge}
                        </div>
                        <span class="text-xs text-gray-500 mt-2 block">
                            Viagem: ${tripLabel}
                        </span>
                    </div>
                </div>

                <div class="absolute top-5 right-5 package-actions-wrapper">
                    <button class="package-actions-btn p-1.5 text-gray-400 hover:text-gray-655 rounded-lg hover:bg-gray-50 transition focus:outline-none cursor-pointer">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                        </svg>
                    </button>
                    <div class="package-actions-menu hidden absolute right-0 mt-1.5 w-44 bg-white border border-gray-100 rounded-xl shadow-lg py-1.5 z-50">
                        <button type="button" class="btn-edit-package w-full text-left px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-gray-50 transition cursor-pointer flex items-center gap-2" data-id="${pkg.id}">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                            </svg>
                            Editar pacote
                        </button>
                        ${pkg.status !== 'inactive' ? `
                            <button type="button" class="btn-inactivate-package w-full text-left px-4 py-2.5 text-xs font-semibold text-amber-600 hover:bg-amber-50/50 transition cursor-pointer flex items-center gap-2" data-id="${pkg.id}">
                                <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                                Inativar pacote
                            </button>
                        ` : ''}
                        <button type="button" class="btn-delete-package w-full text-left px-4 py-2.5 text-xs font-semibold text-red-600 hover:bg-red-50 transition cursor-pointer flex items-center gap-2" data-id="${pkg.id}" data-name="${pkg.name}">
                            <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.34 9m-4.78 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                            </svg>
                            Deletar pacote
                        </button>
                    </div>
                </div>
            `;
            grid.appendChild(card);
        });

        bindRowEvents();
    }

    // Debounced Search Input
    let searchTimeout = null;
    searchEl.addEventListener('input', function (e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            fetchPackages(e.target.value);
        }, 300);
    });

    // Success notification
    function showFlashNotification(message) {
        const flashEl = document.createElement('div');
        flashEl.className = 'fixed bottom-6 right-6 z-[100] px-5 py-3.5 bg-green-600 text-white text-sm font-semibold rounded-xl shadow-lg flex items-center gap-3 animate-fade-in';
        flashEl.innerHTML = `<svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>${message}`;
        document.body.appendChild(flashEl);
        setTimeout(() => flashEl.remove(), 4000);
    }

    // Open/Close bindings
    if (btnAdd) btnAdd.addEventListener('click', () => openDrawer('create'));
    if (btnAddEmpty) btnAddEmpty.addEventListener('click', () => openDrawer('create'));

    btnClose.addEventListener('click', closeDrawer);
    btnCancel.addEventListener('click', closeDrawer);
    overlay.addEventListener('click', closeDrawer);
    document.addEventListener('click', closeAllActionMenus);

    // Initial binding
    bindRowEvents();

})();
</script>
@endpush
