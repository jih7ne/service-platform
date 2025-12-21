<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100 font-sans flex flex-col">
    
    <!-- Header Component -->
    <livewire:shared.intervenant-header />

    <!-- Contenu Principal -->
    <main class="flex-grow flex items-center justify-center p-6">
        <div class="w-full max-w-6xl mx-auto">
            
            <!-- En-tête Section avec animation -->
            <div class="text-center mb-16 animate-fade-in">
                <div class="inline-block mb-4">
                    <span class="px-4 py-2 bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-700 rounded-full text-sm font-semibold shadow-sm">
                        ✨ Espace Intervenant
                    </span>
                </div>
                <h2 class="text-4xl font-bold text-gray-800 mb-4 tracking-tight">Votre Espace de Travail</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Sélectionnez le service que vous souhaitez piloter aujourd'hui et gérez votre activité en toute simplicité.</p>
                
                <!-- Messages Flash Améliorés -->
                @if(session()->has('success'))
                    <div class="mt-6 max-w-md mx-auto p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg shadow-md animate-slide-down">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-green-800 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif
                
                @if(session()->has('error'))
                    <div class="mt-6 max-w-md mx-auto p-4 bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 rounded-lg shadow-md animate-slide-down">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-red-800 font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif
            </div>

            
            <!-- Services Grid avec espacement moderne -->
            <div class="flex justify-center flex-wrap gap-8">
                @foreach($services->take(2) as $index => $service)
                    @php
                        // Configuration Design selon le service
                        if (str_contains(strtolower($service->nomService), 'soutien') || str_contains(strtolower($service->nomService), 'scolaire')) {
                            $route = route('tutoring.dashboard');
                            $icon = '📚'; 
                            $title = 'Soutien Scolaire';
                            $desc = 'Gestion des cours et élèves';
                            $gradient = 'from-blue-500 to-cyan-500';
                            $gradientHover = 'from-blue-600 to-cyan-600';
                            $shadow = 'shadow-blue-100';
                            $btnBg = 'bg-blue-50 hover:bg-blue-100';
                            $btnText = 'text-blue-600';
                            $iconBg = 'bg-blue-50';
                        } elseif (str_contains(strtolower($service->nomService), 'baby')) {
                            $route = route('babysitter.dashboard');
                            $icon = '👶';
                            $title = 'Babysitting';
                            $desc = 'Gestion des gardes d\'enfants';
                            $gradient = 'from-pink-500 to-rose-500';
                            $gradientHover = 'from-pink-600 to-rose-600';
                            $shadow = 'shadow-pink-100';
                            $btnBg = 'bg-pink-50 hover:bg-pink-100';
                            $btnText = 'text-pink-600';
                            $iconBg = 'bg-pink-50';
                        } else {
                            $route = route('petkeeper.dashboard');
                            $icon = '🐾';
                            $title = $service->nomService;
                            $desc = 'Gestion de votre activité';
                            $gradient = 'from-amber-500 to-yellow-500';
                            $gradientHover = 'from-amber-600 to-yellow-600';
                            $shadow = 'shadow-amber-100';
                            $btnBg = 'bg-amber-50 hover:bg-amber-100';
                            $btnText = 'text-amber-600';
                            $iconBg = 'bg-amber-50';
                        }
                        
                        // Récupérer le statut du service
                        $user = Auth::user();
                        $statut = \DB::table('offres_services')
                            ->where('idService', $service->idService)
                            ->where('idIntervenant', $user->idUser)
                            ->value('statut') ?? 'ACTIVE';
                    @endphp

                    <!-- Carte Service Ultra Moderne avec animation au scroll -->
                    <div class="group relative bg-white rounded-3xl p-8 shadow-xl {{ $shadow }} hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border border-gray-100 overflow-hidden w-full sm:w-96 animate-card-entrance" style="animation-delay: {{ $index * 100 }}ms;">
                        
                        <!-- Effet de brillance au survol -->
                        <div class="absolute inset-0 bg-gradient-to-r {{ $gradient }} opacity-0 group-hover:opacity-5 transition-opacity duration-500"></div>
                        
                        <!-- Badge de statut (coin supérieur droit) -->
                        <div class="absolute top-4 right-4 z-20">
                            @if($statut === 'ACTIVE')
                                <span class="flex items-center gap-1.5 px-3 py-1.5 bg-green-100 text-green-700 text-xs font-bold rounded-full border border-green-200 shadow-sm">
                                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                    Actif
                                </span>
                            @else
                                <span class="flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 text-gray-600 text-xs font-bold rounded-full border border-gray-200 shadow-sm">
                                    <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                    Archivé
                                </span>
                            @endif
                        </div>
                        
                        <!-- Cercles décoratifs animés -->
                        <div class="absolute top-0 right-0 -mt-12 -mr-12 w-40 h-40 bg-gradient-to-br {{ $gradient }} rounded-full opacity-10 group-hover:scale-150 transition-transform duration-700 ease-out"></div>
                        <div class="absolute bottom-0 left-0 -mb-8 -ml-8 w-32 h-32 bg-gradient-to-tr {{ $gradient }} rounded-full opacity-5 group-hover:scale-125 transition-transform duration-700 ease-out"></div>
                        
                        <div class="relative z-10 flex flex-col items-center text-center">
                            <!-- Icône avec effet 3D -->
                            <div class="relative mb-6">
                                <div class="absolute inset-0 bg-gradient-to-br {{ $gradient }} rounded-3xl blur-xl opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                                <div class="relative w-24 h-24 rounded-3xl bg-gradient-to-br {{ $gradient }} text-white flex items-center justify-center text-5xl shadow-2xl transform group-hover:rotate-6 group-hover:scale-110 transition-all duration-500">
                                    {{ $icon }}
                                </div>
                            </div>

                            <!-- Titre et Description -->
                            <h3 class="text-2xl font-bold text-gray-800 mb-2 group-hover:text-gray-900 transition-colors duration-300">{{ $title }}</h3>
                            <p class="text-gray-500 mb-8 text-sm leading-relaxed">{{ $desc }}</p>

                            <!-- Séparateur décoratif -->
                            <div class="w-16 h-1 bg-gradient-to-r {{ $gradient }} rounded-full mb-8 group-hover:w-24 transition-all duration-300"></div>

                            <!-- Boutons avec design moderne -->
                            <div class="flex flex-col gap-3 w-full">
                                <a href="{{ $route }}" class="group/btn relative inline-flex items-center justify-center font-bold {{ $btnText }} {{ $btnBg }} px-6 py-3.5 rounded-2xl transition-all duration-300 shadow-md hover:shadow-lg overflow-hidden">
                                    <span class="relative z-10 flex items-center">
                                        Accéder au tableau de bord
                                        <svg class="w-5 h-5 ml-2 transform group-hover/btn:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </span>
                                </a>
                                
                                @if($statut === 'ARCHIVED')
                                    <button 
                                        wire:click="unarchiveService('{{ $service->idService }}')"
                                        class="group/archive inline-flex items-center justify-center font-bold text-green-600 bg-green-50 hover:bg-green-100 px-6 py-3.5 rounded-2xl transition-all duration-300 shadow-md hover:shadow-lg"
                                    >
                                        <svg class="w-5 h-5 mr-2 transform group-hover/archive:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        Désarchiver le service
                                    </button>
                                @else
                                    <button 
                                        wire:click="archiveService('{{ $service->idService }}')"
                                        class="group/archive inline-flex items-center justify-center font-bold text-red-600 bg-red-50 hover:bg-red-100 px-6 py-3.5 rounded-2xl transition-all duration-300 shadow-md hover:shadow-lg"
                                    >
                                        <svg class="w-5 h-5 mr-2 transform group-hover/archive:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                        </svg>
                                        Archiver le service
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            @if($services->count() === 0)
                <!-- État vide moderne -->
                <div class="text-center py-20 animate-fade-in">
                    <div class="inline-flex items-center justify-center w-32 h-32 bg-gradient-to-br from-blue-100 to-cyan-100 rounded-full mb-8 shadow-lg">
                        <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-4">Aucun service disponible</h3>
                    <p class="text-gray-600 mb-10 max-w-md mx-auto text-lg">Commencez par créer votre premier service pour le rendre visible à vos clients.</p>
                    <button class="px-8 py-4 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-2xl font-bold shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 inline-flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Créer mon premier service
                    </button>
                </div>
            @endif
        </div>
    </main>
    
    <!-- Footer Component -->
    <livewire:shared.footer />

    <!-- Modal Ajouter Service -->
    @if($showAddServiceModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl p-8 max-w-2xl w-full shadow-2xl transform transition-all">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Choisissez un service à ajouter</h3>
                <button wire:click="closeAddServiceModal" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Service Soutien Scolaire -->
                @if(!$this->hasService('soutien'))
                <button wire:click="addService('soutien')" class="group p-6 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl hover:shadow-lg transition-all border-2 border-transparent hover:border-blue-400">
                    <div class="text-4xl mb-3">📚</div>
                    <h4 class="font-bold text-gray-800 mb-2">Soutien Scolaire</h4>
                    <p class="text-sm text-gray-600">Cours particuliers et aide aux devoirs</p>
                </button>
                @endif

                <!-- Service Babysitting -->
                @if(!$this->hasService('baby'))
                <button wire:click="addService('baby')" class="group p-6 bg-gradient-to-br from-pink-50 to-rose-50 rounded-2xl hover:shadow-lg transition-all border-2 border-transparent hover:border-pink-400">
                    <div class="text-4xl mb-3">👶</div>
                    <h4 class="font-bold text-gray-800 mb-2">Babysitting</h4>
                    <p class="text-sm text-gray-600">Garde d'enfants à domicile</p>
                </button>
                @endif

                <!-- Service Pet Keeping -->
                @if(!$this->hasService('pet'))
                <button wire:click="addService('pet')" class="group p-6 bg-gradient-to-br from-emerald-50 to-green-50 rounded-2xl hover:shadow-lg transition-all border-2 border-transparent hover:border-green-400">
                    <div class="text-4xl mb-3">🐾</div>
                    <h4 class="font-bold text-gray-800 mb-2">Pet Keeping</h4>
                    <p class="text-sm text-gray-600">Garde d'animaux de compagnie</p>
                </button>
                @endif
            </div>

            @if($allServicesActive)
            <p class="text-center text-gray-500 mt-6">Vous proposez déjà tous les services disponibles !</p>
            @endif
        </div>
    </div>
    @endif

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    
        @keyframes slide-down {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    
        @keyframes card-entrance {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
    
        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }
    
        .animate-slide-down {
            animation: slide-down 0.4s ease-out;
        }
    
        .animate-card-entrance {
            animation: card-entrance 0.7s ease-out both;
        }
    
        /* Effet de pulse sur le badge actif */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }
    
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</div>