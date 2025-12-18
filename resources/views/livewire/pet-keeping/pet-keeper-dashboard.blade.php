<div>

<div>
    <!-- SIDEBAR GAUCHE -->
    <aside class="w-72 bg-white h-screen fixed left-0 top-0 border-r border-gray-100 flex flex-col z-40 shadow-[4px_0_24px_rgba(0,0,0,0.02)]">
        <!-- Logo -->
        <div class="p-8 flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-700 rounded-xl flex items-center justify-center text-white font-bold shadow-amber-200 shadow-lg">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
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
                        <span class="bg-amber-50 px-1.5 py-0.5 rounded text-[10px] tracking-wide">★ {{ $stats['note'] ?? 4.8 }}</span>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 flex items-center justify-between text-[11px] font-semibold text-gray-500 bg-gray-50 rounded-lg p-2 px-4">
                <span>{{ $stats['missions'] ?? 0 }} missions</span>
                <span class="text-green-600 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> En ligne
                </span>
            </div>
            
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
            <a href="/pet-keeper/dashboard" class="flex items-center gap-3 px-4 py-3.5 bg-amber-50 text-amber-800 font-bold rounded-xl transition-all shadow-sm border-l-4 border-amber-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Tableau de bord
            </a>
            
            <a href="/pet-keeper/missions" class="flex items-center gap-3 px-4 py-3.5 text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900 rounded-xl transition-all group">
                <svg class="w-5 h-5 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Mes Missions
            </a>

            <a href="/pet-keeper/profile" class="flex items-center gap-3 px-4 py-3.5 text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900 rounded-xl transition-all group">
                <svg class="w-5 h-5 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Mon Profil
            </a>

            <a href="/pet-keeper/dashboard/services" class="flex items-center gap-3 px-4 py-3.5 text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900 rounded-xl transition-all group">
                <svg class="w-5 h-5 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
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
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Déconnexion
            </button>
        </div>
    </aside>

    <!-- MAIN CONTENT - Offset by sidebar width -->
    <div class="ml-72 min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Tableau de bord</h1>
                        <p class="text-gray-500">Gérez vos missions et demandes</p>
                    </div>
                    
                    <!-- Availability Toggle -->
                    <div class="flex items-center gap-4">
                        <div class="flex items-center">
                            <span class="mr-3 text-sm font-medium text-gray-700">Disponibilité</span>
                            <button wire:click="toggleAvailability" 
                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 {{ $isAvailable ? 'bg-yellow-600' : 'bg-gray-200' }}">
                                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $isAvailable ? 'translate-x-6' : 'translate-x-1' }}"></span>
                            </button>
                        </div>
                        
                        <!-- User Profile -->
                        <div class="flex items-center gap-3">
                            <div class="text-right hidden md:block">
                                <p class="font-semibold text-gray-900">{{ $user->prenom }} {{ $user->nom }}</p>
                                <p class="text-sm text-gray-500">Pet Keeper</p>
                            </div>
                            @if($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" 
                                     alt="Profile" 
                                     class="w-10 h-10 rounded-full border-2 border-yellow-600 object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full border-2 border-yellow-600 bg-yellow-100 flex items-center justify-center">
                                    <span class="font-semibold text-yellow-600">
                                        {{ strtoupper(substr($user->prenom, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="px-6 py-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Missions Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Missions en cours</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['missions'] }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-yellow-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center text-sm text-gray-500">
                            <span class="text-green-500 mr-1">●</span>
                            {{ $stats['pourcentage_missions'] }}% des missions terminées
                        </div>
                    </div>
                </div>

                <!-- Revenue Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Revenu total</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">
                                {{ number_format($stats['revenu'], 2, ',', ' ') }} €
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Rating Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Note moyenne</p>
                            <div class="flex items-center mt-2">
                                <p class="text-3xl font-bold text-gray-900">{{ $stats['note'] }}</p>
                                <div class="ml-2 flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5 {{ $i <= round($stats['note']) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Pending Demands Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Demandes en attente</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['attente'] }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-purple-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="#" class="text-sm font-medium text-yellow-600 hover:text-yellow-700">
                            Voir toutes les demandes →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Two Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column: Urgent Demands -->
                <div class="space-y-6">
                    @if($isAvailable && count($this->groupAnimalsByDemande($demandesUrgentes)) > 0)
                        <!-- Urgent Demands Section -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <span class="w-2 h-6 bg-red-500 rounded-full mr-3"></span>
                                    Demandes urgentes
                                    <span class="ml-auto bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                        {{ count($this->groupAnimalsByDemande($demandesUrgentes)) }} nouvelles
                                    </span>
                                </h2>
                            </div>
                            
                            <div class="p-6 space-y-6">
                                @foreach($this->groupAnimalsByDemande($demandesUrgentes) as $group)
                                @php
                                    $demande = $group['demande'];
                                    $creneaux = $group['creneaux'];
                                @endphp
                                <div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
                                    <!-- Client Info -->
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex items-center space-x-3">
                                            @if($demande->photo_client)
                                                <img src="{{ asset('storage/' . $demande->photo_client) }}" 
                                                     alt="{{ $demande->prenom_client }}" 
                                                     class="w-10 h-10 rounded-full object-cover">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                    <span class="font-semibold text-gray-600">
                                                        {{ strtoupper(substr($demande->prenom_client, 0, 1)) }}
                                                    </span>
                                                </div>
                                            @endif
                                            <div>
                                                <h3 class="font-semibold text-gray-900">
                                                    {{ $demande->prenom_client }} {{ $demande->nom_client }}
                                                </h3>
                                                <p class="text-sm text-gray-500 flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    </svg>
                                                    {{ $demande->ville_client }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-semibold text-gray-900">
                                                {{ number_format($demande->montantTotal, 2, ',', ' ') }} €
                                            </p>
                                            <p class="text-xs text-gray-500">Montant total</p>
                                        </div>
                                    </div>

                                    <!-- Animals Section -->
                                    <div class="mb-4">
                                        <p class="text-sm font-medium text-gray-700 mb-2">Animaux concernés:</p>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($group['animals'] as $animal)
                                            <div class="flex items-center bg-white px-3 py-2 rounded-lg border border-gray-200">
                                                <span class="text-sm font-medium text-gray-900">{{ $animal['nom'] }}</span>
                                                <span class="text-xs text-gray-500 ml-2">{{ $animal['race'] }} • {{ $animal['age'] }} ans</span>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Créneaux Section -->
                                    @if(count($creneaux) > 0)
                                    <div class="mb-4">
                                        <p class="text-sm font-medium text-gray-700 mb-2">Créneaux souhaités:</p>
                                        <div class="space-y-3">
                                            @foreach($creneaux as $date => $creneauxDuJour)
                                            <div>
                                                <div class="text-xs font-semibold text-gray-500 uppercase mb-2">
                                                    {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                                                </div>
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach($creneauxDuJour as $creneau)
                                                    <div class="bg-white px-3 py-2 rounded-lg border border-yellow-200 text-sm">
                                                        <span class="font-medium text-gray-900">{{ $creneau['heureDebut'] }}</span>
                                                        <span class="text-gray-500">→</span>
                                                        <span class="font-medium text-gray-900">{{ $creneau['heureFin'] }}</span>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Main Time Slot -->
                                    <div class="mb-4 p-3 bg-yellow-50 rounded-lg border border-yellow-100">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-gray-700">Date principale:</p>
                                                <p class="text-lg font-semibold text-gray-900">
                                                    {{ \Carbon\Carbon::parse($demande->dateSouhaitee)->format('d/m/Y') }}
                                                </p>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-700">Horaire:</p>
                                                <p class="text-lg font-semibold text-gray-900">
                                                    {{ substr($demande->heureDebut, 0, 5) }} - {{ substr($demande->heureFin, 0, 5) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex gap-3">
                                        <button wire:click="accepterDemande({{ $demande->idDemande }})" 
                                                class="flex-1 px-4 py-2.5 bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 transition-colors shadow-sm">
                                            Accepter
                                        </button>
                                        <button wire:click="openRefusalModal({{ $demande->idDemande }})" 
                                                class="flex-1 px-4 py-2.5 bg-white text-gray-700 font-semibold rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors">
                                            Refuser
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Upcoming Missions -->
                    @if(count($this->groupAnimalsByDemande($missionsAVenir)) > 0)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <span class="w-2 h-6 bg-blue-500 rounded-full mr-3"></span>
                                    Missions à venir
                                </h2>
                            </div>
                            
                            <div class="p-6 space-y-4">
                                @foreach($this->groupAnimalsByDemande($missionsAVenir) as $group)
                                @php
                                    $demande = $group['demande'];
                                @endphp
                                <div class="p-4 bg-white border border-gray-200 rounded-lg hover:border-blue-200 transition-colors">
                                    <div class="flex items-start justify-between mb-3">
                                        <div>
                                            <h3 class="font-semibold text-gray-900 mb-1">
                                                {{ $demande->prenom_client }} {{ $demande->nom_client }}
                                            </h3>
                                            <p class="text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($demande->dateSouhaitee)->format('d/m/Y') }}
                                                • {{ substr($demande->heureDebut, 0, 5) }} - {{ substr($demande->heureFin, 0, 5) }}
                                            </p>
                                        </div>
                                        <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full 
                                                    {{ $demande->statut === 'validée' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $demande->statut }}
                                        </span>
                                    </div>
                                    
                                    <div class="text-sm text-gray-600 mb-3">
                                        <p>{{ $group['animals'][0]['nom'] ?? 'Animal' }} • {{ $group['animals'][0]['race'] ?? '' }}</p>
                                    </div>
                                    
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-500">{{ $demande->ville_client }}</span>
                                        <span class="font-semibold text-gray-900">
                                            {{ number_format($demande->montantTotal, 2, ',', ' ') }} €
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column: Reviews and Feedback -->
                <div class="space-y-6">
                    <!-- Recent Reviews -->
                    @if(count($avisRecents) > 0)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <span class="w-2 h-6 bg-green-500 rounded-full mr-3"></span>
                                    Avis récents
                                </h2>
                            </div>
                            
                            <div class="p-6 space-y-6">
                                 @foreach($avisRecents as $avis)
<div class="pb-6 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
    <div class="flex items-start justify-between mb-3">
        <div class="flex items-center space-x-3">
            @if($avis->photo)
                <img src="{{ asset('storage/' . $avis->photo) }}" 
                     alt="{{ $avis->prenom }}" 
                     class="w-10 h-10 rounded-full object-cover">
            @else
                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                    <span class="font-semibold text-gray-600">
                        {{ strtoupper(substr($avis->prenom, 0, 1)) }}
                    </span>
                </div>
            @endif
            <div>
                <h3 class="font-semibold text-gray-900">{{ $avis->prenom }}</h3>
                <p class="text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($avis->dateCreation)->format('d/m/Y') }}
                </p>
            </div>
        </div>

        <!-- Rating + Reclamation -->
        <div class="flex flex-col items-end gap-1">
            <div class="flex items-center">
                <span class="text-lg font-bold text-gray-900 mr-2">{{ $avis->note_moyenne }}</span>
                <div class="flex">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4 {{ $i <= round($avis->note_moyenne) ? 'text-yellow-400' : 'text-gray-300' }}"
                             fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                </div>
            </div>

            <button
                wire:click="openReclamationModal({{ $avis->idFeedBack }})"
                class="text-sm text-red-600 hover:underline">
                Signaler
            </button>
        </div>
    </div>

    <p class="text-gray-700 leading-relaxed">
        {{ $avis->commentaire }}
    </p>
</div>
@endforeach

                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Refusal Modal -->
    @if($showRefusalModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Refuser la demande</h3>
                    
                    <form wire:submit.prevent="confirmRefusal">
                        <div class="mb-6">
                            <label for="refusalReason" class="block text-sm font-medium text-gray-700 mb-2">
                                Raison du refus *
                            </label>
                            <textarea id="refusalReason" wire:model="refusalReason" rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none"
                                      placeholder="Expliquez pourquoi vous refusez cette demande..."></textarea>
                            @error('refusalReason')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex gap-3">
                            <button type="button" wire:click="closeRefusalModal"
                                    class="flex-1 px-4 py-2 text-gray-700 font-medium bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                Annuler
                            </button>
                            <button type="submit"
                                    class="flex-1 px-4 py-2 text-white font-medium bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                                Confirmer le refus
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif


    @if($showReclamationModal)
<div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-lg w-full">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                Signaler un avis
            </h3>

            <form wire:submit.prevent="submitReclamation" class="space-y-4">
                <!-- Sujet -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Sujet *
                    </label>
                    <input type="text"
                           wire:model.defer="sujet"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                           placeholder="Ex: Avis offensant, faux avis…">
                    @error('sujet')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Description
                    </label>
                    <textarea wire:model.defer="description"
                              rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                              placeholder="Expliquez le problème (optionnel)"></textarea>
                    @error('description')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priorité -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Priorité
                    </label>
                    <select wire:model.defer="priorite"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <option value="faible">Faible</option>
                        <option value="moyenne">Moyenne</option>
                        <option value="urgente">Urgente</option>
                    </select>
                    @error('priorite')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Preuves -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Preuve (optionnelle)
                    </label>
                    <input type="file"
                           wire:model="preuves"
                           class="w-full text-sm text-gray-600">
                    @error('preuves')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror

                    <div wire:loading wire:target="preuves" class="text-xs text-gray-500 mt-1">
                        Téléversement…
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-3 pt-4">
                    <button type="button"
                            wire:click="closeReclamationModal"
                            class="flex-1 px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Annuler
                    </button>
                    <button type="submit"
                            class="flex-1 px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700">
                        Envoyer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif


    <!-- Flash Messages -->
    @if(session()->has('success'))
        <div class="fixed bottom-4 right-4 z-50">
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 shadow-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-green-800">{{ session('success') }}</span>
                </div>
            </div>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="fixed bottom-4 right-4 z-50">
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 shadow-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span class="text-red-800">{{ session('error') }}</span>
                </div>
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