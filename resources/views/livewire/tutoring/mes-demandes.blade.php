<div class="flex h-screen bg-[#F3F4F6] font-sans overflow-hidden">

    <livewire:tutoring.components.professeur-sidebar :currentPage="'tutoring-requests'" />

    {{-- CONTENU PRINCIPAL --}}
    <main class="flex-1 overflow-y-auto p-4 sm:p-6 md:p-8">
        
        <!-- Titre + Filtre -->
        <div class="bg-white p-4 sm:p-5 md:p-6 rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 mb-6 sm:mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900">Mes demandes en attente</h1>
                    <p class="text-sm sm:text-base text-gray-500 mt-1">Gérez les demandes de cours reçues de vos futurs élèves</p>
                </div>

                <!-- Filtre -->
                <div class="relative w-full md:w-auto">
                    <button wire:click="toggleFilters" class="w-full md:w-auto flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filtrer
                        @if($showFilters) <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                        @else <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg> @endif
                    </button>

                    @if($showFilters)
                        <div class="absolute right-0 mt-2 w-full md:w-64 bg-white rounded-xl shadow-xl border border-gray-100 p-4 z-50">
                            <div class="space-y-4">
                                <div>
                                    <p class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase mb-2">Trier par</p>
                                    <select wire:model.live="filterSort" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="recent">📅 Plus récent d'abord</option>
                                        <option value="ancien">📅 Plus ancien d'abord</option>
                                        <option value="prix_decroissant">💰 Prix décroissant</option>
                                        <option value="prix_croissant">💰 Prix croissant</option>
                                    </select>
                                </div>
                                <div>
                                    <p class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase mb-2">Type de cours</p>
                                    <div class="space-y-2">
                                        <label class="flex items-center gap-2 cursor-pointer"><input type="radio" wire:model.live="filterType" value="all" class="text-blue-600 focus:ring-blue-500"><span class="text-xs sm:text-sm text-gray-700">Tout afficher</span></label>
                                        <label class="flex items-center gap-2 cursor-pointer"><input type="radio" wire:model.live="filterType" value="enligne" class="text-blue-600 focus:ring-blue-500"><span class="text-xs sm:text-sm text-gray-700">En ligne (Visio)</span></label>
                                        <label class="flex items-center gap-2 cursor-pointer"><input type="radio" wire:model.live="filterType" value="domicile" class="text-blue-600 focus:ring-blue-500"><span class="text-xs sm:text-sm text-gray-700">À Domicile</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Messages Flash -->
        @if (session()->has('success'))
            <div class="mb-4 sm:mb-6 p-3 sm:p-4 rounded-lg sm:rounded-xl bg-green-50 text-green-700 border border-green-200 flex items-center text-sm sm:text-base">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- LISTE DES CARTES -->
        <div class="space-y-4 sm:space-y-6">
            @forelse($this->demandes as $demande)
                <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-5 md:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex flex-col lg:flex-row justify-between items-start gap-4 sm:gap-6">
                        
                        <!-- Colonne Gauche : Info Client & Service -->
                        <div class="flex gap-3 sm:gap-5 w-full lg:w-1/3">
                            
                            <!-- Avatar Cliquable -->
                            <div class="flex-shrink-0">
                                <a href="{{ route('tutoring.student.profile', $demande->idClient) }}" class="block relative hover:opacity-80 transition-opacity" title="Voir le profil">
                                    @if($demande->client_photo)
                                        <img src="{{ asset('storage/'.$demande->client_photo) }}" class="w-12 h-12 sm:w-14 sm:h-14 rounded-full object-cover border border-gray-200">
                                    @else
                                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-base sm:text-lg border border-blue-200">
                                            {{ substr($demande->client_prenom, 0, 1) }}
                                        </div>
                                    @endif
                                    <div class="absolute -bottom-1 -right-1 bg-white rounded-full p-0.5 shadow-sm border border-gray-100">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="min-w-0 flex-1">
                                <!-- Nom Cliquable -->
                                <h3 class="font-bold text-gray-900 text-base sm:text-lg truncate">
                                    <a href="{{ route('tutoring.student.profile', ['id' => $demande->idClient, 'source' => 'list']) }}" class="hover:text-[#1E40AF] hover:underline transition-colors flex items-center gap-2">
                                        {{ $demande->client_prenom }} {{ $demande->client_nom }}
                                    </a>
                                </h3>

                                <div class="flex items-center text-[10px] sm:text-xs text-gray-500 mb-2 sm:mb-3 mt-1">
                                    <svg class="w-3 h-3 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="truncate">{{ \Carbon\Carbon::parse($demande->dateDemande)->format('d F Y, H:i') }}</span>
                                </div>
                                
                                <!-- Badges -->
                                <div class="flex flex-wrap gap-1.5 sm:gap-2">
                                    <span class="bg-[#1E40AF] text-white text-[9px] sm:text-[11px] font-bold px-2 sm:px-3 py-0.5 sm:py-1 rounded-md uppercase tracking-wider">
                                        {{ $demande->nom_matiere ?? 'MATIÈRE' }}
                                    </span>
                                    <span class="bg-gray-100 text-gray-600 text-[9px] sm:text-[11px] font-bold px-2 sm:px-3 py-0.5 sm:py-1 rounded-md uppercase">
                                        {{ $demande->nom_niveau ?? 'Niveau' }}
                                    </span>
                                    <span class="bg-blue-50 text-blue-600 text-[9px] sm:text-[11px] font-bold px-2 sm:px-3 py-0.5 sm:py-1 rounded-md uppercase">
                                        {{ $demande->type_service ?? 'Présentiel' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Colonne Milieu : Détails Pratiques -->
                        <div class="w-full lg:w-1/3 space-y-2 sm:space-y-3 lg:border-l lg:border-r border-gray-50 lg:px-6 pt-3 lg:pt-0">
                            <div class="flex items-start gap-2 sm:gap-3">
                                <div class="text-gray-400 mt-0.5 flex-shrink-0"><svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
                                <div class="min-w-0">
                                    <p class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase mb-0.5">Horaire souhaité</p>
                                    <p class="text-xs sm:text-sm font-semibold text-gray-800 break-words">
                                        {{ \Carbon\Carbon::parse($demande->dateSouhaitee)->format('l d M') }}, 
                                        {{ substr($demande->heureDebut, 0, 5) }} - {{ substr($demande->heureFin, 0, 5) }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start gap-2 sm:gap-3">
                                <div class="text-gray-400 mt-0.5 flex-shrink-0"><svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                                <div class="min-w-0">
                                    <p class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase mb-0.5">Adresse</p>
                                    <p class="text-xs sm:text-sm font-semibold text-gray-800 break-words">
                                        {{ $demande->client_adresse ?? 'En ligne' }} {{ $demande->client_ville }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Colonne Droite : Prix & Actions -->
                        <div class="w-full lg:w-1/4 flex flex-col justify-between pt-3 lg:pt-0 border-t lg:border-t-0 border-gray-100">
                            <div class="mb-3 sm:mb-4">
                                <p class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase">Budget proposé</p>
                                <p class="text-xl sm:text-2xl font-extrabold text-[#1E40AF] mt-1">{{ $demande->montant_total }} <span class="text-xs sm:text-sm text-gray-500">DH/h</span></p>
                            </div>

                            <div class="space-y-2 sm:space-y-3">
                                <a href="{{ route('tutoring.request.details', ['id' => $demande->idDemande]) }}" class="w-full py-2 sm:py-2.5 border border-gray-300 rounded-lg text-gray-700 font-bold text-xs sm:text-sm hover:bg-gray-50 transition-colors flex justify-center items-center">
                                    Consulter détails
                                </a>

                                <div class="flex gap-2 sm:gap-3">
                                    <button wire:click="refuser({{ $demande->idDemande }})" wire:confirm="Êtes-vous sûr de vouloir refuser cette demande ?" wire:loading.attr="disabled" class="flex-1 py-2 sm:py-2.5 bg-gray-100 text-gray-700 font-bold text-xs sm:text-sm rounded-lg hover:bg-gray-200 transition-colors flex justify-center items-center">
                                        <span wire:loading.remove wire:target="refuser({{ $demande->idDemande }})">Refuser</span>
                                        <span wire:loading wire:target="refuser({{ $demande->idDemande }})"><svg class="animate-spin h-4 w-4 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></span>
                                    </button>

                                    <button wire:click="accepter({{ $demande->idDemande }})" wire:confirm="Accepter cette demande ? Un email sera envoyé au client." wire:loading.attr="disabled" class="flex-1 py-2 sm:py-2.5 bg-[#1E40AF] text-white font-bold text-xs sm:text-sm rounded-lg hover:bg-blue-800 transition-colors shadow-md shadow-blue-100 flex justify-center items-center">
                                        <span wire:loading.remove wire:target="accepter({{ $demande->idDemande }})">Accepter</span>
                                        <span wire:loading wire:target="accepter({{ $demande->idDemande }})" class="flex items-center gap-1"><svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-12 sm:py-20 bg-white rounded-xl sm:rounded-2xl border border-dashed border-gray-300">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900">Aucune demande en attente</h3>
                    <p class="text-sm sm:text-base text-gray-500">Revenez plus tard !</p>
                </div>
            @endforelse
        </div>
    </main>
</div>