@extends('layouts.app')

@section('page-title', 'Configurações')

@section('header-left')
<div class="flex items-center gap-3">
    <span class="text-sm font-bold text-gray-800 font-sans tracking-tight">Configurações</span>
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
<div class="max-w-4xl mx-auto space-y-8 pb-12">
    
    {{-- Seção: Informações da Empresa --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] p-6 md:p-8">
        <div class="flex items-center gap-3.5 mb-6">
            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-coinpel-primary/10 text-coinpel-primary shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5.5 h-5.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Informações da Empresa</h2>
                <p class="text-xs text-gray-400 font-medium mt-0.5">Dados institucionais da operadora de turismo</p>
            </div>
        </div>

        <form id="company-info-form" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="company_name" class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Razão Social</label>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                            </svg>
                        </div>
                        <input type="text" id="company_name" name="company_name" value="{{ $settings['company_name'] ?? '' }}" required
                               class="block w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
                    </div>
                </div>

                <div>
                    <label for="company_cnpj" class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">CNPJ</label>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 0 0 1 3.75 0Zm-1.218 5.33a3 3 0 0 0-3.047 0 2.406 2.406 0 0 0-1.235 2.085h5.518a2.406 2.406 0 0 0-1.236-2.085Z" />
                            </svg>
                        </div>
                        <input type="text" id="company_cnpj" name="company_cnpj" value="{{ $settings['company_cnpj'] ?? '' }}" required
                               class="block w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
                    </div>
                </div>

                <div>
                    <label for="company_email" class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">E-mail de Contato</label>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <input type="email" id="company_email" name="company_email" value="{{ $settings['company_email'] ?? '' }}" required
                               class="block w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
                    </div>
                </div>

                <div>
                    <label for="company_phone" class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Telefone</label>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.387a12.035 12.035 0 0 1-7.108-7.108c-.155-.44.01-1.03.387-1.312l1.293-.97a1.125 1.125 0 0 0 .417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                            </svg>
                        </div>
                        <input type="text" id="company_phone" name="company_phone" value="{{ $settings['company_phone'] ?? '' }}" required
                               class="block w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label for="company_address" class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Endereço Principal</label>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                        </div>
                        <input type="text" id="company_address" name="company_address" value="{{ $settings['company_address'] ?? '' }}" required
                               class="block w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-coinpel-primary focus:border-coinpel-primary transition">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" id="btn-save-company"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-coinpel-primary hover:opacity-95 text-white text-sm font-semibold rounded-lg transition shadow-sm cursor-pointer">
                    Salvar informações
                </button>
            </div>
        </form>
    </div>

    {{-- Seção: Preferências do Sistema --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] p-6 md:p-8">
        <div class="flex items-center gap-3.5 mb-6">
            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-coinpel-primary/10 text-coinpel-primary shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5.5 h-5.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 13.5V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m12-3V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m-6-9V3.75m0 3.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 9.75V10.5" />
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Preferências do Sistema</h2>
                <p class="text-xs text-gray-400 font-medium mt-0.5">Configurações globais de regras e alertas</p>
            </div>
        </div>

        <div class="space-y-6">
            {{-- Opção 1: Notificações por e-mail --}}
            <div class="flex items-center justify-between pb-5 border-b border-gray-100">
                <div class="max-w-xl pr-4">
                    <h3 class="text-sm font-bold text-gray-700">Notificações por e-mail</h3>
                    <p class="text-xs text-gray-400 leading-normal mt-1">Enviar e-mails automáticos aos motoristas e usuários ao cadastrar ou alterar escalas de viagens.</p>
                </div>
                <button type="button" 
                        data-key="notify_on_new_trip"
                        data-value="{{ ($settings['notify_on_new_trip'] ?? 'false') === 'true' ? 'true' : 'false' }}"
                        class="toggle-switch relative inline-flex h-6.5 w-12 shrink-0 cursor-pointer rounded-full border-2 border-transparent {{ ($settings['notify_on_new_trip'] ?? 'false') === 'true' ? 'bg-coinpel-primary/40' : 'bg-gray-200' }} transition-colors duration-200 ease-in-out focus:outline-none" role="switch">
                    <span class="{{ ($settings['notify_on_new_trip'] ?? 'false') === 'true' ? 'translate-x-5.5' : 'translate-x-0' }} pointer-events-none inline-block h-5.5 w-5.5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                </button>
            </div>

            {{-- Opção 2: Registro de auditoria avançado --}}
            <div class="flex items-center justify-between pb-5 border-b border-gray-100">
                <div class="max-w-xl pr-4">
                    <h3 class="text-sm font-bold text-gray-700">Registro de auditoria avançado</h3>
                    <p class="text-xs text-gray-400 leading-normal mt-1">Gravar logs detalhados e alterações de estado de todas as ações executadas pelos usuários administradores.</p>
                </div>
                <button type="button" 
                        data-key="allow_booking"
                        data-value="{{ ($settings['allow_booking'] ?? 'false') === 'true' ? 'true' : 'false' }}"
                        class="toggle-switch relative inline-flex h-6.5 w-12 shrink-0 cursor-pointer rounded-full border-2 border-transparent {{ ($settings['allow_booking'] ?? 'false') === 'true' ? 'bg-coinpel-primary/40' : 'bg-gray-200' }} transition-colors duration-200 ease-in-out focus:outline-none" role="switch">
                    <span class="{{ ($settings['allow_booking'] ?? 'false') === 'true' ? 'translate-x-5.5' : 'translate-x-0' }} pointer-events-none inline-block h-5.5 w-5.5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                </button>
            </div>

            {{-- Opção 3: Modo de manutenção --}}
            <div class="flex items-center justify-between pb-5 border-b border-gray-100">
                <div class="max-w-xl pr-4">
                    <h3 class="text-sm font-bold text-gray-700">Modo de manutenção</h3>
                    <p class="text-xs text-gray-400 leading-normal mt-1">Bloquear temporariamente o acesso ao painel para qualquer usuário não-administrador master.</p>
                </div>
                <button type="button" 
                        data-key="maintenance_mode"
                        data-value="{{ ($settings['maintenance_mode'] ?? 'false') === 'true' ? 'true' : 'false' }}"
                        class="toggle-switch relative inline-flex h-6.5 w-12 shrink-0 cursor-pointer rounded-full border-2 border-transparent {{ ($settings['maintenance_mode'] ?? 'false') === 'true' ? 'bg-coinpel-primary/40' : 'bg-gray-200' }} transition-colors duration-200 ease-in-out focus:outline-none" role="switch">
                    <span class="{{ ($settings['maintenance_mode'] ?? 'false') === 'true' ? 'translate-x-5.5' : 'translate-x-0' }} pointer-events-none inline-block h-5.5 w-5.5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                </button>
            </div>

            {{-- Opção 4: Permissões estritas --}}
            <div class="flex items-center justify-between">
                <div class="max-w-xl pr-4">
                    <h3 class="text-sm font-bold text-gray-700">Permissões estritas de criação</h3>
                    <p class="text-xs text-gray-400 leading-normal mt-1">Exigir obrigatoriamente a associação de veículo e motorista válidos no momento do cadastro de uma nova viagem.</p>
                </div>
                <button type="button" 
                        data-key="require_driver_assignment"
                        data-value="{{ ($settings['require_driver_assignment'] ?? 'false') === 'true' ? 'true' : 'false' }}"
                        class="toggle-switch relative inline-flex h-6.5 w-12 shrink-0 cursor-pointer rounded-full border-2 border-transparent {{ ($settings['require_driver_assignment'] ?? 'false') === 'true' ? 'bg-coinpel-primary/40' : 'bg-gray-200' }} transition-colors duration-200 ease-in-out focus:outline-none" role="switch">
                    <span class="{{ ($settings['require_driver_assignment'] ?? 'false') === 'true' ? 'translate-x-5.5' : 'translate-x-0' }} pointer-events-none inline-block h-5.5 w-5.5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                </button>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    const form = document.getElementById('company-info-form');
    const btnSaveCompany = document.getElementById('btn-save-company');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

    // Submit company form
    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        
        btnSaveCompany.disabled = true;
        btnSaveCompany.textContent = 'Salvando...';

        const formData = new FormData(form);
        const data = {};
        formData.forEach((value, key) => {
            if (key !== '_token') data[key] = value;
        });

        try {
            const response = await fetch('{{ route("settings.update") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    _method: 'PATCH',
                    ...data
                })
            });

            const json = await response.json();

            if (response.ok) {
                showFlashNotification(json.message || 'Configurações salvas!');
            } else {
                alert(json.message || 'Erro ao salvar configurações.');
            }
        } catch (err) {
            alert('Erro de conexão ao salvar.');
        } finally {
            btnSaveCompany.disabled = false;
            btnSaveCompany.textContent = 'Salvar informações';
        }
    });

    // Toggle switch click events
    const switches = document.querySelectorAll('.toggle-switch');
    switches.forEach(btn => {
        btn.addEventListener('click', async function () {
            const key = btn.dataset.key;
            const currentValue = btn.dataset.value === 'true';
            const newValue = !currentValue;
            
            // Optimistic UI update
            btn.dataset.value = newValue ? 'true' : 'false';
            const span = btn.querySelector('span');
            if (newValue) {
                btn.classList.remove('bg-gray-200');
                btn.classList.add('bg-coinpel-primary/40');
                span.classList.remove('translate-x-0');
                span.classList.add('translate-x-5.5');
            } else {
                btn.classList.remove('bg-coinpel-primary/40');
                btn.classList.add('bg-gray-200');
                span.classList.remove('translate-x-5.5');
                span.classList.add('translate-x-0');
            }

            try {
                const response = await fetch('{{ route("settings.update") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        _method: 'PATCH',
                        [key]: newValue
                    })
                });

                const json = await response.json();
                if (!response.ok) {
                    throw new Error();
                }
                showFlashNotification(json.message || 'Preferências atualizadas!');
            } catch (err) {
                // Revert on error
                btn.dataset.value = currentValue ? 'true' : 'false';
                if (currentValue) {
                    btn.classList.remove('bg-gray-200');
                    btn.classList.add('bg-coinpel-primary/40');
                    span.classList.remove('translate-x-0');
                    span.classList.add('translate-x-5.5');
                } else {
                    btn.classList.remove('bg-coinpel-primary/40');
                    btn.classList.add('bg-gray-200');
                    span.classList.remove('translate-x-5.5');
                    span.classList.add('translate-x-0');
                }
                alert('Erro de conexão ao salvar preferência.');
            }
        });
    });

    // Toast/Flash notification builder
    function showFlashNotification(message) {
        const flashEl = document.createElement('div');
        flashEl.className = 'fixed bottom-6 right-6 z-[100] px-5 py-3.5 bg-green-600 text-white text-sm font-semibold rounded-xl shadow-lg flex items-center gap-3 animate-fade-in';
        flashEl.innerHTML = `<svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>${message}`;
        document.body.appendChild(flashEl);
        setTimeout(() => flashEl.remove(), 4000);
    }

})();
</script>
@endpush
