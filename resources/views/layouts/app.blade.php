<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Helpora')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-gray-50 font-sans leading-normal tracking-normal flex flex-col min-h-screen">
    <!-- Header -->
    @livewire('shared.header')
    
    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>
    
    @livewireScripts
    @stack('scripts')
</body>
</html>
