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
            <div class="w-full max-w-sm mx-auto">
                <div class="flex justify-center mb-10">
                    <img src="{{ asset('logo-login.png') }}" alt="COINPEL" class="h-20 w-auto">
                </div>

                @yield('content')
            </div>
        </div>

        <div class="relative hidden lg:flex lg:w-1/2 bg-[#5B2D8E] items-center justify-center p-12 overflow-hidden">
            <img src="{{ asset('imagem-logo-page.svg') }}" alt="COINPEL Turismo" class="max-w-full max-h-full object-contain">
        </div>
    </div>
</body>
</html>
