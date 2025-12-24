<div class="flex h-screen bg-[#F3F4F6] font-sans overflow-hidden">

   {{-- SIDEBAR COMPONENT --}}
    @livewire('tutoring.components.professeur-sidebar', ['currentPage' => 'tutoring-requests'])

    {{-- CONTENU PRINCIPAL --}}
    <main class="flex-1 overflow-y-auto p-8">
        
       <!-- Titre + Filtre -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900">Gestion des demandes</h1>
                <p class="text-gray-500 mt-1">Consultez et gérez vos demandes de soutien scolaire</p>
            </div>

            <!-- Filtre -->
            <div class="relative">
                <button wire:click="toggleFilters" class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Filtrer
                    @if($showFilters) <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                    @else <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg> @endif
                </button>

                @if($showFilters)
                    <div class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-100 p-4 z-50">
                        <div class="space-y-4">
                            <!-- Trier par -->
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase mb-2">Trier par</p>
                                <select wire:model.live="filterSort" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="recent"> Demande la plus récente</option>
                                    <option value="ancien"> Demande la plus ancienne</option>
                                    <option value="date_proche"> Cours le plus proche</option>
                                    <option value="prix_haut"> Prix décroissant</option>
                                    <option value="prix_bas"> Prix croissant</option>
                                </select>
                            </div>

                            <!-- Divider -->
                            <div class="border-t border-gray-200"></div>

                            <!-- Filtres Avancés Toggle -->
                            <button wire:click="toggleAdvancedFilters" class="w-full flex items-center justify-between text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">
                                <span>Filtres avancés</span>
                                <svg class="w-4 h-4 transition-transform {{ $showAdvancedFilters ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            @if($showAdvancedFilters)
                                <div class="space-y-4 pt-2">
                                    <!-- Filtre Matière -->
                                    <div>
                                        <p class="text-xs font-bold text-gray-400 uppercase mb-2">Matière</p>
                                        <select wire:model.live="filterMatiere" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="all">Toutes les matières</option>
                                            @foreach($this->matieresProfesseur as $matiere)
                                                <option value="{{ $matiere }}">{{ $matiere }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Filtre Niveau -->
                                    <div>
                                        <p class="text-xs font-bold text-gray-400 uppercase mb-2">Niveau</p>
                                        <select wire:model.live="filterNiveau" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="all">Tous les niveaux</option>
                                            @foreach($this->niveauxProfesseur as $niveau)
                                                <option value="{{ $niveau }}">{{ $niveau }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Filtre Période -->
                                    <div>
                                        <p class="text-xs font-bold text-gray-400 uppercase mb-2">Date du cours</p>
                                        <select wire:model.live="datePeriod" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="all">Toutes les dates</option>
                                            <option value="today">Aujourd'hui</option>
                                            <option value="week">Cette semaine</option>
                                            <option value="month">Ce mois</option>
                                        </select>
                                    </div>

                                    <!-- Bouton Reset -->
                                    <button wire:click="resetFilters" class="w-full py-2 bg-gray-100 text-gray-700 font-medium text-sm rounded-lg hover:bg-gray-200 transition-colors">
                                        Réinitialiser les filtres
                                    </button>
                                </div>
                            @endif

                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Onglets -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8">
            <div class="flex gap-2 mb-6 border-b border-gray-200">
                <button wire:click="setTab('en_attente')"
                    class="px-6 py-3 transition-all {{ $selectedTab === 'en_attente' ? 'border-b-2 border-[#1E40AF]' : '' }}"
                    style="font-weight: 700; color: {{ $selectedTab === 'en_attente' ? '#1E40AF' : '#6b7280' }};">
                    En attente
                    <span class="ml-2 px-2 py-0.5 rounded-full text-xs {{ $selectedTab === 'en_attente' ? 'bg-[#1E40AF] text-white' : 'bg-gray-200 text-gray-700' }}">
                        {{ $this->stats[0]['value'] }}
                    </span>
                </button>
                <button wire:click="setTab('validee')"
                    class="px-6 py-3 transition-all {{ $selectedTab === 'validee' ? 'border-b-2 border-[#1E40AF]' : '' }}"
                    style="font-weight: 700; color: {{ $selectedTab === 'validee' ? '#1E40AF' : '#6b7280' }};">
                    Acceptées
                    <span class="ml-2 px-2 py-0.5 rounded-full text-xs {{ $selectedTab === 'validee' ? 'bg-[#1E40AF] text-white' : 'bg-gray-200 text-gray-700' }}">
                        {{ $this->stats[1]['value'] }}
                    </span>
                </button>
                <button wire:click="setTab('archive')"
                    class="px-6 py-3 transition-all {{ $selectedTab === 'archive' ? 'border-b-2 border-[#1E40AF]' : '' }}"
                    style="font-weight: 700; color: {{ $selectedTab === 'archive' ? '#1E40AF' : '#6b7280' }};">
                    Historique
                    <span class="ml-2 px-2 py-0.5 rounded-full text-xs {{ $selectedTab === 'archive' ? 'bg-[#1E40AF] text-white' : 'bg-gray-200 text-gray-700' }}">
                        {{ $this->stats[2]['value'] }}
                    </span>
            </div>
        </div>

        <!-- Messages Flash -->
        @if (session()->has('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 text-green-700 border border-green-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- LISTE DES CARTES -->
        <div class="space-y-6">
            @if($selectedTab === 'en_attente')
                @forelse($this->demandes as $demande)
                @php
                    $profileUrl = route('tutoring.student.profile', $demande->idClient);
                @endphp
                
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col lg:flex-row justify-between items-start gap-6 hover:shadow-md transition-shadow">
                    
                    <!-- Colonne Gauche : Info Client & Service -->
                    <div class="flex gap-5 w-full lg:w-1/3">
                        
                        <!-- Avatar Cliquable -->
                        <div class="flex-shrink-0">
                            <a href="{{ $profileUrl }}" class="block relative hover:opacity-80 transition-opacity" title="Voir le profil">
                                @if($demande->client_photo)
                                    <img src="{{ asset('storage/'.$demande->client_photo) }}" class="w-14 h-14 rounded-full object-cover border border-gray-200">
                                @else
                                    <div class="w-14 h-14 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-lg border border-blue-200">
                                        {{ substr($demande->client_prenom, 0, 1) }}
                                    </div>
                                @endif
                                <div class="absolute -bottom-1 -right-1 bg-white rounded-full p-0.5 shadow-sm border border-gray-100">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </div>
                            </a>
                        </div>
                        
                        <div>
                            <!-- Nom Cliquable -->
                            <h3 class="font-bold text-gray-900 text-lg">
                                <a href="{{ $profileUrl }}" class="hover:text-[#1E40AF] hover:underline transition-colors flex items-center gap-2">
                                    {{ $demande->client_prenom }} {{ $demande->client_nom }}
                                </a>
                            </h3>

                            <div class="flex items-center text-xs text-gray-500 mb-1 mt-1">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ \Carbon\Carbon::parse($demande->dateDemande)->isoFormat('D MMM YYYY') }}
                            </div>
                            <div class="flex items-center text-[11px] text-gray-600 mb-3">
                                <span class="text-[10px] text-gray-400 font-bold uppercase mr-2">Date souhaitée</span>
                               {{ \Carbon\Carbon::parse($demande->dateSouhaitee)->isoFormat('D MMM YYYY') }} • {{ substr($demande->heureDebut, 0, 5) }}-{{ substr($demande->heureFin, 0, 5) }}
                            </div>
                            
                            <!-- Détails Service -->
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <span class="bg-blue-100 text-blue-800 text-[10px] px-2 py-1 rounded-full font-medium">
                                        Soutien scolaire
                                    </span>
                                    <span class="bg-gray-100 text-gray-700 text-[10px] px-2 py-1 rounded-full">
                                        {{ $demande->nom_matiere ?? 'Maths' }}
                                    </span>
                                    <span class="bg-gray-100 text-gray-700 text-[10px] px-2 py-1 rounded-full">
                                        {{ $demande->nom_niveau ?? 'Lycée' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Colonne Milieu : Détails Pratiques -->
                    <div class="w-full lg:w-1/3 space-y-3 border-l border-r border-gray-50 px-0 lg:px-6">
                        <div class="flex items-start gap-3">
                            <div class="text-gray-400 mt-0.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
                            <div>
                                <p class="text-xs text-gray-400 font-bold uppercase mb-0.5">Horaire souhaité</p>
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ \Carbon\Carbon::parse($demande->dateSouhaitee)->isoFormat('dddd D MMM') }}, 
                                    {{ substr($demande->heureDebut, 0, 5) }} - {{ substr($demande->heureFin, 0, 5) }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="text-gray-400 mt-0.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-1.414 0l-5.648-5.648a1 1 0 01-.174-.223L4.343 8.343A2 2 0 012 6.586V4a2 2 0 012-2h14a2 2 0 012 2v2.586a2 2 0 01-.343 1.657l-4.835 4.835a1 1 0 01-.174.223z"></path></svg></div>
                            <div>
                                <p class="text-xs text-gray-400 font-bold uppercase mb-0.5">Mode du cours</p>
                                <p class="text-sm font-semibold text-gray-800 break-words">
                                    @if($demande->lieu === 'En ligne')
                                        En ligne
                                    @else
                                        À domicile <br>
                                        <p class="text-xs text-gray-400 font-bold uppercase mb-0.5">Lieu</p>
                                        {{ $demande->lieu }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        @if($demande->montant_total > 0)
                        <div class="flex items-start gap-3">
                            <div class="text-gray-400 mt-0.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                            <div>
                                <p class="text-xs text-gray-400 font-bold uppercase mb-0.5">Prix</p>
                                <p class="text-lg font-extrabold text-[#1E40AF]">{{ number_format($demande->montant_total, 2, ',', ' ') }} DH</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Colonne Droite : Prix & Actions -->
                    <div class="w-full lg:w-1/4 flex flex-col justify-between h-full min-h-[140px]">
                        <div class="text-center"></div>

                        <div class="space-y-3 mt-4">
                            @php
                                $detailsUrl = route('tutoring.request.details', $demande->idDemande);
                            @endphp
                            
                            <a href="{{ $detailsUrl }}" class="w-full py-2 border border-gray-300 rounded-lg text-gray-700 font-bold text-sm hover:bg-gray-50 transition-colors flex justify-center items-center">
                                Consulter détails
                            </a>

                            @if($selectedTab === 'en_attente')
                                <div class="flex gap-3">
                                    <button wire:click="refuser({{ $demande->idDemande }})" 
                                            wire:confirm="Êtes-vous sûr de vouloir refuser cette demande ?" 
                                            wire:loading.attr="disabled" 
                                            class="flex-1 py-2 bg-gray-100 text-gray-700 font-bold text-sm rounded-lg hover:bg-gray-200 transition-colors flex justify-center items-center">
                                        <span wire:loading.remove wire:target="refuser({{ $demande->idDemande }})">Refuser</span>
                                        <span wire:loading wire:target="refuser({{ $demande->idDemande }})">
                                            <svg class="animate-spin h-4 w-4 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </span>
                                    </button>

                                    <button wire:click="accepter({{ $demande->idDemande }})" 
                                            wire:confirm="Accepter cette demande ? Un email sera envoyé au client." 
                                            wire:loading.attr="disabled" 
                                            class="flex-1 py-2 bg-[#1E40AF] text-white font-bold text-sm rounded-lg hover:bg-blue-800 transition-colors shadow-md shadow-blue-100 flex justify-center items-center">
                                        <span wire:loading.remove wire:target="accepter({{ $demande->idDemande }})">Accepter</span>
                                        <span wire:loading wire:target="accepter({{ $demande->idDemande }})" class="flex items-center gap-1">
                                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            @endif

                            @if(($demande->statut === 'terminée' || $demande->statut === 'completed') && $selectedTab === 'archive')
                                @php
                                    $feedbackUrl = route('feedback.tutoring', [
                                        'idService' => 1,
                                        'demandeId' => $demande->idDemande,
                                        'auteurId' => auth()->id(),
                                        'cibleId' => $demande->idClient,
                                        'typeAuteur' => 'intervenant'
                                    ]);
                                @endphp
                                
                                <a href="{{ $feedbackUrl }}" 
                                   class="w-full py-2 bg-green-600 text-white font-bold text-sm rounded-lg hover:bg-green-700 transition-colors flex justify-center items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                    Donner un avis
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl p-12 text-center border border-gray-100">
                    @if($selectedTab === 'en_attente')
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune demande en attente</h3>
                        <p class="text-gray-600">Vous n'avez actuellement aucune demande de cours en attente de validation.</p>
                        <div class="mt-6">
                            <a href="{{ route('tutoring.disponibilites') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Mettre à jour mes disponibilités
                            </a>
                        </div>
                    @elseif($selectedTab === 'validee')
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune demande acceptée</h3>
                        <p class="text-gray-600">Vous n'avez actuellement aucune demande de cours acceptée.</p>
                    @elseif($selectedTab === 'archive')
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune demande dans l'historique</h3>
                        <p class="text-gray-600">Vous n'avez actuellement aucune demande de cours terminée.</p>
                    @endif
                </div>
            @endforelse
            @endif
        </div>
        
        <!-- ONGLET VALIDÉES -->
        @if($selectedTab === 'validee')
            <div class="space-y-6">
                @forelse($this->demandes as $demande)
                @php
                    $profileUrl = route('tutoring.student.profile', $demande->idClient);
                @endphp
                
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col lg:flex-row justify-between items-start gap-6 hover:shadow-md transition-shadow">
                    
                    <!-- Colonne Gauche : Info Client & Service -->
                    <div class="flex gap-5 w-full lg:w-1/3">
                        
                        <!-- Avatar Cliquable -->
                        <div class="flex-shrink-0">
                            <a href="{{ $profileUrl }}" class="block relative hover:opacity-80 transition-opacity" title="Voir le profil">
                                @if($demande->client_photo)
                                    <img src="{{ asset('storage/'.$demande->client_photo) }}" class="w-14 h-14 rounded-full object-cover border border-gray-200">
                                @else
                                    <div class="w-14 h-14 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-lg border border-blue-200">
                                        {{ substr($demande->client_prenom, 0, 1) }}
                                    </div>
                                @endif
                                <div class="absolute -bottom-1 -right-1 bg-white rounded-full p-0.5 shadow-sm border border-gray-100">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </div>
                            </a>
                        </div>
                        
                        <div>
                            <!-- Nom Cliquable -->
                            <h3 class="font-bold text-gray-900 text-lg">
                                <a href="{{ $profileUrl }}" class="hover:text-[#1E40AF] hover:underline transition-colors flex items-center gap-2">
                                    {{ $demande->client_prenom }} {{ $demande->client_nom }}
                                </a>
                            </h3>

                            <div class="flex items-center text-xs text-gray-500 mb-1 mt-1">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ \Carbon\Carbon::parse($demande->dateDemande)->format('d M Y') }}
                            </div>
                            <div class="flex items-center text-[11px] text-gray-600 mb-3">
                                <span class="text-[10px] text-gray-400 font-bold uppercase mr-2">Date souhaitée</span>
                                {{ \Carbon\Carbon::parse($demande->dateSouhaitee)->format('d M Y') }} • {{ substr($demande->heureDebut, 0, 5) }}-{{ substr($demande->heureFin, 0, 5) }}
                            </div>
                            
                            <!-- Détails Service (chips) -->
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <span class="bg-blue-100 text-blue-800 text-[10px] px-2 py-1 rounded-full font-medium">
                                        Soutien scolaire
                                    </span>
                                    <span class="bg-gray-100 text-gray-700 text-[10px] px-2 py-1 rounded-full">
                                        {{ $demande->nom_matiere ?? 'Maths' }}
                                    </span>
                                    <span class="bg-gray-100 text-gray-700 text-[10px] px-2 py-1 rounded-full">
                                        {{ $demande->nom_niveau ?? 'Lycée' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Colonne Centre : Mode + Prix -->
                    <div class="w-full lg:w-1/3 flex flex-col items-center text-center gap-2 mt-8">
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase mb-0.5">Mode de cours</p>
                            <p class="text-sm font-semibold text-gray-800 break-words">
                                @if($demande->lieu === 'En ligne')
                                    En ligne
                                @else
                                    À domicile
                                    <span class="block text-xs text-gray-500">{{ $demande->lieu }}</span>
                                @endif
                            </p>
                        </div>
                        @if($demande->montant_total > 0)
                            <div class="flex items-center gap-2 justify-center">
                                <span class="text-xs text-gray-400 font-bold uppercase">Prix</span>
                                <span class="text-lg font-extrabold text-[#1E40AF]">{{ number_format($demande->montant_total, 2, ',', ' ') }} DH</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Colonne Droite : Actions -->
                    <div class="flex flex-col gap-4 items-end w-full lg:w-auto">
                        <!-- Badge Statut -->
                        <div class="flex items-center gap-2">
                            <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-medium">
                                Acceptée
                            </span>
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex flex-col gap-3 w-full lg:w-48">
                            
                            @if($demande->statut === 'validée' && \Carbon\Carbon::parse($demande->dateSouhaitee)->isPast())
                                @php
                                    $hasFeedback = \App\Models\Feedback::where('idDemande', $demande->idDemande)->exists();
                                    $feedbackUrl = route('feedback.tutoring', [
                                        'idService' => 1,
                                        'demandeId' => $demande->idDemande,
                                        'auteurId' => auth()->id(),
                                        'cibleId' => $demande->idClient,
                                        'typeAuteur' => 'intervenant'
                                    ]);
                                @endphp
                                
                                @if(!$hasFeedback)
                                    <a href="{{ $feedbackUrl }}" 
                                       class="w-full py-2 bg-green-600 text-white font-bold text-sm rounded-lg hover:bg-green-700 transition-colors flex justify-center items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                        Donner un avis
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                    <div class="bg-white rounded-2xl p-12 text-center border border-gray-100">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune demande acceptée</h3>
                        <p class="text-gray-600">Vous n'avez actuellement aucune demande de cours acceptée.</p>
                    </div>
                @endforelse
            </div>
        @endif
        
        <!-- ONGLET ARCHIVE -->
        @if($selectedTab === 'archive')
            <div class="space-y-6">
                @forelse($this->demandes as $demande)
                @php
                    $profileUrl = route('tutoring.student.profile', $demande->idClient);
                @endphp
                
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col lg:flex-row justify-between items-start gap-6 hover:shadow-md transition-shadow">
                    
                    <!-- Colonne Gauche : Info Client & Service -->
                    <div class="flex gap-5 w-full lg:w-1/3">
                        
                        <!-- Avatar Cliquable -->
                        <div class="flex-shrink-0">
                            <a href="{{ $profileUrl }}" class="block relative hover:opacity-80 transition-opacity" title="Voir le profil">
                                @if($demande->client_photo)
                                    <img src="{{ asset('storage/'.$demande->client_photo) }}" class="w-14 h-14 rounded-full object-cover border border-gray-200">
                                @else
                                    <div class="w-14 h-14 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-lg border border-blue-200">
                                        {{ substr($demande->client_prenom, 0, 1) }}
                                    </div>
                                @endif
                                <div class="absolute -bottom-1 -right-1 bg-white rounded-full p-0.5 shadow-sm border border-gray-100">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </div>
                            </a>
                        </div>
                        
                        <div>
                            <!-- Nom Cliquable -->
                            <h3 class="font-bold text-gray-900 text-lg">
                                <a href="{{ $profileUrl }}" class="hover:text-[#1E40AF] hover:underline transition-colors flex items-center gap-2">
                                    {{ $demande->client_prenom }} {{ $demande->client_nom }}
                                </a>
                            </h3>

                            <div class="flex items-center text-xs text-gray-500 mb-1 mt-1">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ \Carbon\Carbon::parse($demande->dateDemande)->format('d M Y') }}
                            </div>
                            <div class="flex items-center text-[11px] text-gray-600 mb-3">
                                <span class="text-[10px] text-gray-400 font-bold uppercase mr-2">Date souhaitée</span>
                                {{ \Carbon\Carbon::parse($demande->dateSouhaitee)->format('d M Y') }} • {{ substr($demande->heureDebut, 0, 5) }}-{{ substr($demande->heureFin, 0, 5) }}
                            </div>
                            
                            <!-- Détails Service (chips) -->
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <span class="bg-blue-100 text-blue-800 text-[10px] px-2 py-1 rounded-full font-medium">
                                        Soutien scolaire
                                    </span>
                                    <span class="bg-gray-100 text-gray-700 text-[10px] px-2 py-1 rounded-full">
                                        {{ $demande->nom_matiere ?? 'Maths' }}
                                    </span>
                                    <span class="bg-gray-100 text-gray-700 text-[10px] px-2 py-1 rounded-full">
                                        {{ $demande->nom_niveau ?? 'Lycée' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Colonne Centre : Mode + Prix -->
                    <div class="w-full lg:w-1/3 flex flex-col items-center text-center gap-2 mt-5">
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase mb-0.5">Mode de cours</p>
                            <p class="text-sm font-semibold text-gray-800 break-words">
                                @if($demande->lieu === 'En ligne')
                                    En ligne
                                @else
                                    À domicile
                                    <span class="block text-xs text-gray-500">{{ $demande->lieu }}</span>
                                @endif
                            </p>
                        </div>
                        @if($demande->montant_total > 0)
                            <div class="flex items-center gap-2 justify-center">
                                <span class="text-xs text-gray-400 font-bold uppercase">Prix</span>
                                <span class="text-lg font-extrabold text-[#1E40AF]">{{ number_format($demande->montant_total, 2, ',', ' ') }} DH</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Colonne Droite : Actions -->
                    <div class="flex flex-col gap-4 items-end w-full lg:w-auto">
                        <!-- Badge Statut -->
                        <div class="flex items-center gap-2">
                            <span class="bg-gray-100 text-gray-700 text-xs px-3 py-1 rounded-full font-medium">
                                {{ $demande->statut === 'terminée' ? 'Terminée' : ($demande->statut === 'refusée' ? 'Refusée' : ($demande->statut === 'validée' ? 'Validée' : 'Annulée')) }}
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="bg-white rounded-2xl p-12 text-center border border-gray-100">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune demande dans l'historique</h3>
                        <p class="text-gray-600">Vous n'avez actuellement aucune demande terminée, refusée ou annulée.</p>
                    </div>
                @endforelse
            </div>
        @endif
    </main>
</div>
</div>