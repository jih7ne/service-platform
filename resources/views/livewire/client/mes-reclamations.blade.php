<div class="py-6 bg-gray-50 min-h-screen font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- En-tête -->
        <div class="mb-5">
            <h1 class="text-2xl font-bold text-gray-900">Mes réclamations</h1>
            <p class="text-sm text-gray-500 mt-1">Contestez les avis inappropriés ou mensongers laissés sur votre profil</p>
        </div>

        <!-- CARTES STATISTIQUES -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-5">
            <!-- Total -->
            <div class="bg-white p-3.5 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Total</p>
                    <p class="text-xl font-bold text-gray-900 mt-0.5">{{ $stats['total'] }}</p>
                </div>
                <div class="w-9 h-9 bg-blue-50 rounded-full flex items-center justify-center text-blue-600">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
            <!-- Résolues -->
            <div class="bg-white p-3.5 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Résolues</p>
                    <p class="text-xl font-bold text-gray-900 mt-0.5">{{ $stats['resolues'] }}</p>
                </div>
                <div class="w-9 h-9 bg-green-50 rounded-full flex items-center justify-center text-green-600">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <!-- En attente -->
            <div class="bg-white p-3.5 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">En attente</p>
                    <p class="text-xl font-bold text-gray-900 mt-0.5">{{ $stats['attente'] }}</p>
                </div>
                <div class="w-9 h-9 bg-amber-50 rounded-full flex items-center justify-center text-amber-600">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
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
                    <input wire:model.live="search" type="text" 
                           class="w-full pl-9 pr-3 py-2 text-xs bg-gray-50 border border-gray-200 focus:bg-white focus:border-blue-500 rounded-full text-gray-600 transition outline-none shadow-sm" 
                           placeholder="Rechercher...">
                </div>
                
                <!-- DROPDOWN STATUTS -->
                <div x-data="{ open: false }" class="relative w-full lg:w-1/3">
                    <button @click="open = !open" @click.away="open = false" type="button" 
                            class="w-full py-2 px-3.5 text-xs bg-gray-50 border border-gray-200 text-gray-700 rounded-full font-medium flex justify-between items-center hover:bg-gray-100 transition shadow-sm">
                        <span>
                            @if($filtreStatut == 'en_attente') En attente
                            @elseif($filtreStatut == 'resolue') Résolues
                            @else Tous les statuts
                            @endif
                        </span>
                        <svg class="w-3.5 h-3.5 text-gray-500 transform transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="open" style="display: none;" class="absolute z-40 w-full mt-2 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden">
                        <div wire:click="$set('filtreStatut', '')" @click="open = false" class="px-3.5 py-2 text-xs text-gray-700 hover:bg-gray-100 cursor-pointer border-b border-gray-50">
                            Tous les statuts
                        </div>
                        <div wire:click="$set('filtreStatut', 'en_attente')" @click="open = false" class="px-3.5 py-2 text-xs text-amber-600 hover:bg-amber-50 cursor-pointer">
                            En attente
                        </div>
                        <div wire:click="$set('filtreStatut', 'resolue')" @click="open = false" class="px-3.5 py-2 text-xs text-green-600 hover:bg-green-50 cursor-pointer">
                            Résolues
                        </div>
                    </div>
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
                        <svg class="w-3.5 h-3.5 text-gray-800 transform transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="open" style="display: none;" class="absolute z-50 w-full mt-2 bg-white border border-gray-200 rounded-lg shadow-xl overflow-hidden">
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
                                    <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                @endif
                            </div>
                            <div wire:click="$set('filtreService', 2)" @click="open = false" 
                                 class="px-3 py-2 text-xs text-gray-700 hover:bg-gray-200 cursor-pointer transition-colors flex justify-between items-center">
                                <span>Babysitting</span>
                                @if($filtreService == 2)
                                    <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                @endif
                            </div>
                            <div wire:click="$set('filtreService', 3)" @click="open = false" 
                                 class="px-3 py-2 text-xs text-gray-700 hover:bg-gray-200 cursor-pointer transition-colors flex justify-between items-center">
                                <span>Garde d'animaux</span>
                                @if($filtreService == 3)
                                    <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- LISTE DES RÉCLAMATIONS -->
        <div class="space-y-3">
            @if($reclamations->count() === 0)
                <div class="bg-white p-8 rounded-xl shadow text-center text-gray-500">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-base font-medium">Aucune réclamation trouvée</p>
                    <p class="text-xs mt-1">Essayez de modifier vos filtres de recherche</p>
                </div>
            @endif

            @foreach($reclamations as $reclamation)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3.5 flex flex-col md:flex-row justify-between items-start md:items-center gap-3 hover:shadow-md transition-shadow duration-200">
                    
                    <!-- SECTION GAUCHE -->
                    <div class="space-y-2 flex-1">
                        <div class="flex items-start justify-between">
                            <h3 class="text-sm font-bold text-gray-900">
                                {{ $reclamation->sujet }}
                            </h3>
                            <div class="flex gap-2">
                                <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold
                                    @if($reclamation->statut === 'resolue') bg-green-100 text-green-700
                                    @else bg-amber-100 text-amber-700
                                    @endif">
                                    @if($reclamation->statut === 'resolue') Résolue
                                    @else En attente
                                    @endif
                                </span>
                                <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold
                                    @if($reclamation->priorite === 'urgente') bg-red-100 text-red-700
                                    @elseif($reclamation->priorite === 'moyenne') bg-amber-100 text-amber-700
                                    @else bg-gray-100 text-gray-700
                                    @endif">
                                    {{ ucfirst($reclamation->priorite) }}
                                </span>
                            </div>
                        </div>

                        @if($reclamation->description)
                            <p class="text-xs text-gray-600 line-clamp-2">
                                {{ $reclamation->description }}
                            </p>
                        @endif

                        <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ \Carbon\Carbon::parse($reclamation->dateCreation)->format('d M Y') }}
                            </span>
                            @if($reclamation->nomService)
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                {{ $reclamation->nomService }}
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- SECTION DROITE -->
                    <div class="text-right space-y-1.5 min-w-[160px]">
                        <div>
                            <p class="text-xs text-gray-500">Contre</p>
                            <p class="text-sm font-bold text-gray-900">
                                {{ $reclamation->prenom_cible }} {{ $reclamation->nom_cible }}
                            </p>
                        </div>

                        <div class="flex gap-2 justify-end">
                            <button wire:click="openModal({{ $reclamation->idReclamation }})"
                                    class="px-3 py-1.5 bg-blue-600 text-white rounded-full text-xs font-medium hover:bg-blue-700 transition-colors duration-200 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Détails
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach

            @if($reclamations->hasPages())
                <div class="mt-6">{{ $reclamations->links() }}</div>
            @endif
        </div>

    </div>
    <!-- MODAL DÉTAILS RÉCLAMATION -->
@if($showModal && $selectedReclamation)
<div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Overlay -->
    <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>

    <!-- Conteneur du modal -->
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative w-full max-w-3xl bg-white rounded-2xl shadow-2xl transform transition-all">
            
            <!-- En-tête du modal -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 rounded-t-2xl">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-white">
                            {{ $selectedReclamation->sujet }}
                        </h3>
                        <p class="text-blue-100 text-sm mt-1">
                            Réclamation #{{ $selectedReclamation->idReclamation }}
                        </p>
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
                
                <!-- Badges de statut et priorité -->
                <div class="flex gap-2 mb-5">
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold
                        @if($selectedReclamation->statut === 'resolue') bg-green-100 text-green-700
                        @else bg-amber-100 text-amber-700
                        @endif">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                            @if($selectedReclamation->statut === 'resolue')
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            @else
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            @endif
                        </svg>
                        @if($selectedReclamation->statut === 'resolue') Résolue @else En attente @endif
                    </span>
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold
                        @if($selectedReclamation->priorite === 'urgente') bg-red-100 text-red-700
                        @elseif($selectedReclamation->priorite === 'moyenne') bg-amber-100 text-amber-700
                        @else bg-gray-100 text-gray-700
                        @endif">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z"/>
                        </svg>
                        Priorité {{ ucfirst($selectedReclamation->priorite) }}
                    </span>
                </div>

                <!-- Informations principales -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    <!-- Date de création -->
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Date de création</p>
                        <p class="text-sm text-gray-900 font-medium">
                            {{ \Carbon\Carbon::parse($selectedReclamation->dateCreation)->format('d/m/Y à H:i') }}
                        </p>
                    </div>

                    <!-- Personne ciblée -->
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Personne ciblée</p>
                        <div class="flex items-center gap-2">
                            @if($selectedReclamation->photo_cible)
                                <img src="{{ asset('storage/' . $selectedReclamation->photo_cible) }}" 
                                     alt="Photo" 
                                     class="w-8 h-8 rounded-full object-cover border-2 border-white shadow">
                            @else
                                <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif
                            <p class="text-sm text-gray-900 font-medium">
                                {{ $selectedReclamation->prenom_cible }} {{ $selectedReclamation->nom_cible }}
                            </p>
                        </div>
                    </div>

                    @if($selectedReclamation->nomService)
                    <!-- Service concerné -->
                    <div class="bg-gray-50 p-4 rounded-xl md:col-span-2">
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Service concerné</p>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-sm text-gray-900 font-medium">{{ $selectedReclamation->nomService }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Description de la réclamation -->
                @if($selectedReclamation->description)
                <div class="mb-5">
                    <h4 class="text-sm font-bold text-gray-900 mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Description de la réclamation
                    </h4>
                    <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                        <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $selectedReclamation->description }}</p>
                    </div>
                </div>
                @endif

                <!-- PREUVES (Images/Documents) -->
                @if($selectedReclamation->preuves)
                <div class="mb-5">
                    <h4 class="text-sm font-bold text-gray-900 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        Preuves jointes
                    </h4>
                    
                    <div class="bg-purple-50 rounded-xl p-4 border border-purple-100">
                        @php
                            // Décode le JSON des preuves
                            $preuvesArray = json_decode($selectedReclamation->preuves, true);
                            if (!is_array($preuvesArray)) {
                                $preuvesArray = [$selectedReclamation->preuves];
                            }
                        @endphp

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach($preuvesArray as $index => $preuve)
                                @php
                                    $extension = strtolower(pathinfo($preuve, PATHINFO_EXTENSION));
                                    $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
                                    $isDocument = in_array($extension, ['pdf', 'doc', 'docx', 'txt']);
                                @endphp

                                @if($isImage)
                                    <!-- Affichage Image -->
                                    <a href="{{ asset('storage/' . $preuve) }}" target="_blank" 
                                       class="group relative block rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-200">
                                        <img src="{{ asset('storage/' . $preuve) }}" 
                                             alt="Preuve {{ $index + 1 }}" 
                                             class="w-full h-32 object-cover group-hover:scale-110 transition-transform duration-200">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-opacity duration-200 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                            </svg>
                                        </div>
                                        <div class="absolute top-2 right-2 bg-white bg-opacity-90 px-2 py-1 rounded text-xs font-semibold text-gray-700">
                                            {{ strtoupper($extension) }}
                                        </div>
                                    </a>
                                @elseif($isDocument)
                                    <!-- Affichage Document -->
                                    <a href="{{ asset('storage/' . $preuve) }}" target="_blank" 
                                       class="group relative block rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-200 bg-gradient-to-br from-blue-50 to-blue-100 p-4">
                                        <div class="flex flex-col items-center justify-center h-32">
                                            @if($extension === 'pdf')
                                                <svg class="w-12 h-12 text-red-500 mb-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                                </svg>
                                            @else
                                                <svg class="w-12 h-12 text-blue-500 mb-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                                </svg>
                                            @endif
                                            <span class="text-xs font-bold text-gray-700 uppercase">{{ $extension }}</span>
                                            <span class="text-xs text-gray-500 mt-1">Document {{ $index + 1 }}</span>
                                        </div>
                                        <div class="absolute inset-0 bg-blue-600 bg-opacity-0 group-hover:bg-opacity-10 transition-opacity duration-200 rounded-lg"></div>
                                    </a>
                                @else
                                    <!-- Fichier non reconnu -->
                                    <a href="{{ asset('storage/' . $preuve) }}" target="_blank" 
                                       class="group relative block rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-200 bg-gradient-to-br from-gray-50 to-gray-100 p-4">
                                        <div class="flex flex-col items-center justify-center h-32">
                                            <svg class="w-12 h-12 text-gray-400 mb-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="text-xs font-bold text-gray-700 uppercase">{{ $extension }}</span>
                                            <span class="text-xs text-gray-500 mt-1">Fichier {{ $index + 1 }}</span>
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        </div>

                        <p class="text-xs text-purple-600 mt-3 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            Cliquez sur une preuve pour l'ouvrir en plein écran
                        </p>
                    </div>
                </div>
                @endif

                <!-- Feedback associé (si existe) -->
                @if($selectedReclamation->commentaire)
                <div class="border-t pt-5">
                    <h4 class="text-sm font-bold text-gray-900 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                        Feedback contesté
                    </h4>

                    <!-- Note moyenne -->
                    @if(isset($selectedReclamation->note) && $selectedReclamation->note > 0)
                    <div class="bg-amber-50 p-3 rounded-lg mb-3 flex items-center justify-between">
                        <span class="text-xs font-semibold text-gray-600">Note moyenne</span>
                        <div class="flex items-center gap-2">
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= round($selectedReclamation->note) ? 'text-amber-400' : 'text-gray-300' }}" 
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-sm font-bold text-gray-900">{{ number_format($selectedReclamation->note, 1) }}/5</span>
                        </div>
                    </div>
                    @endif

                    <!-- Critères détaillés -->
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-2 mb-3">
                        @php
                            $criteres = [
                                ['label' => 'Crédibilité', 'value' => $selectedReclamation->credibilite],
                                ['label' => 'Sympathie', 'value' => $selectedReclamation->sympathie],
                                ['label' => 'Ponctualité', 'value' => $selectedReclamation->ponctualite],
                                ['label' => 'Propreté', 'value' => $selectedReclamation->proprete],
                                ['label' => 'Qualité', 'value' => $selectedReclamation->qualiteTravail],
                            ];
                        @endphp

                        @foreach($criteres as $critere)
                            @if($critere['value'])
                            <div class="bg-white border border-gray-200 p-2 rounded-lg text-center">
                                <p class="text-xs text-gray-500 mb-1">{{ $critere['label'] }}</p>
                                <p class="text-sm font-bold text-gray-900">{{ $critere['value'] }}/5</p>
                            </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Commentaire -->
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Commentaire</p>
                        <p class="text-sm text-gray-700 italic">{{ $selectedReclamation->commentaire }}</p>
                    </div>
                </div>
                @endif

            </div>

            <!-- Pied du modal -->
            <div class="bg-gray-50 px-6 py-4 rounded-b-2xl flex justify-end">
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
</div>