<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="min-h-screen bg-coinpel-bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>COINPEL — Painel Administrativo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased text-gray-900 bg-coinpel-bg">
    <div class="flex min-h-screen bg-coinpel-bg">
        <div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 z-20 bg-black/50 hidden lg:hidden"></div>        <aside id="sidebar" class="fixed inset-y-0 left-0 z-30 flex flex-col w-[188px] bg-coinpel-primary text-white shadow-xl transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shrink-0">
            {{-- Logo --}}
            <div class="flex items-center justify-center pt-8 pb-6 shrink-0">
                <a href="{{ route('dashboard') }}" class="hover:opacity-95 transition-opacity">
                    <img src="{{ asset('logo-coinpel-dashboard.png') }}" alt="COINPEL" class="w-[124px] h-[82px] object-contain">
                </a>
            </div>

            <nav class="flex-1 px-3 py-6 space-y-2 overflow-y-auto">
                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                   class="flex flex-row items-center gap-2.5 px-3 py-2.5 rounded-xl transition duration-150 ease-in-out {{ request()->routeIs('dashboard') ? 'bg-white/12 text-white font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5.5 h-5.5 shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.25 12.75V21a.75.75 0 0 0 .75.75h5.25V16.5a.75.75 0 0 1 .75-.75h6a.75.75 0 0 1 .75.75v5.25H21a.75.75 0 0 0 .75-.75v-8.25M8.25 21V16.5M15.75 21V16.5M3 12.75 12 3.75l9 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-sm font-medium tracking-wide whitespace-nowrap">Dashboard</span>
                </a>

                {{-- Clientes --}}
                <a href="{{ route('customers.index') }}"
                   class="flex flex-row items-center gap-2.5 px-3 py-2.5 rounded-xl transition duration-150 ease-in-out {{ request()->routeIs('customers.*') ? 'bg-white/12 text-white font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5.5 h-5.5 shrink-0" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.9285 3.21429C11.9514 3.21429 12.9325 3.62067 13.6559 4.34403C14.3792 5.06738 14.7856 6.04846 14.7856 7.07144V8.35715C14.7856 8.86368 14.6858 9.36525 14.492 9.83322C14.2982 10.3012 14.014 10.7264 13.6559 11.0846C13.2977 11.4427 12.8725 11.7268 12.4045 11.9207C11.9366 12.1145 11.435 12.2143 10.9285 12.2143C10.4219 12.2143 9.92037 12.1145 9.4524 11.9207C8.98443 11.7268 8.55922 11.4427 8.20105 11.0846C7.84289 10.7264 7.55877 10.3012 7.36493 9.83322C7.17109 9.36525 7.07132 8.86368 7.07132 8.35715V7.07144C7.07132 6.04846 7.4777 5.06738 8.20105 4.34403C8.92441 3.62067 9.90549 3.21429 10.9285 3.21429V3.21429ZM19.9285 21.2143V20.2783C19.9285 16.1807 15.1893 13.5 10.9285 13.5C6.66761 13.5 1.92847 16.1807 1.92847 20.2783V21.2143C1.92847 21.5553 2.06393 21.8823 2.30504 22.1234C2.54616 22.3646 2.87319 22.5 3.21418 22.5H18.6427C18.9837 22.5 19.3108 22.3646 19.5519 22.1234C19.793 21.8823 19.9285 21.5553 19.9285 21.2143Z" fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.0969 3.44315C16.8427 3.71297 17.4872 4.20606 17.9427 4.85529C18.3983 5.50451 18.6426 6.27834 18.6426 7.07143V8.35715C18.6425 9.14918 18.3986 9.92199 17.9441 10.5706C17.4896 11.2193 16.8465 11.7123 16.1021 11.9829C16.9481 10.9556 17.3711 9.53229 17.3698 7.71429C17.3685 5.89629 16.9442 4.47043 16.0969 3.44315ZM22.4998 22.5H23.7855C24.1265 22.5 24.4535 22.3645 24.6946 22.1234C24.9358 21.8823 25.0712 21.5553 25.0712 21.2143V20.2783C25.0712 17.4883 22.8726 15.354 20.1251 14.2779C20.1251 14.2779 23.7855 17.3571 22.4998 22.5Z" fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-sm font-medium tracking-wide whitespace-nowrap">Clientes</span>
                </a>

                <a href="{{ route('drivers.index') }}" 
                   class="flex flex-row items-center gap-2.5 px-3 py-2.5 rounded-xl transition duration-150 ease-in-out {{ request()->routeIs('drivers.*') ? 'bg-white/12 text-white font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5.5 h-5.5 shrink-0" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.9285 3.21429C11.9514 3.21429 12.9325 3.62067 13.6559 4.34403C14.3792 5.06738 14.7856 6.04846 14.7856 7.07144V8.35715C14.7856 8.86368 14.6858 9.36525 14.492 9.83322C14.2982 10.3012 14.014 10.7264 13.6559 11.0846C13.2977 11.4427 12.8725 11.7268 12.4045 11.9207C11.9366 12.1145 11.435 12.2143 10.9285 12.2143C10.4219 12.2143 9.92037 12.1145 9.4524 11.9207C8.98443 11.7268 8.55922 11.4427 8.20105 11.0846C7.84289 10.7264 7.55877 10.3012 7.36493 9.83322C7.17109 9.36525 7.07132 8.86368 7.07132 8.35715V7.07144C7.07132 6.04846 7.4777 5.06738 8.20105 4.34403C8.92441 3.62067 9.90549 3.21429 10.9285 3.21429V3.21429ZM19.9285 21.2143V20.2783C19.9285 16.1807 15.1893 13.5 10.9285 13.5C6.66761 13.5 1.92847 16.1807 1.92847 20.2783V21.2143C1.92847 21.5553 2.06393 21.8823 2.30504 22.1234C2.54616 22.3646 2.87319 22.5 3.21418 22.5H18.6427C18.9837 22.5 19.3108 22.3646 19.5519 22.1234C19.793 21.8823 19.9285 21.5553 19.9285 21.2143Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.0969 3.44315C16.8427 3.71297 17.4872 4.20606 17.9427 4.85529C18.3983 5.50451 18.6426 6.27834 18.6426 7.07143V8.35715C18.6425 9.14918 18.3986 9.92199 17.9441 10.5706C17.4896 11.2193 16.8465 11.7123 16.1021 11.9829C16.9481 10.9556 17.3711 9.53229 17.3698 7.71429C17.3685 5.89629 16.9442 4.47043 16.0969 3.44315ZM22.4998 22.5H23.7855C24.1265 22.5 24.4535 22.3645 24.6946 22.1234C24.9358 21.8823 25.0712 21.5553 25.0712 21.2143V20.2783C25.0712 17.4883 22.8726 15.354 20.1251 14.2779C20.1251 14.2779 23.7855 17.3571 22.4998 22.5Z" fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-sm font-medium tracking-wide whitespace-nowrap">Motoristas</span>
                </a>

                <a href="{{ route('statistics.index') }}" 
                   class="flex flex-row items-center gap-2.5 px-3 py-2.5 rounded-xl transition duration-150 ease-in-out {{ request()->routeIs('statistics.*') ? 'bg-white/12 text-white font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5.5 h-5.5 shrink-0" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.5 4.5V19.9286C4.5 20.6106 4.77092 21.2646 5.25315 21.7468C5.73539 22.2291 6.38944 22.5 7.07143 22.5H21.8571" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M8.35718 14.7857V18.6428" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M13.5 10.9286V18.6429" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M18.6428 7.07143V18.6429" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-sm font-medium tracking-wide whitespace-nowrap">Estatísticas</span>
                </a>

                <a href="{{ route('vehicles.index') }}" 
                   class="flex flex-row items-center gap-2.5 px-3 py-2.5 rounded-xl transition duration-150 ease-in-out {{ request()->routeIs('vehicles.*') ? 'bg-white/12 text-white font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5.5 h-5.5 shrink-0" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M27 11H29V15H27V11Z" fill="currentColor"/>
                        <path d="M3 11H5V15H3V11Z" fill="currentColor"/>
                        <path d="M20 20H22V22H20V20Z" fill="currentColor"/>
                        <path d="M10 20H12V22H10V20Z" fill="currentColor"/>
                        <path d="M21 4H11C9.67441 4.00159 8.40356 4.52888 7.46622 5.46622C6.52888 6.40356 6.00159 7.67441 6 9V23C6.00053 23.5303 6.21141 24.0387 6.58637 24.4136C6.96133 24.7886 7.46973 24.9995 8 25V28H10V25H22V28H24V25C24.5302 24.9992 25.0384 24.7882 25.4133 24.4133C25.7882 24.0384 25.9992 23.5302 26 23V9C25.9984 7.67441 25.4711 6.40356 24.5338 5.46622C23.5964 4.52888 22.3256 4.00159 21 4ZM24 10V16H8V10H24ZM11 6H21C21.6184 6.00184 22.2211 6.19507 22.7253 6.55318C23.2296 6.91128 23.6105 7.41669 23.816 8H8.184C8.38945 7.41669 8.77045 6.91128 9.27465 6.55318C9.77886 6.19507 10.3816 6.00184 11 6ZM8 23V18H24.001L24.002 23H8Z" fill="currentColor"/>
                    </svg>
                    <span class="text-sm font-medium tracking-wide whitespace-nowrap">Veículos</span>
                </a>

                <a href="{{ route('trips.index') }}" 
                   class="flex flex-row items-center gap-2.5 px-3 py-2.5 rounded-xl transition duration-150 ease-in-out {{ request()->routeIs('trips.*') ? 'bg-white/12 text-white font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5.5 h-5.5 shrink-0" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M27 8H29V12H27V8Z" fill="currentColor"/>
                        <path d="M3 8H5V12H3V8Z" fill="currentColor"/>
                        <path d="M20 17H22V19H20V17Z" fill="currentColor"/>
                        <path d="M10 17H12V19H10V17Z" fill="currentColor"/>
                        <path d="M21 1H11C9.67441 1.00159 8.40356 1.52888 7.46622 2.46622C6.52888 3.40356 6.00159 4.67441 6 6V20C6.00053 20.5303 6.21141 21.0387 6.58637 21.4136C6.96133 21.7886 7.46973 21.9995 8 22V25H10V22H22V25H24V22C24.5302 21.9992 25.0384 21.7882 25.4133 21.4133C25.7882 21.0384 25.9992 20.5302 26 20V6C25.9984 4.67441 25.4711 3.40356 24.5338 2.46622C23.5964 1.52888 22.3256 1.00159 21 1ZM24 7V13H8V7H24ZM11 3H21C21.6184 3.00184 22.2211 3.19507 22.7253 3.55318C23.2296 3.91128 23.6105 4.41669 23.816 5H8.184C8.38945 4.41669 8.77045 6.91128 9.27465 6.55318C9.77886 3.19507 10.3816 3.00184 11 3ZM8 20V15H24.001L24.002 20H8Z" fill="currentColor"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M32 25V18L27 13H22C21.4696 13 20.9609 13.2107 20.5858 13.5858C20.2107 13.9609 20 14.4696 20 15V25C20 25.5304 20.2107 26.0391 20.5858 26.4142C20.9609 26.7893 21.4696 27 22 27H30C30.5304 27 31.0391 26.7893 31.4142 26.4142C31.7893 26.0391 32 25.5304 32 25Z" fill="#593E75" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M22 20H27" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M22 21.9999H29" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M22 23.9998H25" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M27 13V16C27 16.5304 27.2107 17.0391 27.5858 17.4142C27.9609 17.7893 28.4696 18 29 18H32" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-sm font-medium tracking-wide whitespace-nowrap">Viagens</span>
                </a>

                <a href="{{ route('contracts.index') }}" 
                   class="flex flex-row items-center gap-2.5 px-3 py-2.5 rounded-xl transition duration-150 ease-in-out {{ request()->routeIs('contracts.*') ? 'bg-white/12 text-white font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5.5 h-5.5 shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.2001 11.2H6.4001V12.8H7.2001V11.2ZM16.8001 12.8H17.6001V11.2H16.8001V12.8ZM7.2001 6.4H6.4001V8H7.2001V6.4ZM10.4001 8H11.2001V6.4H10.4001V8ZM16.8001 0.8L17.3665 0.2336L17.1313 0H16.8001V0.8ZM21.6001 5.6H22.4001V5.2688L22.1665 5.0336L21.6001 5.6ZM12.8001 17.6L12.2337 18.1664L12.8001 17.6ZM12.0001 18.4L12.3585 19.1152L12.4225 19.0832L12.4801 19.04L12.0001 18.4ZM7.2001 12.8H16.8001V11.2H7.2001V12.8ZM7.2001 8H10.4001V6.4H7.2001V8ZM20.0001 22.4H4.0001V24H20.0001V22.4ZM3.2001 21.6V2.4H1.6001V21.6H3.2001ZM4.0001 1.6H16.8001V0H4.0001V1.6ZM20.8001 5.6V21.6H22.4001V5.6H20.8001ZM16.2337 1.3664L21.0337 6.1664L22.1665 5.0336L17.3665 0.2336L16.2337 1.3664ZM4.0001 22.4C3.78792 22.4 3.58444 22.3157 3.43441 22.1657C3.28438 22.0157 3.2001 21.8122 3.2001 21.6H1.6001C1.6001 22.2365 1.85295 22.847 2.30304 23.2971C2.75313 23.7471 3.36358 24 4.0001 24V22.4ZM20.0001 24C20.6366 24 21.2471 23.7471 21.6972 23.2971C22.1472 22.847 22.4001 22.2365 22.4001 21.6H20.8001C20.8001 21.8122 20.7158 22.0157 20.5658 22.1657C20.4158 22.3157 20.2123 22.4 20.0001 22.4V24ZM3.2001 2.4C3.2001 2.18783 3.28438 1.98434 3.43441 1.83431C3.58444 1.68429 3.78792 1.6 4.0001 1.6V0C3.36358 0 2.75313 0.252856 2.30304 0.702944C1.85295 1.15303 1.6001 1.76348 1.6001 2.4H3.2001ZM8.7585 18.6528C8.9361 18.12 9.4417 17.6256 10.0865 17.4528C10.6897 17.2912 11.4657 17.3968 12.2337 18.1664L13.3665 17.0336C12.2145 15.8816 10.8561 15.5888 9.6721 15.9072C8.5313 16.2144 7.5969 17.08 7.2401 18.1472L8.7601 18.6528H8.7585ZM12.2337 18.1664C12.2787 18.2101 12.3209 18.2566 12.3601 18.3056L13.6241 17.3232C13.5443 17.222 13.4582 17.1258 13.3665 17.0352L12.2337 18.1664ZM12.3601 18.3056C12.4849 18.4656 12.4561 18.5168 12.4609 18.4816C12.4641 18.4592 12.4705 18.496 12.3745 18.5824C12.2362 18.698 12.0793 18.7895 11.9105 18.8528C11.7077 18.9344 11.4962 18.9924 11.2801 19.0256C11.1483 19.0507 11.0135 19.0561 10.8801 19.0416C10.8529 19.0352 10.9089 19.0416 10.9921 19.1008C11.0941 19.1795 11.1691 19.2881 11.2067 19.4114C11.2442 19.5346 11.2425 19.6666 11.2017 19.7888C11.1926 19.8153 11.1803 19.8406 11.1649 19.864C11.1617 19.8672 11.1889 19.832 11.2801 19.7568C11.4625 19.6096 11.7985 19.3952 12.3585 19.1168L11.6417 17.6848C11.0385 17.9856 10.5857 18.2608 10.2753 18.512C10.1179 18.6349 9.97793 18.7786 9.8593 18.9392C9.70841 19.1412 9.62954 19.3879 9.6353 19.64C9.6513 19.9856 9.8385 20.24 10.0433 20.3888C10.2241 20.5232 10.4241 20.5808 10.5713 20.6112C10.8705 20.6704 11.2113 20.6544 11.5201 20.608C12.1281 20.5152 12.9153 20.2528 13.4513 19.7664C13.7297 19.512 13.9937 19.1472 14.0497 18.6688C14.1073 18.1792 13.9313 17.72 13.6225 17.3248L12.3585 18.3056H12.3601ZM12.4225 19.0832L13.3665 17.0336M12.4801 19.04L13.3089 18.5488" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-sm font-medium tracking-wide whitespace-nowrap">Contratos</span>
                </a>

                {{-- Pacotes --}}
                <a href="{{ route('packages.index') }}" 
                   class="flex flex-row items-center gap-2.5 px-3 py-2.5 rounded-xl transition duration-150 ease-in-out {{ request()->routeIs('packages.*') ? 'bg-white/12 text-white font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5.5 h-5.5 shrink-0" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M25.1875 8.71875H5.8125C4.20742 8.71875 2.90625 10.0199 2.90625 11.625V23.25C2.90625 24.8551 4.20742 26.1562 5.8125 26.1562H25.1875C26.7926 26.1562 28.0938 24.8551 28.0938 23.25V11.625C28.0938 10.0199 26.7926 8.71875 25.1875 8.71875Z" stroke="currentColor" stroke-linejoin="round"/>
                        <path d="M24.9066 8.71874V6.90233C24.9064 6.45683 24.808 6.01685 24.6182 5.61379C24.4284 5.21073 24.152 4.85451 23.8088 4.57056C23.4655 4.28662 23.0638 4.08193 22.6323 3.97111C22.2008 3.8603 21.7501 3.84608 21.3125 3.92948L5.36688 6.65106C4.67441 6.78302 4.04971 7.1525 3.60051 7.69576C3.15131 8.23902 2.90577 8.92202 2.90625 9.62694V12.5937" stroke="currentColor" stroke-linejoin="round"/>
                        <path d="M22.2813 19.375C21.898 19.375 21.5235 19.2614 21.2048 19.0485C20.8862 18.8356 20.6379 18.533 20.4912 18.179C20.3446 17.8249 20.3062 17.4354 20.381 17.0595C20.4557 16.6837 20.6403 16.3384 20.9112 16.0675C21.1822 15.7965 21.5274 15.612 21.9033 15.5372C22.2791 15.4625 22.6687 15.5008 23.0227 15.6475C23.3767 15.7941 23.6793 16.0425 23.8922 16.3611C24.1051 16.6797 24.2188 17.0543 24.2188 17.4375C24.2188 17.9514 24.0146 18.4442 23.6513 18.8075C23.2879 19.1709 22.7951 19.375 22.2813 19.375Z" fill="currentColor"/>
                    </svg>
                    <span class="text-sm font-medium tracking-wide whitespace-nowrap">Pacotes</span>
                </a>

                {{-- Configurações --}}
                <a href="{{ route('settings.index') }}" 
                   class="flex flex-row items-center gap-2.5 px-3 py-2.5 rounded-xl transition duration-150 ease-in-out {{ request()->routeIs('settings.*') ? 'bg-white/12 text-white font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5.5 h-5.5 shrink-0" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.5 4.5V19.9286C4.5 20.6106 4.77092 21.2646 5.25315 21.7468C5.73539 22.2291 6.38944 22.5 7.07143 22.5H21.8571" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M8.35718 14.7857V18.6428" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M13.5 10.9286V18.6429" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M18.6428 7.07143V18.6429" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-sm font-medium tracking-wide whitespace-nowrap">Configurações</span>
                </a>
            </nav>


            <div class="p-4 border-t border-white/10 text-center text-xs text-white/30 shrink-0">
                v1.2.0
            </div>
        </aside>

        <div class="flex-1 flex flex-col lg:pl-[188px] bg-coinpel-bg">
            <header class="sticky top-0 z-20 flex items-center justify-between h-20 px-8 bg-white border-b border-gray-200/60 shrink-0">
                <button onclick="toggleSidebar()" class="lg:hidden p-1.5 text-gray-500 hover:bg-gray-100 rounded-lg focus:outline-none transition cursor-pointer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
                    </svg>
                </button>

                <div class="flex items-center">
                    @hasSection('header-left')
                        @yield('header-left')
                    @else
                        <span class="text-xs font-semibold text-gray-400 font-sans tracking-wide uppercase hidden sm:inline">
                            COINPEL
                        </span>
                        <span class="mx-2 text-gray-300 hidden sm:inline">/</span>
                        <span class="text-sm font-bold text-gray-800 font-sans tracking-tight">
                            @yield('page-title', 'Painel')
                        </span>
                    @endif
                </div>

                <div class="flex items-center gap-4.5">
                    @hasSection('header-right-action')
                        @yield('header-right-action')
                    @endif

                    <div class="relative" id="notification-dropdown">
                        <button id="notification-btn" class="text-gray-400 hover:text-gray-600 focus:outline-none transition relative cursor-pointer p-1">
                            <span id="notification-badge" class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white hidden pointer-events-none"></span>
                            <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"></path>
                            </svg>
                        </button>

                        <div id="notification-menu" class="hidden absolute top-full right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-200 z-50 transform origin-top-right flex flex-col overflow-hidden" style="max-height: 420px;" onclick="event.stopPropagation()">
                            {{-- Header --}}
                            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 bg-white shrink-0 relative z-10">
                                <div class="flex items-center gap-2">
                                    {{-- ícone sino roxo --}}
                                    <svg class="w-5 h-5 text-[#593E75]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"></path>
                                    </svg>
                                    <span class="font-semibold text-gray-800 text-base">Notificações</span>
                                    <span class="bg-[#593E75] text-white text-xs font-bold px-2 py-0.5 rounded-full" id="notif-badge-count">0</span>
                                </div>
                                <button onclick="closeNotifications()" class="text-gray-400 hover:text-gray-600 transition-colors cursor-pointer p-0.5 rounded-lg hover:bg-gray-50">
                                    {{-- ícone X 20px --}}
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                            
                            {{-- Content Scroll --}}
                            <div id="notification-list" class="divide-y divide-gray-100 overflow-y-auto overscroll-contain flex-1 relative z-0">
                                {{-- Carregado dinamicamente via JS --}}
                            </div>
                        </div>
                    </div>

                    <div class="w-px h-6 bg-gray-200"></div>

                    <div class="relative" id="profile-dropdown">
                        <button onclick="toggleDropdown(event)" class="flex items-center gap-3 focus:outline-none cursor-pointer text-left">
                            <div class="relative w-10 h-10 rounded-full overflow-hidden shrink-0 border border-gray-100 shadow-sm">
                                @if(auth()->user()->profile_photo_path)
                                    <img src="{{ Storage::url(auth()->user()->profile_photo_path) }}" alt="{{ auth()->user()->name }}" class="absolute inset-0 w-full h-full object-cover transition">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center bg-coinpel-primary text-white text-sm font-semibold uppercase">
                                        {{ mb_substr(auth()->user()->name, 0, 1) }}{{ str_contains(auth()->user()->name, ' ') ? mb_substr(explode(' ', auth()->user()->name)[1], 0, 1) : '' }}
                                    </div>
                                @endif
                            </div>
                            
                            <div class="hidden md:flex flex-col">
                                <span class="text-sm font-bold text-gray-800 leading-none">{{ auth()->user()->name }}</span>
                                <span class="text-[11px] font-medium text-gray-400 mt-1 leading-none">Administrador</span>
                            </div>
                        </button>

                        <div id="dropdown-menu" class="hidden absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-lg border border-gray-100 py-1.5 z-50 transform origin-top-right">
                            <button onclick="openGlobalProfileDrawer()" class="flex items-center gap-2 w-full px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 transition cursor-pointer text-left">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                                </svg>
                                <span>Editar perfil</span>
                            </button>
                            <div class="h-px bg-gray-100 my-1"></div>
                            <a href="{{ route('users.index') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 transition">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0 1 10.089 21c-2.913 0-5.552-.843-7.76-2.3a4.125 4.125 0 0 1 7.533-2.493M15 9.75a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4.5 9.75a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"></path>
                                </svg>
                                <span>Usuários</span>
                            </a>
                            <div class="h-px bg-gray-100 my-1"></div>
                            <button onclick="document.getElementById('logout-form').submit();" class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 transition cursor-pointer">
                                <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75"></path>
                                </svg>
                                <span>Sair</span>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 flex flex-col p-6 bg-coinpel-bg">
                @if (session('status'))
                    <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-xl text-sm text-green-800 font-medium">
                        {{ session('status') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }

        function toggleDropdown(event) {
            event.stopPropagation();
            const menu = document.getElementById('dropdown-menu');
            menu.classList.toggle('hidden');
        }

        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById('profile-dropdown');
            const menu = document.getElementById('dropdown-menu');
            if (dropdown && !dropdown.contains(e.target) && menu) {
                menu.classList.add('hidden');
            }
        });

        async function fetchAddressByCep(cep, fieldPrefix) {
            const cleanCep = cep.replace(/\D/g, '');
            if (cleanCep.length !== 8) return;

            // Find the triggering zip input
            let zipInput = window.event ? window.event.target : null;
            if (!zipInput || zipInput.tagName !== 'INPUT') {
                zipInput = document.getElementById(`${fieldPrefix}_zip_code`) || 
                           document.getElementById(`${fieldPrefix}-zip-code`) ||
                           document.querySelector(`input[onblur*="${fieldPrefix}"]`);
            }

            if (!zipInput) return;

            // Helper to find input by prefix-based ID, name, or scoped sibling
            const getField = (name) => {
                // 1. Try finding by ID: {fieldPrefix}_{name} (e.g. driver_street)
                let el = document.getElementById(`${fieldPrefix}_${name}`);
                if (el) return el;

                // 2. Try finding by ID: {fieldPrefix}-${name} (e.g. driver-street)
                el = document.getElementById(`${fieldPrefix}-${name}`);
                if (el) return el;

                // 3. Try finding relative to the zipInput container
                const container = zipInput.closest('form') || 
                                  zipInput.closest('.section-edit') || 
                                  zipInput.closest('#section-address') || 
                                  zipInput.closest('div.grid') ||
                                  (zipInput.parentElement ? zipInput.parentElement.parentElement : null);
                if (container) {
                    el = container.querySelector(`[name="${name}"]`) || 
                         container.querySelector(`[id$="${name}"]`) || 
                         container.querySelector(`[id$="-${name}"]`);
                    if (el) return el;
                }

                // 4. Try globally by name
                return document.querySelector(`[name="${name}"]`);
            };

            const streetInput = getField('street');
            const cityInput = getField('city');
            const stateInput = getField('state');
            const neighborhoodInput = getField('neighborhood');
            const numberInput = getField('number');

            // Find or create error container
            let errorEl = document.getElementById(`${fieldPrefix}_zip_code_error`) || 
                          document.getElementById(`err-${fieldPrefix}-zip-code`) ||
                          document.getElementById(`err-zip-code`);
            
            if (!errorEl && zipInput && zipInput.parentElement) {
                errorEl = zipInput.parentElement.querySelector('.error-field') || 
                          zipInput.parentElement.querySelector('.text-red-600') ||
                          zipInput.parentElement.querySelector('.text-red-500');
            }

            // Reset error
            if (errorEl) {
                errorEl.classList.add('hidden');
                errorEl.textContent = '';
            }
            zipInput.classList.remove('border-red-400', 'border-red-600');

            const originalValue = zipInput.value;
            zipInput.disabled = true;
            zipInput.value = 'Buscando...';

            try {
                const response = await fetch(`https://viacep.com.br/ws/${cleanCep}/json/`);
                if (!response.ok) throw new Error('Erro de conexão ao buscar CEP.');
                const data = await response.json();

                if (data.erro === true || data.erro === 'true') {
                    throw new Error('CEP não encontrado.');
                }

                // Fill fields
                if (streetInput) streetInput.value = data.logradouro || '';
                if (cityInput) cityInput.value = data.localidade || '';
                if (stateInput) stateInput.value = data.uf || '';
                if (neighborhoodInput) neighborhoodInput.value = data.bairro || '';

                // Format visual value
                zipInput.value = cleanCep.replace(/^(\d{5})(\d{3})$/, '$1-$2');

                // Focus on the number field
                if (numberInput) {
                    setTimeout(() => numberInput.focus(), 50);
                }

            } catch (err) {
                // Clear address fields on error
                if (streetInput) streetInput.value = '';
                if (cityInput) cityInput.value = '';
                if (stateInput) stateInput.value = '';
                if (neighborhoodInput) neighborhoodInput.value = '';

                // Restore original CEP value
                zipInput.value = originalValue;
                zipInput.classList.add('border-red-600');

                if (errorEl) {
                    errorEl.textContent = err.message || 'CEP não encontrado.';
                    errorEl.classList.remove('hidden');
                }
            } finally {
                zipInput.disabled = false;
            }
        }

        function formatCepInput(input) {
            let val = input.value.replace(/\D/g, '');
            if (val.length > 5) {
                val = val.substring(0, 5) + '-' + val.substring(5, 8);
            } else {
                val = val.substring(0, 8);
            }
            input.value = val;
        }

        (function() {
            const notificationBtn = document.getElementById('notification-btn');
            const notificationMenu = document.getElementById('notification-menu');
            const notificationBadge = document.getElementById('notification-badge');
            const notificationList = document.getElementById('notification-list');
            const notifBadgeCount = document.getElementById('notif-badge-count');

            let currentOffset = 0;
            const limit = 20;
            let isLoading = false;

            const notificationIcons = {
                driver_available: {
                    bgColor: 'bg-green-100',
                    color: '#6FCF97',
                    svg: `<svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                          </svg>`
                },
                password_pending: {
                    bgColor: 'bg-orange-100',
                    color: '#F2994A',
                    svg: `<svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
                          </svg>`
                },
                new_trip: {
                    bgColor: 'bg-purple-100',
                    color: '#593E75',
                    svg: `<svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                          </svg>`
                },
                in_progress: {
                    bgColor: 'bg-yellow-100',
                    color: '#F2C94C',
                    svg: `<svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                          </svg>`
                },
                contract_expiring: {
                    bgColor: 'bg-red-100',
                    color: '#EB5757',
                    svg: `<svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                          </svg>`
                }
            };

            function showLoadingSkeleton() {
                if (!notificationList) return;
                notificationList.innerHTML = `
                    <div class="flex items-start gap-3 px-5 py-4 border-b border-gray-100 animate-pulse">
                        <div class="w-9 h-9 rounded-full bg-gray-200 shrink-0"></div>
                        <div class="flex-1 space-y-2">
                            <div class="h-3 bg-gray-200 rounded w-3/4"></div>
                            <div class="h-3 bg-gray-200 rounded w-1/2"></div>
                            <div class="h-2 bg-gray-200 rounded w-1/4 mt-1"></div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 px-5 py-4 border-b border-gray-100 animate-pulse">
                        <div class="w-9 h-9 rounded-full bg-gray-200 shrink-0"></div>
                        <div class="flex-1 space-y-2">
                            <div class="h-3 bg-gray-200 rounded w-3/4"></div>
                            <div class="h-3 bg-gray-200 rounded w-1/2"></div>
                            <div class="h-2 bg-gray-200 rounded w-1/4 mt-1"></div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 px-5 py-4 border-b border-gray-100 animate-pulse">
                        <div class="w-9 h-9 rounded-full bg-gray-200 shrink-0"></div>
                        <div class="flex-1 space-y-2">
                            <div class="h-3 bg-gray-200 rounded w-3/4"></div>
                            <div class="h-3 bg-gray-200 rounded w-1/2"></div>
                            <div class="h-2 bg-gray-200 rounded w-1/4 mt-1"></div>
                        </div>
                    </div>
                `;
            }

            function updateBadge(count) {
                const isMenuOpen = notificationMenu && !notificationMenu.classList.contains('hidden');
                if (notificationBadge) {
                    if (count > 0 && !isMenuOpen) {
                        notificationBadge.classList.remove('hidden');
                    } else {
                        notificationBadge.classList.add('hidden');
                    }
                }
                if (notifBadgeCount) {
                    notifBadgeCount.textContent = count;
                }
            }

            async function fetchNotificationsCountOnly() {
                try {
                    const response = await fetch('/notifications?countOnly=true', {
                        headers: { 'Accept': 'application/json' }
                    });
                    if (!response.ok) return;
                    const data = await response.json();
                    updateBadge(data.count);
                } catch (err) {
                    // Silently ignore background polling errors
                }
            }

            async function loadNotifications(append = false) {
                if (isLoading) return;
                isLoading = true;

                if (!append) {
                    currentOffset = 0;
                    showLoadingSkeleton();
                }

                try {
                    const response = await fetch(`/notifications?offset=${currentOffset}&limit=${limit}`, {
                        headers: { 'Accept': 'application/json' }
                    });
                    if (!response.ok) throw new Error();
                    const data = await response.json();

                    updateBadge(data.count);

                    const htmlItems = data.items.map(item => {
                        const iconCfg = notificationIcons[item.type] || {
                            bgColor: 'bg-gray-100',
                            color: '#9CA3AF',
                            svg: `<svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>`
                        };
                        return `
                            <a href="${item.link}" class="flex items-start gap-3 px-5 py-4 hover:bg-gray-50 transition-colors border-b border-gray-100 last:border-0 group">
                                <div class="shrink-0 w-9 h-9 rounded-full flex items-center justify-center ${iconCfg.bgColor}" style="color: ${iconCfg.color};">
                                    ${iconCfg.svg}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-800 font-medium leading-snug line-clamp-2">${item.message}</p>
                                    <p class="text-xs text-gray-400 mt-1">${item.created_at}</p>
                                </div>
                                <svg class="shrink-0 w-4 h-4 text-gray-300 group-hover:text-gray-500 mt-0.5 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                                </svg>
                            </a>
                        `;
                    }).join('');

                    if (!append) {
                        if (data.items.length === 0) {
                            notificationList.innerHTML = `
                                <div class="px-5 py-10 text-center">
                                    <svg class="w-10 h-10 text-gray-300 mx-auto" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"/>
                                    </svg>
                                    <p class="text-sm text-gray-500 mt-3">Nenhuma notificação no momento.</p>
                                </div>
                            `;
                        } else {
                            notificationList.innerHTML = htmlItems;
                        }
                    } else {
                        notificationList.insertAdjacentHTML('beforeend', htmlItems);
                    }

                    currentOffset = data.nextOffset;
                } catch (err) {
                    if (!append) {
                        notificationList.innerHTML = `
                            <div class="px-5 py-6 text-center text-red-500 text-sm font-semibold">
                                Erro ao carregar notificações.
                            </div>
                        `;
                    }
                } finally {
                    isLoading = false;
                }
            }

            // Expose globally
            window.closeNotifications = function() {
                if (notificationMenu) {
                    notificationMenu.classList.add('hidden');
                }
            };

            window.loadMoreNotifications = function() {
                loadNotifications(true);
            };

            if (notificationBtn) {
                notificationBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    if (!notificationMenu) return;
                    const isHidden = notificationMenu.classList.contains('hidden');
                    
                    const profileMenu = document.getElementById('dropdown-menu');
                    if (profileMenu) profileMenu.classList.add('hidden');

                    if (isHidden) {
                        notificationMenu.classList.remove('hidden');
                        if (notificationBadge) notificationBadge.classList.add('hidden');
                        loadNotifications(false);
                    } else {
                        window.closeNotifications();
                    }
                });
            }

            window.addEventListener('click', function(e) {
                const dropdown = document.getElementById('notification-dropdown');
                if (dropdown && !dropdown.contains(e.target)) {
                    window.closeNotifications();
                }
            });

            // Initial fetch
            fetchNotificationsCountOnly();

            // 60-second periodic refetch with interval cleanup
            if (window.notificationInterval) {
                clearInterval(window.notificationInterval);
            }
            window.notificationInterval = setInterval(fetchNotificationsCountOnly, 60000);
        })();
    </script>

    {{-- Global Profile Drawer --}}
    <div id="global-profile-drawer-overlay" class="fixed inset-0 bg-black/40 z-40 hidden opacity-0 transition-opacity duration-300"></div>
    <div id="global-profile-drawer" class="fixed inset-y-0 right-0 w-[480px] bg-white z-50 shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col h-full">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 shrink-0">
            <div class="flex items-center gap-2">
                <h2 class="text-lg font-bold text-gray-800">Editar Perfil</h2>
            </div>
            <button onclick="closeGlobalProfileDrawer()" class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-50 transition cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div id="global-profile-error" class="hidden mx-6 mt-4 p-4 bg-red-50 border border-red-200 rounded-lg text-sm text-red-800 font-medium shrink-0"></div>
        <div class="flex-1 overflow-y-auto px-6 py-4 space-y-6">
            <div class="flex flex-col items-center gap-2 mb-2">
                <div id="global-profile-avatar-wrap" class="relative w-24 h-24 rounded-full overflow-hidden shrink-0 border-2 border-gray-200 shadow-sm bg-coinpel-primary" style="width: 96px; height: 96px;">
                    @if(auth()->user()->profile_photo_path)
                        <img id="global-profile-photo-preview" src="{{ Storage::url(auth()->user()->profile_photo_path) }}" class="absolute inset-0 w-full h-full object-cover">
                    @else
                        <div id="global-profile-photo-preview" class="absolute inset-0 flex items-center justify-center bg-coinpel-primary text-white font-bold text-2xl uppercase">
                            {{ mb_substr(auth()->user()->name, 0, 1) }}{{ str_contains(auth()->user()->name, ' ') ? mb_substr(explode(' ', auth()->user()->name)[1], 0, 1) : '' }}
                        </div>
                    @endif
                </div>
                <div class="flex items-center gap-3 mt-2">
                    <label class="text-xs text-[#593E75] font-medium cursor-pointer hover:text-[#381794] transition-colors">
                        Trocar foto
                        <input type="file" id="global-profile-photo-input" accept="image/jpeg,image/png,image/webp" class="hidden" onchange="uploadGlobalProfilePhoto(this)">
                    </label>
                    <button type="button" id="global-profile-remove-photo-btn" class="{{ auth()->user()->profile_photo_path ? '' : 'hidden' }} text-xs text-red-500 hover:text-red-700 font-medium transition-colors flex items-center gap-1 cursor-pointer" onclick="removeGlobalProfilePhoto()">
                        Remover foto
                    </button>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Nome:</label>
                <input id="global-profile-name" type="text" value="{{ auth()->user()->name }}" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary transition">
            </div>
            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">E-mail:</label>
                <input id="global-profile-email" type="email" value="{{ auth()->user()->email }}" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Nova senha (opcional):</label>
                <input id="global-profile-password" type="password" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-coinpel-primary transition" placeholder="Deixe em branco para não alterar">
            </div>
        </div>
        <div class="shrink-0 px-6 py-4 border-t border-gray-100 space-y-2">
            <button id="global-profile-submit" onclick="submitGlobalProfile()" class="w-full py-2.5 bg-coinpel-primary hover:opacity-95 text-white text-sm font-semibold rounded-lg transition cursor-pointer">Salvar alterações</button>
            <button onclick="closeGlobalProfileDrawer()" class="w-full py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 transition cursor-pointer">Cancelar</button>
        </div>
    </div>
    
    <script>
        const globalProfileDrawer = document.getElementById('global-profile-drawer');
        const globalProfileOverlay = document.getElementById('global-profile-drawer-overlay');
        const authUserId = {{ auth()->id() }};

        function openGlobalProfileDrawer() {
            const menu = document.getElementById('dropdown-menu');
            if (menu) menu.classList.add('hidden');
            
            globalProfileOverlay.classList.remove('hidden');
            setTimeout(() => {
                globalProfileOverlay.classList.remove('opacity-0');
                globalProfileDrawer.classList.remove('translate-x-full');
            }, 10);
        }

        function closeGlobalProfileDrawer() {
            globalProfileOverlay.classList.add('opacity-0');
            globalProfileDrawer.classList.add('translate-x-full');
            setTimeout(() => {
                globalProfileOverlay.classList.add('hidden');
            }, 300);
        }

        globalProfileOverlay.addEventListener('click', closeGlobalProfileDrawer);

        function uploadGlobalProfilePhoto(input) {
            if (!input.files || !input.files[0]) return;
            const file = input.files[0];
            if (file.size > 2 * 1024 * 1024) {
                input.value = ''; alert('A foto deve ter no máximo 2MB.'); return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                const wrap = document.getElementById('global-profile-avatar-wrap');
                if (wrap) {
                    wrap.innerHTML = `<img id="global-profile-photo-preview" src="${e.target.result}" class="absolute inset-0 w-full h-full object-cover">`;
                }
            };
            reader.readAsDataURL(file);

            const formData = new FormData();
            formData.append('profile_photo', file);

            fetch(`/users/${authUserId}/photo`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: formData
            })
            .then(async r => {
                const data = await r.json();
                if (!r.ok || !data.success) throw data;
                return data;
            })
            .then(data => {
                const wrap = document.getElementById('global-profile-avatar-wrap');
                if (wrap) {
                    wrap.innerHTML = `<img id="global-profile-photo-preview" src="${data.photo_url}" class="absolute inset-0 w-full h-full object-cover">`;
                }
                document.getElementById('global-profile-remove-photo-btn').classList.remove('hidden');

                const topBtn = document.querySelector('#profile-dropdown button');
                if (topBtn) {
                    const avatarWrap = topBtn.querySelector('.relative.w-10.h-10');
                    if (avatarWrap) {
                        avatarWrap.innerHTML = `<img src="${data.photo_url}" class="absolute inset-0 w-full h-full object-cover">`;
                    }
                }
            })
            .catch(err => {
                input.value = '';
                if (err.errors && err.errors.profile_photo) {
                    alert(err.errors.profile_photo[0]);
                } else {
                    alert(err.message || 'Erro ao enviar foto.');
                }
            });
        }

        function removeGlobalProfilePhoto() {
            if (!confirm('Remover sua foto de perfil?')) return;
            const btn = document.getElementById('global-profile-remove-photo-btn');
            btn.textContent = 'Removendo...'; btn.disabled = true;
            
            fetch(`/users/${authUserId}/photo`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (!data.success) throw new Error(data.message);
                const wrap = document.getElementById('global-profile-avatar-wrap');
                if (wrap) wrap.innerHTML = `<div id="global-profile-photo-preview" class="absolute inset-0 flex items-center justify-center bg-coinpel-primary text-white font-bold text-2xl uppercase">${data.initials}</div>`;
                btn.classList.add('hidden'); btn.textContent = 'Remover foto'; btn.disabled = false;
                
                const topBtn = document.querySelector('#profile-dropdown button');
                if (topBtn) {
                    const avatarWrap = topBtn.querySelector('.relative.w-10.h-10');
                    if (avatarWrap) {
                        avatarWrap.innerHTML = `<div class="absolute inset-0 flex items-center justify-center bg-coinpel-primary text-white text-sm font-semibold uppercase">${data.initials}</div>`;
                    }
                }
            })
            .catch(err => {
                btn.textContent = 'Remover foto'; btn.disabled = false;
                alert(err.message || 'Erro ao remover foto.');
            });
        }

        function submitGlobalProfile() {
            const btn = document.getElementById('global-profile-submit');
            btn.textContent = 'Salvando...'; btn.disabled = true;
            
            const formData = new FormData();
            formData.append('_method', 'PATCH');
            formData.append('name', document.getElementById('global-profile-name').value);
            formData.append('email', document.getElementById('global-profile-email').value);
            
            const pass = document.getElementById('global-profile-password').value;
            if (pass) formData.append('password', pass);
            
            fetch(`/users/${authUserId}`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: formData
            })
            .then(async r => {
                const data = await r.json();
                if (!r.ok) throw data;
                return data;
            })
            .then(data => {
                const topBtn = document.querySelector('#profile-dropdown button');
                if (topBtn) {
                    const nameWrap = topBtn.querySelector('.md\\:flex.flex-col span.font-bold');
                    if (nameWrap) nameWrap.textContent = document.getElementById('global-profile-name').value;
                }
                document.getElementById('global-profile-password').value = '';
                closeGlobalProfileDrawer();
                alert('Perfil atualizado com sucesso.');
                btn.textContent = 'Salvar alterações'; btn.disabled = false;
            })
            .catch(err => {
                btn.textContent = 'Salvar alterações'; btn.disabled = false;
                if (err.errors) {
                    alert('Erro na validação dos campos. Verifique o email.');
                } else {
                    alert(err.message || 'Erro ao atualizar perfil.');
                }
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
