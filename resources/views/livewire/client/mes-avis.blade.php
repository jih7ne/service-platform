<div class="py-6 bg-gray-50 min-h-screen font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Messages Flash -->
        @if (session()->has('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        
        @if (session()->has('error'))
            <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <!-- En-tête -->
        <div class="mb-5">
            <h1 class="text-2xl font-bold text-gray-900">Mes avis</h1>
            <p class="text-sm text-gray-500 mt-1">Consultez les avis reçus des intervenants</p>
        </div>

        <!-- CARTES STATISTIQUES -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-5">
            <!-- Total -->
            <div class="bg-white p-3.5 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Total</p>
                    <p class="text-xl font-bold text-gray-900 mt-0.5">{{ $stats['total_avis'] }}</p>
                </div>
                <div class="w-9 h-9 bg-blue-50 rounded-full flex items-center justify-center text-blue-600">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                </div>
            </div>
            <!-- Positifs -->
            <div class="bg-white p-3.5 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Positifs</p>
                    <p class="text-xl font-bold text-gray-900 mt-0.5">{{ $stats['avis_positifs'] }}</p>
                </div>
                <div class="w-9 h-9 bg-green-50 rounded-full flex items-center justify-center text-green-600">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <!-- Négatifs -->
            <div class="bg-white p-3.5 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Négatifs</p>
                    <p class="text-xl font-bold text-gray-900 mt-0.5">{{ $stats['avis_negatifs'] }}</p>
                </div>
                <div class="w-9 h-9 bg-red-50 rounded-full flex items-center justify-center text-red-600">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- SECTION FILTRES -->
        <div class="bg-white p-3.5 rounded-xl shadow-sm border border-gray-100 mb-5">
            <div class="flex flex-col lg:flex-row gap-3 items-center">
                
                <!-- LABEL FILTRES -->
                <div class="flex items-center gap-2 text-gray-900 font-bold text-sm min-w-max">
                    <svg class="w-4.5 h-4.5 text-blue-900" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 4.6C3 4.03995 3 3.75992 3.10899 3.54601C3.20487 3.35785 3.35785 3.20487 3.54601 3.10899C3.75992 3 4.03995 3 4.6 3H19.4C19.9601 3 20.2401 3 20.454 3.10899C20.6422 3.20487 20.7951 3.35785 20.891 3.54601C21 3.75992 21 4.03995 21 4.6V6.33726C21 6.58185 21 6.70414 20.9724 6.81923C20.9479 6.92127 20.9075 7.01881 20.8526 7.10828C20.7908 7.2092 20.7043 7.29568 20.5314 7.46863L14.4686 13.5314C14.2957 13.7043 14.2092 13.7908 14.1474 13.8917C14.0925 13.9812 14.0521 14.0787 14.0276 14.1808C14 14.2959 14 14.4182 14 14.6627V20L10 21V14.6627C10 14.4182 10 14.2959 9.97237 14.1808C9.94787 14.0787 9.90747 13.9812 9.85264 13.8917C9.7908 13.7908 9.70432 13.7043 9.53137 13.5314L3.46863 7.46863C3.29568 7.29568 3.2092 7.2092 3.14736 7.10828C3.09253 7.01881 3.05213 6.92127 3.02763 6.81923C3 6.70414 3 6.58185 3 6.33726V4.6Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Filtres</span>
                </div>

                <!-- BARRE DE RECHERCHE -->
                <div class="relative w-full lg:w-1/3">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input wire:model.live="searchTerm" type="text" 
                           class="w-full pl-9 pr-3 py-2 text-xs bg-gray-50 border border-gray-200 focus:bg-white focus:border-blue-500 rounded-full text-gray-600 transition outline-none shadow-sm" 
                           placeholder="Rechercher par nom, service ou commentaire...">
                </div>
                
                <!-- DROPDOWN SERVICES -->
                <div x-data="{ open: false }" class="relative w-full lg:w-1/3">
                    <button @click="open = !open" @click.away="open = false" type="button" 
                            class="w-full py-2 px-3.5 text-xs bg-white border-2 border-blue-800 text-gray-800 rounded-full font-medium flex justify-between items-center shadow-sm hover:bg-gray-50 transition">
                        <span class="truncate">
                            @if($filterService == 'Soutien scolaire') 
                                Soutien scolaire
                            @elseif($filterService == 'Babysitting') 
                                Babysitting
                            @elseif($filterService == 'Garde d\'animaux') 
                                Garde d'animaux
                            @else 
                                Tous les services
                            @endif
                        </span>
                        <svg class="w-3.5 h-3.5 text-gray-800 transform transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="open" x-cloak class="absolute z-50 w-full mt-2 bg-white border border-gray-200 rounded-lg shadow-xl overflow-hidden">
                        <div class="bg-gray-600 text-white px-3 py-2 text-xs font-bold">Tous les services</div>
                        <div class="max-h-40 overflow-y-auto">
                            <div wire:click="$set('filterService', '')" @click="open = false" 
                                 class="px-3 py-2 text-xs text-gray-700 hover:bg-gray-100 cursor-pointer border-b border-gray-100 transition-colors">
                                Afficher tout
                            </div>
                            @foreach($services as $service)
                            <div wire:click="$set('filterService', '{{ $service }}')" @click="open = false" 
                                 class="px-3 py-2 text-xs text-gray-700 hover:bg-gray-200 cursor-pointer transition-colors flex justify-between items-center">
                                <span>{{ $service }}</span>
                                @if($filterService == $service)
                                    <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- DROPDOWN TYPE D'AVIS -->
                <div x-data="{ open: false }" class="relative w-full lg:w-1/3">
                    <button @click="open = !open" @click.away="open = false" type="button" 
                            class="w-full py-2 px-3.5 text-xs bg-gray-50 border border-gray-200 text-gray-700 rounded-full font-medium flex justify-between items-center hover:bg-gray-100 transition shadow-sm">
                        <span>
                            @if($filterNote == 'positive') 
                                Positifs
                            @elseif($filterNote == 'negative') 
                                Négatifs
                            @else 
                                Tous les statuts
                            @endif
                        </span>
                        <svg class="w-3.5 h-3.5 text-gray-500 transform transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="open" x-cloak class="absolute z-40 w-full mt-2 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden">
                        <div wire:click="$set('filterNote', '')" @click="open = false" class="px-3.5 py-2 text-xs text-gray-700 hover:bg-gray-100 cursor-pointer border-b border-gray-50">
                            Tous les statuts
                        </div>
                        <div wire:click="$set('filterNote', 'positive')" @click="open = false" class="px-3.5 py-2 text-xs text-green-600 hover:bg-green-50 cursor-pointer">
                            Positifs (≥4)
                        </div>
                        <div wire:click="$set('filterNote', 'negative')" @click="open = false" class="px-3.5 py-2 text-xs text-red-600 hover:bg-red-50 cursor-pointer">
                            Négatifs (&lt;3)
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- LISTE DES AVIS -->
        <div class="space-y-3">
            @if($avis->count() === 0)
                <div class="bg-white p-8 rounded-xl shadow text-center text-gray-500">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-base font-medium">Aucun avis trouvé</p>
                    <p class="text-xs mt-1">Essayez de modifier vos filtres de recherche</p>
                </div>
            @endif

            @foreach($avis as $avis_item)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3.5 flex flex-col md:flex-row justify-between items-start md:items-center gap-3 hover:shadow-md transition-shadow duration-200">
                    
                    <!-- SECTION GAUCHE -->
                    <div class="space-y-2 flex-1">
                        <div class="flex items-start justify-between">
                            <h3 class="text-sm font-bold text-gray-900">
                                {{ $avis_item->nom_service ?? 'Service non spécifié' }}
                            </h3>
                            <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold
    @if($avis_item->note_moyenne > 3) bg-green-100 text-green-700
    @else bg-red-100 text-red-700
    @endif">
    @if($avis_item->note_moyenne > 3) Positif
    @else Négatif
    @endif
</span>
                        </div>

                        @if($avis_item->commentaire)
                            <p class="text-xs text-gray-600 line-clamp-2">
                                {{ $avis_item->commentaire }}
                            </p>
                        @endif

                        <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ \Carbon\Carbon::parse($avis_item->dateCreation)->format('d M Y') }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ $avis_item->auteur_prenom }} {{ $avis_item->auteur_nom }}
                            </span>
                        </div>
                    </div>

                    <!-- SECTION DROITE -->
                    <div class="text-right space-y-1.5 min-w-[160px]">
                        <div>
                            <p class="text-xs text-gray-500">Note moyenne</p>
                            <p class="text-2xl font-extrabold text-gray-900">
                                {{ number_format($avis_item->note_moyenne, 1) }}/5
                            </p>
                        </div>

                        <div class="flex gap-2 justify-end">
                            <button wire:click="openAvisModal({{ $avis_item->idFeedBack }})"
                                    class="px-3 py-1.5 bg-blue-600 text-white rounded-full text-xs font-medium hover:bg-blue-700 transition-colors duration-200 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Détails
                            </button>

                            @if(!$avis_item->has_reclamation)
                                <button wire:click="openReclamationModal({{ $avis_item->idFeedBack }})"
                                        class="px-3 py-1.5 bg-red-50 text-red-600 border border-red-100 rounded-full text-xs font-medium hover:bg-red-100 transition-colors duration-200 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    Réclamation
                                </button>
                            @else
                                <span class="px-3 py-1.5 bg-gray-100 text-gray-500 rounded-full text-xs font-medium">
                                    Réclamation envoyée
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            @if($avis->hasPages())
                <div class="mt-6">{{ $avis->links() }}</div>
            @endif
        </div>

    </div>

    <!-- MODAL DÉTAILS AVIS -->
    @if($showAvisModal && $selectedAvis)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" wire:click="closeAvisModal"></div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Détails de l'avis</h3>
                        <button wire:click="closeAvisModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <!-- Service -->
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Service</p>
                            <p class="text-sm font-semibold">{{ $selectedAvis->nom_service ?? 'Non spécifié' }}</p>
                        </div>

                        <!-- Auteur -->
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Intervenant</p>
                            <p class="text-sm">{{ $selectedAvis->auteur_prenom }} {{ $selectedAvis->auteur_nom }}</p>
                        </div>

                        <!-- Date -->
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Date</p>
                            <p class="text-sm">{{ \Carbon\Carbon::parse($selectedAvis->dateCreation)->format('d M Y à H:i') }}</p>
                        </div>

                        <!-- Notes détaillées -->
                        <div>
                            <p class="text-xs text-gray-500 mb-2">Notes détaillées</p>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <p class="text-xs text-gray-600">Crédibilité</p>
                                    <p class="text-lg font-bold">{{ $selectedAvis->credibilite }}/5</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <p class="text-xs text-gray-600">Sympathie</p>
                                    <p class="text-lg font-bold">{{ $selectedAvis->sympathie }}/5</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <p class="text-xs text-gray-600">Ponctualité</p>
                                    <p class="text-lg font-bold">{{ $selectedAvis->ponctualite }}/5</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <p class="text-xs text-gray-600">Propreté</p>
                                    <p class="text-lg font-bold">{{ $selectedAvis->proprete }}/5</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-lg col-span-2">
                                    <p class="text-xs text-gray-600">Qualité du travail</p>
                                    <p class="text-lg font-bold">{{ $selectedAvis->qualiteTravail }}/5</p>
                                </div>
                            </div>
                        </div>

                        <!-- Commentaire -->
                        @if($selectedAvis->commentaire)
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Commentaire</p>
                            <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded-lg">{{ $selectedAvis->commentaire }}</p>
                        </div>
                        @endif

                        <!-- Note moyenne -->
                        <div class="bg-blue-50 p-4 rounded-lg text-center">
                            <p class="text-xs text-gray-600 mb-1">Note moyenne</p>
                            <p class="text-3xl font-bold text-blue-600">{{ number_format($selectedAvis->note_moyenne, 1) }}/5</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                    @if(!$selectedAvis->has_reclamation)
                        <button wire:click="openReclamationModalFromDetails" type="button" 
                                class="w-full sm:w-auto px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition">
                            Signaler cet avis
                        </button>
                    @else
                        <span class="w-full sm:w-auto px-4 py-2 bg-gray-200 text-gray-600 text-sm font-medium rounded-lg text-center">
                            Réclamation déjà envoyée
                        </span>
                    @endif
                    <button wire:click="closeAvisModal" type="button" 
                            class="w-full sm:w-auto mt-3 sm:mt-0 px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- MODAL RÉCLAMATION AMÉLIORÉ -->
@if($showReclamationModal)
<div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-60 p-4 transition-opacity backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden relative transform transition-all scale-100">
        <!-- Close Button -->
        <button wire:click="closeReclamationModal" class="absolute top-4 right-4 p-2 bg-gray-100 rounded-full text-gray-500 hover:text-gray-700 transition z-10">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <!-- Header Modal -->
        <div class="p-8 pb-4 border-b border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Créer une réclamation</h2>
                    <p class="text-sm text-gray-500 mt-1">Signalez un problème avec cet avis</p>
                </div>
            </div>
        </div>

        <!-- Body -->
        <form wire:submit.prevent="createReclamation" class="p-8 space-y-6 max-h-[60vh] overflow-y-auto">
            
            <!-- Sujet -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2 uppercase tracking-wide">Sujet de la réclamation *</label>
                <input 
                    type="text" 
                    wire:model="sujet"
                    placeholder="Ex: Avis inapproprié, fausses informations..."
                    class="w-full px-4 py-3 text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all"
                >
                @error('sujet') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2 uppercase tracking-wide">Description détaillée *</label>
                <textarea 
                    wire:model="description"
                    rows="5"
                    placeholder="Décrivez en détail le problème avec cet avis..."
                    class="w-full px-4 py-3 text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all resize-none"
                ></textarea>
                @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Priorité -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-3 uppercase tracking-wide">Priorité *</label>
                <div class="grid grid-cols-3 gap-3">
                    <label class="relative cursor-pointer">
                        <input type="radio" wire:model="priorite" value="faible" class="peer sr-only">
                        <div class="px-4 py-3 text-center text-sm font-bold border-2 border-gray-200 rounded-xl transition-all peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:text-green-700 hover:border-green-300">
                            Faible
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" wire:model="priorite" value="moyenne" class="peer sr-only" checked>
                        <div class="px-4 py-3 text-center text-sm font-bold border-2 border-gray-200 rounded-xl transition-all peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-checked:text-amber-700 hover:border-amber-300">
                            Moyenne
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" wire:model="priorite" value="haute" class="peer sr-only">
                        <div class="px-4 py-3 text-center text-sm font-bold border-2 border-gray-200 rounded-xl transition-all peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700 hover:border-red-300">
                            Haute
                        </div>
                    </label>
                </div>
                @error('priorite') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Preuves (Photos/PDF) -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2 uppercase tracking-wide">Preuves (Photos ou PDF)</label>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-blue-400 transition-colors bg-gray-50">
                    <input 
                        type="file" 
                        wire:model="preuves"
                        multiple
                        accept="image/*,.pdf"
                        class="hidden"
                        id="preuves-upload"
                    >
                    <label for="preuves-upload" class="cursor-pointer">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <p class="text-sm text-gray-600 font-medium">Cliquez pour télécharger des fichiers</p>
                        <p class="text-xs text-gray-400 mt-1">Images ou PDF (max 10MB par fichier)</p>
                    </label>
                </div>
                @if($preuves)
                    <div class="mt-3 space-y-2">
                        @foreach($preuves as $index => $preuve)
                            <div class="flex items-center justify-between bg-blue-50 px-4 py-2 rounded-lg">
                                <span class="text-sm text-gray-700 font-medium truncate">{{ $preuve->getClientOriginalName() }}</span>
                                <button type="button" wire:click="removePreuve({{ $index }})" class="text-red-500 hover:text-red-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif
                @error('preuves.*') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

        </form>

        <!-- Footer -->
        <div class="bg-gray-50 px-8 py-6 flex justify-end gap-3 border-t border-gray-100">
            <button 
                type="button" 
                wire:click="closeReclamationModal"
                class="px-6 py-3 bg-white border-2 border-gray-300 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all"
            >
                Annuler
            </button>
            <button 
                type="submit" 
                wire:click="createReclamation"
                class="px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white text-sm font-bold rounded-xl hover:from-red-600 hover:to-red-700 transition-all shadow-lg disabled:opacity-50"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove wire:target="createReclamation">Envoyer la réclamation</span>
                <span wire:loading wire:target="createReclamation">Envoi en cours...</span>
            </button>
        </div>
    </div>
</div>
@endif

</div>