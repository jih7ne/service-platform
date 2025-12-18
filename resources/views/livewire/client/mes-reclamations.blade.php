<div class="py-8 bg-gray-50 min-h-screen font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Mes réclamations</h1>
            <p class="text-gray-500 mt-1">Contestez les avis inappropriés ou mensongers laissés sur votre profil par les intervenants</p>
        </div>

        <!-- 1. CARTES STATISTIQUES -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <!-- Total -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex justify-between items-center">
                <div>
                    <p class="text-sm font-semibold text-gray-500">Total</p>
                    <p class="text-4xl font-bold text-gray-900 mt-1">{{ $stats['total'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
            <!-- Résolues -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex justify-between items-center">
                <div>
                    <p class="text-sm font-semibold text-gray-500">Résolues</p>
                    <p class="text-4xl font-bold text-gray-900 mt-1">{{ $stats['resolues'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-50 rounded-full flex items-center justify-center text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <!-- En attente -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex justify-between items-center">
                <div>
                    <p class="text-sm font-semibold text-gray-500">En attente</p>
                    <p class="text-4xl font-bold text-gray-900 mt-1">{{ $stats['attente'] }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-50 rounded-full flex items-center justify-center text-amber-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- 2. SECTION FILTRES -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 mb-8">
            <div class="flex flex-col lg:flex-row gap-5 items-center">
                
                <!-- LABEL "FILTRES" AVEC ICONE -->
                <div class="flex items-center gap-2 text-gray-900 font-bold text-lg min-w-max mr-2">
                    <svg class="w-6 h-6 text-blue-900" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 4.6C3 4.03995 3 3.75992 3.10899 3.54601C3.20487 3.35785 3.35785 3.20487 3.54601 3.10899C3.75992 3 4.03995 3 4.6 3H19.4C19.9601 3 20.2401 3 20.454 3.10899C20.6422 3.20487 20.7951 3.35785 20.891 3.54601C21 3.75992 21 4.03995 21 4.6V6.33726C21 6.58185 21 6.70414 20.9724 6.81923C20.9479 6.92127 20.9075 7.01881 20.8526 7.10828C20.7908 7.2092 20.7043 7.29568 20.5314 7.46863L14.4686 13.5314C14.2957 13.7043 14.2092 13.7908 14.1474 13.8917C14.0925 13.9812 14.0521 14.0787 14.0276 14.1808C14 14.2959 14 14.4182 14 14.6627V20L10 21V14.6627C10 14.4182 10 14.2959 9.97237 14.1808C9.94787 14.0787 9.90747 13.9812 9.85264 13.8917C9.7908 13.7908 9.70432 13.7043 9.53137 13.5314L3.46863 7.46863C3.29568 7.29568 3.2092 7.2092 3.14736 7.10828C3.09253 7.01881 3.05213 6.92127 3.02763 6.81923C3 6.70414 3 6.58185 3 6.33726V4.6Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Filtres</span>
                </div>

                <!-- BARRE DE RECHERCHE -->
                <div class="relative w-full lg:w-1/3">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input wire:model.live="search" type="text" 
                           class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 focus:bg-white focus:border-blue-500 rounded-full text-gray-600 transition outline-none shadow-sm" 
                           placeholder="Rechercher par sujet ou service...">
                </div>
                
                <!-- DROPDOWN STATUTS -->
                <div x-data="{ open: false }" class="relative w-full lg:w-1/3">
                    <button @click="open = !open" @click.away="open = false" type="button" 
                            class="w-full py-3 px-6 bg-gray-50 border border-gray-200 text-gray-700 rounded-full text-sm font-medium flex justify-between items-center hover:bg-gray-100 transition shadow-sm">
                        <span>
                            @if($filtreStatut == 'en_attente') En attente
                            @elseif($filtreStatut == 'resolue') Résolues
                            @else Tous les statuts
                            @endif
                        </span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="open" style="display: none;" class="absolute z-40 w-full mt-2 bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden py-1">
                        <div wire:click="$set('filtreStatut', '')" @click="open = false" class="px-5 py-3 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer border-b border-gray-50">
                            Tous les statuts
                        </div>
                        <div wire:click="$set('filtreStatut', 'en_attente')" @click="open = false" class="px-5 py-3 text-sm text-amber-600 hover:bg-amber-50 cursor-pointer">
                            En attente
                        </div>
                        <div wire:click="$set('filtreStatut', 'resolue')" @click="open = false" class="px-5 py-3 text-sm text-green-600 hover:bg-green-50 cursor-pointer">
                            Résolues
                        </div>
                    </div>
                </div>

                <!-- DROPDOWN SERVICES -->
                <div x-data="{ open: false }" class="relative w-full lg:w-1/3">
                    
                    <!-- BOUTON DECLENCHEUR -->
                    <button @click="open = !open" @click.away="open = false" type="button" 
                            class="w-full py-3 px-6 bg-white border-2 border-blue-800 text-gray-800 rounded-full text-sm font-medium flex justify-between items-center shadow-sm hover:bg-gray-50 transition">
                        <span class="truncate">
                            @if($filtreService == 1) Soutien scolaire
                            @elseif($filtreService == 2) Babysitting
                            @elseif($filtreService == 3) Garde d'animaux
                            @else Tous les services
                            @endif
                        </span>
                        <svg class="w-5 h-5 text-gray-800 transform transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <!-- MENU DÉROULANT -->
                    <div x-show="open" 
                         style="display: none;" 
                         class="absolute z-50 w-full mt-2 bg-white border border-gray-200 rounded shadow-xl overflow-hidden">
                        
                        <!-- EN-TÊTE GRIS FONCÉ -->
                        <div class="bg-gray-600 text-white px-4 py-3 text-sm font-bold">
                            Tous les services
                        </div>
                        
                        <!-- LISTE DES OPTIONS -->
                        <div class="max-h-60 overflow-y-auto">
                            
                            <!-- Option 1 : Afficher tout -->
                            <div wire:click="$set('filtreService', '')" @click="open = false" 
                                 class="px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer border-b border-gray-100 transition-colors">
                                Afficher tout
                            </div>

                            <!-- Option 2 : Soutien scolaire (ID 1) -->
                            <div wire:click="$set('filtreService', 1)" @click="open = false" 
                                 class="px-4 py-3 text-sm text-gray-700 hover:bg-gray-200 cursor-pointer transition-colors flex justify-between items-center">
                                <span>Soutien scolaire</span>
                                @if($filtreService == 1)
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                @endif
                            </div>

                            <!-- Option 3 : Babysitting (ID 2) -->
                            <div wire:click="$set('filtreService', 2)" @click="open = false" 
                                 class="px-4 py-3 text-sm text-gray-700 hover:bg-gray-200 cursor-pointer transition-colors flex justify-between items-center">
                                <span>Babysitting</span>
                                @if($filtreService == 2)
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                @endif
                            </div>

                            <!-- Option 4 : Garde d'animaux (ID 3) -->
                            <div wire:click="$set('filtreService', 3)" @click="open = false" 
                                 class="px-4 py-3 text-sm text-gray-700 hover:bg-gray-200 cursor-pointer transition-colors flex justify-between items-center">
                                <span>Garde d'animaux</span>
                                @if($filtreService == 3)
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- 3. LISTE DES RÉCLAMATIONS -->
        <div class="space-y-4">
            @if($reclamations->count() === 0)
                <div class="bg-white p-10 rounded-2xl shadow text-center text-gray-500">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-lg font-medium">Aucune réclamation trouvée</p>
                    <p class="text-sm mt-2">Essayez de modifier vos filtres de recherche</p>
                </div>
            @endif

            @foreach($reclamations as $reclamation)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
                    
                    <div class="flex flex-col md:flex-row justify-between gap-4">
                        
                        <!-- SECTION GAUCHE -->
                        <div class="space-y-3 flex-1">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">
                                        {{ $reclamation->sujet }}
                                    </h3>
                                    @if($reclamation->nomService)
                                        <p class="text-sm text-gray-500 mt-1">{{ $reclamation->nomService }}</p>
                                    @endif
                                </div>
                                <div class="flex gap-2">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold
                                        @if($reclamation->statut === 'resolue') bg-green-100 text-green-700
                                        @else bg-amber-100 text-amber-700
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $reclamation->statut)) }}
                                    </span>
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold
                                        @if($reclamation->priorite === 'urgente') bg-red-100 text-red-700
                                        @elseif($reclamation->priorite === 'moyenne') bg-amber-100 text-amber-700
                                        @else bg-gray-100 text-gray-700
                                        @endif">
                                        {{ ucfirst($reclamation->priorite) }}
                                    </span>
                                </div>
                            </div>

                            @if($reclamation->description)
                                <p class="text-sm text-gray-600 line-clamp-2">
                                    {{ $reclamation->description }}
                                </p>
                            @endif

                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Contre : {{ $reclamation->prenom_cible }} {{ $reclamation->nom_cible }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($reclamation->dateCreation)->format('d M Y') }}
                                </span>
                            </div>
                        </div>

                        <!-- SECTION DROITE -->
                        <div class="flex items-center">
                            <button wire:click="openModal({{ $reclamation->idReclamation }})"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-full text-sm font-medium hover:bg-blue-700 transition-colors duration-200 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Voir détails
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- PAGINATION -->
            @if($reclamations->hasPages())
                <div class="mt-8">
                    {{ $reclamations->links() }}
                </div>
            @endif
        </div>

        <!-- ================= MODAL DETAILS ================= -->
        @if($showModal && $selectedReclamation)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-60 p-4 transition-opacity backdrop-blur-sm">
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden relative transform transition-all scale-100">
                
                <!-- Close Button -->
                <button wire:click="closeModal" class="absolute top-4 right-4 p-2 bg-gray-100 rounded-full text-gray-500 hover:text-gray-800 hover:bg-gray-200 transition z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <!-- Header -->
                <div class="p-8 pb-4 border-b border-gray-100">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $selectedReclamation->sujet }}</h2>
                            <div class="flex gap-2">
                                <span class="px-3 py-1 rounded-full text-xs font-bold
                                    {{ $selectedReclamation->statut === 'resolue' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ ucfirst(str_replace('_', ' ', $selectedReclamation->statut)) }}
                                </span>
                                <span class="px-3 py-1 rounded-full text-xs font-bold
                                    @if($selectedReclamation->priorite === 'urgente') bg-red-100 text-red-700
                                    @elseif($selectedReclamation->priorite === 'moyenne') bg-amber-100 text-amber-700
                                    @else bg-gray-100 text-gray-700
                                    @endif">
                                    Priorité : {{ ucfirst($selectedReclamation->priorite) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Body -->
                <div class="p-8 space-y-6 max-h-[60vh] overflow-y-auto">
                    
                    <!-- Description -->
                    @if($selectedReclamation->description)
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 mb-3 uppercase tracking-wide">Description</h3>
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $selectedReclamation->description }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Service concerné -->
                    @if($selectedReclamation->nomService)
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 mb-3 uppercase tracking-wide">Service concerné</h3>
                        <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm flex items-center gap-3">
                            <div class="bg-blue-50 p-2 rounded-lg text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Type de service</p>
                                <p class="font-bold text-gray-900">{{ $selectedReclamation->nomService }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Personne ciblée -->
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 mb-3 uppercase tracking-wide">Intervenant concerné</h3>
                        <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold overflow-hidden">
                                @if($selectedReclamation->photo_cible)
                                    <img src="{{ asset('storage/'.$selectedReclamation->photo_cible) }}" class="w-full h-full object-cover">
                                @else
                                    {{ substr($selectedReclamation->prenom_cible ?? '?', 0, 1) }}
                                @endif
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Nom complet</p>
                                <p class="font-bold text-gray-900">
                                    {{ $selectedReclamation->prenom_cible ?? 'Non spécifié' }} {{ $selectedReclamation->nom_cible }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Avis lié (si existe) -->
                    @if($selectedReclamation->idFeedback)
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 mb-3 uppercase tracking-wide">Avis contesté</h3>
                        <div class="bg-amber-50 border border-amber-100 rounded-xl p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $selectedReclamation->note ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-sm font-bold text-gray-700">{{ $selectedReclamation->note }}/5</span>
                            </div>
                            @if($selectedReclamation->commentaire)
                                <p class="text-sm text-gray-700 italic">"{{ $selectedReclamation->commentaire }}"</p>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Preuves -->
                    @if($selectedReclamation->preuves)
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 mb-3 uppercase tracking-wide">Preuves jointes</h3>
                        <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                            <p class="text-sm text-blue-600 underline">{{ $selectedReclamation->preuves }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Date -->
                    <div class="text-center pt-4 border-t border-gray-100">
                        <p class="text-xs text-gray-400">
                            Réclamation #{{ $selectedReclamation->idReclamation }} créée le {{ \Carbon\Carbon::parse($selectedReclamation->dateCreation)->format('d/m/Y à H:i') }}
                        </p>
                    </div>

                </div>

                <!-- Footer -->
                <div class="p-6 bg-gray-50 border-t border-gray-100">
                    <button wire:click="closeModal" class="w-full py-3.5 bg-gray-900 hover:bg-black text-white font-bold rounded-xl transition shadow-lg transform hover:-translate-y-0.5">
                        Fermer
                    </button>
                </div>

            </div>
        </div>
        @endif

    </div>
</div>