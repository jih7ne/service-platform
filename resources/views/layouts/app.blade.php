<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helpora</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-gray-50 font-sans leading-normal tracking-normal flex flex-col min-h-screen">

    <!-- ICI J'APPELLE TON HEADER -->
    <livewire:shared.header />

    <!-- ICI C'EST LE CONTENU DE TA PAGE QUI VA S'AFFICHER -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- ICI J'APPELLE TON FOOTER -->
    <livewire:shared.footer />

    @livewireScripts
</body>
</html>
    <title>@yield('title', 'Helpora')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-gray-50">
    @yield('content')
    
    @livewireScripts
    @stack('scripts')
</body>
</html>