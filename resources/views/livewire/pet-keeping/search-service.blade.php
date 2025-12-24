
<div class="min-h-screen bg-gray-50 font-sans">
    <livewire:shared.header />

    <!-- Header Section with Gradient -->
    <div class="relative bg-white overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-amber-100/20 to-amber-200/10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
            <!-- Bouton Retour -->
            <div class="mb-6">
                <a href="{{ route('services') }}" class="inline-flex items-center text-amber-700 hover:text-amber-800 font-semibold transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour aux services
                </a>
            </div>

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                <div>
                    <h1 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tight mb-4">
                        Trouvez le <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-600 to-amber-800">Pet-Sitter idéal</span>
                    </h1>
                    <p class="text-lg text-gray-600 max-w-2xl leading-relaxed">
                        Des gardiens qualifiés pour prendre soin de vos animaux de compagnie. 
                        <span class="font-semibold text-amber-700">{{ count($services) }} profils vérifiés</span> disponibles maintenant.
                    </p>
                </div>
                
                <!-- Search Bar and Toggle -->
                <div class="w-full md:w-auto md:min-w-[400px] flex flex-col gap-4">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input
                            type="text"
                            wire:model.live.debounce.500ms="searchQuery"
                            class="block w-full pl-11 pr-4 py-4 bg-white border border-gray-200 rounded-2xl leading-5 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all shadow-sm hover:shadow-md"
                            placeholder="Rechercher par nom, service, description..."
                        />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <div wire:loading wire:target="searchQuery" class="animate-spin rounded-full h-5 w-5 border-b-2 border-amber-600"></div>
                        </div>
                    </div>
                    
                    <!-- Toggle Map/List Button -->
                    <div class="flex justify-center md:justify-end">
                        <button
                            wire:click="switchView('{{ $viewMode === 'map' ? 'list' : 'map' }}')"
                            class="flex items-center gap-2 px-4 py-2 rounded-lg font-semibold transition-all {{ $viewMode === 'map' ? 'bg-amber-600 text-white' : 'bg-white text-amber-600 border border-amber-600' }}"
                        >
                            @if($viewMode === 'map')
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
            @if($viewMode !== 'map')
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
        @if($viewMode === 'map')
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-4 bg-gradient-to-r from-amber-600 to-amber-800 text-white">
                <h3 class="font-bold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Carte des Pet-Sitters ({{ count($mapMarkers) }} profils)
                </h3>
            </div>
            <div wire:ignore id="map" style="height: 600px; width: 100%;"></div>
            
            <!-- Map Controls -->
            <div class="absolute top-20 right-4 z-20 flex flex-col gap-2">
                <button onclick="window.zoomIn()" 
                        class="p-3 bg-white rounded-lg shadow-md hover:shadow-lg transition-all hover:bg-gray-50 active:scale-95">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </button>
                <button onclick="window.zoomOut()" 
                        class="p-3 bg-white rounded-lg shadow-md hover:shadow-lg transition-all hover:bg-gray-50 active:scale-95">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                    </svg>
                </button>
                <button onclick="window.locateMe()" 
                        class="p-3 bg-amber-600 text-white rounded-lg shadow-md hover:bg-amber-700 transition-colors active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Map Results List -->
            @if(count($mapMarkers) > 0)
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($mapMarkers as $marker)
                            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow p-4">
                                <div class="flex items-start gap-3 mb-3">
                                    <img src="{{ $marker['photo'] }}" 
                                         class="w-12 h-12 rounded-full object-cover border border-gray-200">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 text-sm">{{ $marker['name'] }}</h4>
                                        <div class="flex items-center gap-1 mb-1">
                                            <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                            <span class="text-sm font-medium">{{ number_format($marker['rating'], 1) }}</span>
                                        </div>
                                        <p class="text-xs text-gray-600">📍 {{ $marker['city'] }}, {{ $marker['country'] }}</p>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="text-lg font-bold text-gray-900 mb-1">
                                        {{ number_format($marker['price'], 2) }} DH / {{ $marker['criteria'] }}
                                    </div>
                                    <div class="flex flex-wrap gap-1 mb-2">
                                        @foreach($marker['services'] as $service)
                                            <span class="px-2 py-1 bg-amber-50 text-amber-700 rounded-full text-xs">{{ $service }}</span>
                                        @endforeach
                                    </div>
                                    <p class="text-sm text-gray-600">{{ $marker['description'] }}</p>
                                </div>
                                
                                
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        
        <!-- LIST VIEW -->
        @else
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filters Sidebar -->
            <aside class="hidden lg:block w-80 flex-shrink-0" id="filtersSidebar">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-8 max-h-[calc(100vh-4rem)] overflow-y-auto custom-scrollbar">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-50">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Filtres
                        </h3>
                        <button
                            wire:click="resetFilters"
                            class="text-xs font-semibold text-gray-500 hover:text-amber-600 transition-colors uppercase tracking-wide"
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
                                    wire:click="$set('sortBy', 'rating')"
                                    class="px-3 py-1.5 text-xs rounded-lg font-semibold transition-all border {{ $sortBy === 'rating' ? 'bg-amber-600 text-white border-amber-600' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50' }}">
                                    Note
                                </button>
                                <button 
                                    wire:click="$set('sortBy', 'price')"
                                    class="px-3 py-1.5 text-xs rounded-lg font-semibold transition-all border {{ $sortBy === 'price' ? 'bg-amber-600 text-white border-amber-600' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50' }}">
                                    Prix
                                </button>
                                <button 
                                    wire:click="$set('sortBy', 'dateDsc')"
                                    class="px-3 py-1.5 text-xs rounded-lg font-semibold transition-all border {{ $sortBy === 'dateDsc' ? 'bg-amber-600 text-white border-amber-600' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50' }}">
                                    Plus récents
                                </button>
                            </div>
                        </div>

                        <!-- Type d'animal -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Type d'animal</label>
                            <div class="relative">
                                <select wire:model.live="petType" class="w-full pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 appearance-none cursor-pointer transition-all hover:bg-white">
                                    <option value="all">Tous les animaux</option>
                                    @foreach(App\Constants\PetKeeping\Constants::getSelectOptions() as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Catégorie de service -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Catégorie de service</label>
                            <div class="relative">
                                <select wire:model.live="serviceCategory" class="w-full pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 appearance-none cursor-pointer transition-all hover:bg-white">
                                    <option value="all">Toutes les catégories</option>
                                    @foreach(App\Constants\PetKeeping\Constants::forSelect() as $value => $optionLabel)
                                        <option value="{{ $value }}">{{ $optionLabel }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Critère de paiement -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Critère de paiement</label>
                            <div class="relative">
                                <select wire:model.live="criteria" class="w-full pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 appearance-none cursor-pointer transition-all hover:bg-white">
                                    <option value="all">Tous les critères</option>
                                    @foreach(App\Constants\PetKeeping\Constants::forSelectCriteria() as $value => $optionLabel)
                                        <option value="{{ $value }}">{{ $optionLabel }}</option>
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
                                <select wire:model.live="minRating" class="w-full pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 appearance-none cursor-pointer transition-all hover:bg-white">
                                    <option value="0">Toutes les notes</option>
                                    <option value="4">⭐ 4.0+ Très bien</option>
                                    <option value="4.5">⭐ 4.5+ Excellent</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Prix -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Fourchette de prix (DH)</label>
                            <div class="space-y-3">
                                <div class="flex items-center gap-2">
                                    <input type="number" wire:model.live="minPrice" 
                                           placeholder="Min"
                                           class="flex-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 text-sm">
                                    <span class="text-gray-400">-</span>
                                    <input type="number" wire:model.live="maxPrice" 
                                           placeholder="Max"
                                           class="flex-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 text-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Exigences -->
                        <div class="space-y-3">
                            <label class="block text-sm font-bold text-gray-700">Exigences</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model.live="vaccinationRequired" 
                                           class="rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                                    <span class="ml-2 text-sm text-gray-700">Vaccination requise</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model.live="acceptsUntrainedPets" 
                                           class="rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                                    <span class="ml-2 text-sm text-gray-700">Accepte non dressés</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model.live="acceptsAggressivePets" 
                                           class="rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                                    <span class="ml-2 text-sm text-gray-700">Accepte agressifs</span>
                                </label>
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
                        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-amber-600"></div>
                        <span class="font-medium text-gray-700">Mise à jour...</span>
                    </div>
                </div>

                <!-- Active Filters Display -->
                @if($searchQuery || $petType !== 'all' || $serviceCategory || $criteria || $minRating > 0 || $minPrice > 0 || $maxPrice || $vaccinationRequired || $acceptsUntrainedPets || $acceptsAggressivePets)
                <div class="mb-6 p-4 bg-white rounded-xl border border-gray-100 shadow-sm">
                    <div class="flex items-center justify-between flex-wrap gap-3">
                        <div class="flex flex-wrap gap-2">
                            @if($searchQuery)
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-amber-600 text-white text-xs rounded-full font-semibold">
                                    Recherche: "{{ Str::limit($searchQuery, 20) }}"
                                </span>
                            @endif
                            @if($petType !== 'all')
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-amber-600 text-white text-xs rounded-full font-semibold">
                                    Type: {{ App\Constants\PetKeeping\Constants::getSelectOptions()[$petType] ?? $petType }}
                                </span>
                            @endif
                            @if($serviceCategory && $serviceCategory !== 'all')
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-amber-600 text-white text-xs rounded-full font-semibold">
                                    Catégorie: {{ App\Constants\PetKeeping\Constants::forSelect()[$serviceCategory] ?? $serviceCategory }}
                                </span>
                            @endif
                            @if($criteria && $criteria !== 'all')
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-amber-600 text-white text-xs rounded-full font-semibold">
                                    Critère: {{ App\Constants\PetKeeping\Constants::forSelectCriteria()[$criteria] ?? $criteria }}
                                </span>
                            @endif
                            @if($minRating > 0)
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-amber-600 text-white text-xs rounded-full font-semibold">
                                    Note ≥ {{ $minRating }}
                                </span>
                            @endif
                            @if($minPrice > 0)
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-amber-600 text-white text-xs rounded-full font-semibold">
                                    Prix min: {{ $minPrice }} DH
                                </span>
                            @endif
                            @if($maxPrice)
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-amber-600 text-white text-xs rounded-full font-semibold">
                                    Prix max: {{ $maxPrice }} DH
                                </span>
                            @endif
                            @if($vaccinationRequired)
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-amber-600 text-white text-xs rounded-full font-semibold">
                                    💉 Vaccination
                                </span>
                            @endif
                            @if($acceptsUntrainedPets)
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-amber-600 text-white text-xs rounded-full font-semibold">
                                    🎓 Non dressés
                                </span>
                            @endif
                            @if($acceptsAggressivePets)
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-amber-600 text-white text-xs rounded-full font-semibold">
                                    ⚠️ Agressifs
                                </span>
                            @endif
                        </div>
                        <button 
                            wire:click="resetFilters"
                            class="text-sm text-amber-600 hover:text-amber-800 font-bold flex items-center gap-1"
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
                    @forelse($services as $service)
                    <div class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-300 hover:-translate-y-1">
                        <!-- Card Header / Image -->
                        <div class="relative h-48 overflow-hidden bg-gray-100">
                            
                            <img 
                                src="{{ $service['photo'] ? asset('storage/' . $service['photo']) : asset('images/default.jpg') }}" 
                                alt="Photo de {{ $service['providerName'] }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                onerror="this.src='https://api.dicebear.com/7.x/avataaars/svg?seed={{ urlencode($service['providerName'] ?? 'default') }}'"
                            />
                            <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-2.5 py-1 rounded-lg text-xs font-bold text-gray-900 shadow-sm flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-yellow-400 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                {{ number_format($service['note'], 1) }}
                            </div>
                            @if($service['note'] >= 4.5)
                            <div class="absolute top-3 left-3 bg-yellow-400/90 backdrop-blur-sm px-2.5 py-1 rounded-lg text-xs font-bold text-white shadow-sm">
                                ⭐ TOP
                            </div>
                            @endif
                        </div>

                        <!-- Card Body -->
                        <div class="p-5">
                            <div class="mb-4">
                                <h3 class="text-lg font-bold text-gray-900 mb-1 group-hover:text-amber-700 transition-colors">
                                    {{ $service['nomService'] ?? 'Service' }}
                                </h3>
                                
                                <!-- Provider Name -->
                                <p class="text-sm text-gray-600 mb-2 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ $service['providerName'] ?? 'Fournisseur' }}
                                </p>
                                
                                <!-- Rating Stars -->
                                <div class="flex items-center justify-center gap-1 mb-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($service['note']))
                                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endif
                                    @endfor
                                    <span class="text-sm font-medium ml-1">{{ number_format($service['note'], 1) }}</span>
                                    <span class="text-xs text-gray-500">({{ $service['nbrAvis'] ?? 0 }} avis)</span>
                                </div>

                                <!-- Location -->
                                @if($service['city'] || $service['location'])
                                    <div class="flex items-center justify-center gap-1 mt-2 text-gray-600 text-sm">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $service['city'] ?? $service['location'] }}
                                    </div>
                                @endif
                            </div>

                            <!-- Service Details -->
                            <div class="mb-5">
                                <!-- Category and Criteria -->
                                <div class="flex flex-wrap gap-2 mb-3 justify-center">
                                    @if($service['category'])
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-purple-50 text-purple-700 border border-purple-100">
                                            {{ $service['category'] }}
                                        </span>
                                    @endif
                                    @if($service['paymentCriteria'])
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                                            {{ str_replace('_', ' ', $service['paymentCriteria']) }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Pet Type -->
                                @if($service['petType'])
                                    <div class="flex items-center justify-center gap-2 mb-3">
                                        <span class="text-xs text-gray-500 font-medium">Type d'animal:</span>
                                        <span class="px-2.5 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">
                                            {{ $service['petType'] }}
                                        </span>
                                    </div>
                                @endif

                                <!-- Requirements -->
                                <div class="flex flex-wrap gap-1.5 justify-center">
                                    @if($service['vaccinationRequired'] ?? false)
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-red-50 text-red-700 border border-red-100">
                                            💉 Vaccination
                                        </span>
                                    @endif
                                    @if($service['acceptsUntrainedPets'] ?? false)
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-yellow-50 text-yellow-700 border border-yellow-100">
                                            🎓 Non dressés
                                        </span>
                                    @endif
                                    @if($service['acceptsAggressivePets'] ?? false)
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-orange-50 text-orange-700 border border-orange-100">
                                            ⚠️ Agressifs
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                                <div class="flex flex-col">
                                    <span class="text-xs text-gray-500 font-medium uppercase tracking-wider">À partir de</span>
                                    <div class="flex items-baseline gap-0.5">
                                        <span class="text-xl font-black text-gray-900">{{ number_format($service['base_price'], 0) }}</span>
                                        <span class="text-xs font-bold text-gray-500">DH</span>
                                    </div>
                                </div>
                                <button wire:click="toService({{ $service['providerId'] }}, {{ $service['id'] }})" 
                                        class="inline-flex items-center justify-center px-4 py-2 bg-amber-600 text-white text-sm font-bold rounded-xl hover:bg-amber-700 transition-all shadow-lg shadow-amber-500/30">
                                    Voir
                                </button>
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
                            Nous n'avons trouvé aucun service correspondant à vos critères. Essayez d'élargir votre recherche.
                        </p>
                        <button wire:click="resetFilters" class="mt-6 text-amber-600 font-bold hover:underline">
                            Effacer tous les filtres
                        </button>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if(count($services) > $perPage)
                    <div class="mt-12">
                        <nav class="flex items-center justify-between border-t border-gray-200 px-4 sm:px-0">
                            <div class="-mt-px flex w-0 flex-1">
                                <button wire:click="previousPage" 
                                        class="inline-flex items-center border-t-2 border-transparent pr-1 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700"
                                        {{ $currentPage <= 1 ? 'disabled' : '' }}>
                                    <svg class="mr-3 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a.75.75 0 01-.75.75H4.66l2.1 1.95a.75.75 0 11-1.02 1.1l-3.5-3.25a.75.75 0 010-1.1l3.5-3.25a.75.75 0 111.02 1.1l-2.1 1.95h12.59A.75.75 0 0118 10z" clip-rule="evenodd" />
                                    </svg>
                                    Précédent
                                </button>
                            </div>
                            
                            <div class="hidden md:-mt-px md:flex">
                                @for($page = 1; $page <= ceil(count($services) / $perPage); $page++)
                                    @if($page === $currentPage)
                                        <button wire:click="gotoPage({{ $page }})"
                                                class="inline-flex items-center border-t-2 border-amber-500 px-4 pt-4 text-sm font-medium text-amber-600"
                                                aria-current="page">
                                            {{ $page }}
                                        </button>
                                    @else
                                        <button wire:click="gotoPage({{ $page }})"
                                                class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                                            {{ $page }}
                                        </button>
                                    @endif
                                @endfor
                            </div>
                            
                            <div class="-mt-px flex w-0 flex-1 justify-end">
                                <button wire:click="nextPage" 
                                        class="inline-flex items-center border-t-2 border-transparent pl-1 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700"
                                        {{ $currentPage >= ceil(count($services) / $perPage) ? 'disabled' : '' }}>
                                    Suivant
                                    <svg class="ml-3 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </nav>
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
</style>
@endpush

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
      crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>

<script>
    // Map variables
    let map = null;
    let markersLayer = null;
    
    // Custom marker icons
    const markerIcons = {
        default: L.divIcon({
            html: `
                <div class="relative">
                    <div class="w-10 h-10 rounded-full bg-amber-600 border-3 border-white shadow-lg flex items-center justify-center transform hover:scale-125 transition-transform duration-200">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            `,
            className: 'custom-marker-icon',
            iconSize: [40, 40],
            iconAnchor: [20, 40],
            popupAnchor: [0, -40]
        }),
        
        highRating: L.divIcon({
            html: `
                <div class="relative">
                    <div class="w-12 h-12 rounded-full bg-yellow-500 border-3 border-white shadow-lg flex items-center justify-center transform hover:scale-125 transition-transform duration-200">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-yellow-500 rounded-full border-2 border-white flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            `,
            className: 'high-rating-marker-icon',
            iconSize: [48, 48],
            iconAnchor: [24, 48],
            popupAnchor: [0, -48]
        })
    };
    
    // Initialize map
    function initMap() {
        console.log('Initializing map...');
        
        // Remove existing map if any
        if (map) {
            map.remove();
            map = null;
        }
        
        const mapElement = document.getElementById('map');
        if (!mapElement) {
            console.error('Map element not found');
            return;
        }
        
        // Clear any loading content
        mapElement.innerHTML = '';
        
        try {
            // Get data from Livewire
            const mapMarkers = @json($mapMarkers);
            const mapCenter = @json($mapCenter) || { lat: 33.5731, lng: -7.5898 };
            const mapZoom = @json($mapZoom) || 10;
            
            // Create map
            map = L.map('map').setView([mapCenter.lat, mapCenter.lng], mapZoom);
            
            // Add tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19,
            }).addTo(map);
            
            // Create marker layer
            markersLayer = L.layerGroup().addTo(map);
            
            // Add markers if we have data
            if (mapMarkers && mapMarkers.length > 0) {
                console.log(`Adding ${mapMarkers.length} markers...`);
                
                mapMarkers.forEach((data) => {
                    // Skip if no coordinates
                    if (!data.lat || !data.lng) {
                        console.warn('Marker missing coordinates:', data);
                        return;
                    }
                    
                    // Choose icon based on rating
                    const icon = data.rating >= 4.5 ? markerIcons.highRating : markerIcons.default;
                    
                    // Create marker
                    const marker = L.marker([data.lat, data.lng], {
                        icon: icon,
                        title: data.name,
                        riseOnHover: true
                    }).addTo(markersLayer);
                    
                    // Create popup content
                    const popupContent = createPopupContent(data);
                    
                    // Bind popup to marker
                    marker.bindPopup(popupContent, {
                        maxWidth: 300,
                        minWidth: 250,
                        className: 'custom-popup'
                    });
                    
                    // Add click event
                    marker.on('click', function(e) {
                        console.log('Marker clicked:', data);
                        // Center map on marker
                        map.setView(e.latlng, 15);
                    });
                });
                
                // Fit bounds to show all markers
                const bounds = L.latLngBounds(mapMarkers.map(m => [m.lat, m.lng]));
                map.fitBounds(bounds, {
                    padding: [50, 50],
                    maxZoom: 15
                });
            } else {
                console.log('No markers to display');
                // Add a message in center
                const messageMarker = L.marker([mapCenter.lat, mapCenter.lng], {
                    icon: L.divIcon({
                        html: `
                            <div class="bg-white p-4 rounded-lg shadow-lg border border-gray-200 max-w-xs">
                                <div class="text-center">
                                    <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <p class="text-sm text-gray-600">Marking Error!</p>
                                    <p class="text-xs text-gray-500 mt-1">Couldnot mark the points</p>
                                </div>
                            </div>
                        `,
                        className: 'no-markers-icon',
                        iconSize: [250, 100],
                        iconAnchor: [125, 50]
                    })
                }).addTo(map);
            }
            
            // Add zoom control
            L.control.zoom({
                position: 'topright'
            }).addTo(map);
            
            console.log('Map initialized successfully');
            
            // Invalidate size after render
            setTimeout(() => {
                if (map) {
                    map.invalidateSize();
                }
            }, 100);
            
        } catch (error) {
            console.error('Error initializing map:', error);
            mapElement.innerHTML = `
                <div class="flex flex-col items-center justify-center h-full bg-gray-100 rounded-lg p-8">
                    <svg class="w-16 h-16 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.698-.833-2.464 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Erreur de carte</h3>
                    <p class="text-gray-600 text-center mb-4">${error.message}</p>
                    <button onclick="initMap()" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-sm font-medium transition-colors">
                        Réessayer
                    </button>
                </div>
            `;
        }
    }
    
    // Create popup content
    function createPopupContent(data) {
        const ratingStars = Array.from({length: 5}, (_, i) => {
            const starClass = i < Math.floor(data.rating || 0) ? 'text-yellow-500' : 'text-gray-300';
            return `<svg class="w-4 h-4 ${starClass}" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>`;
        }).join('');
        
        return `
            <div class="p-3 min-w-[250px] max-w-[300px]">
                <div class="flex items-start gap-3 mb-3">
                    <img src="${data.photo || 'https://api.dicebear.com/7.x/avataaars/svg?seed=' + encodeURIComponent(data.name || 'default')}" 
                         class="w-12 h-12 rounded-full object-cover border-2 border-gray-200 shadow-sm">
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-900 text-sm mb-1">${data.name || 'Pet Sitter'}</h4>
                        <div class="flex items-center gap-1 mb-1">
                            ${ratingStars}
                            <span class="text-sm font-medium ml-1">${(data.rating || 0).toFixed(1)}</span>
                        </div>
                        ${data.city ? `<p class="text-xs text-gray-600 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            ${data.city}${data.country ? ', ' + data.country : ''}
                        </p>` : ''}
                    </div>
                </div>
                
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Prix:</span>
                        <span class="font-bold text-gray-900">${(data.price || 0).toFixed(2)} DH</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Critère:</span>
                        <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-medium">
                            ${data.criteria || 'Non spécifié'}
                        </span>
                    </div>
                    
                    ${data.services && data.services.length > 0 ? `
                    <div>
                        <span class="text-sm text-gray-600 block mb-1">Services:</span>
                        <div class="flex flex-wrap gap-1">
                            ${data.services.slice(0, 3).map(service => 
                                `<span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">${service}</span>`
                            ).join('')}
                            ${data.services.length > 3 ? `<span class="text-xs text-gray-500">+${data.services.length - 3} plus</span>` : ''}
                        </div>
                    </div>
                    ` : ''}
                    
                    ${data.description ? `
                    <div class="pt-2 border-t border-gray-100">
                        <p class="text-sm text-gray-600 line-clamp-2">${data.description}</p>
                    </div>
                    ` : ''}
                </div>
                
                <div class="flex gap-2 mt-4">
                    <button onclick="window.Livewire.dispatch('view-details', {id: ${data.id || 0}})" 
                            class="flex-1 px-3 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-sm font-medium transition-colors duration-200">
                        Voir détails
                    </button>
                    <button onclick="window.Livewire.dispatch('book-service', {id: ${data.id || 0}})" 
                            class="px-3 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-sm font-medium transition-colors duration-200">
                        Réserver
                    </button>
                </div>
            </div>
        `;
    }
    
    // Map control functions
    window.zoomIn = function() {
        if (map) map.zoomIn();
    }
    
    window.zoomOut = function() {
        if (map) map.zoomOut();
    }
    
    window.locateMe = function() {
        if (!map || !navigator.geolocation) {
            alert('La géolocalisation n\'est pas disponible');
            return;
        }
        
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const { latitude, longitude } = position.coords;
                
                // Add user location marker
                const userIcon = L.divIcon({
                    html: `
                        <div class="relative">
                            <div class="w-12 h-12 rounded-full bg-blue-600 border-3 border-white shadow-lg flex items-center justify-center animate-pulse">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    `,
                    className: 'user-location-icon',
                    iconSize: [48, 48],
                    iconAnchor: [24, 48]
                });
                
                const userMarker = L.marker([latitude, longitude], {
                    icon: userIcon,
                    zIndexOffset: 1000
                }).addTo(map);
                
                userMarker.bindPopup('Votre position actuelle').openPopup();
                
                // Center map on user location
                map.setView([latitude, longitude], 15);
                
                // Send to Livewire
                window.Livewire.dispatch('user-located', {
                    lat: latitude,
                    lng: longitude
                });
            },
            (error) => {
                console.error('Geolocation error:', error);
                alert('Impossible d\'obtenir votre position. Vérifiez les permissions de géolocalisation.');
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    }
    
    // Livewire event handlers
    document.addEventListener('livewire:initialized', () => {
        console.log('Livewire initialized, view mode:', @json($viewMode));
        
        // Initialize map if in map view
        if (@json($viewMode) === 'map') {
            console.log('In map view, initializing...');
            setTimeout(initMap, 300);
        }
        
        // Listen for view changes
        Livewire.on('switched-to-map-view', () => {
            console.log('Switched to map view');
            setTimeout(() => {
                initMap();
                // Invalidate size
                setTimeout(() => {
                    if (map) map.invalidateSize();
                }, 200);
            }, 200);
        });
        
        // Listen for map refresh
        Livewire.on('refresh-map', (data) => {
            console.log('Refresh map event received:', data);
            
            if (!map && @json($viewMode) === 'map') {
                initMap();
                return;
            }
            
            if (map) {
                // Clear existing markers
                if (markersLayer) {
                    map.removeLayer(markersLayer);
                    markersLayer.clearLayers();
                }
                
                // Add new markers if provided
                if (data.markers && data.markers.length > 0) {
                    markersLayer = L.layerGroup();
                    
                    data.markers.forEach((markerData) => {
                        if (!markerData.lat || !markerData.lng) return;
                        
                        const icon = markerData.rating >= 4.5 ? markerIcons.highRating : markerIcons.default;
                        const marker = L.marker([markerData.lat, markerData.lng], {
                            icon: icon,
                            title: markerData.name
                        }).addTo(markersLayer);
                        
                        const popupContent = createPopupContent(markerData);
                        marker.bindPopup(popupContent, {
                            maxWidth: 300,
                            className: 'custom-popup'
                        });
                    });
                    
                    map.addLayer(markersLayer);
                    
                    // Fit bounds
                    const bounds = L.latLngBounds(data.markers.map(m => [m.lat, m.lng]));
                    if (bounds.isValid()) {
                        map.fitBounds(bounds, {
                            padding: [50, 50],
                            maxZoom: 15
                        });
                    }
                }
                
                // Update center if provided
                if (data.center) {
                    map.setView([data.center.lat, data.center.lng], data.zoom || map.getZoom());
                }
            }
        });
    });
    
    // Initialize on DOM ready as fallback
    document.addEventListener('DOMContentLoaded', function() {
        if (@json($viewMode) === 'map') {
            console.log('DOM ready - initializing map');
            setTimeout(initMap, 500);
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (map) {
            setTimeout(() => {
                map.invalidateSize();
            }, 200);
        }
    });
</script>

<style>
    /* Leaflet container */
    #map {
        width: 100% !important;
        height: 600px !important;
        border-radius: 0.75rem;
        overflow: hidden;
        background: #f3f4f6;
        position: relative;
    }
    
    .leaflet-container {
        font-family: inherit !important;
        width: 100% !important;
        height: 100% !important;
        border-radius: 0.75rem !important;
        z-index: 1 !important;
    }
    
    /* Custom popup */
    .custom-popup .leaflet-popup-content-wrapper {
        border-radius: 0.75rem !important;
        border: none !important;
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1) !important;
        padding: 0 !important;
        overflow: hidden;
    }
    
    .custom-popup .leaflet-popup-content {
        margin: 0 !important;
        padding: 0 !important;
    }
    
    .custom-popup .leaflet-popup-tip {
        box-shadow: none !important;
    }
    
    /* Line clamp for description */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

<script>
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