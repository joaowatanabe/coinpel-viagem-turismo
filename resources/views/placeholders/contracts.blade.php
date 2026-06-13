@extends('layouts.app')

@section('page-title', 'Contratos')

@section('content')
<div class="flex flex-col items-center justify-center py-20 bg-white border border-gray-100 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
    <div class="flex items-center justify-center w-16 h-16 rounded-2xl bg-coinpel-primary/10 text-coinpel-primary mb-6">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
        </svg>
    </div>
    <h1 class="text-xl font-bold text-gray-800 tracking-tight mb-2">Módulo Contratos em Desenvolvimento</h1>
    <p class="text-sm text-gray-500 max-w-sm leading-relaxed text-center font-normal">
        Este módulo está planejado e será disponibilizado em breve na próxima sprint do projeto COINPEL.
    </p>
</div>
@endsection
