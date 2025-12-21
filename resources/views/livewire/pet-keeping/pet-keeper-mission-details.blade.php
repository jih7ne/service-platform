<div>
    <!-- SIDEBAR GAUCHE -->
    <aside class="w-72 bg-white h-screen fixed left-0 top-0 border-r border-gray-100 flex flex-col z-40 shadow-[4px_0_24px_rgba(0,0,0,0.02)]">
        <!-- Logo -->
        <div class="p-8 flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-700 rounded-xl flex items-center justify-center text-white font-bold shadow-amber-200 shadow-lg">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                </svg>
            </div>
            <span class="text-2xl font-extrabold text-gray-800 tracking-tight">Helpora</span>
        </div>

        <div class="px-6 pb-6">
            <p class="text-xs font-bold text-gray-400 mb-4 uppercase tracking-wider pl-2">Espace PetKeeper</p>
            
            <!-- Carte Profil Miniature -->
            <div class="bg-white rounded-2xl p-3 flex items-center gap-3 border border-gray-100 shadow-sm group hover:border-amber-200 transition-colors cursor-pointer">
                <div class="w-12 h-12 rounded-full bg-gray-100 p-0.5 border-2 border-white shadow-sm overflow-hidden">
                    @if(isset($user->photo) && $user->photo)
                        <img src="{{ Storage::url($user->photo) }}" class="w-full h-full rounded-full object-cover">
                    @else
                        <img class="w-full h-full rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ $user->prenom }}+{{ $user->nom }}&background=d97706&color=fff" alt="Avatar">
                    @endif
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-gray-900 leading-tight group-hover:text-amber-700 transition-colors">
                        {{ $user->prenom }} {{ $user->nom }}
                    </h4>
                    <div class="flex items-center text-xs text-amber-600 font-bold mt-0.5">
                        <span class="bg-amber-50 px-1.5 py-0.5 rounded text-[10px] tracking-wide">★ 4.8</span>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 flex items-center justify-between text-[11px] font-semibold text-gray-500 bg-gray-50 rounded-lg p-2 px-4">
                <span>{{ $this->groupAnimalsByDemande(collect([$demande]))[0]['animals'][0]['nom'] ?? 'Mission' }}</span>
                <span class="text-green-600 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> En ligne
                </span>
            </div>
            
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
            <a href="/pet-keeper/dashboard" class="flex items-center gap-3 px-4 py-3.5 text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900 rounded-xl transition-all group">
                <svg class="w-5 h-5 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                Tableau de bord
            </a>
            
            <a href="/pet-keeper/missions" class="flex items-center gap-3 px-4 py-3.5 text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900 rounded-xl transition-all group">
                <svg class="w-5 h-5 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Mes Missions
            </a>

            <a href="/pet-keeper/profile" class="flex items-center gap-3 px-4 py-3.5 text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900 rounded-xl transition-all group">
                <svg class="w-5 h-5 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Mon Profil
            </a>

            <a href="/pet-keeper/dashboard/services" class="flex items-center gap-3 px-4 py-3.5 text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900 rounded-xl transition-all group">
                <svg class="w-5 h-5 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                Mes Services
            </a>

            <a href="/pet-keeper/dashboard/clients" 
               class="flex items-center gap-3 px-4 py-3 text-gray-700 font-medium hover:text-yellow-600 rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13 0a11 11 0 01-2.5 7.5"/>
                </svg>
                <span>Mes Clients</span>
            </a>

            <a href="/pet-keeper/dashboard/disponibilites" 
               class="flex items-center gap-3 px-4 py-3 text-gray-600 font-medium hover:text-yellow-600 rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>Disponibilités</span>
            </a>
        </nav>

        <div class="p-6">
            <button class="flex items-center gap-3 text-gray-400 font-bold text-sm hover:text-red-500 transition-colors w-full px-4 py-2 hover:bg-red-50 rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Déconnexion
            </button>
        </div>
    </aside>

    <!-- MAIN CONTENT - Offset by sidebar width -->
    <div class="ml-72 min-h-screen bg-gray-50">
        @if($demande && $demande->count() > 0)
            @php
                $groupedData = $this->groupAnimalsByDemande($demande);
                $mission = $groupedData[0]['demande'] ?? null;
                $animals = $groupedData[0]['animals'] ?? [];
                $creneaux = $groupedData[0]['creneaux'] ?? [];
                
                $statusColors = [
                    'en_attente' => 'bg-yellow-100 text-yellow-800',
                    'validée' => 'bg-blue-100 text-blue-800',
                    'en_cours' => 'bg-green-100 text-green-800',
                    'terminée' => 'bg-green-100 text-green-800',
                    'refusée' => 'bg-red-100 text-red-800',
                    'annulée' => 'bg-gray-100 text-gray-800',
                ];
            @endphp
            
            @if($mission)
                <!-- Back Button -->
                <div class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <a href="{{ route('petkeeper.missions') }}" class="flex items-center gap-2 text-gray-600 hover:text-yellow-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Retour aux missions
                            </a>
                            <div class="h-6 w-px bg-gray-300"></div>
                            <h1 class="text-2xl font-bold text-gray-900">Mission #{{ $mission->idDemande }}</h1>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <span class="px-4 py-2 text-sm font-semibold rounded-full {{ $statusColors[$mission->statut] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst(str_replace('_', ' ', $mission->statut)) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="px-6 py-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Left Column: Mission Details -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Mission Overview Card -->
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                                <div class="p-6 border-b border-gray-100">
                                    <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                        <span class="w-2 h-6 bg-yellow-500 rounded-full mr-3"></span>
                                        Détails de la mission
                                    </h2>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <p class="text-sm font-medium text-gray-500 mb-2">Date de la mission</p>
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-lg bg-yellow-50 flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-lg font-bold text-gray-900">
                                                        {{ \Carbon\Carbon::parse($mission->dateSouhaitee)->format('d F Y') }}
                                                    </p>
                                                    <p class="text-sm text-gray-500">
                                                        {{ substr($mission->heureDebut, 0, 5) }} - {{ substr($mission->heureFin, 0, 5) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <p class="text-sm font-medium text-gray-500 mb-2">Lieu</p>
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-lg font-bold text-gray-900">{{ $mission->ville_client }}</p>
                                                    <p class="text-sm text-gray-500">Adresse précise fournie</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Client Information -->
                                <div class="p-6 border-b border-gray-100">
                                    <h3 class="font-semibold text-gray-900 mb-4">Client</h3>
                                    <div class="flex items-center gap-4">
                                        @if($mission->photo_client)
                                            <img src="{{ asset('storage/' . $mission->photo_client) }}" 
                                                 alt="{{ $mission->prenom_client }}" 
                                                 class="w-14 h-14 rounded-full object-cover border-2 border-yellow-100">
                                        @else
                                            <div class="w-14 h-14 rounded-full bg-yellow-100 flex items-center justify-center border-2 border-yellow-200">
                                                <span class="text-xl font-bold text-yellow-700">
                                                    {{ strtoupper(substr($mission->prenom_client, 0, 1)) }}
                                                </span>
                                            </div>
                                        @endif
                                        <div>
                                            <h4 class="text-lg font-bold text-gray-900">{{ $mission->prenom_client }} {{ $mission->nom_client }}</h4>
                                            <div class="flex items-center gap-4 mt-2">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                    <span class="text-sm font-medium text-gray-700">{{ $mission->note_client ?? '4.8' }}/5</span>
                                                </div>
                                                <button class="text-sm font-medium text-yellow-600 hover:text-yellow-700">
                                                    Voir le profil complet →
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Créneaux Section -->
                                @if(count($creneaux) > 0)
                                <div class="p-6 border-b border-gray-100">
                                    <h3 class="font-semibold text-gray-900 mb-4">Créneaux planifiés</h3>
                                    <div class="space-y-4">
                                        @foreach($creneaux as $date => $creneauxDuJour)
                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <div class="flex items-center justify-between mb-3">
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    <span class="font-semibold text-gray-900">
                                                        {{ \Carbon\Carbon::parse($date)->format('d F Y') }}
                                                    </span>
                                                </div>
                                                <span class="text-sm text-gray-500">{{ count($creneauxDuJour) }} créneau(x)</span>
                                            </div>
                                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                                @foreach($creneauxDuJour as $creneau)
                                                <div class="bg-white p-3 rounded-lg border border-gray-200 text-center">
                                                    <div class="text-sm font-medium text-gray-900">{{ $creneau['heureDebut'] }}</div>
                                                    <div class="text-xs text-gray-500 my-1">à</div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $creneau['heureFin'] }}</div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                               
                            </div>

                            <!-- Animals Details Card -->
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                                <div class="p-6 border-b border-gray-100">
                                    <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                        <span class="w-2 h-6 bg-green-500 rounded-full mr-3"></span>
                                        Animaux à garder
                                    </h2>
                                </div>
                                
                                <div class="p-6 space-y-6">
                                    @foreach($animals as $animal)
                                    <div class="bg-gray-50 rounded-lg p-5">
                                        <div class="flex items-start justify-between mb-4">
                                            <div>
                                                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $animal['nom'] }}</h3>
                                                <div class="flex items-center gap-3">
                                                    <span class="text-sm font-medium text-gray-700">{{ $animal['race'] }}</span>
                                                    <span class="text-sm text-gray-500">•</span>
                                                    <span class="text-sm text-gray-500">{{ $animal['age'] }} ans</span>
                                                    <span class="text-sm text-gray-500">•</span>
                                                    <span class="text-sm font-medium text-gray-700">{{ $animal['espece'] }}</span>
                                                </div>
                                            </div>
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                                {{ $animal['statutVaccination'] === 'RECURRING' ? 'bg-green-100 text-green-800' : 
                                                   ($animal['statutVaccination'] === 'NEVER' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                {{ $animal['statutVaccination'] }}
                                            </span>
                                        </div>

                                        <!-- Vaccination Status -->
                                        <div class="mb-4">
                                            <p class="text-sm font-medium text-gray-700 mb-2">Statut de vaccination</p>
                                            <div class="flex items-center gap-2">
                                                @if($animal['statutVaccination'] === 'RECURRING')
                                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span class="text-sm text-green-600">Vaccinations à jour</span>
                                                @elseif($animal['statutVaccination'] === 'NEVER')
                                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                    <span class="text-sm text-red-600">Non vacciné</span>
                                                @else
                                                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.688 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                                    </svg>
                                                    <span class="text-sm text-yellow-600">Vaccination partielle</span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Behavior Notes -->
                                        @if($animal['note_comportementale'])
                                        <div>
                                            <p class="text-sm font-medium text-gray-700 mb-2">Comportement</p>
                                            <div class="bg-yellow-50 rounded-lg p-3 border border-yellow-100">
                                                <p class="text-sm text-gray-700">{{ $animal['note_comportementale'] }}</p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Summary & Actions -->
                        <div class="space-y-6">
                            <!-- Summary Card -->
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                                <div class="p-6 border-b border-gray-100">
                                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Récapitulatif</h2>
                                </div>
                                
                                <div class="p-6 space-y-4">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Numéro de mission</span>
                                        <span class="font-semibold text-gray-900">#{{ $mission->idDemande }}</span>
                                    </div>
                                    
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Date de demande</span>
                                        <span class="font-semibold text-gray-900">
                                            {{ \Carbon\Carbon::parse($mission->dateDemande)->format('d/m/Y H:i') }}
                                        </span>
                                    </div>
                                    
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Facture</span>
                                        <span class="font-semibold text-gray-900">{{ $mission->numFac ?? 'À générer' }}</span>
                                    </div>
                                    
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Durée estimée</span>
                                        @php
                                            $debut = \Carbon\Carbon::parse($mission->heureDebut);
                                            $fin = \Carbon\Carbon::parse($mission->heureFin);
                                            $duree = $fin->diffInHours($debut);
                                        @endphp
                                        <span class="font-semibold text-gray-900">{{ $duree }} heures</span>
                                    </div>
                                    
                                    <div class="pt-4 border-t border-gray-100">
                                        <div class="flex justify-between items-center">
                                            <span class="text-lg font-bold text-gray-900">Montant total</span>
                                            <span class="text-2xl font-bold text-yellow-600">
                                                {{ number_format($mission->montantTotal, 2, ',', ' ') }} DH
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-500 mt-1">TVA incluse</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions Card -->
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                                <div class="p-6 border-b border-gray-100">
                                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Actions</h2>
                                </div>
                                
                                <div class="p-6 space-y-3">
                                    @if(in_array($mission->statut, ['en_attente', 'validée']))
                                        <button class="w-full px-4 py-3 bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 transition-colors shadow-sm flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Démarrer la mission
                                        </button>
                                        
                                        <button class="w-full px-4 py-3 bg-white text-gray-700 font-semibold rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                            </svg>
                                            Signaler un problème
                                        </button>
                                    @endif
                                    
                                    @if($mission->statut === 'en_cours')
                                        <button class="w-full px-4 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors shadow-sm flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Terminer la mission
                                        </button>
                                    @endif
                                    
                                    @if($mission->statut === 'terminée')
                                        <button class="w-full px-4 py-3 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-colors shadow-sm flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Mission terminée
                                        </button>
                                    @endif
                                    
                                    <button class="w-full px-4 py-3 bg-white text-red-600 font-semibold rounded-lg border border-red-200 hover:bg-red-50 transition-colors flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Annuler la mission
                                    </button>
                                    
                                    <a href="{{ route('petkeeper.missions') }}" class="block text-center text-sm font-medium text-gray-600 hover:text-yellow-600 transition-colors pt-2">
                                        ← Retour à la liste des missions
                                    </a>
                                </div>
                            </div>

                            
                        </div>
                    </div>
                </div>
            @endif
        @else
            <!-- Error State -->
            <div class="ml-72 min-h-screen flex items-center justify-center">
                <div class="text-center">
                    <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.688 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">Mission introuvable</h2>
                    <p class="text-gray-500 mb-6">La mission que vous recherchez n'existe pas ou a été supprimée.</p>
                    <a href="{{ route('petkeeper.missions') }}" class="px-6 py-3 bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 transition-colors inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Retour aux missions
                    </a>
                </div>
            </div>
        @endif
    </div>

    <style>
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>
</div>