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
                    <div class="client-card bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center gap-4 cursor-pointer hover:shadow-md transition-shadow relative"
                         data-client-id="{{ $client->id }}">
                        
                        {{-- Avatar (Initials Only) --}}
                        <div class="flex items-center justify-center w-14 h-14 rounded-full bg-[#593E75] text-white font-bold text-lg uppercase shrink-0 shadow-sm">
                            {{ strtoupper(mb_substr($client->name, 0, 1)) }}{{ str_contains(trim($client->name), ' ') ? strtoupper(mb_substr(explode(' ', trim($client->name))[1], 0, 1)) : '' }}
                        </div>

                        {{-- Details --}}
                        <div class="flex flex-col justify-center min-w-0 flex-1 pr-8">
                            <h3 class="font-bold text-coinpel-font-tertiary text-base leading-tight truncate">{{ $client->name }}</h3>
                            <span class="text-xs text-coinpel-font-primary mt-0.5 truncate">{{ $client->email }}</span>
                            <span class="text-[11px] text-coinpel-font-primary/80 mt-1 block truncate">CPF: {{ $client->cpf }} &nbsp;•&nbsp; Tel: {{ $client->phone }}</span>
                        </div>

                        {{-- Botão "..." — DEVE ter a classe client-dropdown-btn --}}
                        <button class="client-dropdown-btn absolute top-3 right-3 p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-50 transition focus:outline-none cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                            </svg>
                        </button>
                        
                        {{-- Menu dropdown — DEVE ter a classe client-dropdown-menu hidden --}}
                        <div class="client-dropdown-menu hidden absolute top-8 right-3 bg-white shadow-lg rounded-lg border border-gray-100 z-50 min-w-[160px] py-1">
                            <button type="button"
                                    onclick="editClient({{ $client->id }}); event.stopPropagation();"
                                    class="w-full text-left px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 transition cursor-pointer flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                                </svg>
                                Editar cliente
                            </button>
                            <button type="button"
                                    onclick="deleteClient({{ $client->id }}, '{{ $client->name }}'); event.stopPropagation();"
                                    class="w-full text-left px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 transition cursor-pointer flex items-center gap-2">
                                <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.34 9m-4.78 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                </svg>
                                Excluir cliente
                            </button>
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
<div id="client-detail-drawer" 
     class="fixed inset-y-0 right-0 w-[420px] bg-white z-50 shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col h-full">
    <div id="client-detail-content"></div>
</div>

@push('scripts')
<script>
(function () {
    // ── State ───────────────────────────────────────────────────────────
    let editingId = null;
    let currentClient = null;
    let detailPhotoErrorTimeout = null;
    let photoErrorTimeout = null;
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

    const fields = {
        name: document.getElementById('field-name'),
        email: document.getElementById('field-email'),
        phone: document.getElementById('field-phone'),
        cpf: document.getElementById('field-cpf'),
        birth_date: document.getElementById('field-birth-date')
    };    // ── Drawer open/close ───────────────────────────────────────────────
    function openDrawer(mode, data) {
        editingId = mode === 'edit' ? data.id : null;

        // Reset
        clearErrors();
        resetForm();

        if (mode === 'edit') {
            Object.keys(fields).forEach(key => {
                if (fields[key]) fields[key].value = data[key] ?? '';
            });

            if (data.birth_date && fields.birth_date) {
                if (data.birth_date.includes('/')) {
                    const parts = data.birth_date.split('/');
                    if (parts.length === 3) {
                        fields.birth_date.value = `${parts[2]}-${parts[1]}-${parts[0]}`;
                    }
                } else {
                    fields.birth_date.value = data.birth_date.split('T')[0];
                }
            }

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

    function resetForm() {
        Object.keys(fields).forEach(key => {
            if (fields[key]) fields[key].value = '';
        });
    }

    function clearErrors() {
        drawerError.classList.add('hidden');
        drawerError.textContent = '';
        Object.keys(fields).forEach(key => {
            if (fields[key]) fields[key].classList.remove('border-red-400');
            const errEl = document.getElementById(`err-${key}`);
            if (errEl) {
                errEl.classList.add('hidden');
                errEl.textContent = '';
            }
        });
    }

    function showErrors(errors) {
        Object.entries(errors).forEach(([key, msgs]) => {
            if (fields[key]) fields[key].classList.add('border-red-400');
            const errEl = document.getElementById(`err-${key}`);
            if (errEl) {
                errEl.textContent = Array.isArray(msgs) ? msgs[0] : msgs;
                errEl.classList.remove('hidden');
            }
        });
    }

    btnSubmit.addEventListener('click', async function () {
        clearErrors();

        const formData = new FormData();
        Object.keys(fields).forEach(key => {
            if (fields[key]) {
                let val = fields[key].value;
                if (key === 'zip_code') val = val.replace(/\D/g, '');
                formData.append(key, val);
            }
        });

        const url = editingId ? `/customers/${editingId}` : '/customers';
        if (editingId) {
            formData.append('_method', 'PATCH');
        }

        btnSubmit.disabled = true;
        const originalText = btnSubmit.textContent;
        btnSubmit.textContent = 'Processando...';

        try {
            const response = await fetch(url, {
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
                    showErrors(json.errors);
                } else {
                    drawerError.textContent = json.message || 'Erro ao processar a requisição.';
                    drawerError.classList.remove('hidden');
                }
                return;
            }

            sessionStorage.setItem('flash_status', json.message);
            window.location.reload();

        } catch {
            drawerError.textContent = 'Erro de rede. Verifique sua conexão.';
            drawerError.classList.remove('hidden');
        } finally {
            btnSubmit.disabled = false;
            btnSubmit.textContent = originalText;
        }
    });

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

    window.editClient = async function (id) {
        closeAllActionMenus();
        try {
            const response = await fetch(`/customers/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });
            if (!response.ok) throw new Error('Não foi possível carregar os dados.');
            const client = await response.json();
            currentClient = client;
            openDrawer('edit', client);
        } catch (err) {
            alert(err.message);
        }
    };

    window.deleteClient = async function (id, name) {
        closeAllActionMenus();
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
    };

    if (btnAdd) btnAdd.addEventListener('click', () => openDrawer('create'));
    if (btnAddEmpty) btnAddEmpty.addEventListener('click', () => openDrawer('create'));

    btnClose.addEventListener('click', closeDrawer);
    btnCancel.addEventListener('click', closeDrawer);
    overlay.addEventListener('click', closeDrawer);

    function closeAllActionMenus() {
        document.querySelectorAll('.client-dropdown-menu').forEach(m => m.classList.add('hidden'));
    }

    // ── Document Event Delegation ─────────────────────────────────────────
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.client-dropdown-btn') && 
            !e.target.closest('.client-dropdown-menu')) {
            closeAllActionMenus();
        }

        const dropBtn = e.target.closest('.client-dropdown-btn');
        if (dropBtn) {
            e.stopPropagation();
            const menu = dropBtn.nextElementSibling;
            if (menu) {
                const isAlreadyOpen = !menu.classList.contains('hidden');
                closeAllActionMenus();
                if (!isAlreadyOpen) {
                    menu.classList.remove('hidden');
                }
            }
            return;
        }

        const card = e.target.closest('.client-card');
        if (card && !e.target.closest('.client-dropdown-btn') 
                 && !e.target.closest('.client-dropdown-menu')) {
            const clientId = card.dataset.clientId;
            openClientDetail(clientId);
            return;
        }

        if (e.target.closest('#detail-drawer-close')) {
            closeClientDetail();
            return;
        }

        if (e.target.closest('#detail-drawer-delete')) {
            if (currentClient) {
                deleteClient(currentClient.id, currentClient.name);
            }
            return;
        }

        const btnEditSec = e.target.closest('.btn-edit-section');
        if (btnEditSec) {
            const section = btnEditSec.dataset.section;
            const container = document.getElementById(`section-${section}`);
            if (container) {
                container.querySelector('.section-view').classList.add('hidden');
                container.querySelector('.section-edit').classList.remove('hidden');
            }
            return;
        }

        const btnCancelSec = e.target.closest('.btn-cancel-edit');
        if (btnCancelSec) {
            populateClientDetail(currentClient);
            return;
        }

        const btnSaveSec = e.target.closest('.btn-save-section');
        if (btnSaveSec) {
            const section = btnSaveSec.dataset.section;
            saveSectionData(section, btnSaveSec);
            return;
        }

        if (e.target.closest('#btn-delete-detail-photo')) {
            deleteDetailPhoto();
            return;
        }
    });

    document.addEventListener('change', function (e) {
        if (e.target.id === 'detail-field-photo') {
            uploadDetailPhoto(e.target);
        }
    });

    // ── Detail Drawer Functions ──────────────────────────────────────────
    window.openClientDetail = function (id) {
        const drawer = document.getElementById('client-detail-drawer');
        const overlay = document.getElementById('detail-drawer-overlay');
        
        drawer.classList.remove('hidden', 'translate-x-full');
        if (overlay) {
            overlay.classList.remove('hidden');
            setTimeout(() => overlay.classList.add('opacity-100'), 10);
        }
        document.body.style.overflow = 'hidden';
        
        document.getElementById('client-detail-content').innerHTML = `
            <div class="animate-pulse p-6 space-y-6">
                <div class="flex items-center justify-between">
                    <div class="h-8 w-8 bg-gray-200 rounded-full"></div>
                    <div class="h-6 w-24 bg-gray-200 rounded"></div>
                    <div class="h-8 w-8 bg-gray-200 rounded-full"></div>
                </div>
                <div class="flex flex-col items-center gap-3 pt-4">
                    <div class="w-[120px] h-[120px] rounded-full bg-gray-200"></div>
                    <div class="h-4 w-32 bg-gray-200 rounded"></div>
                </div>
                <div class="space-y-4 border-t border-gray-100 pt-6">
                    <div class="h-4 w-20 bg-gray-200 rounded mb-2"></div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="h-10 bg-gray-150 rounded"></div>
                        <div class="h-10 bg-gray-150 rounded"></div>
                    </div>
                </div>
            </div>
        `;
        
        fetch(`/customers/${id}`, {
            headers: { 
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(r => {
            if (!r.ok) throw new Error();
            return r.json();
        })
        .then(client => {
            populateClientDetail(client);
        })
        .catch(() => {
            document.getElementById('client-detail-content').innerHTML = `
                <div class="p-6 text-center">
                    <p class="text-red-500 font-medium mb-3">Erro ao carregar dados.</p>
                    <button onclick="openClientDetail(${id})" class="px-4 py-2 bg-coinpel-primary text-white text-xs font-semibold rounded-lg hover:opacity-90 transition">
                        Tentar novamente
                    </button>
                </div>
            `;
        });
    };

    function closeClientDetail() {
        const drawer = document.getElementById('client-detail-drawer');
        const overlay = document.getElementById('detail-drawer-overlay');
        
        drawer.classList.add('translate-x-full');
        if (overlay) {
            overlay.classList.remove('opacity-100');
            setTimeout(() => overlay.classList.add('hidden'), 300);
        }
        document.body.style.overflow = '';
        currentClient = null;
    }

    function populateClientDetail(client) {
        currentClient = client;

        const formattedBirthDate = client.birth_date || '—';
        let inputBirthDate = '';
        if (client.birth_date) {
            const parts = client.birth_date.split('/');
            if (parts.length === 3) {
                inputBirthDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
            }
        }

        const initials = client.initials || (client.name ? client.name.substring(0, 2).toUpperCase() : 'CL');

        const html = `
        <!-- Drawer Header -->
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

        <!-- Error Display -->
        <div id="detail-drawer-error" class="hidden mx-6 mt-4 p-4 bg-red-50 border border-red-200 rounded-lg text-sm text-red-800 font-medium shrink-0"></div>

        <!-- Drawer Scrollable Content -->
        <div class="flex-1 overflow-y-auto px-6 py-6 space-y-6">
            
            <!-- Profile Photo -->
            <div class="flex flex-col items-center gap-3">
                <div id="detail-avatar-container" class="w-[120px] h-[120px] rounded-full bg-[#593E75] text-white font-bold text-4xl uppercase border border-coinpel-primary/20 flex items-center justify-center overflow-hidden shadow-sm shrink-0">
                    ${initials}
                </div>
            </div>

            <!-- Seção: Dados pessoais -->
            <div class="border-t border-gray-100 pt-5 section-container" id="section-personal">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs font-bold text-coinpel-primary uppercase tracking-wider">Dados pessoais</h3>
                    <button type="button" class="btn-edit-section p-1 text-gray-400 hover:text-coinpel-primary hover:bg-gray-50 rounded transition cursor-pointer" data-section="personal">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/>
                        </svg>
                    </button>
                </div>
                
                <!-- View Mode -->
                <div class="section-view space-y-3">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="block text-[10px] font-semibold text-gray-400 uppercase">Nome</span>
                            <span id="lbl-name" class="text-sm font-semibold text-gray-800 view-field" data-name="name">${client.name || '—'}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] font-semibold text-gray-400 uppercase">Data de Nascimento</span>
                            <span id="lbl-birth_date" class="text-sm font-semibold text-gray-800 view-field" data-name="birth_date">${formattedBirthDate}</span>
                        </div>
                    </div>
                    <div>
                        <span class="block text-[10px] font-semibold text-gray-400 uppercase">CPF</span>
                        <span id="lbl-cpf" class="text-sm font-semibold text-gray-800 view-field" data-name="cpf">${client.cpf || '—'}</span>
                    </div>
                </div>

                <!-- Edit Mode -->
                <div class="section-edit hidden space-y-4">
                    <div>
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">Nome</label>
                        <input type="text" name="name" value="${client.name || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
                        <p class="hidden mt-1 text-xs text-red-600 error-field" data-field="name"></p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">Nascimento</label>
                            <input type="date" name="birth_date" value="${inputBirthDate}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
                            <p class="hidden mt-1 text-xs text-red-600 error-field" data-field="birth_date"></p>
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">CPF</label>
                            <input type="text" name="cpf" value="${client.cpf || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
                            <p class="hidden mt-1 text-xs text-red-600 error-field" data-field="cpf"></p>
                        </div>
                    </div>
                    <div class="flex gap-2 justify-end pt-1">
                        <button type="button" class="btn-cancel-edit px-3 py-1.5 text-xs font-semibold text-gray-600 hover:bg-gray-100 rounded-lg transition cursor-pointer" data-section="personal">Cancelar</button>
                        <button type="button" class="btn-save-section px-3 py-1.5 text-xs font-semibold text-white bg-coinpel-primary hover:opacity-95 rounded-lg transition cursor-pointer" data-section="personal">Salvar</button>
                    </div>
                </div>
            </div>

            <!-- Seção: Endereço -->
            <div class="border-t border-gray-100 pt-5 section-container" id="section-address">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs font-bold text-coinpel-primary uppercase tracking-wider">Endereço</h3>
                    <button type="button" class="btn-edit-section p-1 text-gray-400 hover:text-coinpel-primary hover:bg-gray-50 rounded transition cursor-pointer" data-section="address">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/>
                        </svg>
                    </button>
                </div>
                
                <!-- View Mode -->
                <div class="section-view space-y-3">
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <span class="block text-[10px] font-semibold text-gray-400 uppercase">CEP</span>
                            <span id="lbl-zip_code" class="text-sm font-semibold text-gray-800 view-field" data-name="zip_code">${client.zip_code || '—'}</span>
                        </div>
                        <div class="col-span-2">
                            <span class="block text-[10px] font-semibold text-gray-400 uppercase">Cidade/Estado</span>
                            <span id="lbl-city_state" class="text-sm font-semibold text-gray-800 view-field" data-name="city_state">${client.city || '—'} / ${client.state || '—'}</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-2">
                            <span class="block text-[10px] font-semibold text-gray-400 uppercase">Endereço</span>
                            <span id="lbl-street" class="text-sm font-semibold text-gray-800 view-field" data-name="street">${client.street || '—'}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] font-semibold text-gray-400 uppercase">Número</span>
                            <span id="lbl-number" class="text-sm font-semibold text-gray-800 view-field" data-name="number">${client.number || '—'}</span>
                        </div>
                    </div>
                </div>

                <!-- Edit Mode -->
                <div class="section-edit hidden space-y-4">
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">CEP</label>
                            <input type="text" name="zip_code" value="${client.zip_code || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                                   oninput="formatCepInput(this)"
                                   onblur="fetchAddressByCep(this.value, 'client_detail')">
                            <p class="hidden mt-1 text-xs text-red-600 error-field" data-field="zip_code"></p>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">Cidade</label>
                            <input type="text" name="city" value="${client.city || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
                            <p class="hidden mt-1 text-xs text-red-600 error-field" data-field="city"></p>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-7">
                            <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">Rua</label>
                            <input type="text" name="street" value="${client.street || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
                            <p class="hidden mt-1 text-xs text-red-600 error-field" data-field="street"></p>
                        </div>
                        <div class="col-span-3">
                            <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">Número</label>
                            <input type="text" name="number" value="${client.number || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
                            <p class="hidden mt-1 text-xs text-red-600 error-field" data-field="number"></p>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">UF</label>
                            <input type="text" name="state" value="${client.state || ''}" maxlength="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition uppercase">
                            <p class="hidden mt-1 text-xs text-red-600 error-field" data-field="state"></p>
                        </div>
                    </div>
                    <div class="flex gap-2 justify-end pt-1">
                        <button type="button" class="btn-cancel-edit px-3 py-1.5 text-xs font-semibold text-gray-600 hover:bg-gray-100 rounded-lg transition cursor-pointer" data-section="address">Cancelar</button>
                        <button type="button" class="btn-save-section px-3 py-1.5 text-xs font-semibold text-white bg-coinpel-primary hover:opacity-95 rounded-lg transition cursor-pointer" data-section="address">Salvar</button>
                    </div>
                </div>
            </div>

            <!-- Seção: Contato -->
            <div class="border-t border-gray-100 pt-5 section-container" id="section-contact">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs font-bold text-coinpel-primary uppercase tracking-wider">Contato</h3>
                    <button type="button" class="btn-edit-section p-1 text-gray-400 hover:text-coinpel-primary hover:bg-gray-50 rounded transition cursor-pointer" data-section="contact">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/>
                        </svg>
                    </button>
                </div>
                
                <!-- View Mode -->
                <div class="section-view space-y-3">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="block text-[10px] font-semibold text-gray-400 uppercase">E-mail</span>
                            <span id="lbl-email" class="text-sm font-semibold text-gray-800 view-field" data-name="email">${client.email || '—'}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] font-semibold text-gray-400 uppercase">Telefone</span>
                            <span id="lbl-phone" class="text-sm font-semibold text-gray-800 view-field" data-name="phone">${client.phone || '—'}</span>
                        </div>
                    </div>
                </div>

                <!-- Edit Mode -->
                <div class="section-edit hidden space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">E-mail</label>
                            <input type="email" name="email" value="${client.email || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
                            <p class="hidden mt-1 text-xs text-red-600 error-field" data-field="email"></p>
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-400 uppercase mb-1">Telefone</label>
                            <input type="text" name="phone" value="${client.phone || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
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
        `;

        document.getElementById('client-detail-content').innerHTML = html;
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
        const detailDrawer = document.getElementById('client-detail-drawer');
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
        const card = document.querySelector(`.client-card[data-client-id="${client.id}"]`);
        if (!card) return;

        const nameEl = card.querySelector('h3');
        if (nameEl) nameEl.textContent = client.name;

        const emailEl = card.querySelector('.text-coinpel-font-primary');
        if (emailEl) emailEl.textContent = client.email;

        const detailsEl = card.querySelector('.text-xs, .text-\\[11px\\]');
        if (detailsEl) {
            detailsEl.innerHTML = `CPF: ${client.cpf} &nbsp;•&nbsp; Tel: ${client.phone}`;
        }

        const initialsDiv = card.querySelector('.bg-\\[\\#593E75\\]');
        if (initialsDiv) {
            const initials = client.initials || (client.name ? client.name.substring(0, 2).toUpperCase() : 'CL');
            initialsDiv.textContent = initials;
        }
    }

    async function saveSectionData(section, btn) {
        clearDetailErrors();
        const detailError = document.getElementById('detail-drawer-error');
        const detailDrawer = document.getElementById('client-detail-drawer');
        if (detailError) {
            detailError.classList.add('hidden');
            detailError.textContent = '';
        }

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
                    if (detailError) {
                        detailError.textContent = json.message || 'Ocorreu um erro ao atualizar.';
                        detailError.classList.remove('hidden');
                    }
                }
                return;
            }

            const clientRes = await fetch(`/customers/${currentClient.id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });
            const freshClient = await clientRes.json();
            
            currentClient = freshClient;
            populateClientDetail(currentClient);
            updateCardInList(currentClient);

        } catch (err) {
            if (detailError) {
                detailError.textContent = 'Erro de conexão. Tente novamente.';
                detailError.classList.remove('hidden');
            }
        } finally {
            btn.disabled = false;
            btn.textContent = originalText;
        }
    }



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
