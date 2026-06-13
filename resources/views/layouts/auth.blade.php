<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>COINPEL — Autenticação</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900">
    <div class="flex min-h-full">
        <div class="flex flex-col justify-center flex-1 px-4 py-12 sm:px-6 lg:flex-none lg:w-1/2 lg:px-20 xl:px-24 bg-white">
            <div class="w-full max-w-[460px] mx-auto">
                <div class="mb-6">
                    <img src="{{ asset('logo-login.png') }}" alt="COINPEL" class="w-full h-auto select-none pointer-events-none">
                </div>

                @yield('content')
            </div>
        </div>

        <div class="relative hidden lg:flex lg:w-1/2 bg-coinpel-primary flex-col justify-end overflow-hidden">
            <img src="{{ asset('imagem-logo-page1.png') }}" alt="COINPEL Turismo" class="w-full object-contain object-bottom select-none pointer-events-none">
        </div>
    </div>
</body>
</html>
