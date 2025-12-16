<div class="min-h-screen bg-[#F3F4F6] font-sans flex flex-col">
    
    <!-- Header Component -->
    <livewire:shared.intervenant-header />

    <!-- Contenu Principal -->
    <main class="flex-grow flex items-center justify-center p-6">
        <div class="w-full">
            
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

            
            <!-- Services Horizontaux -->
            <div class="flex justify-center flex-wrap">
                @foreach($services->take(2) as $service)
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
                    <a href="{{ $route }}" class="group relative bg-white rounded-3xl p-8 shadow-xl {{ $shadow }} hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 overflow-hidden mr-4">
                        
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
                            <div class="flex flex-col gap-3">
                                <a href="{{ $route }}" class="inline-flex items-center font-bold {{ $btnText }} bg-gray-50 px-6 py-3 rounded-full group-hover:bg-gray-100 transition-colors">
                                    Accéder au tableau de bord
                                    <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </a>
                                
                                @php
                                    // Récupérer le statut du service
                                    $user = Auth::user();
                                    $statut = \DB::table('offres_services')
                                        ->where('idService', $service->idService)
                                        ->where('idIntervenant', $user->idUser)
                                        ->value('statut') ?? 'ACTIVE';
                                @endphp
                                
                                @if($statut === 'ARCHIVED')
                                    <button 
                                        wire:click="unarchiveService('{{ $service->idService }}')"
                                        class="inline-flex items-center font-bold text-green-600 bg-green-50 px-6 py-3 rounded-full hover:bg-green-100 transition-colors"
                                    >
                                        Désarchiver
                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                    </button>
                                @else
                                    <button 
                                        wire:click="archiveService('{{ $service->idService }}')"
                                        class="inline-flex items-center font-bold text-red-600 bg-red-50 px-6 py-3 rounded-full hover:bg-red-100 transition-colors"
                                    >
                                        Archiver
                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
    </main>
    
    <!-- Footer Component -->
    <livewire:shared.footer />
</div>