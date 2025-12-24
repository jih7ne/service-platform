<div class="py-6 bg-gray-50 min-h-screen font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- En-tête -->
        <div class="mb-5">
            <h1 class="text-2xl font-bold text-gray-900">Mes demandes</h1>
            <p class="text-sm text-gray-500 mt-1">Gérez toutes vos demandes de services</p>
        </div>

        <!-- CARTES STATISTIQUES -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-5">
            <!-- Total -->
            <div class="bg-white p-3.5 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Total</p>
                    <p class="text-xl font-bold text-gray-900 mt-0.5">{{ $stats['total'] }}</p>
                </div>
                <div class="w-9 h-9 bg-blue-50 rounded-full flex items-center justify-center text-blue-600">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <!-- Acceptées -->
            <div class="bg-white p-3.5 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Acceptées</p>
                    <p class="text-xl font-bold text-gray-900 mt-0.5">{{ $stats['acceptees'] }}</p>
                </div>
                <div class="w-9 h-9 bg-green-50 rounded-full flex items-center justify-center text-green-600">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <!-- En attente -->
            <div class="bg-white p-3.5 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">En attente</p>
                    <p class="text-xl font-bold text-gray-900 mt-0.5">{{ $stats['attente'] }}</p>
                </div>
                <div class="w-9 h-9 bg-amber-50 rounded-full flex items-center justify-center text-amber-600">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <!-- Refusées -->
            <div class="bg-white p-3.5 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Refusées</p>
                    <p class="text-xl font-bold text-gray-900 mt-0.5">{{ $stats['refusees'] }}</p>
                </div>
                <div class="w-9 h-9 bg-red-50 rounded-full flex items-center justify-center text-red-600">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- SECTION FILTRES -->
        <div class="bg-white p-3.5 rounded-xl shadow-sm border border-gray-100 mb-5">
            <div class="flex flex-col lg:flex-row gap-3 items-center">

                <!-- LABEL FILTRES -->
                <div class="flex items-center gap-2 text-gray-900 font-bold text-sm min-w-max">
                    <svg class="w-4.5 h-4.5 text-blue-900" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M3 4.6C3 4.03995 3 3.75992 3.10899 3.54601C3.20487 3.35785 3.35785 3.20487 3.54601 3.10899C3.75992 3 4.03995 3 4.6 3H19.4C19.9601 3 20.2401 3 20.454 3.10899C20.6422 3.20487 20.7951 3.35785 20.891 3.54601C21 3.75992 21 4.03995 21 4.6V6.33726C21 6.58185 21 6.70414 20.9724 6.81923C20.9479 6.92127 20.9075 7.01881 20.8526 7.10828C20.7908 7.2092 20.7043 7.29568 20.5314 7.46863L14.4686 13.5314C14.2957 13.7043 14.2092 13.7908 14.1474 13.8917C14.0925 13.9812 14.0521 14.0787 14.0276 14.1808C14 14.2959 14 14.4182 14 14.6627V20L10 21V14.6627C10 14.4182 10 14.2959 9.97237 14.1808C9.94787 14.0787 9.90747 13.9812 9.85264 13.8917C9.7908 13.7908 9.70432 13.7043 9.53137 13.5314L3.46863 7.46863C3.29568 7.29568 3.2092 7.2092 3.14736 7.10828C3.09253 7.01881 3.05213 6.92127 3.02763 6.81923C3 6.70414 3 6.58185 3 6.33726V4.6Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>Filtres</span>
                </div>

                <!-- BARRE DE RECHERCHE -->
                <div class="relative w-full lg:w-1/3">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input wire:model.live="search" type="text"
                        class="w-full pl-9 pr-3 py-2 text-xs bg-gray-50 border border-gray-200 focus:bg-white focus:border-blue-500 rounded-full text-gray-600 transition outline-none shadow-sm"
                        placeholder="Rechercher...">
                </div>

                <!-- DROPDOWN SERVICES -->
                <div x-data="{ open: false }" class="relative w-full lg:w-1/3">
                    <button @click="open = !open" @click.away="open = false" type="button"
                        class="w-full py-2 px-3.5 text-xs bg-white border-2 border-blue-800 text-gray-800 rounded-full font-medium flex justify-between items-center shadow-sm hover:bg-gray-50 transition">
                        <span class="truncate">
                            @if($filtreService == 1) Soutien scolaire
                            @elseif($filtreService == 2) Babysitting
                            @elseif($filtreService == 3) Garde d'animaux
                            @else Tous les services
                            @endif
                        </span>
                        <svg class="w-3.5 h-3.5 text-gray-800 transform transition-transform duration-200"
                            :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <div x-show="open" style="display: none;"
                        class="absolute z-50 w-full mt-2 bg-white border border-gray-200 rounded-lg shadow-xl overflow-hidden">
                        <div class="bg-gray-600 text-white px-3 py-2 text-xs font-bold">Tous les services</div>
                        <div class="max-h-40 overflow-y-auto">
                            <div wire:click="$set('filtreService', '')" @click="open = false"
                                class="px-3 py-2 text-xs text-gray-700 hover:bg-gray-100 cursor-pointer border-b border-gray-100 transition-colors">
                                Afficher tout
                            </div>
                            <div wire:click="$set('filtreService', 1)" @click="open = false"
                                class="px-3 py-2 text-xs text-gray-700 hover:bg-gray-200 cursor-pointer transition-colors flex justify-between items-center">
                                <span>Soutien scolaire</span>
                                @if($filtreService == 1)
                                    <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @endif
                            </div>
                            <div wire:click="$set('filtreService', 2)" @click="open = false"
                                class="px-3 py-2 text-xs text-gray-700 hover:bg-gray-200 cursor-pointer transition-colors flex justify-between items-center">
                                <span>Babysitting</span>
                                @if($filtreService == 2)
                                    <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @endif
                            </div>
                            <div wire:click="$set('filtreService', 3)" @click="open = false"
                                class="px-3 py-2 text-xs text-gray-700 hover:bg-gray-200 cursor-pointer transition-colors flex justify-between items-center">
                                <span>Garde d'animaux</span>
                                @if($filtreService == 3)
                                    <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DROPDOWN STATUTS -->
                <div x-data="{ open: false }" class="relative w-full lg:w-1/3">
                    <button @click="open = !open" @click.away="open = false" type="button"
                        class="w-full py-2 px-3.5 text-xs bg-gray-50 border border-gray-200 text-gray-700 rounded-full font-medium flex justify-between items-center hover:bg-gray-100 transition shadow-sm">
                        <span>
                            @if($filtreStatut == 'en_attente') En attente
                            @elseif($filtreStatut == 'validée') Acceptées
                            @elseif($filtreStatut == 'refusée') Refusées
                            @else Tous les statuts
                            @endif
                        </span>
                        <svg class="w-3.5 h-3.5 text-gray-500 transform transition-transform duration-200"
                            :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <div x-show="open" style="display: none;"
                        class="absolute z-40 w-full mt-2 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden">
                        <div wire:click="$set('filtreStatut', '')" @click="open = false"
                            class="px-3.5 py-2 text-xs text-gray-700 hover:bg-gray-100 cursor-pointer border-b border-gray-50">
                            Tous les statuts
                        </div>
                        <div wire:click="$set('filtreStatut', 'en_attente')" @click="open = false"
                            class="px-3.5 py-2 text-xs text-amber-600 hover:bg-amber-50 cursor-pointer">
                            En attente
                        </div>
                        <div wire:click="$set('filtreStatut', 'validée')" @click="open = false"
                            class="px-3.5 py-2 text-xs text-green-600 hover:bg-green-50 cursor-pointer">
                            Acceptées
                        </div>
                        <div wire:click="$set('filtreStatut', 'refusée')" @click="open = false"
                            class="px-3.5 py-2 text-xs text-red-600 hover:bg-red-50 cursor-pointer">
                            Refusées
                        </div>
                        <div wire:click="$set('filtreStatut', 'annulée')" @click="open = false"
                            class="px-3.5 py-2 text-xs text-gray-500 hover:bg-gray-100 cursor-pointer border-t border-gray-50">
                            Annulées
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- LISTE DES DEMANDES -->
        <div class="space-y-3">
            @if($demandes->count() === 0)
                <div class="bg-white p-8 rounded-xl shadow text-center text-gray-500">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-base font-medium">Aucune demande trouvée</p>
                    <p class="text-xs mt-1">Essayez de modifier vos filtres de recherche</p>
                </div>
            @endif

            @foreach($demandes as $demande)
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 p-3.5 flex flex-col md:flex-row justify-between items-start md:items-center gap-3 hover:shadow-md transition-shadow duration-200">

                    <!-- LEFT SECTION -->
                    <div class="space-y-2 flex-1 min-w-0">
                        <div class="flex items-start justify-between">
                            <h3 class="text-sm font-bold text-gray-900 truncate flex-1">
                                {{ $demande->nomService }}
                            </h3>
                            <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold shrink-0
                                    @if($demande->statut === 'validée') bg-green-100 text-green-700
                                    @elseif($demande->statut === 'en_attente') bg-amber-100 text-amber-700
                                    @elseif($demande->statut === 'refusée') bg-red-100 text-red-700
                                    @elseif($demande->statut === 'annulée') bg-gray-100 text-gray-700
                                    @else bg-red-100 text-red-700
                                    @endif">
                                {{ ucfirst(str_replace('_', ' ', $demande->statut)) }}
                            </span>
                        </div>

                        
                        <!-- Time slots -->
                        @if($demande->note_speciales)
                            @php
                                $parsedAvailability = $this->parseAvailability($demande->note_speciales);
                            @endphp
                            
                            @if($parsedAvailability['type'] === 'json')
                                <div class="text-xs text-gray-600">
                                    <div class="font-semibold mb-1">Disponibilités proposées:</div>
                                    <div class="space-y-1">
                                        @foreach($parsedAvailability['value'] as $slot)
                                            <div class="inline-flex items-center bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg mr-3 mb-2 border border-blue-100">
                                                <span class="font-medium">{{ \Carbon\Carbon::parse($slot['date'])->translatedFormat('d M') }}</span>
                                                <span class="mx-2 text-blue-300">•</span>
                                                <span class="font-semibold">{{ $slot['heureDebut'] }} - {{ $slot['heureFin'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <p class="text-xs text-gray-600 line-clamp-2">{{ $parsedAvailability['value'] }}</p>
                            @endif
                        @endif

                        <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                {{ \Carbon\Carbon::parse($demande->dateSouhaitee)->format('d M Y') }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ substr($demande->heureDebut, 0, 5) }} - {{ substr($demande->heureFin, 0, 5) }}
                            </span>
                        </div>
                    </div>

                    <!-- RIGHT SECTION -->
                    <div class="text-right space-y-1.5 min-w-[160px]">
                        <div>
                            <p class="text-xs text-gray-500">Prix Total</p>
                            <p class="text-2xl font-extrabold text-gray-900">
                                {{ $demande->prix_estime ?? 0 }} MAD
                            </p>
                        </div>

                        <div class="flex gap-3 justify-end">
                            <button wire:click="openModal({{ $demande->idDemande }})"
                                class="px-4 py-2 bg-blue-600 text-white rounded-full text-sm font-medium hover:bg-blue-700 transition-colors duration-200 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Détails
                            </button>

                            @if(\Carbon\Carbon::parse($demande->dateSouhaitee)->isPast())
                                <button wire:click='openFeedbackModel({{ $demande->idDemande }}, {{ $demande->idIntervenant }})' 
                                        class="px-4 py-2 bg-emerald-600 text-white rounded-full text-sm font-medium hover:bg-emerald-700 transition-colors duration-200 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                    Donner mon avis
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            @if($demandes->hasPages())
                <div class="mt-6">{{ $demandes->links() }}</div>
            @endif
        </div>

    </div>
    <!-- MODAL DÉTAILS DEMANDE -->
@if($showModal && $selectedDemande)
<div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Overlay -->
    <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>

    <!-- Conteneur du modal -->
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative w-full max-w-4xl bg-white rounded-2xl shadow-2xl transform transition-all">
            
            <!-- En-tête du modal -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 rounded-t-2xl">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                @if($selectedDemande->idService == 1)
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                @elseif($selectedDemande->idService == 2)
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">
                                    {{ $selectedDemande->nomService }}
                                </h3>
                                <p class="text-blue-100 text-sm mt-1">
                                    Demande #{{ $selectedDemande->idDemande }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <button wire:click="closeModal" class="text-white hover:text-gray-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Corps du modal -->
            <div class="px-6 py-5 max-h-[70vh] overflow-y-auto">
                
                <!-- Badge de statut -->
                <div class="flex gap-2 mb-5">
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold
                        @if($selectedDemande->statut === 'validée') bg-green-100 text-green-700
                        @elseif($selectedDemande->statut === 'en_attente') bg-amber-100 text-amber-700
                        @elseif($selectedDemande->statut === 'refusée') bg-red-100 text-red-700
                        @elseif($selectedDemande->statut === 'annulée') bg-gray-100 text-gray-700
                        @else bg-gray-100 text-gray-700
                        @endif">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                            @if($selectedDemande->statut === 'validée')
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            @elseif($selectedDemande->statut === 'en_attente')
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            @else
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            @endif
                        </svg>
                        {{ ucfirst(str_replace('_', ' ', $selectedDemande->statut)) }}
                    </span>

                    <!-- Prix  -->
                    <div class="ml-auto bg-blue-50 px-4 py-1.5 rounded-full">
                        <span class="text-xs font-semibold text-blue-600">Prix Total:</span>
                        <span class="text-sm font-bold text-blue-900 ml-1">{{ $selectedDemande->prix_estime ?? 0 }} MAD</span>
                    </div>
                </div>

                <!-- Informations principales -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    <!-- Date souhaitée -->
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-1 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Date souhaitée
                        </p>
                        <p class="text-sm text-gray-900 font-medium">
                            {{ \Carbon\Carbon::parse($selectedDemande->dateSouhaitee)->format('d/m/Y') }}
                        </p>
                    </div>

                    <!-- Horaires -->
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-1 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Horaires
                        </p>
                        <p class="text-sm text-gray-900 font-medium">
                            {{ substr($selectedDemande->heureDebut,0,5) }} - {{ substr($selectedDemande->heureFin,0,5) }}
                        </p>
                    </div>

                    <!-- Date de demande -->
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Date de demande</p>
                        <p class="text-sm text-gray-900 font-medium">
                            {{ \Carbon\Carbon::parse($selectedDemande->dateDemande)->format('d/m/Y à H:i') }}
                        </p>
                    </div>

                    <!-- Intervenant (si assigné) -->
                    @if($selectedDemande->idIntervenant)
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Intervenant assigné</p>
                        <div class="flex items-center gap-2">
                            @if($selectedDemande->photo_intervenant)
                                <img src="{{ asset('storage/' . $selectedDemande->photo_intervenant) }}" 
                                     alt="Photo" 
                                     class="w-8 h-8 rounded-full object-cover border-2 border-white shadow">
                            @else
                                <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <p class="text-sm text-gray-900 font-medium">
                                    {{ $selectedDemande->prenom_intervenant }} {{ $selectedDemande->nom_intervenant }}
                                </p>
                                @if($selectedDemande->tel_intervenant)
                                <p class="text-xs text-gray-500">{{ $selectedDemande->tel_intervenant }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Notes spéciales -->
               
                @if($demande->note_speciales)
                    @php
                        $parsedAvailability = $this->parseAvailability($demande->note_speciales);
                    @endphp
                            
                    @if($parsedAvailability['type'] === 'json')
                        <div class="text-xs text-gray-600">
                            <div class="font-semibold mb-1">Disponibilités proposées:</div>
                                <div class="space-y-1">
                                    @foreach($parsedAvailability['value'] as $slot)
                                        <div class="inline-flex items-center bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg mr-3 mb-2 border border-blue-100">
                                            <span class="font-medium">{{ \Carbon\Carbon::parse($slot['date'])->translatedFormat('d M') }}</span>
                                            <span class="mx-2 text-blue-300">•</span>
                                            <span class="font-semibold">{{ $slot['heureDebut'] }} - {{ $slot['heureFin'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                    @else

                        <h4 class="text-sm font-bold text-gray-900 mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                            Notes spéciales
                        </h4>
                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $parsedAvailability['value'] }}</p>
                        </div>
                    @endif
                @endif

                <!-- SECTION SPÉCIFIQUE : GARDE D'ANIMAUX -->
                @if($selectedDemande->idService == 3 && $animalDetails)
                <div class="border-t pt-5 mb-5">
                    <h4 class="text-sm font-bold text-gray-900 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        Informations sur l'animal
                    </h4>

                    <div class="bg-pink-50 rounded-xl p-4 border border-pink-100">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nom et type -->
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Nom</p>
                                <p class="text-sm text-gray-900 font-bold">{{ $animalDetails->nom }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Type</p>
                                <p class="text-sm text-gray-900 font-medium">{{ ucfirst($animalDetails->type) }}</p>
                            </div>

                            @if($animalDetails->race)
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Race</p>
                                <p class="text-sm text-gray-900 font-medium">{{ $animalDetails->race }}</p>
                            </div>
                            @endif

                            @if($animalDetails->age)
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Âge</p>
                                <p class="text-sm text-gray-900 font-medium">{{ $animalDetails->age }} an(s)</p>
                            </div>
                            @endif

                            @if($animalDetails->besoins_medicaux)
                            <div class="md:col-span-2">
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Besoins médicaux</p>
                                <p class="text-sm text-gray-700">{{ $animalDetails->besoins_medicaux }}</p>
                            </div>
                            @endif

                            @if($animalDetails->notes)
                            <div class="md:col-span-2">
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Notes</p>
                                <p class="text-sm text-gray-700">{{ $animalDetails->notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Description du service (si disponible) -->
                @if($selectedDemande->desc_service)
                <div class="border-t pt-5">
                    <h4 class="text-sm font-bold text-gray-900 mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        À propos du service
                    </h4>
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                        <p class="text-sm text-gray-700">{{ $selectedDemande->desc_service }}</p>
                    </div>
                </div>
                @endif

            </div>

            <!-- Pied du modal -->
            <div class="bg-gray-50 px-6 py-4 rounded-b-2xl flex justify-between items-center">

                <button wire:click="closeModal" 
                        class="px-5 py-2.5 bg-gray-600 text-white rounded-lg text-sm font-medium hover:bg-gray-700 transition-colors duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Fermer
                </button>
            </div>

        </div>
    </div>
</div>
@endif


<!-- Simplified version with all yellow stars -->
@if($showFeedbackModel)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-emerald-100 rounded-lg">
                            <svg class="w-6 h-6 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Donner votre avis</h3>
                            <p class="text-gray-600 text-sm">Évaluez votre expérience avec l'intervenant</p>
                        </div>
                    </div>
                    <button wire:click="closeFeedbackModel" 
                            class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6 space-y-6">
                <!-- Ratings Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @php
                        $fields = [
                            'ponctualite' => 'Ponctualité',
                            'credibilite' => 'Crédibilité',
                            'sympathie' => 'Sympathie',
                            'qualiteTravail' => 'Qualité de Travail',
                            'proprete' => 'Propreté',
                        ];
                    @endphp
                    
                    @foreach($fields as $field => $label)
                        <div class="space-y-2">
                            <label class="block font-medium text-gray-700">
                                {{ $label }}
                            </label>
                            <div class="flex items-center gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" 
                                            wire:click="$set('{{ $field }}', {{ $i }})"
                                            class="focus:outline-none transition-transform hover:scale-110">
                                        <svg class="w-8 h-8 {{ $i <= ${$field} ? 'text-yellow-400 fill-yellow-400' : 'text-gray-300' }}" 
                                             fill="currentColor" 
                                             viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </button>
                                @endfor
                                <span class="ml-2 text-sm font-medium text-gray-600">
                                    {{ ${$field} }}/5
                                </span>
                            </div>
                        </div>
                    @endforeach

                    <!-- Average Score -->
                    <div class="bg-gradient-to-r from-gray-50 to-white p-4 rounded-xl border border-gray-200">
                        <div class="text-center">
                            <div class="text-sm text-gray-600 mb-1">Note moyenne</div>
                            @php
                                $average = ($ponctualite + $credibilite + $sympathie + $qualiteTravail + $proprete) / 5;
                            @endphp
                            <div class="text-3xl font-bold text-gray-900 mb-2">
                                {{ number_format($average, 1) }}/5
                            </div>
                            <div class="flex items-center justify-center gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= round($average) ? 'text-yellow-400 fill-yellow-400' : 'text-gray-300' }}" 
                                         fill="currentColor" 
                                         viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comment Section -->
                <div class="space-y-2">
                    <label class="block font-medium text-gray-700">
                        Commentaire (optionnel)
                    </label>
                    <textarea wire:model="commentaire" 
                              rows="4"
                              placeholder="Partagez votre expérience, vos suggestions ou vos remarques..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors resize-none"></textarea>
                    <p class="text-sm text-gray-500">
                        Votre commentaire aide à améliorer la qualité du service.
                    </p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="p-6 border-t border-gray-200 bg-gray-50 rounded-b-xl">
                <div class="flex items-center justify-between">
                    <button wire:click="closeFeedbackModel"
                            type="button"
                            class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200 font-medium">
                        Annuler
                    </button>
                    
                    <button wire:click="submitFeedback"
                            type="button"
                            class="px-6 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors duration-200 font-medium flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                        Envoyer l'avis
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif

</div>