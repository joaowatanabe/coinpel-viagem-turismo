@extends('layouts.app')

@section('page-title', 'Clientes')

@section('header-left')
<div class="flex items-center gap-3">
    <span class="text-sm font-bold text-gray-800 font-sans tracking-tight">Clientes</span>
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
<div class="flex flex-col items-center justify-center py-20 bg-white border border-gray-100 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
    <div class="flex items-center justify-center w-16 h-16 rounded-2xl bg-coinpel-primary/10 text-coinpel-primary mb-6">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.089 21c-2.913 0-5.552-.843-7.76-2.3a4.125 4.125 0 0 1 7.533-2.493M15 9.75a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Z" />
        </svg>
    </div>
    <h1 class="text-xl font-bold text-gray-800 tracking-tight mb-2">Módulo Clientes em Desenvolvimento</h1>
    <p class="text-sm text-gray-500 max-w-sm leading-relaxed text-center font-normal">
        Este módulo está planejado e será disponibilizado em breve na próxima sprint do projeto COINPEL.
    </p>
</div>
@endsection
