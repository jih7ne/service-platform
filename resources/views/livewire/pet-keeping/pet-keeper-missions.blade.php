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
                <span>{{ count($this->groupAnimalsByDemande($missions_a_venir)) }} missions actives</span>
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
            
            <a href="/pet-keeper/missions"
               class="flex items-center gap-3 px-4 py-3.5 bg-amber-50 text-amber-800 font-bold rounded-xl transition-all shadow-sm border-l-4 border-amber-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        <!-- Header -->
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Mes Missions</h1>
                        <p class="text-gray-500">Suivez et gérez toutes vos interventions</p>
                    </div>
                    
                    <!-- Stats Summary -->
                    <div class="flex items-center gap-6">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900">{{ count($this->groupAnimalsByDemande($missions_a_venir)) }}</p>
                            <p class="text-sm text-gray-500">Missions actives</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900">{{ count($this->groupAnimalsByDemande($missions_terminees)) }}</p>
                            <p class="text-sm text-gray-500">Terminées</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="px-6 py-8">
            <!-- Active Missions Section -->
            <div class="mb-10">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <span class="w-2 h-8 bg-yellow-500 rounded-full mr-3"></span>
                        Missions en cours
                    </h2>
                    <div class="text-sm text-gray-500">
                        {{ count($this->groupAnimalsByDemande($missions_a_venir)) }} mission(s) active(s)
                    </div>
                </div>

                @if(count($this->groupAnimalsByDemande($missions_a_venir)) > 0)
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        @foreach($this->groupAnimalsByDemande($missions_a_venir) as $group)
                        @php
                            $mission = $group['demande'];
                            $creneaux = $group['creneaux'];
                            $statusColors = [
                                'en_attente' => 'bg-yellow-100 text-yellow-800',
                                'validée' => 'bg-blue-100 text-blue-800',
                                'en_cours' => 'bg-green-100 text-green-800',
                            ];
                        @endphp
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                            <!-- Mission Header -->
                            <div class="p-6 border-b border-gray-100">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <div class="flex items-center gap-3 mb-2">
                                            <h3 class="text-lg font-bold text-gray-900">Mission #{{ $mission->idDemande }}</h3>
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$mission->statut] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst(str_replace('_', ' ', $mission->statut)) }}
                                            </span>
                                        </div>
                                        <p class="text-gray-600">
                                            {{ \Carbon\Carbon::parse($mission->dateSouhaitee)->format('d F Y') }}
                                            • {{ substr($mission->heureDebut, 0, 5) }} - {{ substr($mission->heureFin, 0, 5) }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xl font-bold text-gray-900">
                                            {{ number_format($mission->montantTotal, 2, ',', ' ') }} €
                                        </p>
                                        <p class="text-sm text-gray-500">Montant</p>
                                    </div>
                                </div>

                                <!-- Client Info -->
                                <div class="flex items-center gap-3">
                                    @if($mission->photo_client)
                                        <img src="{{ asset('storage/' . $mission->photo_client) }}" 
                                             alt="{{ $mission->prenom_client }}" 
                                             class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="font-semibold text-gray-600">
                                                {{ strtoupper(substr($mission->prenom_client, 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $mission->prenom_client }} {{ $mission->nom_client }}</p>
                                        <p class="text-sm text-gray-500 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            {{ $mission->ville_client }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Mission Details -->
                            <div class="p-6">
                                <!-- Animals Section -->
                                <div class="mb-6">
                                    <p class="text-sm font-medium text-gray-700 mb-3">Animaux concernés:</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($group['animals'] as $animal)
                                        <div class="flex items-center bg-gray-50 px-3 py-2 rounded-lg">
                                            <div class="mr-3">
                                                <span class="text-sm font-medium text-gray-900">{{ $animal['nom'] }}</span>
                                                <span class="text-xs text-gray-500 ml-2">{{ $animal['race'] }} • {{ $animal['age'] }} ans</span>
                                            </div>
                                            <span class="text-xs px-2 py-1 rounded-full 
                                                {{ $animal['statutVaccination'] === 'RECURRING' ? 'bg-green-100 text-green-800' : 
                                                   ($animal['statutVaccination'] === 'NEVER' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                {{ $animal['statutVaccination'] }}
                                            </span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Créneaux Section -->
                                @if(count($creneaux) > 0)
                                <div class="mb-6">
                                    <p class="text-sm font-medium text-gray-700 mb-3">Créneaux planifiés:</p>
                                    <div class="space-y-3">
                                        @foreach($creneaux as $date => $creneauxDuJour)
                                        <div>
                                            <div class="text-xs font-semibold text-gray-500 uppercase mb-2">
                                                {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                                            </div>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($creneauxDuJour as $creneau)
                                                <div class="bg-yellow-50 px-3 py-2 rounded-lg border border-yellow-200 text-sm">
                                                    <span class="font-medium text-gray-900">{{ $creneau['heureDebut'] }}</span>
                                                    <span class="text-gray-500 mx-1">→</span>
                                                    <span class="font-medium text-gray-900">{{ $creneau['heureFin'] }}</span>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <!-- Behavior Notes -->
                                @if($group['animals'][0]['note_comportementale'] ?? false)
                                <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
                                    <p class="text-sm font-medium text-blue-700 mb-1">Note comportementale:</p>
                                    <p class="text-sm text-blue-600">{{ $group['animals'][0]['note_comportementale'] }}</p>
                                </div>
                                @endif

                                <!-- Action Button -->
                                <div class="flex gap-3">
                                    <a href="{{ route('petkeeper.mission.show', $mission->idDemande) }}" 
                                       class="flex-1 px-4 py-2.5 bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 transition-colors shadow-sm flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Consulter
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 mb-3">Aucune mission en cours</h3>
                        <p class="text-gray-500 max-w-md mx-auto">
                            Vous n'avez actuellement aucune mission en cours. Les nouvelles missions apparaîtront ici une fois acceptées.
                        </p>
                    </div>
                @endif
            </div>

            <!-- Completed Missions Section -->
            <div>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <span class="w-2 h-8 bg-gray-400 rounded-full mr-3"></span>
                        Missions terminées
                    </h2>
                    <div class="text-sm text-gray-500">
                        {{ count($this->groupAnimalsByDemande($missions_terminees)) }} mission(s) terminée(s)
                    </div>
                </div>

                @if(count($this->groupAnimalsByDemande($missions_terminees)) > 0)
                    <div class="overflow-x-auto bg-white rounded-xl shadow-sm border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                        Mission
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                        Client
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                        Statut
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                        Montant
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($this->groupAnimalsByDemande($missions_terminees) as $group)
                                @php
                                    $mission = $group['demande'];
                                    $statusColors = [
                                        'terminée' => 'bg-green-100 text-green-800',
                                        'refusée' => 'bg-red-100 text-red-800',
                                        'annulée' => 'bg-gray-100 text-gray-800',
                                    ];
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">#{{ $mission->idDemande }}</div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $group['animals'][0]['nom'] ?? 'Animal' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $mission->prenom_client }} {{ $mission->nom_client }}</div>
                                        <div class="text-sm text-gray-500">{{ $mission->ville_client }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($mission->dateSouhaitee)->format('d/m/Y') }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ substr($mission->heureDebut, 0, 5) }} - {{ substr($mission->heureFin, 0, 5) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$mission->statut] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst(str_replace('_', ' ', $mission->statut)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ number_format($mission->montantTotal, 2, ',', ' ') }} €
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('petkeeper.mission.show', $mission->idDemande) }}" 
                                           class="text-yellow-600 hover:text-yellow-700 hover:underline">
                                            Consulter
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 mb-3">Aucune mission terminée</h3>
                        <p class="text-gray-500 max-w-md mx-auto">
                            Vous n'avez pas encore complété de missions. Les missions terminées apparaîtront ici.
                        </p>
                    </div>
                @endif
            </div>
        </div>
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