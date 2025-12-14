<div class="min-h-screen bg-[#F3F4F6] font-sans flex flex-col">
    
    <!-- En-tête (Header) avec date et profil -->
    <header class="bg-white shadow-sm border-b border-gray-100 py-6 px-8">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-800">
                    Bonjour, <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">{{ $prenom }}</span> !
                </h1>
            </div>
            <div class="hidden md:flex items-center space-x-4">
                <div class="text-right">
                    <p class="text-sm font-bold text-gray-800">{{ Auth::user()->nom }} {{ Auth::user()->prenom }}</p>
                    <p class="text-xs text-green-500 font-semibold flex items-center justify-end">
                        <span class="w-2 h-2 rounded-full bg-green-500 mr-1 animate-pulse"></span> En ligne
                    </p>
                </div>
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold text-lg shadow-lg">
                    {{ substr($prenom, 0, 1) }}
                </div>
            </div>
        </div>
    </header>

    <!-- Contenu Principal -->
    <main class="flex-grow flex items-center justify-center p-6">
        <div class="max-w-5xl w-full">
            
            <div class="text-center mb-12">
                <h2 class="text-2xl font-bold text-gray-700 mb-3">Votre Espace de Travail</h2>
                <p class="text-gray-500">Sélectionnez le service que vous souhaitez piloter aujourd'hui.</p>
            </div>

            <!-- Grille des Services -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 justify-center">
                @foreach($services as $service)
                    @php
                        // Configuration Design selon le service
                        if (str_contains(strtolower($service->nomService), 'soutien') || str_contains(strtolower($service->nomService), 'scolaire')) {
                            $route = route('tutoring.dashboard');
                            $icon = '📚'; 
                            $title = 'Soutien Scolaire';
                            $desc = 'Gestion des cours et élèves';
                            $gradient = 'from-blue-500 to-cyan-500';
                            $shadow = 'shadow-blue-200';
                            $btnText = 'text-blue-600';
                        } elseif (str_contains(strtolower($service->nomService), 'baby')) {
                            $route = route('babysitter.dashboard');
                            $icon = '👶';
                            $title = 'Babysitting';
                            $desc = 'Gestion des gardes d\'enfants';
                            $gradient = 'from-pink-500 to-rose-500';
                            $shadow = 'shadow-pink-200';
                            $btnText = 'text-pink-600';
                        } else {
                            $route = '#';
                            $icon = '🐾';
                            $title = $service->nomService;
                            $desc = 'Gestion de votre activité';
                            $gradient = 'from-emerald-500 to-green-500';
                            $shadow = 'shadow-green-200';
                            $btnText = 'text-green-600';
                        }
                    @endphp

                    <!-- Carte Service Animée -->
                    <a href="{{ $route }}" class="group relative bg-white rounded-3xl p-8 shadow-xl {{ $shadow }} hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 overflow-hidden">
                        
                        <!-- Cercle de fond décoratif (animé au survol) -->
                        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-gradient-to-br {{ $gradient }} rounded-full opacity-10 group-hover:scale-150 transition-transform duration-500 ease-out"></div>
                        
                        <div class="relative z-10 flex flex-col items-center text-center">
                            <!-- Icône -->
                            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br {{ $gradient }} text-white flex items-center justify-center text-4xl mb-6 shadow-lg transform group-hover:rotate-6 transition-transform duration-300">
                                {{ $icon }}
                            </div>

                            <!-- Titre et Description -->
                            <h3 class="text-2xl font-bold text-gray-800 mb-2 group-hover:text-black transition-colors">{{ $title }}</h3>
                            <p class="text-gray-500 mb-8">{{ $desc }}</p>

                            <!-- Bouton "Faux" -->
                            <span class="inline-flex items-center font-bold {{ $btnText }} bg-gray-50 px-6 py-3 rounded-full group-hover:bg-gray-100 transition-colors">
                                Accéder au tableau de bord
                                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Section Raccourcis Rapides (Décoratif) -->
            <!-- Section Raccourcis Rapides -->
            <div class="mt-16 text-center">
                <p class="text-sm font-semibold text-gray-400 uppercase tracking-wide mb-6">Raccourcis Rapides</p>
                <div class="flex flex-wrap justify-center gap-4">
                    
                    <!-- Bouton Disponibilités (Gardé) -->
                    <button class="flex items-center px-4 py-2 bg-white rounded-lg shadow-sm border border-gray-200 text-gray-600 hover:text-blue-600 hover:border-blue-200 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Mes Disponibilités
                    </button>

                    <!-- Bouton Déconnexion (Fonctionnel) -->
                    <button 
                        wire:click="logout" 
                        class="flex items-center px-4 py-2 bg-white rounded-lg shadow-sm border border-gray-200 text-gray-600 hover:text-red-600 hover:border-red-200 transition-colors"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Déconnexion
                    </button>
                </div>
            </div>

        </div>
    </main>
</div>