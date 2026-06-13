@extends('layouts.app')

@section('page-title', 'Usuários')

@section('header-left')
<div class="flex items-center gap-3">
    <button id="btn-add-user"
            class="inline-flex items-center gap-2 px-4 py-2 bg-coinpel-primary hover:opacity-95 text-white text-sm font-semibold rounded-lg transition shadow-sm shrink-0 cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        + Adicionar usuário
    </button>
</div>
@endsection

@section('header-right-action')
<form method="GET" action="{{ route('users.index') }}" class="relative w-64 md:w-72">
    <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-gray-400">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.637 10.637Z"/>
        </svg>
    </span>
    <input type="text"
           id="search"
           name="search"
           value="{{ $search ?? '' }}"
           placeholder="Pesquisar usuário"
           class="block w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
</form>
@endsection

@section('content')
<div class="flex flex-col gap-0 -m-6">

    {{-- Table --}}
    <div class="bg-white overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Usuário</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">E-mail</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status de Bloqueio</th>
                    <th class="px-6 py-3 w-12"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50/60 transition">
                        <td class="px-6 py-4 text-sm font-bold text-gray-800 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-coinpel-primary/10 text-coinpel-primary text-xs uppercase font-bold border border-coinpel-primary/20 shrink-0">
                                    {{ substr($user->name, 0, 2) }}
                                </span>
                                <span>{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-600 whitespace-nowrap">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                            @if($user->is_blocked)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold text-red-800 bg-red-50 rounded-full border border-red-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                                    Bloqueado
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold text-green-800 bg-green-50 rounded-full border border-green-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span>
                                    Ativo
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="relative user-actions-wrapper inline-block">
                                <button class="user-actions-btn p-1.5 hover:bg-gray-100 text-gray-400 hover:text-gray-600 rounded-lg transition focus:outline-none cursor-pointer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                                    </svg>
                                </button>
                                <div class="user-actions-menu hidden absolute right-0 mt-1 w-36 bg-white border border-gray-100 rounded-xl shadow-lg py-1.5 z-10 text-left">
                                    <button type="button"
                                            class="btn-edit-user w-full text-left px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 transition cursor-pointer"
                                            data-id="{{ $user->id }}"
                                            data-name="{{ $user->name }}"
                                            data-email="{{ $user->email }}"
                                            data-is_blocked="{{ $user->is_blocked ? '1' : '0' }}">
                                        Editar usuário
                                    </button>
                                    @if(auth()->id() !== $user->id)
                                        <button type="button"
                                                class="btn-delete-user w-full text-left px-4 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 transition cursor-pointer"
                                                data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}">
                                            Excluir usuário
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-sm text-gray-500">
                            Nenhum usuário administrador encontrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginação --}}
    @if($users->isNotEmpty())
        <div class="p-6 bg-white border-t border-gray-100">
            {{ $users->links() }}
        </div>
    @endif

</div>

{{-- Sliding Drawer Overlay --}}
<div id="drawer-overlay" class="fixed inset-0 bg-black/40 z-40 hidden opacity-0 transition-opacity duration-300"></div>

{{-- Sliding Drawer --}}
<div id="user-drawer" class="fixed inset-y-0 right-0 w-[440px] bg-white z-50 shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col h-full">
    
    {{-- Drawer Header --}}
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 shrink-0">
        <div class="flex items-center gap-2">
            <h2 class="text-lg font-bold text-gray-800">Usuário</h2>
            <button id="drawer-delete" class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition shrink-0 hidden cursor-pointer" title="Excluir usuário">
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
    <div class="flex-1 overflow-y-auto px-6 py-6 space-y-6">
        
        {{-- Name --}}
        <div>
            <label for="field-name" class="block text-xs font-semibold text-gray-500 mb-1.5">Nome:</label>
            <input id="field-name" name="name" type="text" required
                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                   placeholder="Ex: Admin Secundário">
            <p id="err-name" class="hidden mt-1 text-xs text-red-600"></p>
        </div>

        {{-- Email --}}
        <div>
            <label for="field-email" class="block text-xs font-semibold text-gray-500 mb-1.5">E-mail:</label>
            <input id="field-email" name="email" type="email" required
                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                   placeholder="Ex: admin.2@coinpel.com">
            <p id="err-email" class="hidden mt-1 text-xs text-red-600"></p>
        </div>

        {{-- Password --}}
        <div>
            <label for="field-password" id="label-password" class="block text-xs font-semibold text-gray-500 mb-1.5">Senha provisória:</label>
            <input id="field-password" name="password" type="text"
                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                   placeholder="Mínimo 6 caracteres">
            <p id="helper-password" class="text-[10px] text-gray-400 mt-1">O usuário deverá redefinir esta senha em seu primeiro acesso.</p>
            <p id="err-password" class="hidden mt-1 text-xs text-red-600"></p>
        </div>

        {{-- Blocked Status --}}
        <div id="status-container">
            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Status:</label>
            <select id="field-is-blocked" name="is_blocked"
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition bg-white">
                <option value="0">Ativo</option>
                <option value="1">Bloqueado</option>
            </select>
            <p id="err-is-blocked" class="hidden mt-1 text-xs text-red-600"></p>
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
    const currentUserId = {{ auth()->id() }};
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content
                    || '{{ csrf_token() }}';

    // ── Element refs ────────────────────────────────────────────────────
    const overlay     = document.getElementById('drawer-overlay');
    const drawer      = document.getElementById('user-drawer');
    const btnAdd      = document.getElementById('btn-add-user');
    const btnClose    = document.getElementById('drawer-close');
    const btnCancel   = document.getElementById('drawer-cancel');
    const btnSubmit   = document.getElementById('drawer-submit');
    const btnDelete   = document.getElementById('drawer-delete');
    const drawerError = document.getElementById('drawer-error');

    const fields = {
        name:       document.getElementById('field-name'),
        email:      document.getElementById('field-email'),
        password:   document.getElementById('field-password'),
        is_blocked: document.getElementById('field-is-blocked'),
    };

    const labelPassword  = document.getElementById('label-password');
    const helperPassword = document.getElementById('helper-password');
    const statusContainer = document.getElementById('status-container');

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

            // Adjust password field behavior for edit
            labelPassword.textContent = 'Nova senha provisória (opcional):';
            helperPassword.textContent = 'Deixe em branco se não quiser redefinir a senha do usuário.';
            
            // Cannot delete or block yourself
            if (parseInt(data.id) === currentUserId) {
                btnDelete.classList.add('hidden');
                statusContainer.classList.add('opacity-50', 'pointer-events-none');
            } else {
                btnDelete.classList.remove('hidden');
                statusContainer.classList.remove('opacity-50', 'pointer-events-none');
            }

            btnSubmit.textContent = 'Salvar alterações';
        } else {
            labelPassword.textContent = 'Senha provisória:';
            helperPassword.textContent = 'O usuário deverá redefinir esta senha em seu primeiro acesso.';
            btnDelete.classList.add('hidden');
            statusContainer.classList.remove('opacity-50', 'pointer-events-none');
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

    // ── Reset form ──────────────────────────────────────────────────────
    function resetForm() {
        Object.values(fields).forEach(f => { if (f) f.value = ''; });
        fields.is_blocked.value = '0';
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
            name:       'err-name',
            email:      'err-email',
            password:   'err-password',
            is_blocked: 'err-is-blocked',
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
        return {
            name:       fields.name.value,
            email:      fields.email.value,
            password:   fields.password.value,
            is_blocked: fields.is_blocked.value,
        };
    }

    // ── Submit ───────────────────────────────────────────────────────────
    btnSubmit.addEventListener('click', async function () {
        clearErrors();
        drawerError.classList.add('hidden');

        const data = collectData();
        const isEdit = editingId !== null;
        const url    = isEdit ? '/users/' + editingId : '/users';
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
        if (editingId === currentUserId) return;
        if (!confirm('Confirma a exclusão deste usuário?')) return;

        btnDelete.disabled = true;
        try {
            const response = await fetch('/users/' + editingId, {
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

    // ── Delete from row actions ──────────────────────────────────────────
    document.querySelectorAll('.btn-delete-user').forEach(btn => {
        btn.addEventListener('click', async function () {
            const id   = btn.dataset.id;
            const name = btn.dataset.name;
            if (parseInt(id) === currentUserId) return;
            if (!confirm(`Confirma a exclusão do usuário ${name}?`)) return;

            try {
                const response = await fetch('/users/' + id, {
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

    // ── Edit from row actions ────────────────────────────────────────────
    document.querySelectorAll('.btn-edit-user').forEach(btn => {
        btn.addEventListener('click', function () {
            closeAllActionMenus();
            openDrawer('edit', btn.dataset);
        });
    });

    // ── Open events ───────────────────────────────────────────────────────
    if (btnAdd) btnAdd.addEventListener('click', () => openDrawer('create'));

    // ── Close events ──────────────────────────────────────────────────────
    btnClose.addEventListener('click', closeDrawer);
    btnCancel.addEventListener('click', closeDrawer);
    overlay.addEventListener('click', closeDrawer);

    // ── Action menus ──────────────────────────────────────────────────────
    function closeAllActionMenus() {
        document.querySelectorAll('.user-actions-menu').forEach(m => m.classList.add('hidden'));
    }

    document.querySelectorAll('.user-actions-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const menu = btn.closest('.user-actions-wrapper').querySelector('.user-actions-menu');
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

})();
</script>
@endpush

@endsection
