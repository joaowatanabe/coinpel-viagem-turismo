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
    
    {{-- Info Card: Status Módulo --}}
    <div class="bg-amber-50 border border-amber-200/60 rounded-2xl p-5 flex items-start gap-4">
        <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 shrink-0">
            <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3Z"/>
            </svg>
        </div>
        <div>
            <h3 class="text-sm font-bold text-amber-800">Módulo em Desenvolvimento</h3>
            <p class="text-xs text-amber-700/80 leading-relaxed mt-1">
                As configurações abaixo estão em modo de demonstração visual (desabilitadas) e serão totalmente integradas na próxima sprint do projeto COINPEL.
            </p>
        </div>
    </div>

    {{-- Seção: Informações da Empresa --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] p-6 md:p-8">
        <div class="flex items-center gap-3.5 mb-6">
            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-coinpel-primary/10 text-coinpel-primary shrink-0">
                <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-10.5h16.5M2.25 9h19.5M2.25 12h19.5m-18-1.5v-6a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 20.25 4.5v6"/>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Informações da Empresa</h2>
                <p class="text-xs text-gray-400 font-medium mt-0.5">Dados institucionais da operadora de turismo</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Razão Social</label>
                <input type="text" disabled value="COINPEL Viagens e Turismo Ltda."
                       class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-400 font-medium cursor-not-allowed">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">CNPJ</label>
                <input type="text" disabled value="12.345.678/0001-90"
                       class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-400 font-medium cursor-not-allowed">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">E-mail de Contato</label>
                <input type="text" disabled value="contato@coinpel.com.br"
                       class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-400 font-medium cursor-not-allowed">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Telefone</label>
                <input type="text" disabled value="(53) 3222-1234"
                       class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-400 font-medium cursor-not-allowed">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Endereço Principal</label>
                <input type="text" disabled value="Av. Duque de Caxias, 1234 - Fragata, Pelotas - RS"
                       class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-400 font-medium cursor-not-allowed">
            </div>
        </div>
    </div>

    {{-- Seção: Preferências do Sistema --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] p-6 md:p-8">
        <div class="flex items-center gap-3.5 mb-6">
            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-coinpel-primary/10 text-coinpel-primary shrink-0">
                <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l.546.947a1.125 1.125 0 0 1-.26 1.431l-1.002.827c-.293.24-.438.613-.431.992a6.759 6.759 0 0 1 0 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-.546.948a1.125 1.125 0 0 1-1.37.49l-1.216-.456c-.356-.133-.751-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-.546-.947a1.125 1.125 0 0 1 .26-1.431l1.002-.827c.293-.24.438-.613.43-.992a6.759 6.759 0 0 1 0-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 0 1-.26-1.43l.546-.947a1.125 1.125 0 0 1 1.37-.49l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
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
                <button type="button" disabled class="relative inline-flex h-6.5 w-12 shrink-0 cursor-not-allowed rounded-full border-2 border-transparent bg-coinpel-primary/40 transition-colors duration-200 ease-in-out focus:outline-none" role="switch">
                    <span class="translate-x-5.5 pointer-events-none inline-block h-5.5 w-5.5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                </button>
            </div>

            {{-- Opção 2: Registro de auditoria avançado --}}
            <div class="flex items-center justify-between pb-5 border-b border-gray-100">
                <div class="max-w-xl pr-4">
                    <h3 class="text-sm font-bold text-gray-700">Registro de auditoria avançado</h3>
                    <p class="text-xs text-gray-400 leading-normal mt-1">Gravar logs detalhados e alterações de estado de todas as ações executadas pelos usuários administradores.</p>
                </div>
                <button type="button" disabled class="relative inline-flex h-6.5 w-12 shrink-0 cursor-not-allowed rounded-full border-2 border-transparent bg-gray-200 transition-colors duration-200 ease-in-out focus:outline-none" role="switch">
                    <span class="translate-x-0 pointer-events-none inline-block h-5.5 w-5.5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                </button>
            </div>

            {{-- Opção 3: Modo de manutenção --}}
            <div class="flex items-center justify-between pb-5 border-b border-gray-100">
                <div class="max-w-xl pr-4">
                    <h3 class="text-sm font-bold text-gray-700">Modo de manutenção</h3>
                    <p class="text-xs text-gray-400 leading-normal mt-1">Bloquear temporariamente o acesso ao painel para qualquer usuário não-administrador master.</p>
                </div>
                <button type="button" disabled class="relative inline-flex h-6.5 w-12 shrink-0 cursor-not-allowed rounded-full border-2 border-transparent bg-gray-200 transition-colors duration-200 ease-in-out focus:outline-none" role="switch">
                    <span class="translate-x-0 pointer-events-none inline-block h-5.5 w-5.5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                </button>
            </div>

            {{-- Opção 4: Permissões estritas --}}
            <div class="flex items-center justify-between">
                <div class="max-w-xl pr-4">
                    <h3 class="text-sm font-bold text-gray-700">Permissões estritas de criação</h3>
                    <p class="text-xs text-gray-400 leading-normal mt-1">Exigir obrigatoriamente a associação de veículo e motorista válidos no momento do cadastro de uma nova viagem.</p>
                </div>
                <button type="button" disabled class="relative inline-flex h-6.5 w-12 shrink-0 cursor-not-allowed rounded-full border-2 border-transparent bg-coinpel-primary/40 transition-colors duration-200 ease-in-out focus:outline-none" role="switch">
                    <span class="translate-x-5.5 pointer-events-none inline-block h-5.5 w-5.5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                </button>
            </div>
        </div>
    </div>

</div>
@endsection
