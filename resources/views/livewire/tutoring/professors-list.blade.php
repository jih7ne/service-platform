<div class="min-h-screen bg-gray-50 font-sans">
    <livewire:shared.header />

    <!-- Header Section with Gradient -->
    <div class="relative bg-white overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-[#2B5AA8]/5 to-[#2B5AA8]/10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
            <!-- Bouton Retour -->
            <div class="mb-6">
                <a href="{{ route('services') }}" class="inline-flex items-center text-[#2B5AA8] hover:text-[#224A91] font-semibold transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour aux services
                </a>
            </div>

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                <div>
                    <h1 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tight mb-4">
                        Trouvez le <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#2B5AA8] to-[#1e3a8a]">Professeur idéal</span>
                    </h1>
                    <p class="text-lg text-gray-600 max-w-2xl leading-relaxed">
                        Des professeurs qualifiés pour accompagner votre réussite scolaire. 
                        <span class="font-semibold text-[#2B5AA8]">{{ $professeurs->total() }} profils vérifiés</span> disponibles maintenant.
                    </p>
                </div>
                
                <!-- Search Bar and Toggle -->
                <div class="w-full md:w-auto md:min-w-[400px] flex flex-col gap-4">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#2B5AA8] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input
                            type="text"
                            wire:model.live.debounce.500ms="searchTerm"
                            class="block w-full pl-11 pr-4 py-4 bg-white border border-gray-200 rounded-2xl leading-5 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2B5AA8]/20 focus:border-[#2B5AA8] transition-all shadow-sm hover:shadow-md"
                            placeholder="Rechercher par nom, matière, niveau, prix..."
                        />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <div wire:loading wire:target="searchTerm" class="animate-spin rounded-full h-5 w-5 border-b-2 border-[#2B5AA8]"></div>
                        </div>
                    </div>
                    
                    <!-- Toggle Map/List Button -->
                    <div class="flex justify-center md:justify-end">
                        <button
                            wire:click="toggleMap"
                            class="flex items-center gap-2 px-4 py-2 rounded-lg font-semibold transition-all {{ $showMap ? 'bg-[#2B5AA8] text-white' : 'bg-white text-[#2B5AA8] border border-[#2B5AA8]' }}"
                        >
                            @if($showMap)
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                            Liste
                            @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                            Carte
                            @endif
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Mobile Filter Toggle (Only in List Mode) -->
            @if(!$showMap)
            <div class="md:hidden">
                <button
                    onclick="toggleFilters()"
                    class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-700 font-semibold shadow-sm active:bg-gray-50"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                    </svg>
                    Filtres avancés
                </button>
            </div>
            @endif
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- MAP VIEW -->
        @if($showMap)
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-4 bg-gradient-to-r from-[#2B5AA8] to-[#1e3a8a] text-white">
                <h3 class="font-bold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Carte des Professeurs ({{ count($professeursMap) }} profils)
                </h3>
            </div>
            <div wire:ignore id="map" style="height: 600px; width: 100%;"></div>
            
            <!-- Légende -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-center gap-6 text-sm text-gray-600">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-gradient-to-br from-[#2B5AA8] to-[#1e3a8a] rounded-full border-2 border-white"></div>
                        <span>Professeur disponible</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-yellow-500">⭐</span>
                        <span>Note élevée (4.5+)</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- LIST VIEW -->
        @else
        <div class="flex flex-col lg:flex-row gap-8">
         
            <aside class="hidden lg:block w-80 flex-shrink-0" id="filtersSidebar">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-8 max-h-[calc(100vh-4rem)] overflow-y-auto custom-scrollbar">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-50">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#2B5AA8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Filtres
                        </h3>
                        <button
                            wire:click="resetFilters"
                            class="text-xs font-semibold text-gray-500 hover:text-[#2B5AA8] transition-colors uppercase tracking-wide"
                        >
                            Réinitialiser
                        </button>
                    </div>

                    <div class="space-y-8">
                        <!-- Tri rapide -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Trier par</label>
                            <div class="flex flex-wrap gap-2">
                                <button 
                                    wire:click="sortByField('note')"
                                    class="px-3 py-1.5 text-xs rounded-lg font-semibold transition-all border {{ $sortBy === 'note' ? 'bg-[#2B5AA8] text-white border-[#2B5AA8]' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50' }}">
                                    Note {{ $sortBy === 'note' ? ($sortDirection === 'desc' ? '↓' : '↑') : '' }}
                                </button>
                                <button 
                                    wire:click="sortByField('prix')"
                                    class="px-3 py-1.5 text-xs rounded-lg font-semibold transition-all border {{ $sortBy === 'prix' ? 'bg-[#2B5AA8] text-white border-[#2B5AA8]' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50' }}">
                                    Prix {{ $sortBy === 'prix' ? ($sortDirection === 'desc' ? '↓' : '↑') : '' }}
                                </button>
                                <button 
                                    wire:click="sortByField('nom')"
                                    class="px-3 py-1.5 text-xs rounded-lg font-semibold transition-all border {{ $sortBy === 'nom' ? 'bg-[#2B5AA8] text-white border-[#2B5AA8]' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50' }}">
                                    Nom {{ $sortBy === 'nom' ? ($sortDirection === 'desc' ? '↓' : '↑') : '' }}
                                </button>
                            </div>
                        </div>

                        <!-- Ville -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Ville</label>
                            <div class="relative">
                                <select wire:model.live="selectedVille" class="w-full pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#2B5AA8]/20 focus:border-[#2B5AA8] appearance-none cursor-pointer transition-all hover:bg-white">
                                    <option value="">Toutes les villes</option>
                                    @foreach($villes as $ville)
                                        <option value="{{ $ville }}">{{ $ville }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Note minimale -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Note minimale</label>
                            <div class="relative">
                                <select wire:model.live="selectedNote" class="w-full pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#2B5AA8]/20 focus:border-[#2B5AA8] appearance-none cursor-pointer transition-all hover:bg-white">
                                    <option value="">Toutes les notes</option>
                                    <option value="4.5">⭐ 4.5+ Excellent</option>
                                    <option value="4.0">⭐ 4.0+ Très bien</option>
                                    <option value="3.5">⭐ 3.5+ Bien</option>
                                    <option value="3.0">⭐ 3.0+ Correct</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Matière -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Matière</label>
                            <div class="relative">
                                <select wire:model.live="selectedMatiere" class="w-full pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#2B5AA8]/20 focus:border-[#2B5AA8] appearance-none cursor-pointer transition-all hover:bg-white">
                                    <option value="">Toutes les matières</option>
                                    @foreach($matieres as $matiere)
                                        <option value="{{ $matiere->id_matiere }}">{{ $matiere->nom_matiere }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Niveau -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Niveau</label>
                            <div class="relative">
                                <select wire:model.live="selectedNiveau" class="w-full pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#2B5AA8]/20 focus:border-[#2B5AA8] appearance-none cursor-pointer transition-all hover:bg-white">
                                    <option value="">Tous les niveaux</option>
                                    @foreach($niveaux as $niveau)
                                        <option value="{{ $niveau->id_niveau }}">{{ $niveau->nom_niveau }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Results Grid -->
            <div class="flex-1 min-w-0">
                <!-- Loading Overlay -->
                <div wire:loading.flex class="fixed inset-0 z-50 flex items-center justify-center bg-black/10 backdrop-blur-[1px]">
                    <div class="bg-white p-4 rounded-2xl shadow-xl flex items-center gap-3">
                        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-[#2B5AA8]"></div>
                        <span class="font-medium text-gray-700">Mise à jour...</span>
                    </div>
                </div>

                <!-- Active Filters Display -->
                @if($searchTerm || $selectedVille || $selectedNote || $selectedMatiere || $selectedNiveau)
                <div class="mb-6 p-4 bg-white rounded-xl border border-gray-100 shadow-sm">
                    <div class="flex items-center justify-between flex-wrap gap-3">
                        <div class="flex flex-wrap gap-2">
                            @if($searchTerm)
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-[#2B5AA8] text-white text-xs rounded-full font-semibold">
                                    Recherche: "{{ Str::limit($searchTerm, 20) }}"
                                </span>
                            @endif
                            @if($selectedVille)
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-[#2B5AA8] text-white text-xs rounded-full font-semibold">
                                    Ville: {{ $selectedVille }}
                                </span>
                            @endif
                            @if($selectedNote)
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-[#2B5AA8] text-white text-xs rounded-full font-semibold">
                                    Note ≥ {{ $selectedNote }}
                                </span>
                            @endif
                            @if($selectedMatiere)
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-[#2B5AA8] text-white text-xs rounded-full font-semibold">
                                    {{ $matieres->firstWhere('id_matiere', $selectedMatiere)->nom_matiere }}
                                </span>
                            @endif
                            @if($selectedNiveau)
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-[#2B5AA8] text-white text-xs rounded-full font-semibold">
                                    {{ $niveaux->firstWhere('id_niveau', $selectedNiveau)->nom_niveau }}
                                </span>
                            @endif
                        </div>
                        <button 
                            wire:click="resetFilters"
                            class="text-sm text-[#2B5AA8] hover:text-[#224A91] font-bold flex items-center gap-1"
                        >
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Tout effacer
                        </button>
                    </div>
                </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" wire:loading.class="opacity-50 transition-opacity duration-200">
                    @forelse($professeurs as $professeur)
                    <div class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-300 hover:-translate-y-1">
                        <!-- Card Header / Image -->
                        <div class="relative h-48 overflow-hidden bg-gray-100">
                            <img 
                                src="{{ $professeur->photo ? asset('storage/' . $professeur->photo) : asset('images/default-avatar.png') }}" 
                                alt="Photo de {{ $professeur->surnom ?? $professeur->prenom }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            />
                            <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-2.5 py-1 rounded-lg text-xs font-bold text-gray-900 shadow-sm flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-yellow-400 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                {{ number_format($professeur->note, 1) }}
                            </div>
                            @if($professeur->note >= 4.5)
                            <div class="absolute top-3 left-3 bg-yellow-400/90 backdrop-blur-sm px-2.5 py-1 rounded-lg text-xs font-bold text-white shadow-sm">
                                ⭐ TOP
                            </div>
                            @endif
                        </div>

                        <!-- Card Body -->
                        <div class="p-5">
                            <div class="mb-4">
                                <h3 class="text-lg font-bold text-gray-900 mb-1 group-hover:text-[#2B5AA8] transition-colors">
                                    {{ $professeur->surnom ?? ($professeur->prenom . ' ' . $professeur->nom) }}
                                </h3>
                                
                                <div class="flex items-center justify-center gap-1 mb-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($professeur->note))
                                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                
                                <p class="text-sm text-gray-600 text-center">
                                    ({{ $professeur->nbrAvis }} avis)
                                </p>

                                @if($professeur->ville)
                                    <div class="flex items-center justify-center gap-1 mt-2 text-gray-600 text-sm">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $professeur->ville }}
                                    </div>
                                @endif
                            </div>

                            <!-- Subjects Tags -->
@if($professeur->services->isNotEmpty())
<div class="flex flex-wrap gap-1.5 mb-5 h-16 overflow-hidden content-start justify-center">
    @foreach($professeur->services->unique('matiere_id')->take(3) as $service)
    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
        {{ $service->nom_matiere }}
    </span>
    @endforeach
    @if($professeur->services->unique('matiere_id')->count() > 3)
    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-50 text-gray-600 border border-gray-100">
        +{{ $professeur->services->unique('matiere_id')->count() - 3 }}
    </span>
    @endif
</div>
@endif 

<!-- Footer -->
                            <!-- Footer -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                                <div class="flex flex-col">
                                    <span class="text-xs text-gray-500 font-medium uppercase tracking-wider">À partir de</span>
                                    <div class="flex items-baseline gap-0.5">
                                        <span class="text-xl font-black text-gray-900">{{ $professeur->services->isNotEmpty() ? number_format($professeur->min_prix, 0) : 'N/A' }}</span>
                                        <span class="text-xs font-bold text-gray-500">DH/h</span>
                                    </div>
                                </div>
                                <a href="{{ route('professeurs.details', $professeur->id_professeur) }}" class="inline-flex items-center justify-center px-4 py-2 bg-[#2B5AA8] text-white text-sm font-bold rounded-xl hover:bg-[#224A91] transition-all shadow-lg shadow-blue-500/30">
                                    Voir profil
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-16 text-center bg-white rounded-3xl border border-gray-100 border-dashed">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Aucun résultat trouvé</h3>
                        <p class="text-gray-500 max-w-sm mx-auto">
                            Nous n'avons trouvé aucun professeur correspondant à vos critères. Essayez d'élargir votre recherche.
                        </p>
                        <button wire:click="resetFilters" class="mt-6 text-[#2B5AA8] font-bold hover:underline">
                            Effacer tous les filtres
                        </button>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($professeurs->hasPages())
                    <div class="mt-12">
                        {{ $professeurs->links() }}
                    </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    <livewire:shared.footer />
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
      crossorigin=""/>
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #e5e7eb;
        border-radius: 20px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background-color: #d1d5db;
    }
    
    .custom-popup .leaflet-popup-content-wrapper {
        border-radius: 16px;
        padding: 0;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }
    
    .custom-popup .leaflet-popup-content {
        margin: 0;
        width: auto !important;
    }
    
    .custom-popup .leaflet-popup-tip {
        background: white;
    }
    
    .custom-professor-marker {
        background: transparent !important;
        border: none !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>

<script>
let mapInstance = null;
let markersLayer = null;

function destroyMap() {
    if (mapInstance) {
        console.log('🗑 Destruction de la carte');
        mapInstance.remove();
        mapInstance = null;
        markersLayer = null;
    }
}

function initializeMap(professors) {
    console.log('🗺 Initialisation carte avec', professors.length, 'professeurs');
    
    const mapElement = document.getElementById('map');
    if (!mapElement) {
        console.error('❌ Element #map introuvable');
        return;
    }

    if (typeof L === 'undefined') {
        console.error('❌ Leaflet non disponible');
        return;
    }

    if (professors.length === 0) {
        mapElement.innerHTML = '<div style="display: flex; align-items: center; justify-content: center; height: 600px; color: #666; font-size: 16px;">Aucun professeur avec coordonnées GPS disponibles</div>';
        return;
    }

    destroyMap();

    try {
        mapInstance = L.map('map').setView(
            [professors[0].latitude, professors[0].longitude], 
            12
        );

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(mapInstance);

        markersLayer = L.layerGroup().addTo(mapInstance);

        const professorIcon = L.divIcon({
            className: 'custom-professor-marker',
            html: `<div style="background: linear-gradient(135deg, #2B5AA8 0%, #1e3a8a 100%); 
                           width: 45px; height: 45px; border-radius: 50%; 
                           border: 4px solid white; 
                           display: flex; align-items: center; justify-content: center;
                           box-shadow: 0 4px 8px rgba(0,0,0,0.3);
                           cursor: pointer;
                           transition: transform 0.2s;">
                    <svg style="width: 22px; height: 22px; color: white;" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                    </svg>
                  </div>`,
            iconSize: [45, 45],
            iconAnchor: [22.5, 22.5]
        });

        professors.forEach((prof) => {
            const photoUrl = prof.photo ? `/storage/${prof.photo}` : '/images/default-avatar.png';
            
            const services = prof.services.slice(0, 3).map(s => 
                `<span style="background: #E1EAF7; color: #2B5AA8; padding: 4px 10px; border-radius: 12px; font-size: 11px; display: inline-block; margin: 3px; font-weight: 600;">${s.nom_matiere}</span>`
            ).join(' ');

            const moreServices = prof.services.length > 3 
                ? `<span style="background: #f3f4f6; color: #6b7280; padding: 4px 10px; border-radius: 12px; font-size: 11px; display: inline-block; margin: 3px; font-weight: 600;">+${prof.services.length - 3} autres</span>` 
                : '';

            const stars = '⭐'.repeat(Math.floor(prof.note));
            
            const popupContent = `
                <div class="professor-popup" style="min-width: 280px; max-width: 320px; font-family: system-ui; padding: 8px;">
                    <div style="text-align: center; margin-bottom: 12px;">
                        <div style="position: relative; display: inline-block; margin-bottom: 10px;">
                            <img src="${photoUrl}" 
                                 style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 4px solid #E1EAF7;"
                                 onerror="this.src='/images/default-avatar.png'">
                            ${prof.note >= 4.5 ? '<div style="position: absolute; bottom: -5px; right: -5px; background: #fbbf24; color: white; font-size: 10px; font-weight: bold; padding: 4px 8px; border-radius: 12px; border: 2px solid white;">⭐ TOP</div>' : ''}
                        </div>
                        
                        <h3 style="font-weight: bold; font-size: 18px; margin: 8px 0; color: #111;">
                            ${prof.surnom || prof.prenom + ' ' + prof.nom}
                        </h3>
                        
                        <div style="margin: 8px 0;">
                            <span style="color: #fbbf24; font-size: 16px;">${stars}</span> 
                            <strong style="font-size: 15px;">${prof.note}/5</strong> 
                            <span style="color: #6b7280; font-size: 13px;">(${prof.nbrAvis} avis)</span>
                        </div>
                        
                        <div style="display: flex; align-items: center; justify-content: center; gap: 4px; margin: 8px 0; color: #6b7280; font-size: 14px;">
                            <svg style="width: 16px; height: 16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            ${prof.ville}
                        </div>
                    </div>
                    
                    <div style="margin: 12px 0; padding: 12px; background: #f9fafb; border-radius: 10px;">
                        <div style="text-align: center; margin-bottom: 8px;">
                            <span style="font-size: 12px; color: #6b7280; text-transform: uppercase; font-weight: 600;">À partir de</span>
                        </div>
                        <div style="text-align: center;">
                            <span style="font-size: 32px; font-weight: bold; color: #2B5AA8;">${prof.min_prix}</span>
                            <span style="font-size: 16px; color: #6b7280; font-weight: 500;"> DH/h</span>
                        </div>
                    </div>
                    
                    <div style="margin: 12px 0;">
                        <div style="font-size: 12px; color: #6b7280; margin-bottom: 6px; font-weight: 600;">MATIÈRES ENSEIGNÉES</div>
                        <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                            ${services}
                            ${moreServices}
                        </div>
                    </div>
                    
                    <div style="margin-top: 15px;">
                        <a href="/professeurs/${prof.id_professeur}" 
                           style="display: block; background: linear-gradient(135deg, #2B5AA8 0%, #1e3a8a 100%); color: white; padding: 12px; 
                                  border-radius: 10px; text-decoration: none; font-weight: bold; text-align: center;
                                  box-shadow: 0 4px 6px rgba(43, 90, 168, 0.3); transition: all 0.3s;"
                           onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(43, 90, 168, 0.4)';"
                           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(43, 90, 168, 0.3)';">
                            📚 Voir le profil complet
                        </a>
                    </div>
                </div>`;

            const marker = L.marker([prof.latitude, prof.longitude], {
                icon: professorIcon
            }).addTo(markersLayer);

            marker.bindPopup(popupContent, {
                maxWidth: 340,
                className: 'custom-popup'
            });

            marker.on('mouseover', function(e) {
                this.getElement().querySelector('div').style.transform = 'scale(1.15)';
            });
            
            marker.on('mouseout', function(e) {
                this.getElement().querySelector('div').style.transform = 'scale(1)';
            });
        });

        if (professors.length > 1) {
            const bounds = L.latLngBounds(professors.map(p => [p.latitude, p.longitude]));
            mapInstance.fitBounds(bounds, { 
                padding: [60, 60],
                maxZoom: 15
            });
        }

        setTimeout(() => {
            if (mapInstance) {
                mapInstance.invalidateSize();
                console.log('✅ Carte initialisée avec succès');
            }
        }, 250);

    } catch (error) {
        console.error('❌ Erreur lors de la création de la carte:', error);
    }
}

const professeursData = @json($professeursMap);

document.addEventListener('livewire:init', () => {
    console.log('🎯 Livewire init - Configuration des listeners');
    
    Livewire.hook('morph.updated', ({ el, component }) => {
        console.log('🔄 Livewire morph.updated détecté');
        
        setTimeout(() => {
            const mapElement = document.getElementById('map');
            if (mapElement && window.getComputedStyle(mapElement).display !== 'none') {
                console.log('✅ Carte visible après update, initialisation...');
                initializeMap(professeursData);
            } else if (mapElement) {
                console.log('⏹ Carte cachée après update, destruction...');
                destroyMap();
            }
        }, 100);
    });
});

document.addEventListener('DOMContentLoaded', function() {
    console.log('📦 DOM chargé, vérification état initial');
    
    setTimeout(() => {
        const mapElement = document.getElementById('map');
        if (mapElement && window.getComputedStyle(mapElement).display !== 'none') {
            console.log('🎯 Carte visible au chargement, initialisation...');
            initializeMap(professeursData);
        }
    }, 300);
});

function toggleFilters() {
    const sidebar = document.getElementById('filtersSidebar');
    
    if (sidebar.classList.contains('hidden')) {
        sidebar.classList.remove('hidden');
        sidebar.classList.add('fixed', 'inset-0', 'z-50', 'w-full', 'h-full', 'bg-white', 'p-4', 'overflow-y-auto');
        if (!document.getElementById('closeFiltersBtn')) {
            const closeBtn = document.createElement('button');
            closeBtn.id = 'closeFiltersBtn';
            closeBtn.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
            closeBtn.className = 'absolute top-4 right-4 p-2 text-gray-500';
            closeBtn.onclick = toggleFilters;
            sidebar.prepend(closeBtn);
        }
    } else {
        sidebar.classList.add('hidden');
        sidebar.classList.remove('fixed', 'inset-0', 'z-50', 'w-full', 'h-full', 'bg-white', 'p-4', 'overflow-y-auto');
        const closeBtn = document.getElementById('closeFiltersBtn');
        if (closeBtn) closeBtn.remove();
    }
}
</script>
@endpush