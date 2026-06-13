@extends('layouts.app')

@section('page-title', 'Contratos')

@section('header-left')
<div class="flex items-center gap-3">
    <span class="text-sm font-bold text-gray-800 font-sans tracking-tight">Contratos</span>
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
<div class="flex-1 flex flex-col items-center justify-center py-20 bg-white border border-gray-100 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
    <div class="flex items-center justify-center w-16 h-16 rounded-2xl bg-coinpel-primary/10 text-coinpel-primary mb-6">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
        </svg>
    </div>
    <h1 class="text-xl font-bold text-gray-800 tracking-tight mb-2">Módulo Contratos em Desenvolvimento</h1>
    <p class="text-sm text-gray-500 max-w-sm leading-relaxed text-center font-normal">
        Este módulo está planejado e será disponibilizado em breve na próxima sprint do projeto COINPEL.
    </p>
</div>
@endsection
