<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Helpora</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>
<body class="bg-[#F7F7F7]">
    <div class="flex h-screen overflow-hidden">
        @livewire('shared.admin.admin-sidebar', ['currentPage' => 'admin-dashboard'])
        
        <main class="flex-1 overflow-y-auto">
            @isset($slot)
                {{ $slot }}
            @else
                @yield('content')
            @endisset
        </main>
    </div>
    
    @livewireScripts
    @stack('scripts')
</body>
</html>