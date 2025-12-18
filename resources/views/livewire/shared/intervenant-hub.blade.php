<div class="min-h-screen bg-[#F3F4F6] font-sans flex flex-col">
    
    <!-- Header Component -->
    <livewire:shared.intervenant-header />

    <!-- Contenu Principal -->
    <main class="flex-grow flex items-center justify-center p-6">
        <div class="w-full max-w-6xl mx-auto">
            
            <div class="text-center mb-12">
                <h2 class="text-2xl font-bold text-gray-700 mb-3">Votre Espace de Travail</h2>
                <p class="text-gray-500">Sélectionnez le service que vous souhaitez piloter aujourd'hui.</p>
                
                @if(session()->has('success'))
                    <div class="mt-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session()->has('error'))
                    <div class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <!-- Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
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
                        } elseif (str_contains(strtolower($service->nomService), 'pet') || str_contains(strtolower($service->nomService), 'animaux')) {
                            $route = route('petkeeper.dashboard');
                            $icon = '🐾';
                            $title = 'Pet Keeping';
                            $desc = 'Gestion de la garde d\'animaux';
                            $gradient = 'from-emerald-500 to-green-500';
                            $shadow = 'shadow-green-200';
                            $btnText = 'text-green-600';
                        } else {
                            $route = route('intervenant.hub');
                            $icon = '📋';
                            $title = $service->nomService;
                            $desc = 'Gestion de votre activité';
                            $gradient = 'from-gray-500 to-gray-600';
                            $shadow = 'shadow-gray-200';
                            $btnText = 'text-gray-600';
                        }
                        
                        // Récupérer le statut du service
                        $user = Auth::user();
                        $statut = \DB::table('offres_services')
                            ->where('idService', $service->idService)
                            ->where('idIntervenant', $user->idUser)
                            ->value('statut') ?? 'ACTIVE';
                    @endphp

                    <!-- Carte Service Animée -->
                    <div class="group relative bg-white rounded-3xl p-8 shadow-xl {{ $shadow }} hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 overflow-hidden {{ $statut === 'ARCHIVED' ? 'opacity-60' : '' }}">
                        
                        @if($statut === 'ARCHIVED')
                            <div class="absolute top-4 right-4 bg-gray-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                                ARCHIVÉ
                            </div>
                        @endif
                        
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

                            <!-- Boutons -->
                            <div class="flex flex-col gap-3 w-full">
                                @if($statut === 'ACTIVE')
                                    <a href="{{ $route }}" class="inline-flex items-center justify-center font-bold {{ $btnText }} bg-gray-50 px-6 py-3 rounded-full hover:bg-gray-100 transition-colors">
                                        Accéder au tableau de bord
                                        <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                    </a>
                                    
                                    <button 
                                        wire:click="archiveService('{{ $service->idService }}')"
                                        class="inline-flex items-center justify-center font-bold text-red-600 bg-red-50 px-6 py-3 rounded-full hover:bg-red-100 transition-colors"
                                    >
                                        Archiver
                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                    </button>
                                @else
                                    <button 
                                        wire:click="unarchiveService('{{ $service->idService }}')"
                                        class="inline-flex items-center justify-center font-bold text-green-600 bg-green-50 px-6 py-3 rounded-full hover:bg-green-100 transition-colors"
                                    >
                                        Désarchiver
                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Bouton Ajouter un Service (si autorisé) -->
                @if($canAddService)
                    <div class="group relative bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-2 border-dashed border-gray-300 hover:border-purple-400 overflow-hidden cursor-pointer">
                        
                        <!-- Cercle de fond décoratif -->
                        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-full opacity-10 group-hover:scale-150 transition-transform duration-500 ease-out"></div>
                        
                        <div class="relative z-10 flex flex-col items-center justify-center text-center h-full min-h-[300px]">
                            <!-- Icône Plus -->
                            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-purple-500 to-indigo-500 text-white flex items-center justify-center text-4xl mb-6 shadow-lg transform group-hover:rotate-90 transition-transform duration-300">
                                ➕
                            </div>

                            <!-- Titre et Description -->
                            <h3 class="text-2xl font-bold text-gray-800 mb-2 group-hover:text-purple-600 transition-colors">Ajouter un Service</h3>
                            <p class="text-gray-500 mb-8">Proposez un nouveau service à vos clients</p>

                            <!-- Bouton -->
                            <button 
                                wire:click="$dispatch('openAddServiceModal')"
                                class="inline-flex items-center justify-center font-bold text-purple-600 bg-purple-50 px-6 py-3 rounded-full hover:bg-purple-100 transition-colors"
                            >
                                Commencer
                                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
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
</div>