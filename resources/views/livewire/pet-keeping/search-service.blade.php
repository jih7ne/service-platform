

<div class="min-h-screen bg-white">
    <livewire:shared.header />
    
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-4 md:p-6">
        <!-- Centered Title Section -->
        <div class="flex flex-col items-center justify-center text-center w-full mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Trouvez des Services de Garde d'Animaux</h1>
            <p class="text-gray-600 mb-6">Services professionnels pour vos compagnons à quatre pattes</p>
        </div>
        
        <div class="max-w-8xl mx-auto">
            <!-- Search Bar Section -->
            <div class="mb-8">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input wire:model.live.debounce.400ms="searchQuery" 
                           placeholder="Rechercher par nom de service, fournisseur, ou description..."
                           class="w-full pl-12 pr-4 py-4 border-0 bg-white rounded-xl shadow-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 text-base">
                </div>
            </div>

            <!-- View Toggle -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div class="flex items-center gap-2">
                    <span class="text-gray-600">Vue:</span>
                    <div class="inline-flex rounded-lg border border-gray-200 bg-white p-1 shadow-sm">
                        <button 
                            wire:click="$set('viewMode', 'list')"
                            class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 {{ $viewMode === 'list' ? 'bg-indigo-100 text-indigo-700 border border-indigo-200' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            Liste
                        </button>
                        <button 
                            wire:click="$set('viewMode', 'map')"
                            class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 {{ $viewMode === 'map' ? 'bg-indigo-100 text-indigo-700 border border-indigo-200' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                            Carte
                        </button>
                    </div>
                </div>

                <!-- Location Search for Map View -->
                @if($viewMode === 'map')
                    <div class="flex-1 max-w-md">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <input wire:model.live.debounce.500ms="locationQuery" 
                                   placeholder="Rechercher une ville, un code postal..."
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-sm">
                        </div>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Filters Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                        <div class="p-5 border-b border-gray-100">
                            <div class="flex justify-between items-center">
                                <h2 class="font-semibold text-gray-900 text-lg">Filtres</h2>
                                <button wire:click="resetFilters" 
                                        class="text-sm text-indigo-600 hover:text-indigo-800 font-medium px-3 py-1 rounded-lg hover:bg-indigo-50 transition-colors">
                                    Tout réinitialiser
                                </button>
                            </div>
                        </div>

                        <div class="p-5 space-y-5">
                            <!-- Location Filters (Only for Map View) -->
                            @if($viewMode === 'map')
                                <div>
                                    <label class="block font-medium text-gray-900 mb-2">Pays</label>
                                    <select wire:model.live="selectedCountry" 
                                            class="w-full border-gray-200 rounded-lg py-2.5 px-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200">
                                        <option value="">Tous les pays</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country }}">{{ $country }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block font-medium text-gray-900 mb-2">Ville</label>
                                    <select wire:model.live="selectedCity" 
                                            class="w-full border-gray-200 rounded-lg py-2.5 px-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200">
                                        <option value="">Toutes les villes</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city }}">{{ $city }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block font-medium text-gray-900 mb-2">Rayon de recherche</label>
                                    <div class="flex items-center gap-2">
                                        <input type="range" wire:model.live="searchRadius" 
                                               min="1" max="100" 
                                               class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                                        <span class="text-sm text-gray-600 min-w-[50px]">{{ $searchRadius }} km</span>
                                    </div>
                                </div>
                                
                                <div class="pt-2 border-t border-gray-100">
                                    <p class="text-sm text-gray-600">
                                        {{ count($mapMarkers) }} pet-sitters trouvés dans cette zone
                                    </p>
                                </div>
                            @endif

                            <!-- Pet Type -->
                            <div>
                                <label class="block font-medium text-gray-900 mb-2">Type d'animal</label>
                                <select wire:model.live="petType" 
                                        class="w-full border-gray-200 rounded-lg py-2.5 px-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200">
                                    @foreach(App\Constants\PetKeeping\Constants::getSelectOptions() as $value => $label)
                                        <option value="{{ $value }}" {{ old('pet_type') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Service Category -->
                            <div>
                                <label class="block font-medium text-gray-900 mb-2">Catégorie de service</label>
                                <select wire:model.live="serviceCategory" 
                                        class="w-full border-gray-200 rounded-lg py-2.5 px-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200">
                                    @foreach(App\Constants\PetKeeping\Constants::forSelect() as $value => $optionLabel)
                                        <option value="{{ $value }}">
                                            {{ $optionLabel }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Payment Criteria -->
                            <div>
                                <label class="block font-medium text-gray-900 mb-2">Critère de paiement</label>
                                <select wire:model.live="criteria" 
                                        class="w-full border-gray-200 rounded-lg py-2.5 px-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200">
                                    @foreach(App\Constants\PetKeeping\Constants::forSelectCriteria() as $value => $optionLabel)
                                        <option value="{{ $value }}">
                                            {{ $optionLabel }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Price Range -->
                            <div>
                                <label class="block font-medium text-gray-900 mb-2">Fourchette de prix</label>
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 relative">
                                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">$</span>
                                        <input type="number" wire:model.blur="minPrice" 
                                               placeholder="Min"
                                               class="w-full pl-8 pr-3 py-2 border-gray-200 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200">
                                    </div>
                                    <span class="text-gray-400">-</span>
                                    <div class="flex-1 relative">
                                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">$</span>
                                        <input type="number" wire:model.blur="maxPrice" 
                                               placeholder="Max"
                                               class="w-full pl-8 pr-3 py-2 border-gray-200 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200">
                                    </div>
                                </div>
                            </div>

                            <!-- Service Rating -->
                            <div>
                                <label class="block font-medium text-gray-900 mb-2">Note minimale du service</label>
                                <select wire:model.live="minRating" 
                                        class="w-full border-gray-200 rounded-lg py-2.5 px-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200">
                                    <option value="0">Toutes les notes</option>
                                    <option value="4">★★★★☆ & plus</option>
                                    <option value="4.5">★★★★½ & plus</option>
                                    <option value="4.8">★★★★★ (4.8+)</option>
                                </select>
                            </div>
                            
                            <!-- Pet Keeper Rating -->
                            <div>
                                <label class="block font-medium text-gray-900 mb-2">Note minimale du pet-sitter</label>
                                <select wire:model.live="minRatingPetKeeper" 
                                        class="w-full border-gray-200 rounded-lg py-2.5 px-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200">
                                    <option value="0">Toutes les notes</option>
                                    <option value="4">★★★★☆ & plus</option>
                                    <option value="4.5">★★★★½ & plus</option>
                                    <option value="4.8">★★★★★ (4.8+)</option>
                                </select>
                            </div>

                            <!-- Additional Filters -->
                            <div class="space-y-3 pt-2 border-t border-gray-100">
                                <label class="block font-medium text-gray-900">Exigences</label>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" wire:model.live="vaccinationRequired" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">Vaccination requise</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" wire:model.live="acceptsUntrainedPets" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">Accepte les animaux non dressés</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" wire:model.live="acceptsAggressivePets" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">Accepte les animaux agressifs</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Results Section -->
                <div class="lg:col-span-3">
                    <!-- Results Header -->
                    <div class="bg-white rounded-2xl shadow-sm p-4 mb-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">
                                    @if($viewMode === 'list')
                                        Services Disponibles
                                    @else
                                        Carte des Services
                                    @endif
                                </h2>
                                <p class="text-gray-600 text-sm">
                                    @if($viewMode === 'list')
                                        @if(count($services) === 0)
                                            Aucun service trouvé
                                        @elseif(count($services) === 1)
                                            1 service trouvé
                                        @else
                                            {{ count($services) }} services trouvés
                                        @endif
                                    @else
                                        @if(count($mapMarkers) === 0)
                                            Aucun pet-sitter dans cette zone
                                        @elseif(count($mapMarkers) === 1)
                                            1 pet-sitter dans cette zone
                                        @else
                                            {{ count($mapMarkers) }} pet-sitters dans cette zone
                                        @endif
                                    @endif
                                </p>
                            </div>
                            
                            @if($viewMode === 'list')
                                <div class="flex items-center gap-3">
                                    <span class="text-gray-600 text-sm">Trier par:</span>
                                    <select wire:model.live="sortBy" 
                                            class="border-gray-200 rounded-lg py-2 px-3 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20">
                                        <option value="relevance">Pertinence</option>
                                        <option value="rating">Note (Élevée à Basse)</option>
                                        <option value="price">Prix (Bas à Élevé)</option>
                                        <option value="demand">Plus Populaire</option>
                                        <option value="distance">Distance</option>
                                    </select>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- List View -->
                    @if($viewMode === 'list')
                        <!-- Results Grid -->
                        <div class="space-y-6">
                            @forelse ($services as $service)
                                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                                     <div class="p-6">
                                    <div class="flex flex-col md:flex-row gap-6">
                                        <!-- Provider Profile Section -->
                                        <div class="flex-shrink-0">
                                            <div class="flex flex-col items-center gap-4 md:block md:w-32">
                                                <div class="relative">
                                                    <img src="{{ $service['photo'] ?? 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . urlencode($service['providerName'] ?? 'default') }}" 
                                                         class="w-28 h-28 rounded-2xl object-cover border-2 border-white shadow-md mx-auto md:mx-0">
                                                    @if(($service['status'] ?? '') === 'actif')
                                                        <div class="absolute -bottom-2 -right-2 bg-blue-600 text-white p-1.5 rounded-full shadow-md">
                                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <!-- Price on mobile/tablet -->
                                                <div class="text-center md:text-left">
                                                    <div class="text-gray-600 text-sm">À partir de</div>
                                                    <div class="font-bold text-xl text-gray-900">${{ number_format($service['base_price'] ?? 0, 2) }}</div>
                                                    <div class="text-gray-500 text-sm">{{ strtolower(str_replace('_', ' ', $service['paymentCriteria'] ?? '')) }}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Main Content -->
                                        <div class="flex-1">
                                            <!-- Header with name, rating, and price (desktop) -->
                                            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-4">
                                                <div class="flex-1">
                                                    <div class="flex flex-wrap items-center gap-2 mb-2">
                                                        <h3 class="text-xl font-bold text-gray-900">{{ $service['nomService'] ?? 'Service' }}</h3>
                                                        <div class="flex items-center gap-1">
                                                            <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                            </svg>
                                                            <span class="font-semibold">{{ number_format($service['note'] ?? 0, 1) }}</span>
                                                            <span class="text-gray-600 text-sm">({{ $service['nbrAvis'] ?? 0 }} avis)</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Provider and Service Info -->
                                                    <div class="flex flex-wrap items-center gap-3 text-gray-600 text-sm mb-3">
                                                        <div class="flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                            </svg>
                                                            <span>{{ $service['providerName'] ?? 'Fournisseur' }}</span>
                                                        </div>
                                                        <div class="flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"></path>
                                                            </svg>
                                                            <span>{{ $service['nombres_services_demandes'] ?? 0 }} réservations</span>
                                                        </div>
                                                        <div class="flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                                            </svg>
                                                            <span>{{ $service['category'] ?? '' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Price on desktop (hidden on mobile) -->
                                                <div class="hidden md:block text-right">
                                                    <div class="text-gray-600 text-sm">À partir de</div>
                                                    <div class="font-bold text-2xl text-gray-900">${{ number_format($service['base_price'] ?? 0, 2) }}</div>
                                                    <div class="text-gray-500 text-sm">{{ strtolower(str_replace('_', ' ', $service['paymentCriteria'] ?? '')) }}</div>
                                                </div>
                                            </div>

                                            <!-- Service Description -->
                                            <p class="text-gray-700 mb-4">{{ $service['description'] ?? '' }}</p>

                                            <!-- Service Tags -->
                                            <div class="flex flex-wrap items-center gap-2 mb-4">
                                                <span class="font-medium text-gray-700">Catégorie:</span>
                                                <span class="px-3 py-1.5 bg-purple-50 text-purple-700 rounded-full text-sm font-medium">
                                                    {{ $service['category'] ?? '' }}
                                                </span>
                                                <span class="font-medium text-gray-700 ml-2">Critère de paiement:</span>
                                                <span class="px-3 py-1.5 bg-green-50 text-green-700 rounded-full text-sm font-medium">
                                                    {{ str_replace('_', ' ', $service['paymentCriteria'] ?? '') }}
                                                </span>
                                            </div>

                                            <!-- Pet Types and Requirements -->
                                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-4">
                                                <!-- Pet Types -->
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <span class="font-medium">Type d'animal:</span>
                                                    <span class="px-2.5 py-1 bg-gray-100 rounded-full">{{ $service['petType'] ?? '' }}</span>
                                                </div>
                                                
                                                <!-- Requirements -->
                                                <div class="flex flex-wrap items-center gap-2">
                                                    @if(($service['vaccinationRequired'] ?? false))
                                                        <span class="px-2.5 py-1 bg-red-50 text-red-700 rounded-full">💉 Vaccination requise</span>
                                                    @endif
                                                    @if(($service['acceptsUntrainedPets'] ?? false))
                                                        <span class="px-2.5 py-1 bg-yellow-50 text-yellow-700 rounded-full">🎓 Accepte non dressés</span>
                                                    @endif
                                                    @if(($service['acceptsAggressivePets'] ?? false))
                                                        <span class="px-2.5 py-1 bg-orange-50 text-orange-700 rounded-full">⚠️ Accepte agressifs</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Footer with status and buttons -->
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-4 border-t border-gray-100">
                                                <!-- Service Status -->
                                                <div>
                                                    @if(($service['status'] ?? '') === 'actif')
                                                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 text-green-800 rounded-full font-medium">
                                                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                                            Disponible maintenant
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-red-100 text-red-800 rounded-full font-medium">
                                                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                                            Actuellement indisponible
                                                        </span>
                                                    @endif
                                                </div>

                                                <!-- Action Buttons -->
                                                <div class="flex flex-wrap gap-2">
                                                    

                                                    <button wire:click="bookService({{ $service['id'] ?? 0 }})" 
                                                            class="px-8 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition shadow-sm">
                                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                        Réserver maintenant
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            @empty
                                <!-- Empty state -->
                            @endforelse
                        </div>
                    @else
                        <!-- Map View -->
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden h-[600px]">
                            <!-- Map Container -->
                            <div id="map" class="w-full h-full"></div>
                            
                            <!-- Map Controls -->
                            <div class="absolute top-4 right-4 z-10 flex flex-col gap-2">
                                <button wire:click="zoomIn" 
                                        class="p-2 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow">
                                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                                <button wire:click="zoomOut" 
                                        class="p-2 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow">
                                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <button wire:click="locateMe" 
                                        class="p-2 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <!-- Map Legend -->
                            <div class="absolute bottom-4 left-4 z-10">
                                <div class="bg-white rounded-lg shadow-lg p-3 max-w-xs">
                                    <h4 class="font-medium text-gray-900 text-sm mb-2">Légende</h4>
                                    <div class="space-y-2">
                                        <div class="flex items-center gap-2">
                                            <div class="w-4 h-4 rounded-full bg-indigo-500"></div>
                                            <span class="text-xs text-gray-600">Pet-sitter actif</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div class="w-4 h-4 rounded-full bg-green-500"></div>
                                            <span class="text-xs text-gray-600">Disponible maintenant</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div class="w-4 h-4 rounded-full bg-yellow-500"></div>
                                            <span class="text-xs text-gray-600">Note élevée (4.5+)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Map Results Sidebar -->
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @forelse ($mapMarkers as $marker)
                                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                                    <div class="p-4">
                                        <div class="flex items-start gap-3">
                                            <img src="{{ $marker['photo'] ?? 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . urlencode($marker['name'] ?? 'default') }}" 
                                                 class="w-16 h-16 rounded-lg object-cover">
                                            <div class="flex-1">
                                                <h3 class="font-semibold text-gray-900 text-sm">{{ $marker['name'] }}</h3>
                                                <div class="flex items-center gap-1 mt-1">
                                                    <svg class="w-3 h-3 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                    <span class="text-xs font-medium">{{ number_format($marker['rating'] ?? 0, 1) }}</span>
                                                </div>
                                                <div class="flex items-center gap-1 mt-1">
                                                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    <span class="text-xs text-gray-600">{{ $marker['distance'] ?? '0' }} km</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <div class="flex flex-wrap gap-1 mb-2">
                                                @foreach($marker['services'] as $service)
                                                    <span class="px-2 py-1 bg-indigo-50 text-indigo-700 rounded-full text-xs">
                                                        {{ $service }}
                                                    </span>
                                                @endforeach
                                            </div>
                                            
                                            <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-100">
                                                <div class="text-sm">
                                                    <span class="font-medium text-gray-900">${{ number_format($marker['price'] ?? 0, 2) }}</span>
                                                    <span class="text-gray-500 text-xs ml-1">/ {{ $marker['criteria'] ?? '' }}</span>
                                                </div>
                                                <button wire:click="viewDetails('{{ $marker['id'] }}')" 
                                                        class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-medium transition-colors">
                                                    Voir
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full bg-white rounded-xl shadow-md p-8 text-center">
                                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucun pet-sitter dans cette zone</h3>
                                    <p class="text-gray-600 mb-4">Essayez de rechercher une autre zone ou d'élargir le rayon de recherche.</p>
                                    <button wire:click="$set('searchRadius', 50)" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition-colors">
                                        Élargir la recherche
                                    </button>
                                </div>
                            @endforelse
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Map initialization and management
    let map;
    let markers = [];
    let currentLocationMarker;

    function initMap() {
        // Default center (Paris)
        const defaultCenter = { lat: 48.8566, lng: 2.3522 };
        
        map = L.map('map').setView(defaultCenter, 12);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19,
        }).addTo(map);

        // Add markers if we have data
        @this.on('refresh-map', (data) => {
            updateMarkers(data.markers);
        });

        // Initial markers from Livewire
        updateMarkers(@json($mapMarkers));
    }

    function updateMarkers(markersData) {
        // Clear existing markers
        markers.forEach(marker => map.removeLayer(marker));
        markers = [];

        // Add new markers
        markersData.forEach(data => {
            const markerColor = getMarkerColor(data);
            
            const marker = L.marker([data.lat, data.lng], {
                icon: L.divIcon({
                    html: `
                        <div class="relative">
                            <div class="w-8 h-8 rounded-full ${markerColor} border-2 border-white shadow-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    `,
                    className: 'custom-div-icon',
                    iconSize: [32, 32],
                    iconAnchor: [16, 32]
                })
            }).addTo(map);

            // Add popup
            marker.bindPopup(`
                <div class="p-2 min-w-[200px]">
                    <div class="flex items-center gap-2 mb-2">
                        <img src="${data.photo}" class="w-10 h-10 rounded-full">
                        <div>
                            <h4 class="font-semibold text-sm">${data.name}</h4>
                            <div class="flex items-center gap-1">
                                <svg class="w-3 h-3 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <span class="text-xs">${data.rating}</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-xs text-gray-600 mb-2">
                        ${data.services.join(', ')}
                    </div>
                    <div class="text-sm font-medium text-gray-900 mb-2">
                        $${data.price} / ${data.criteria}
                    </div>
                    <button onclick="Livewire.dispatch('view-details', {id: '${data.id}'})" 
                            class="w-full px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded text-xs font-medium transition-colors">
                        Voir les détails
                    </button>
                </div>
            `);

            markers.push(marker);
        });

        // Fit bounds to show all markers
        if (markers.length > 0) {
            const group = new L.featureGroup(markers);
            map.fitBounds(group.getBounds().pad(0.1));
        }
    }

    function getMarkerColor(data) {
        if (data.rating >= 4.5) return 'bg-yellow-500';
        if (data.status === 'actif') return 'bg-green-500';
        return 'bg-indigo-500';
    }

    // Initialize map when Livewire is ready
    document.addEventListener('livewire:initialized', () => {
        // Initialize map when in map view
        if (@this.get('viewMode') === 'map') {
            setTimeout(initMap, 100);
        }

        // Reinitialize map when switching to map view
        @this.on('switched-to-map-view', () => {
            setTimeout(initMap, 100);
        });

        // Zoom in/out functions
        window.zoomIn = () => map.zoomIn();
        window.zoomOut = () => map.zoomOut();

        // Locate user
        window.locateMe = () => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const { latitude, longitude } = position.coords;
                        
                        // Remove old location marker
                        if (currentLocationMarker) {
                            map.removeLayer(currentLocationMarker);
                        }
                        
                        // Add new location marker
                        currentLocationMarker = L.marker([latitude, longitude], {
                            icon: L.divIcon({
                                html: `
                                    <div class="relative">
                                        <div class="w-8 h-8 rounded-full bg-blue-500 border-2 border-white shadow-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                `,
                                className: 'location-div-icon',
                                iconSize: [32, 32],
                                iconAnchor: [16, 32]
                            })
                        }).addTo(map);
                        
                        // Center map on user location
                        map.setView([latitude, longitude], 13);
                        
                        // Dispatch to Livewire
                        Livewire.dispatch('user-located', {
                            lat: latitude,
                            lng: longitude
                        });
                    },
                    (error) => {
                        console.error('Geolocation error:', error);
                        alert('Impossible d\'obtenir votre position. Veuillez vérifier vos paramètres de localisation.');
                    }
                );
            } else {
                alert('La géolocalisation n\'est pas supportée par votre navigateur.');
            }
        };
    });
</script>

<style>
    /* Leaflet map styles */
    #map {
        z-index: 1;
    }
    
    .custom-div-icon {
        text-align: center;
    }
    
    .location-div-icon {
        text-align: center;
    }
    
    /* Custom scrollbar for map popups */
    .leaflet-popup-content {
        max-height: 300px;
        overflow-y: auto;
    }
    
    .leaflet-popup-content::-webkit-scrollbar {
        width: 6px;
    }
    
    .leaflet-popup-content::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    
    .leaflet-popup-content::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }
    
    .leaflet-popup-content::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
@endpush