@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        {{-- Card: Viagens --}}
        <div class="bg-white rounded-2xl border border-gray-100/80 shadow-[0_8px_30px_rgb(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:border-gray-200/50 transition-all duration-300 p-6 flex items-center gap-4.5 group">
            <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-coinpel-primary/10 text-coinpel-primary shrink-0 transition duration-150 group-hover:scale-105">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25M2.25 17.25v-10.5A2.25 2.25 0 0 1 4.5 4.5h15a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25Z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Viagens</p>
                <p class="text-2xl font-bold text-gray-800 tracking-tight leading-tight mt-1">{{ $tripsCount }}</p>
            </div>
        </div>

        {{-- Card: Veículos --}}
        <div class="bg-white rounded-2xl border border-gray-100/80 shadow-[0_8px_30px_rgb(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:border-gray-200/50 transition-all duration-300 p-6 flex items-center gap-4.5 group">
            <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-blue-50 text-blue-500 shrink-0 transition duration-150 group-hover:scale-105">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124l-.375-6a3.75 3.75 0 0 0-3.75-3.75H6.375c-.621 0-1.129.504-1.09 1.124l.375 6A3.75 3.75 0 0 0 9.42 15h4.16" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Veículos</p>
                <p class="text-2xl font-bold text-gray-800 tracking-tight leading-tight mt-1">{{ $vehiclesCount }}</p>
            </div>
        </div>

        {{-- Card: Motoristas --}}
        <div class="bg-white rounded-2xl border border-gray-100/80 shadow-[0_8px_30px_rgb(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:border-gray-200/50 transition-all duration-300 p-6 flex items-center gap-4.5 group">
            <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 shrink-0 transition duration-150 group-hover:scale-105">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0ZM6 15a3 3 0 0 1 6 0H6Z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Motoristas</p>
                <p class="text-2xl font-bold text-gray-800 tracking-tight leading-tight mt-1">{{ $driversCount }}</p>
            </div>
        </div>

        {{-- Card: Administradores --}}
        <div class="bg-white rounded-2xl border border-gray-100/80 shadow-[0_8px_30px_rgb(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:border-gray-200/50 transition-all duration-300 p-6 flex items-center gap-4.5 group">
            <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-amber-50 text-coinpel-accent shrink-0 transition duration-150 group-hover:scale-105">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Administradores</p>
                <p class="text-2xl font-bold text-gray-800 tracking-tight leading-tight mt-1">{{ $usersCount }}</p>
            </div>
        </div>
    </div>

    {{-- Welcome block --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] p-12 md:p-16 flex flex-col items-center justify-center text-center max-w-4xl mx-auto mt-6">
        <div class="flex items-center justify-center w-16 h-16 rounded-2xl bg-coinpel-primary/10 text-coinpel-primary mb-6">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124l-.375-6a3.75 3.75 0 0 0-3.75-3.75H6.375c-.621 0-1.129.504-1.09 1.124l.375 6A3.75 3.75 0 0 0 9.42 15h4.16a3.75 3.75 0 0 0 3.75-3.75h0" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 tracking-tight mb-3">Bem-vindo ao COINPEL</h1>
        <p class="text-sm text-gray-500 max-w-md leading-relaxed font-normal">
            Sistema administrativo de viagens de turismo. Utilize a barra lateral de navegação para gerenciar as escalas e recursos.
        </p>

        <div class="mt-8 flex flex-wrap gap-3.5 justify-center">
            <a href="{{ route('trips.index') }}"
               class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-coinpel-primary text-white text-xs font-semibold hover:bg-coinpel-primary-dark transition shadow-sm shadow-coinpel-primary/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25M2.25 17.25v-10.5A2.25 2.25 0 0 1 4.5 4.5h15a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25Z" />
                </svg>
                Ver Viagens
            </a>
            <a href="{{ route('vehicles.index') }}"
               class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-white border border-gray-200 text-gray-700 text-xs font-semibold hover:border-coinpel-primary hover:text-coinpel-primary transition">
                Ver Veículos
            </a>
            <a href="{{ route('drivers.index') }}"
               class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-white border border-gray-200 text-gray-700 text-xs font-semibold hover:border-coinpel-primary hover:text-coinpel-primary transition">
                Ver Motoristas
            </a>
        </div>
    </div>
@endsection
