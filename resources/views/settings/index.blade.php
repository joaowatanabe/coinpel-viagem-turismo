@extends('layouts.app')

@section('page-title', 'Configurações')

@section('header-left')
<div class="flex items-center gap-3">
    <span class="text-sm font-bold text-gray-800 font-sans tracking-tight">Configurações</span>
</div>
@endsection

@section('header-right-action')
<a href="{{ route('dashboard') }}"
   class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-lg transition shrink-0 cursor-pointer">
    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
    </svg>
    Dashboard
</a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto pb-12">
    
    <!-- SEÇÃO 1: Informações da empresa -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center gap-3 mb-6">
            <!-- SVG building-office-2 -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                 stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-[#593E75] shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" 
                      d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 
                         3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 
                         1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
            </svg>
            <div>
                <h2 class="font-semibold text-gray-800 text-base uppercase">
                    Informações da Empresa
                </h2>
                <p class="text-xs text-gray-500">
                    Dados institucionais da operadora de turismo
                </p>
            </div>
        </div>
        
        <form id="company-info-form">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- input RAZÃO SOCIAL -->
                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        RAZÃO SOCIAL
                    </label>
                    <input type="text" 
                           name="company_name"
                           value="{{ $settings['company_name'] ?? '' }}"
                           class="w-full px-3 py-2.5 text-sm text-gray-800 
                                  bg-white border border-gray-300 rounded-lg
                                  focus:outline-none focus:ring-2 
                                  focus:ring-[#593E75] focus:border-transparent
                                  transition-colors placeholder-gray-400">
                </div>

                <!-- input CNPJ -->
                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        CNPJ
                    </label>
                    <input type="text" 
                           name="company_cnpj"
                           value="{{ $settings['company_cnpj'] ?? '' }}"
                           class="w-full px-3 py-2.5 text-sm text-gray-800 
                                  bg-white border border-gray-300 rounded-lg
                                  focus:outline-none focus:ring-2 
                                  focus:ring-[#593E75] focus:border-transparent
                                  transition-colors placeholder-gray-400">
                </div>

                <!-- input E-MAIL DE CONTATO -->
                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        E-MAIL DE CONTATO
                    </label>
                    <input type="email" 
                           name="company_email"
                           value="{{ $settings['company_email'] ?? '' }}"
                           class="w-full px-3 py-2.5 text-sm text-gray-800 
                                  bg-white border border-gray-300 rounded-lg
                                  focus:outline-none focus:ring-2 
                                  focus:ring-[#593E75] focus:border-transparent
                                  transition-colors placeholder-gray-400">
                </div>

                <!-- input TELEFONE -->
                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        TELEFONE
                    </label>
                    <input type="text" 
                           name="company_phone"
                           value="{{ $settings['company_phone'] ?? '' }}"
                           class="w-full px-3 py-2.5 text-sm text-gray-800 
                                  bg-white border border-gray-300 rounded-lg
                                  focus:outline-none focus:ring-2 
                                  focus:ring-[#593E75] focus:border-transparent
                                  transition-colors placeholder-gray-400">
                </div>

                <!-- input ENDEREÇO PRINCIPAL (col-span-2) -->
                <div class="space-y-1 md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        ENDEREÇO PRINCIPAL
                    </label>
                    <input type="text" 
                           name="company_address"
                           value="{{ $settings['company_address'] ?? '' }}"
                           class="w-full px-3 py-2.5 text-sm text-gray-800 
                                  bg-white border border-gray-300 rounded-lg
                                  focus:outline-none focus:ring-2 
                                  focus:ring-[#593E75] focus:border-transparent
                                  transition-colors placeholder-gray-400">
                </div>
            </div>
            
            <div class="flex justify-end mt-6">
                <button type="button" onclick="saveCompanyInfo()"
                        id="btn-save-company"
                        class="px-6 py-2.5 bg-[#593E75] text-white text-sm 
                               font-medium rounded-lg hover:bg-[#381794] 
                               transition-colors cursor-pointer">
                    Salvar informações
                </button>
            </div>
        </form>
    </div>

    <!-- SEÇÃO 2: Preferências do sistema -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center gap-3 mb-6">
            <!-- SVG adjustments-horizontal -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                 stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-[#593E75] shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" 
                      d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0ZM10.5 
                         6H3.75m16.5 6h-9.75m9.75 0a1.5 1.5 0 0 1-3 0 1.5 1.5 0 0 1 3 
                         0Zm0 0H3.75m16.5 6H6.75m9.75 0a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 
                         3 0Zm0 0H3.75"/>
            </svg>
            <div>
                <h2 class="font-semibold text-gray-800 text-base uppercase">
                    Preferências do Sistema
                </h2>
                <p class="text-xs text-gray-500">
                    Configurações globais de regras e alertas
                </p>
            </div>
        </div>
        
        <!-- Opção 1: Notificações por e-mail -->
        <div class="flex items-start justify-between py-4 border-b border-gray-100 last:border-0">
            <div class="flex-1 pr-8">
                <p class="text-sm font-medium text-gray-800">
                    Notificações por e-mail
                </p>
                <p class="text-xs text-gray-500 mt-0.5">
                    Enviar e-mails automáticos aos motoristas e usuários 
                    ao cadastrar ou alterar escalas de viagens.
                </p>
            </div>
            <!-- Toggle switch CSS puro -->
            <button type="button" role="switch"
                    id="toggle-notify_on_new_trip"
                    aria-checked="{{ ($settings['notify_on_new_trip'] ?? 'false') === 'true' ? 'true' : 'false' }}"
                    onclick="toggleSetting('notify_on_new_trip', this)"
                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none cursor-pointer {{ ($settings['notify_on_new_trip'] ?? 'false') === 'true' ? 'bg-[#593E75]' : 'bg-gray-200' }}">
                <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform {{ ($settings['notify_on_new_trip'] ?? 'false') === 'true' ? 'translate-x-6' : 'translate-x-1' }}"></span>
            </button>
        </div>

        <!-- Opção 2: Registro de auditoria avançado -->
        <div class="flex items-start justify-between py-4 border-b border-gray-100 last:border-0">
            <div class="flex-1 pr-8">
                <p class="text-sm font-medium text-gray-800">
                    Registro de auditoria avançado
                </p>
                <p class="text-xs text-gray-500 mt-0.5">
                    Gravar logs detalhados e alterações de estado de todas as ações executadas pelos usuários administradores.
                </p>
            </div>
            <!-- Toggle switch CSS puro -->
            <button type="button" role="switch"
                    id="toggle-allow_booking"
                    aria-checked="{{ ($settings['allow_booking'] ?? 'false') === 'true' ? 'true' : 'false' }}"
                    onclick="toggleSetting('allow_booking', this)"
                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none cursor-pointer {{ ($settings['allow_booking'] ?? 'false') === 'true' ? 'bg-[#593E75]' : 'bg-gray-200' }}">
                <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform {{ ($settings['allow_booking'] ?? 'false') === 'true' ? 'translate-x-6' : 'translate-x-1' }}"></span>
            </button>
        </div>

        <!-- Opção 3: Modo de manutenção -->
        <div class="flex items-start justify-between py-4 border-b border-gray-100 last:border-0">
            <div class="flex-1 pr-8">
                <p class="text-sm font-medium text-gray-800">
                    Modo de manutenção
                </p>
                <p class="text-xs text-gray-500 mt-0.5">
                    Bloquear temporariamente o acesso ao painel para qualquer usuário não-administrador master.
                </p>
            </div>
            <!-- Toggle switch CSS puro -->
            <button type="button" role="switch"
                    id="toggle-maintenance_mode"
                    aria-checked="{{ ($settings['maintenance_mode'] ?? 'false') === 'true' ? 'true' : 'false' }}"
                    onclick="toggleSetting('maintenance_mode', this)"
                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none cursor-pointer {{ ($settings['maintenance_mode'] ?? 'false') === 'true' ? 'bg-[#593E75]' : 'bg-gray-200' }}">
                <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform {{ ($settings['maintenance_mode'] ?? 'false') === 'true' ? 'translate-x-6' : 'translate-x-1' }}"></span>
            </button>
        </div>

        <!-- Opção 4: Permissões estritas de criação -->
        <div class="flex items-start justify-between py-4 border-b border-gray-100 last:border-0">
            <div class="flex-1 pr-8">
                <p class="text-sm font-medium text-gray-800">
                    Permissões estritas de criação
                </p>
                <p class="text-xs text-gray-500 mt-0.5">
                    Exigir obrigatoriamente a associação de veículo e motorista válidos no momento do cadastro de uma nova viagem.
                </p>
            </div>
            <!-- Toggle switch CSS puro -->
            <button type="button" role="switch"
                    id="toggle-require_driver_assignment"
                    aria-checked="{{ ($settings['require_driver_assignment'] ?? 'false') === 'true' ? 'true' : 'false' }}"
                    onclick="toggleSetting('require_driver_assignment', this)"
                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none cursor-pointer {{ ($settings['require_driver_assignment'] ?? 'false') === 'true' ? 'bg-[#593E75]' : 'bg-gray-200' }}">
                <span class="inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform {{ ($settings['require_driver_assignment'] ?? 'false') === 'true' ? 'translate-x-6' : 'translate-x-1' }}"></span>
            </button>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

    window.saveCompanyInfo = async function () {
        const form = document.getElementById('company-info-form');
        const btnSaveCompany = document.getElementById('btn-save-company');
        
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
    };

    window.toggleSetting = async function (key, btn) {
        const isActive = btn.getAttribute('aria-checked') === 'true';
        const newValue = !isActive;
        
        btn.setAttribute('aria-checked', newValue);
        btn.classList.toggle('bg-[#593E75]', newValue);
        btn.classList.toggle('bg-gray-200', !newValue);
        
        const span = btn.querySelector('span');
        span.classList.toggle('translate-x-6', newValue);
        span.classList.toggle('translate-x-1', !newValue);
        
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
            // Reverter em caso de erro
            btn.setAttribute('aria-checked', isActive);
            btn.classList.toggle('bg-[#593E75]', isActive);
            btn.classList.toggle('bg-gray-200', !isActive);
            span.classList.toggle('translate-x-6', isActive);
            span.classList.toggle('translate-x-1', !isActive);
            alert('Erro de conexão ao salvar preferência.');
        }
    };

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
