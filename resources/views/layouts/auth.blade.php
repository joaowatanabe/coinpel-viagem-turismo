<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="min-h-screen bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>COINPEL — Autenticação</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased text-gray-900">
    <div class="flex min-h-screen">
        <div class="flex flex-col justify-center flex-1 px-4 py-12 sm:px-6 lg:flex-none lg:w-1/2 lg:px-20 xl:px-24 bg-white">
            <div class="w-full max-w-[460px] mx-auto">
                <div class="mb-6">
                    <img src="{{ asset('logo-login.png') }}" alt="COINPEL" class="w-full h-auto select-none pointer-events-none">
                </div>

                @yield('content')
            </div>
        </div>

        <div class="relative hidden lg:block lg:w-1/2 bg-coinpel-primary overflow-hidden">
            <img src="{{ asset('imagem-logo-page.svg') }}" alt="COINPEL Turismo" class="absolute bottom-0 left-0 w-full h-auto select-none pointer-events-none">
        </div>
    </div>
</body>
</html>
