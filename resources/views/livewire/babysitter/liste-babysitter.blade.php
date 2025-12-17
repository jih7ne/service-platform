<div class="min-h-screen bg-gray-50 font-sans">
    <livewire:shared.header />
    <!-- Header Section with Gradient -->
    <div class="relative bg-white overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-[#B82E6E]/5 to-[#B82E6E]/10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 mb-8 text-sm font-medium text-gray-500">
                <a href="/" wire:navigate class="hover:text-[#B82E6E] transition-colors flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Accueil
                </a>
                <span class="text-gray-300">/</span>
                <a href="/services" wire:navigate class="hover:text-[#B82E6E] transition-colors">
                    Services
                </a>
                <span class="text-gray-300">/</span>
                <span class="text-[#B82E6E] font-bold">Babysitting</span>
            </nav>

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                <div>
                    <h1 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tight mb-4">
                        Trouvez la <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#B82E6E] to-[#D94686]">Babysitter idéale</span>
                    </h1>
                    <p class="text-lg text-gray-600 max-w-2xl leading-relaxed">
                        Des professionnels de confiance pour prendre soin de vos enfants. 
                        <span class="font-semibold text-[#B82E6E]">{{ $totalBabysitters }} profils vérifiés</span> disponibles maintenant.
                    </p>
                </div>
                
                <!-- Search Bar and Toggle -->
                <div class="w-full md:w-auto md:min-w-[400px] flex flex-col gap-4">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#B82E6E] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            class="block w-full pl-11 pr-4 py-4 bg-white border border-gray-200 rounded-2xl leading-5 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#B82E6E]/20 focus:border-[#B82E6E] transition-all shadow-sm hover:shadow-md"
                            placeholder="Rechercher par nom, ville, quartier..."
                        />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <div wire:loading wire:target="search" class="animate-spin rounded-full h-5 w-5 border-b-2 border-[#B82E6E]"></div>
                        </div>
                    </div>
                    
                    <!-- Toggle Map/List Button -->
                    <div class="flex justify-center md:justify-end">
                        <button
                            wire:click="toggleMap"
                            class="flex items-center gap-2 px-4 py-2 rounded-lg font-semibold transition-all {{ $showMap ? 'bg-[#B82E6E] text-white' : 'bg-white text-[#B82E6E] border border-[#B82E6E]' }}"
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
            
         <!-- Toggle List/Map Button -->
            @if(count($babysittersMap) > 0)
           
            @endif
            
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
            <div class="p-4 bg-gradient-to-r from-[#B82E6E] to-[#D94686] text-white">
                <h3 class="font-bold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Carte des babysitters ({{ count($babysittersMap) }} profils)
                </h3>
            </div>
            <div id="babysitters-map" style="height: 600px; width: 100%;"></div>
        </div>
        
        <!-- LIST VIEW -->
        @elseif(!$showMap)
        <div class="flex flex-col lg:flex-row gap-8">
         
            <aside class="hidden lg:block w-80 flex-shrink-0" id="filtersSidebar">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-8 max-h-[calc(100vh-4rem)] overflow-y-auto custom-scrollbar">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-50">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#B82E6E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Filtres
                        </h3>
                        <button
                            wire:click="clearFilters"
                            class="text-xs font-semibold text-gray-500 hover:text-[#B82E6E] transition-colors uppercase tracking-wide"
                        >
                            Réinitialiser
                        </button>
                    </div>

                    <div class="space-y-8">
                        <!-- Ville -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Ville
                            </label>
                            <div class="relative">
                                <select wire:model.live="ville" class="w-full pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#B82E6E]/20 focus:border-[#B82E6E] appearance-none cursor-pointer transition-all hover:bg-white">
                                    <option value="">Toutes les villes</option>
                                    @foreach($villes as $v)
                                    <option value="{{ $v }}">{{ $v }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Prix -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-sm font-bold text-gray-700">Budget horaire</label>
                                <span class="text-xs font-medium text-gray-500">Max: {{ $priceMax }} DH</span>
                            </div>
                            <input
                                type="range"
                                min="30"
                                max="250"
                                step="5"
                                wire:model.live="priceMax"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-[#B82E6E]"
                            />
                            <div class="flex justify-between mt-2 text-xs text-gray-500 font-medium">
                                <span>30 DH</span>
                                <span>250 DH</span>
                            </div>
                        </div>

                        <!-- Caractéristiques -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                Préférences
                            </label>
                            <div class="space-y-3">
                                <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors group">
                                    <div class="relative flex items-center">
                                        <input type="checkbox" wire:model.live="non_fumeur" class="peer h-5 w-5 cursor-pointer appearance-none rounded-md border border-gray-300 transition-all checked:border-[#B82E6E] checked:bg-[#B82E6E]" />
                                        <svg class="pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-white opacity-0 peer-checked:opacity-100 w-3.5 h-3.5" viewBox="0 0 14 14" fill="none">
                                            <path d="M3 8L6 11L11 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Non-fumeur</span>
                                </label>
                                <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors group">
                                    <div class="relative flex items-center">
                                        <input type="checkbox" wire:model.live="permis_conduire" class="peer h-5 w-5 cursor-pointer appearance-none rounded-md border border-gray-300 transition-all checked:border-[#B82E6E] checked:bg-[#B82E6E]" />
                                        <svg class="pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-white opacity-0 peer-checked:opacity-100 w-3.5 h-3.5" viewBox="0 0 14 14" fill="none">
                                            <path d="M3 8L6 11L11 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Permis de conduire</span>
                                </label>
                                <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors group">
                                    <div class="relative flex items-center">
                                        <input type="checkbox" wire:model.live="voiture" class="peer h-5 w-5 cursor-pointer appearance-none rounded-md border border-gray-300 transition-all checked:border-[#B82E6E] checked:bg-[#B82E6E]" />
                                        <svg class="pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-white opacity-0 peer-checked:opacity-100 w-3.5 h-3.5" viewBox="0 0 14 14" fill="none">
                                            <path d="M3 8L6 11L11 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">A une voiture</span>
                                </label>
                                <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors group">
                                    <div class="relative flex items-center">
                                        <input type="checkbox" wire:model.live="possede_enfant" class="peer h-5 w-5 cursor-pointer appearance-none rounded-md border border-gray-300 transition-all checked:border-[#B82E6E] checked:bg-[#B82E6E]" />
                                        <svg class="pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-white opacity-0 peer-checked:opacity-100 w-3.5 h-3.5" viewBox="0 0 14 14" fill="none">
                                            <path d="M3 8L6 11L11 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">A des enfants</span>
                                </label>
                            </div>
                        </div>

                        <!-- Services -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                Compétences
                            </label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($allServices as $service)
                                <button
                                    wire:click="toggleService({{ $service->idSuperpouvoir }})"
                                    type="button"
                                    class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all border {{ in_array($service->idSuperpouvoir, $selectedServices) ? 'bg-[#B82E6E] text-white border-[#B82E6E] shadow-sm' : 'bg-white text-gray-600 border-gray-200 hover:border-gray-300 hover:bg-gray-50' }}"
                                >
                                    {{ $service->superpouvoir }}
                                </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Formations -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                Formations
                            </label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($allFormations as $formation)
                                <button
                                    wire:click="toggleFormation({{ $formation->idFormation }})"
                                    type="button"
                                    class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all border {{ in_array($formation->idFormation, $selectedFormations) ? 'bg-[#B82E6E] text-white border-[#B82E6E] shadow-sm' : 'bg-white text-gray-600 border-gray-200 hover:border-gray-300 hover:bg-gray-50' }}"
                                >
                                    {{ $formation->formation }}
                                </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Catégories d'enfants -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                Âge des enfants
                            </label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($allCategories as $categorie)
                                <button
                                    wire:click="toggleCategorie({{ $categorie->idCategorie }})"
                                    type="button"
                                    class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all border {{ in_array($categorie->idCategorie, $selectedCategories) ? 'bg-[#B82E6E] text-white border-[#B82E6E] shadow-sm' : 'bg-white text-gray-600 border-gray-200 hover:border-gray-300 hover:bg-gray-50' }}"
                                >
                                    {{ $categorie->categorie }}
                                </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Expériences besoins spéciaux -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                Expérience besoins spéciaux
                            </label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($allExperiences as $experience)
                                <button
                                    wire:click="toggleExperience({{ $experience->idExperience }})"
                                    type="button"
                                    class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all border {{ in_array($experience->idExperience, $selectedExperiences) ? 'bg-[#B82E6E] text-white border-[#B82E6E] shadow-sm' : 'bg-white text-gray-600 border-gray-200 hover:border-gray-300 hover:bg-gray-50' }}"
                                >
                                    {{ $experience->experience }}
                                </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Expérience -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Expérience
                            </label>
                            <div class="relative">
                                <select wire:model.live="experience" class="w-full pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#B82E6E]/20 focus:border-[#B82E6E] appearance-none cursor-pointer transition-all hover:bg-white">
                                    <option value="">Peu importe</option>
                                    <option value="1">1 an minimum</option>
                                    <option value="3">3 ans minimum</option>
                                    <option value="5">5 ans minimum</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Préférence domicile -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Lieu de garde
                            </label>
                            <div class="relative">
                                <select wire:model.live="preference_domicile" class="w-full pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#B82E6E]/20 focus:border-[#B82E6E] appearance-none cursor-pointer transition-all hover:bg-white">
                                    <option value="">Peu importe</option>
                                    <option value="domicil_babysitter">Chez la babysitter</option>
                                    <option value="domicil_client">Chez le client</option>
                                    <option value="les_deux">Les deux</option>
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
                        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-[#B82E6E]"></div>
                        <span class="font-medium text-gray-700">Mise à jour...</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" wire:loading.class="opacity-50 transition-opacity duration-200">
                    @forelse($babysitters as $babysitter)
                    @php
                        $utilisateur = $babysitter->intervenant->utilisateur;
                        $localisation = $utilisateur->localisations()->first();
                        $services = $babysitter->superpouvoirs;
                    @endphp
                    <div class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-300 hover:-translate-y-1">
                        <!-- Card Header / Image -->
                        <div class="relative h-48 overflow-hidden bg-gray-100">
                           <img
                                src="{{ $utilisateur->photo ? asset('storage/' . $utilisateur->photo) : 'https://ui-avatars.com/api/?name='.urlencode($utilisateur->prenom.' '.$utilisateur->nom).'&background=random' }}"
                                alt="{{ $utilisateur->prenom }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            />
                            <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-2.5 py-1 rounded-lg text-xs font-bold text-gray-900 shadow-sm flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-yellow-400 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                {{ number_format($utilisateur->note, 1) }}
                            </div>
                            @if($babysitter->estDispo)
                            <div class="absolute top-3 left-3 bg-green-500/90 backdrop-blur-sm px-2.5 py-1 rounded-lg text-xs font-bold text-white shadow-sm">
                                Disponible
                            </div>
                            @endif
                        </div>

                        <!-- Card Body -->
                        <div class="p-5">
                            <div class="mb-4">
                                <h3 class="text-lg font-bold text-gray-900 mb-1 group-hover:text-[#B82E6E] transition-colors">
                                    {{ $utilisateur->prenom }} {{ substr($utilisateur->nom, 0, 1) }}.
                                </h3>
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $localisation->ville ?? 'Ville inconnue' }}
                                </div>
                            </div>

                            <!-- Services Tags -->
                            <div class="flex flex-wrap gap-1.5 mb-5 h-16 overflow-hidden content-start">
                                @forelse($babysitter->superpouvoirs->take(3) as $service)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-pink-50 text-pink-700 border border-pink-100">
                                    {{ $service->superpouvoir }}
                                </span>
                                @empty
                                <span class="text-xs text-gray-400 italic">Aucun service spécifié</span>
                                @endforelse
                                @if($babysitter->superpouvoirs->count() > 3)
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-50 text-gray-600 border border-gray-100">
                                    +{{ $babysitter->superpouvoirs->count() - 3 }}
                                </span>
                                @endif
                            </div>

                            <!-- Footer -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                                <div class="flex flex-col">
                                    <span class="text-xs text-gray-500 font-medium uppercase tracking-wider">Tarif</span>
                                    <div class="flex items-baseline gap-0.5">
                                        <span class="text-xl font-black text-gray-900">{{ $babysitter->prixHeure }}</span>
                                        <span class="text-xs font-bold text-gray-500">DH/h</span>
                                    </div>
                                </div>
                                <a href="/babysitter-profile/{{ $babysitter->idBabysitter }}" wire:navigate class="inline-flex items-center justify-center px-4 py-2 bg-[#B82E6E] text-white text-sm font-bold rounded-xl hover:bg-[#9d265d] transition-all shadow-lg shadow-pink-500/30">
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
                            Nous n'avons trouvé aucune babysitter correspondant à vos critères. Essayez d'élargir votre recherche.
                        </p>
                        <button wire:click="clearFilters" class="mt-6 text-[#B82E6E] font-bold hover:underline">
                            Effacer tous les filtres
                        </button>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="mobileSidebar" class="fixed inset-0 z-40 hidden lg:hidden">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="toggleFilters()"></div>
        <div class="absolute right-0 top-0 bottom-0 w-80 bg-white shadow-2xl transform transition-transform duration-300 overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xl font-bold text-gray-900">Filtres</h3>
                    <button onclick="toggleFilters()" class="p-2 -mr-2 text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <!-- Mobile Filters Content (Clone of Desktop) -->
                <!-- Note: In a real app, we'd extract this to a component to avoid duplication. For now, we'll just rely on the desktop sidebar being hidden and this one being shown when toggled. 
                     Actually, to avoid ID conflicts and state issues, it's better to just style the main sidebar to be fixed on mobile.
                -->
            </div>
        </div>
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
    </style>
    @endpush

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
        
    <script>
        let mapInstance = null;

        function destroyMap() {
            if (mapInstance) {
                mapInstance.remove();
                mapInstance = null;
            }
        }

        function initializeMap(babysitters) {
            console.log('initializeMap appelé avec:', babysitters.length, 'babysitters');
            console.log('Données babysitters:', babysitters);
            
            const mapElement = document.getElementById('babysitters-map');
            if (!mapElement) {
                console.log('Élément map non trouvé');
                return;
            }

            if (babysitters.length === 0) {
                console.log('Aucun babysitter à afficher');
                mapElement.innerHTML = '<div style="display: flex; align-items: center; justify-content: center; height: 600px; color: #666;">Aucun babysitter avec localisation</div>';
                return;
            }

            destroyMap();

            // Utiliser Casablanca comme centre par défaut
            mapInstance = L.map('babysitters-map').setView([33.5731, -7.5898], 10);
            console.log('Carte initialisée');
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(mapInstance);

            // Ajouter les marqueurs
            babysitters.forEach((babysitter, index) => {
                console.log(`Création marqueur ${index + 1}:`, babysitter);
                
                // Marqueur simple sans icône personnalisée
                const marker = L.marker([babysitter.latitude, babysitter.longitude]).addTo(mapInstance);
                
                console.log(`Marqueur ${index + 1} ajouté à [${babysitter.latitude}, ${babysitter.longitude}]`);
                
                const popupContent = `
                    <div style="padding: 8px; text-align: center; min-width: 150px;">
                        <h4 style="margin: 0 0 4px 0;">${babysitter.prenom} ${babysitter.nom}</h4>
                        <p style="margin: 2px 0; color: #666; font-size: 12px;">${babysitter.ville}</p>
                        <p style="margin: 4px 0; font-weight: bold; color: #B82E6E;">${babysitter.prixHeure} DH/h</p>
                        <a href="/babysitter-profile/${babysitter.idBabysitter}" style="color: #B82E6E; text-decoration: none; font-size: 12px;">Voir profil</a>
                    </div>`;
                
                marker.bindPopup(popupContent);
            });

            console.log('Tous les marqueurs ajoutés');
        }

        // Initialiser la carte si en mode carte au chargement
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('babysitters-map')) {
                const babysittersData = @json($babysittersMap);
                console.log('Initialisation au chargement - données:', babysittersData);
                if (babysittersData && babysittersData.length > 0) {
                    initializeMap(babysittersData);
                }
            }
        });

        // Réinitialiser la carte lors du toggle
        document.addEventListener('livewire:init', () => {
            Livewire.on('map-toggled', () => {
                const mapElement = document.getElementById('babysitters-map');
                if (mapElement) {
                    const babysittersData = @json($babysittersMap);
                    console.log('Toggle map - données:', babysittersData);
                    if (babysittersData && babysittersData.length > 0) {
                        initializeMap(babysittersData);
                    } else {
                        console.log('Aucune donnée de babysitters disponible');
                        mapElement.innerHTML = '<div style="display: flex; align-items: center; justify-content: center; height: 600px; color: #666;">Aucun babysitter avec localisation disponible</div>';
                    }
                } else {
                    destroyMap();
                }
            });
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
</div>