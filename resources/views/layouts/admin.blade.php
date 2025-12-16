<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Helpora</title>
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
    
    <style>
        /* Styles pour les modals */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        
        .modal-content {
            background: white;
            border-radius: 1rem;
            max-width: 28rem;
            width: 100%;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            max-height: 90vh;
            overflow-y: auto;
        }
        
        /* Animation pour les modals */
        .modal-enter {
            animation: modalEnter 0.3s ease-out;
        }
        
        @keyframes modalEnter {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(-10px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
        
        /* Empêcher le scroll du body quand modal ouvert */
        body.modal-open {
            overflow: hidden;
        }

        /* S'assurer que le conteneur principal ne cache pas les modals */
        .main-container {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body class="bg-[#F7F7F7]">
    <div class="flex h-screen overflow-hidden">
        @livewire('shared.admin.admin-sidebar', ['currentPage' => 'admin-dashboard'])
        
        <main class="flex-1 overflow-y-auto main-container">
            @isset($slot)
                {{ $slot }}
            @else
                @yield('content')
            @endisset
        </main>
    </div>
    
    <!-- 🎯 ZONE POUR LES MODALS - EN DEHORS DU CONTENEUR PRINCIPAL -->
    <div id="modal-root"></div>
    
    @livewireScripts
    @stack('scripts')

    <script>
        // Gérer l'ouverture/fermeture des modals
        document.addEventListener('livewire:init', () => {
            Livewire.on('modalOpened', () => {
                document.body.classList.add('modal-open');
            });
            
            Livewire.on('modalClosed', () => {
                document.body.classList.remove('modal-open');
            });
        });

        // Fermer les modals avec Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modals = document.querySelectorAll('.modal-backdrop');
                if (modals.length > 0) {
                    Livewire.dispatch('close-all-modals');
                }
            }
        });
        
        // Fermer les modals en cliquant à l'extérieur
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-backdrop')) {
                Livewire.dispatch('close-all-modals');
            }
        });
    </script>
</body>
</html>