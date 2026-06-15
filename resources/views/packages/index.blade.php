@extends('layouts.app')

@section('page-title', 'Pacotes')

@section('header-left')
<div class="flex items-center gap-3">
    <span class="text-sm font-bold text-gray-800 font-sans tracking-tight">Pacotes</span>
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
        {{-- Ícone do Módulo de Pacotes da Sidebar --}}
        <svg class="w-8 h-8" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M25.1875 8.71875H5.8125C4.20742 8.71875 2.90625 10.0199 2.90625 11.625V23.25C2.90625 24.8551 4.20742 26.1562 5.8125 26.1562H25.1875C26.7926 26.1562 28.0938 24.8551 28.0938 23.25V11.625C28.0938 10.0199 26.7926 8.71875 25.1875 8.71875Z" stroke="currentColor" stroke-linejoin="round"/>
            <path d="M24.9066 8.71874V6.90233C24.9064 6.45683 24.808 6.01685 24.6182 5.61379C24.4284 5.21073 24.152 4.85451 23.8088 4.57056C23.4655 4.28662 23.0638 4.08193 22.6323 3.97111C22.2008 3.8603 21.7501 3.84608 21.3125 3.92948L5.36688 6.65106C4.67441 6.78302 4.04971 7.1525 3.60051 7.69576C3.15131 8.23902 2.90577 8.92202 2.90625 9.62694V12.5937" stroke="currentColor" stroke-linejoin="round"/>
            <path d="M22.2813 19.375C21.898 19.375 21.5235 19.2614 21.2048 19.0485C20.8862 18.8356 20.6379 18.533 20.4912 18.179C20.3446 17.8249 20.3062 17.4354 20.381 17.0595C20.4557 16.6837 20.6403 16.3384 20.9112 16.0675C21.1822 15.7965 21.5274 15.612 21.9033 15.5372C22.2791 15.4625 22.6687 15.5008 23.0227 15.6475C23.3767 15.7941 23.6793 16.0425 23.8922 16.3611C24.1051 16.6797 24.2188 17.0543 24.2188 17.4375C24.2188 17.9514 24.0146 18.4442 23.6513 18.8075C23.2879 19.1709 22.7951 19.375 22.2813 19.375Z" fill="currentColor"/>
        </svg>
    </div>
    <h1 class="text-xl font-bold text-gray-800 tracking-tight mb-2">Módulo Pacotes</h1>
    <p class="text-sm text-gray-500 max-w-sm leading-relaxed text-center font-normal mb-8">
        Este módulo está em desenvolvimento.
    </p>
    <a href="{{ route('dashboard') }}"
       class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-coinpel-primary text-white text-xs font-semibold hover:opacity-95 transition shadow-sm">
        Voltar ao Dashboard
    </a>
</div>
@endsection
