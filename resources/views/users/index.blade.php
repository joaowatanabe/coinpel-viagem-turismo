@extends('layouts.app')

@section('page-title', 'Usuários')

@section('header-left')
<div class="flex items-center gap-3">
    <button id="btn-add-user"
            class="inline-flex items-center gap-2 px-4 py-2 bg-coinpel-primary hover:opacity-95 text-white text-sm font-semibold rounded-lg transition shadow-sm shrink-0 cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Adicionar usuário
    </button>
</div>
@endsection

@section('header-right-action')
<form method="GET" action="{{ route('users.index') }}" class="relative w-64 md:w-72">
    <input type="text"
           id="search"
           name="search"
           value="{{ $search ?? '' }}"
           placeholder="Pesquisar usuário"
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

    {{-- Table --}}
    <div class="flex-1 bg-white pb-12">
        <div class="overflow-visible relative">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Usuário</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">E-mail</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Senha</th>
                    <th class="px-6 py-3 w-14"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($users as $user)
                    <tr data-user-id="{{ $user->id }}" class="hover:bg-gray-50/60 transition {{ $user->is_blocked ? 'opacity-60' : '' }}">

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-gray-800 leading-tight">{{ $user->name }}</span>
                                @if(auth()->id() === $user->id)
                                    <span class="text-[10px] font-semibold text-coinpel-primary mt-0.5 leading-none">Você</span>
                                @endif
                            </div>
                        </td>

                        {{-- Email --}}
                        <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                            {{ $user->email }}
                        </td>

                        {{-- Status Badge --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->is_blocked)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold text-red-700 bg-red-50 rounded-full border border-red-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 shrink-0"></span>
                                    Bloqueado
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold text-green-700 bg-green-50 rounded-full border border-green-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 shrink-0"></span>
                                    Ativo
                                </span>
                            @endif
                        </td>

                        {{-- Must Change Password --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->must_change_password)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold text-amber-700 bg-amber-50 rounded-full border border-amber-200">
                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                                    </svg>
                                    Troca pendente
                                </span>
                            @else
                                <span class="text-xs text-gray-400 font-medium">—</span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="px-4 py-4 whitespace-nowrap text-right">
                            <div class="relative user-actions-wrapper inline-block">
                                <button class="user-actions-btn p-1.5 hover:bg-gray-100 text-gray-400 hover:text-gray-600 rounded-lg transition focus:outline-none cursor-pointer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                                    </svg>
                                </button>
                                <div class="user-actions-menu hidden absolute right-0 mt-1 w-48 bg-white border border-gray-100 rounded-xl shadow-lg py-1.5 z-50 text-left">

                                    {{-- Edit --}}
                                    <button type="button"
                                            class="btn-edit-user flex items-center gap-2.5 w-full text-left px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-gray-50 transition cursor-pointer"
                                            data-id="{{ $user->id }}"
                                            data-name="{{ $user->name }}"
                                            data-email="{{ $user->email }}"
                                            data-is_blocked="{{ $user->is_blocked ? '1' : '0' }}"
                                            data-photo_path="{{ $user->profile_photo_path }}"
                                            data-photo_url="{{ $user->profile_photo_path ? Storage::url($user->profile_photo_path) : '' }}">
                                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                                        </svg>
                                        Editar usuário
                                    </button>

                                    {{-- Block / Unblock (not for self) --}}
                                    @if(auth()->id() !== $user->id)
                                        <div class="h-px bg-gray-100 mx-2 my-1"></div>
                                        @if($user->is_blocked)
                                            <button type="button"
                                                    class="btn-toggle-block flex items-center gap-2.5 w-full text-left px-4 py-2.5 text-xs font-semibold text-green-700 hover:bg-green-50 transition cursor-pointer"
                                                    data-id="{{ $user->id }}"
                                                    data-name="{{ $user->name }}"
                                                    data-action="unblock">
                                                <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
                                                </svg>
                                                Desbloquear usuário
                                            </button>
                                        @else
                                            <button type="button"
                                                    class="btn-toggle-block flex items-center gap-2.5 w-full text-left px-4 py-2.5 text-xs font-semibold text-amber-700 hover:bg-amber-50 transition cursor-pointer"
                                                    data-id="{{ $user->id }}"
                                                    data-name="{{ $user->name }}"
                                                    data-action="block">
                                                <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
                                                </svg>
                                                Bloquear usuário
                                            </button>
                                        @endif

                                        <div class="h-px bg-gray-100 mx-2 my-1"></div>

                                        {{-- Delete --}}
                                        <button type="button"
                                                class="btn-delete-user flex items-center gap-2.5 w-full text-left px-4 py-2.5 text-xs font-semibold text-red-600 hover:bg-red-50 transition cursor-pointer"
                                                data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}">
                                            <svg class="w-4 h-4 text-red-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                            </svg>
                                            Excluir usuário
                                        </button>
                                    @endif

                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-gray-400">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                </svg>
                                <p class="text-sm font-medium">Nenhum usuário administrador encontrado.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>{{-- /overflow-x-auto --}}
    </div>

    {{-- Paginação --}}
    @if($users->hasPages())
        <div class="px-6 py-4 bg-white border-t border-gray-100">
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
            <h2 id="drawer-title" class="text-lg font-bold text-gray-800">Novo Usuário</h2>
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
    <div class="flex-1 overflow-y-auto px-6 py-6 space-y-5">

        {{-- Section: Dados --}}
        <div>
            <h3 class="text-xs font-bold text-coinpel-primary uppercase tracking-wider mb-4">Dados do administrador</h3>

            {{-- Name --}}
            <div class="mb-4">
                <label for="field-name" class="block text-xs font-semibold text-gray-500 mb-1.5">Nome:</label>
                <input id="field-name" name="name" type="text" required
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                       placeholder="Ex: Carlos Administrador">
                <p id="err-name" class="hidden mt-1 text-xs text-red-600"></p>
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label for="field-email" class="block text-xs font-semibold text-gray-500 mb-1.5">E-mail:</label>
                <input id="field-email" name="email" type="email" required
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                       placeholder="Ex: admin@coinpel.com">
                <p id="err-email" class="hidden mt-1 text-xs text-red-600"></p>
            </div>

            {{-- Password --}}
            <div>
                <label for="field-password" id="label-password" class="block text-xs font-semibold text-gray-500 mb-1.5">Senha provisória:</label>
                <div class="relative">
                    <input id="field-password" name="password" type="password"
                           class="w-full px-3 py-2.5 pr-10 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition"
                           placeholder="Mínimo 6 caracteres">
                    <button type="button" id="btn-toggle-password"
                            class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600 transition cursor-pointer">
                        <svg id="icon-eye" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        <svg id="icon-eye-slash" class="w-4 h-4 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"/>
                        </svg>
                    </button>
                </div>
                <p id="helper-password" class="text-[10px] text-gray-400 mt-1.5">O usuário deverá redefinir esta senha em seu primeiro acesso.</p>
                <p id="err-password" class="hidden mt-1 text-xs text-red-600"></p>
            </div>
        </div>

        {{-- Section: Status --}}
        <div id="status-container" class="pt-5 border-t border-gray-100">
            <h3 class="text-xs font-bold text-coinpel-primary uppercase tracking-wider mb-4">Status de acesso</h3>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Situação da conta:</label>
                <select id="field-is-blocked" name="is_blocked"
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition bg-white">
                    <option value="0">✅ Ativo — pode acessar o sistema</option>
                    <option value="1">🔒 Bloqueado — sem acesso ao sistema</option>
                </select>
                <p id="err-is-blocked" class="hidden mt-1 text-xs text-red-600"></p>
            </div>
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
    // ── State ───────────────────────────────────────────────────────────
    let editingId = null;
    const currentUserId = {{ auth()->id() }};
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content
                    || '{{ csrf_token() }}';

    // ── Element refs ────────────────────────────────────────────────────
    const overlay        = document.getElementById('drawer-overlay');
    const drawer         = document.getElementById('user-drawer');
    const drawerTitle    = document.getElementById('drawer-title');
    const btnAdd         = document.getElementById('btn-add-user');
    const btnClose       = document.getElementById('drawer-close');
    const btnCancel      = document.getElementById('drawer-cancel');
    const btnSubmit      = document.getElementById('drawer-submit');
    const btnDelete      = document.getElementById('drawer-delete');
    const drawerError    = document.getElementById('drawer-error');
    const labelPassword  = document.getElementById('label-password');
    const helperPassword = document.getElementById('helper-password');
    const statusContainer = document.getElementById('status-container');
    const btnTogglePass  = document.getElementById('btn-toggle-password');
    const fieldPassword  = document.getElementById('field-password');
    const iconEye        = document.getElementById('icon-eye');
    const iconEyeSlash   = document.getElementById('icon-eye-slash');

    const fields = {
        name:       document.getElementById('field-name'),
        email:      document.getElementById('field-email'),
        password:   fieldPassword,
        is_blocked: document.getElementById('field-is-blocked'),
    };

    // ── Password visibility toggle ───────────────────────────────────────
    btnTogglePass.addEventListener('click', function () {
        const isHidden = fieldPassword.type === 'password';
        fieldPassword.type = isHidden ? 'text' : 'password';
        iconEye.classList.toggle('hidden', isHidden);
        iconEyeSlash.classList.toggle('hidden', !isHidden);
    });

    // ── Photo functionality moved to global profile drawer ─────────────────────────

    // ── Drawer open/close ────────────────────────────────────────────────
    function openDrawer(mode, data) {
        editingId = mode === 'edit' ? data.id : null;

        clearErrors();
        resetForm();

        const filePhotoInput = document.getElementById('user-edit-photo-input');
        if (filePhotoInput) filePhotoInput.value = '';

        const wrap = document.getElementById('user-edit-avatar-wrap');
        const removeBtn = document.getElementById('user-remove-photo-btn');

        if (mode === 'edit') {
            drawerTitle.textContent = 'Editar Usuário';
            fields.name.value       = data.name  ?? '';
            fields.email.value      = data.email ?? '';
            fields.is_blocked.value = data.is_blocked ?? '0';
            fields.password.value   = '';

            labelPassword.textContent  = 'Nova senha provisória (opcional):';
            helperPassword.textContent = 'Deixe em branco para manter a senha atual.';

            if (parseInt(data.id) === currentUserId) {
                btnDelete.classList.add('hidden');
                statusContainer.classList.add('opacity-50', 'pointer-events-none');
            } else {
                btnDelete.classList.remove('hidden');
                statusContainer.classList.remove('opacity-50', 'pointer-events-none');
            }

            btnSubmit.textContent = 'Salvar alterações';
        } else {
            drawerTitle.textContent    = 'Novo Usuário';
            labelPassword.textContent  = 'Senha provisória:';
            helperPassword.textContent = 'O usuário deverá redefinir esta senha em seu primeiro acesso.';
            btnDelete.classList.add('hidden');
            statusContainer.classList.remove('opacity-50', 'pointer-events-none');
            btnSubmit.textContent = 'Finalizar cadastro';
        }

        window.userId = editingId;

        // Reset password visibility
        fieldPassword.type = 'password';
        iconEye.classList.remove('hidden');
        iconEyeSlash.classList.add('hidden');

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

    // ── Reset form ───────────────────────────────────────────────────────
    function resetForm() {
        Object.values(fields).forEach(f => { if (f) f.value = ''; });
        fields.is_blocked.value = '0';
        drawerError.classList.add('hidden');
        drawerError.textContent = '';
        const errPhoto = document.getElementById('err-profile-photo');
        if (errPhoto) {
            errPhoto.classList.add('hidden');
            errPhoto.textContent = '';
        }
    }

    // ── Error display ────────────────────────────────────────────────────
    function clearErrors() {
        document.querySelectorAll('[id^="err-"]').forEach(el => {
            el.classList.add('hidden');
            el.textContent = '';
        });
        Object.values(fields).forEach(f => {
            if (f) f.classList.remove('border-red-400');
        });
        const filePhotoInput = document.getElementById('user-edit-photo-input');
        if (filePhotoInput) filePhotoInput.classList.remove('border-red-400');
    }

    function showErrors(errors) {
        const filePhotoInput = document.getElementById('user-edit-photo-input');
        const map = {
            name:          'err-name',
            email:         'err-email',
            password:      'err-password',
            is_blocked:    'err-is-blocked',
            profile_photo: 'err-profile-photo',
        };
        Object.entries(errors).forEach(([key, msgs]) => {
            const errEl  = document.getElementById(map[key]);
            const fieldEl = fields[key] || (key === 'profile_photo' ? filePhotoInput : null);
            if (errEl) {
                errEl.textContent = Array.isArray(msgs) ? msgs[0] : msgs;
                errEl.classList.remove('hidden');
            }
            if (fieldEl) {
                fieldEl.classList.add('border-red-400');
            }
        });
    }

    // ── Submit ───────────────────────────────────────────────────────────
    btnSubmit.addEventListener('click', async function () {
        clearErrors();
        drawerError.classList.add('hidden');

        const isEdit = editingId !== null;
        const url    = isEdit ? '/users/' + editingId : '/users';
        const method = isEdit ? 'PATCH' : 'POST';

        const formData = new FormData();
        formData.append('name', fields.name.value);
        formData.append('email', fields.email.value);
        formData.append('password', fields.password.value);
        formData.append('is_blocked', fields.is_blocked.value);
        
        if (isEdit) {
            formData.append('_method', 'PATCH');
        }

        btnSubmit.disabled    = true;
        btnSubmit.textContent = 'Salvando...';

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-HTTP-Method-Override': method,
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

            if (isEdit) {
                // Update table row dynamically
                const user = json.user;
                const row = document.querySelector(`tr[data-user-id="${user.id}"]`);
                
                if (row) {
                    // Update Name
                    const nameEl = row.querySelector('.text-sm.font-bold');
                    if (nameEl) nameEl.textContent = user.name;
                    
                    // Update Email
                    const emailCol = row.querySelector('td:nth-child(2)');
                    if (emailCol) emailCol.textContent = user.email;

                    // Update Status
                    const statusCol = row.querySelector('td:nth-child(3)');
                    if (statusCol) {
                        if (user.is_blocked) {
                            statusCol.innerHTML = `
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold text-red-700 bg-red-50 rounded-full border border-red-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 shrink-0"></span>
                                    Bloqueado
                                </span>
                            `;
                            row.classList.add('opacity-60');
                        } else {
                            statusCol.innerHTML = `
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold text-green-700 bg-green-50 rounded-full border border-green-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 shrink-0"></span>
                                    Ativo
                                </span>
                            `;
                            row.classList.remove('opacity-60');
                        }
                    }

                    // Update dataset attributes on action button edit trigger
                    const btnEdit = row.querySelector('.btn-edit-user');
                    if (btnEdit) {
                        btnEdit.dataset.name = user.name;
                        btnEdit.dataset.email = user.email;
                        btnEdit.dataset.is_blocked = user.is_blocked ? '1' : '0';
                        btnEdit.dataset.photo_path = user.profile_photo_path || '';
                        btnEdit.dataset.photo_url = user.profile_photo_path ? `/storage/${user.profile_photo_path}` : '';
                    }
                }

                showFlashNotification(json.message);
                closeDrawer();
            } else {
                sessionStorage.setItem('flash_status', json.message);
                window.location.reload();
            }

        } catch (err) {
            drawerError.textContent = 'Erro de conexão. Tente novamente.';
            drawerError.classList.remove('hidden');
        } finally {
            btnSubmit.disabled    = false;
            btnSubmit.textContent = editingId ? 'Salvar alterações' : 'Finalizar cadastro';
        }
    });

    // ── Delete from drawer ───────────────────────────────────────────────
    btnDelete.addEventListener('click', async function () {
        if (!editingId || parseInt(editingId) === currentUserId) return;
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
                drawerError.textContent = json.message || 'Erro ao excluir. Tente novamente.';
                drawerError.classList.remove('hidden');
            }
        } catch {
            drawerError.textContent = 'Erro de conexão. Tente novamente.';
            drawerError.classList.remove('hidden');
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
            if (!confirm(`Confirma a exclusão do usuário "${name}"?`)) return;

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

    // ── Block / Unblock from row actions ─────────────────────────────────
    document.querySelectorAll('.btn-toggle-block').forEach(btn => {
        btn.addEventListener('click', async function () {
            const id     = btn.dataset.id;
            const name   = btn.dataset.name;
            const action = btn.dataset.action; // 'block' | 'unblock'
            const label  = action === 'block' ? 'bloquear' : 'desbloquear';

            if (!confirm(`Confirma ${label} o usuário "${name}"?`)) return;

            try {
                const response = await fetch('/users/' + id + '/toggle-block', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-HTTP-Method-Override': 'PATCH',
                    },
                    body: JSON.stringify({
                        _method: 'PATCH',
                        block: action === 'block',
                    }),
                });
                const json = await response.json();
                if (response.ok) {
                    sessionStorage.setItem('flash_status', json.message);
                    window.location.reload();
                } else {
                    alert(json.message || 'Erro ao processar. Tente novamente.');
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

    // Toast/Flash notification builder
    function showFlashNotification(message) {
        const flashEl = document.createElement('div');
        flashEl.className = 'fixed bottom-6 right-6 z-[100] px-5 py-3.5 bg-green-600 text-white text-sm font-semibold rounded-xl shadow-lg flex items-center gap-3 animate-fade-in';
        flashEl.innerHTML = `<svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>${message}`;
        document.body.appendChild(flashEl);
        setTimeout(() => flashEl.remove(), 4000);
    }

    window.showToast = function (message, type) {
        showFlashNotification(message);
    };

    // ── Flash from sessionStorage ──────────────────────────────────────────
    const flash = sessionStorage.getItem('flash_status');
    if (flash) {
        sessionStorage.removeItem('flash_status');
        showFlashNotification(flash);
    }

})();
</script>
@endpush

@endsection
