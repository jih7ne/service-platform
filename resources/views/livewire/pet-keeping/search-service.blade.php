<div class="min-h-screen bg-white">
    <livewire:shared.header />
    
    <div class="min-h-screen bg-amber-50 p-4 md:p-6">
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
                            wire:click="switchView('list')"
                            class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 {{ $viewMode === 'list' ? 'bg-indigo-100 text-indigo-700 border border-indigo-200' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            Liste
                        </button>
                        <button 
                            wire:click="switchView('map')"
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


                            <!-- Availability Filter -->
                            <div class="pt-2 border-t border-gray-100">
                                <label class="block font-medium text-gray-900 mb-2">Filtrage par disponibilités</label>
                                
                                <!-- Start Time -->
                                <div class="mb-4">
                                    <label class="block text-sm text-gray-700 mb-1.5">Heure début</label>
                                    <div class="relative">
                                        <input type="time" 
                                            wire:model.live="startTime"
                                            class="w-full border-gray-200 rounded-lg py-2.5 px-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200"
                                            placeholder="HH:MM"
                                            min="00:00"
                                            max="23:59">
                                    </div>
                                </div>
                                
                                <!-- End Time -->
                                <div>
                                    <label class="block text-sm text-gray-700 mb-1.5">Heure fin</label>
                                    <div class="relative">
                                        <input type="time" 
                                            wire:model.live="endTime"
                                            class="w-full border-gray-200 rounded-lg py-2.5 px-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200"
                                            placeholder="HH:MM"
                                            min="00:00"
                                            max="23:59">
                                    </div>
                                </div>
                                
                                
                            </div>





                            <!-- Price Range -->
                            <div>
                                <label class="block font-medium text-gray-900 mb-2">Fourchette de prix</label>
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 relative">
                                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">DH</span>
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
                                        <option value="dateAsc">Date (Ascending)</option>
                                        <option value="dateDsc">Date (Descending)</option>
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
                                                    <div class="font-bold text-xl text-gray-900">{{ number_format($service['base_price'] ?? 0, 2) }} DH</div>
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
                                                    <div class="font-bold text-2xl text-gray-900">{{ number_format($service['base_price'] ?? 0, 2) }} DH</div>
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
                                                    
                                                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 text-green-800 rounded-full font-medium">
                                                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                                            Disponible maintenant
                                                        </span>
                                                    
                            
                                                </div>

                                                <!-- Action Buttons -->
                                                <div class="flex flex-wrap gap-2">
                                                    <button wire:click="bookService({{ $service['id'] ?? 0 }})" 
                                                            class="px-8 py-2.5 bg-amber-700 hover:bg-amber-600 text-white font-medium rounded-lg transition shadow-sm">
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
                                <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucun service trouvé</h3>
                                    <p class="text-gray-600 mb-4">Essayez de modifier vos critères de recherche</p>
                                    <button wire:click="resetFilters" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition-colors">
                                        Réinitialiser les filtres
                                    </button>
                                </div>
                            @endforelse
                        </div>
                        
                        
                    @else
                        <!-- Map View -->
                        @if($viewMode === 'map')
                            <div class="bg-white rounded-2xl shadow-lg overflow-hidden relative">
                                <!-- Map Container -->
                                <div id="map" class="w-full h-[600px] rounded-lg"></div>
                                
                                <!-- Loading indicator -->
                                <div id="map-loading" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-80 z-10 hidden">
                                    <div class="text-center">
                                        <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-500 mb-4"></div>
                                        <p class="text-gray-600">Chargement de la carte...</p>
                                    </div>
                                </div>
                                
                                <!-- Map Controls -->
                                <div class="absolute top-4 right-4 z-20 flex flex-col gap-2">
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
                                            class="p-3 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 transition-colors active:scale-95">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                                
                                <!-- Map Legend -->
                                <div class="absolute bottom-4 left-4 z-20">
                                    <div class="bg-white rounded-lg shadow-lg p-3 max-w-xs border border-gray-200">
                                        <h4 class="font-medium text-gray-900 text-sm mb-2">Légende</h4>
                                        <div class="space-y-2">
                                            <div class="flex items-center gap-2">
                                                <div class="w-4 h-4 rounded-full bg-green-500"></div>
                                                <span class="text-xs text-gray-600">Disponible</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="w-4 h-4 rounded-full bg-yellow-500"></div>
                                                <span class="text-xs text-gray-600">Note élevée (4.5+)</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="w-4 h-4 rounded-full bg-indigo-500"></div>
                                                <span class="text-xs text-gray-600">Standard</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Search Results Counter -->
                                <div class="absolute top-4 left-4 z-20">
                                    <div class="bg-white rounded-lg shadow-lg p-3 border border-gray-200">
                                        <div class="text-sm text-gray-700">
                                            <span class="font-medium">{{ count($mapMarkers) }}</span> pet-sitter(s) trouvé(s)
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Map Results List -->
                            @if(count($mapMarkers) > 0)
                                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
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
                                                    ${{ number_format($marker['price'], 2) }} / {{ $marker['criteria'] }}
                                                </div>
                                                <div class="flex flex-wrap gap-1 mb-2">
                                                    @foreach($marker['services'] as $service)
                                                        <span class="px-2 py-1 bg-indigo-50 text-indigo-700 rounded-full text-xs">{{ $service }}</span>
                                                    @endforeach
                                                </div>
                                                <p class="text-sm text-gray-600">{{ $marker['description'] }}</p>
                                            </div>
                                            
                                            <div class="flex gap-2">
                                                <button onclick="window.viewServiceDetails({{ $marker['id'] }})" 
                                                        class="flex-1 px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition-colors">
                                                    Voir détails
                                                </button>
                                                <button wire:click="bookService({{ $marker['id'] }})" 
                                                        class="px-3 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-sm font-medium transition-colors">
                                                    Réserver
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="mt-6 bg-white rounded-2xl shadow-lg p-8 text-center">
                                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                    </svg>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucun pet-sitter dans cette zone</h3>
                                    <p class="text-gray-600 mb-4">Essayez d'élargir votre recherche ou modifier les filtres</p>
                                    <button wire:click="resetFilters" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition-colors">
                                        Réinitialiser les filtres
                                    </button>
                                </div>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
      crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>

<!-- Include Leaflet Marker Cluster for better marker management -->
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

<script>
    // Map variables
    let map = null;
    let markersLayer = null;
    
    // Custom marker icons
    const markerIcons = {
        default: L.divIcon({
            html: `
                <div class="relative">
                    <div class="w-8 h-8 rounded-full bg-blue-500 border-2 border-white shadow-lg flex items-center justify-center transform hover:scale-125 transition-transform duration-200">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-blue-500 rounded-full border border-white"></div>
                </div>
            `,
            className: 'custom-marker-icon',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        }),
        
        premium: L.divIcon({
            html: `
                <div class="relative">
                    <div class="w-10 h-10 rounded-full bg-yellow-500 border-2 border-white shadow-lg flex items-center justify-center transform hover:scale-125 transition-transform duration-200">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-yellow-500 rounded-full border-2 border-white flex items-center justify-center">
                        <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            `,
            className: 'premium-marker-icon',
            iconSize: [40, 40],
            iconAnchor: [20, 40],
            popupAnchor: [0, -40]
        }),
        
        highRating: L.divIcon({
            html: `
                <div class="relative">
                    <div class="w-9 h-9 rounded-full bg-green-500 border-2 border-white shadow-lg flex items-center justify-center transform hover:scale-125 transition-transform duration-200">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                </div>
            `,
            className: 'high-rating-marker-icon',
            iconSize: [36, 36],
            iconAnchor: [18, 36],
            popupAnchor: [0, -36]
        })
    };
    
    // Initialize map
    function initMap() {
        console.log('Initializing map with markers...');
        
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
            
            console.log('Map data:', {
                markersCount: mapMarkers?.length || 0,
                center: mapCenter,
                zoom: mapZoom,
                markers: mapMarkers
            });
            
            // Create map
            map = L.map('map').setView([mapCenter.lat, mapCenter.lng], mapZoom);
            
            // Add tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19,
            }).addTo(map);
            
            // Create marker cluster group
            markersLayer = L.markerClusterGroup({
                showCoverageOnHover: false,
                zoomToBoundsOnClick: true,
                spiderfyOnMaxZoom: true,
                removeOutsideVisibleBounds: false,
                animate: true,
                animateAddingMarkers: true
            });
            
            // Add markers if we have data
            if (mapMarkers && mapMarkers.length > 0) {
                console.log(`Adding ${mapMarkers.length} markers...`);
                addMarkersToLayer(mapMarkers);
                map.addLayer(markersLayer);
                
                // Fit bounds to show all markers
                if (markersLayer.getBounds().isValid()) {
                    map.fitBounds(markersLayer.getBounds(), {
                        padding: [50, 50],
                        maxZoom: 15
                    });
                }
            } else {
                console.log('No markers to display');
                // Add a message marker in center
                const messageMarker = L.marker([mapCenter.lat, mapCenter.lng], {
                    icon: L.divIcon({
                        html: `
                            <div class="bg-white p-4 rounded-lg shadow-lg border border-gray-200 max-w-xs">
                                <div class="text-center">
                                    <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <p class="text-sm text-gray-600">Aucun pet-sitter dans cette zone</p>
                                    <p class="text-xs text-gray-500 mt-1">Modifiez vos filtres pour voir plus de résultats</p>
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
            
            // Add scale control
            L.control.scale({
                imperial: false,
                metric: true
            }).addTo(map);
            
            console.log('Map initialized successfully');
            
            // Invalidate size after render
            setTimeout(() => {
                if (map) {
                    map.invalidateSize();
                    console.log('Map size invalidated');
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
                    <button onclick="initMap()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition-colors">
                        Réessayer
                    </button>
                </div>
            `;
        }
    }
    
    // Add markers to the cluster layer
    function addMarkersToLayer(markersData) {
        if (!markersLayer || !map) {
            console.error('Map or markers layer not initialized');
            return;
        }
        
        markersData.forEach((data, index) => {
            // Skip if no coordinates
            if (!data.lat || !data.lng) {
                console.warn(`Marker ${index} missing coordinates:`, data);
                return;
            }
            
            // Choose icon based on data
            let icon;
            if (data.rating >= 4.5) {
                icon = markerIcons.highRating;
            } else if (data.price > 100) { // Premium if price > 100
                icon = markerIcons.premium;
            } else {
                icon = markerIcons.default;
            }
            
            // Create marker
            const marker = L.marker([data.lat, data.lng], {
                icon: icon,
                title: data.name,
                riseOnHover: true
            });
            
            // Create popup content
            const popupContent = createPopupContent(data);
            
            // Bind popup to marker
            marker.bindPopup(popupContent, {
                maxWidth: 300,
                minWidth: 250,
                className: 'custom-popup'
            });
            
            // Add hover effects
            marker.on('mouseover', function() {
                this.openPopup();
            });
            
            marker.on('mouseout', function() {
                this.closePopup();
            });
            
            // Add click event
            marker.on('click', function(e) {
                console.log('Marker clicked:', data);
                // Center map on marker
                map.setView(e.latlng, 15);
            });
            
            // Add to cluster layer
            markersLayer.addLayer(marker);
        });
        
        console.log(`Added ${markersData.length} markers to layer`);
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
                            <span class="text-xs text-gray-500">(${data.reviews || 0} avis)</span>
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
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
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
                            class="flex-1 px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition-colors duration-200">
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
                const accuracy = position.coords.accuracy;
                
                // Add user location marker
                const userIcon = L.divIcon({
                    html: `
                        <div class="relative">
                            <div class="w-10 h-10 rounded-full bg-blue-600 border-3 border-white shadow-lg flex items-center justify-center animate-pulse">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    `,
                    className: 'user-location-icon',
                    iconSize: [40, 40],
                    iconAnchor: [20, 40]
                });
                
                const userMarker = L.marker([latitude, longitude], {
                    icon: userIcon,
                    zIndexOffset: 1000
                }).addTo(map);
                
                // Add accuracy circle
                L.circle([latitude, longitude], {
                    color: '#3b82f6',
                    fillColor: '#3b82f6',
                    fillOpacity: 0.1,
                    radius: accuracy
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
                    markersLayer = L.markerClusterGroup();
                    addMarkersToLayer(data.markers);
                    map.addLayer(markersLayer);
                    
                    // Fit bounds
                    if (markersLayer.getBounds().isValid()) {
                        map.fitBounds(markersLayer.getBounds(), {
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
    
    // Debug function to check markers
    window.debugMarkers = function() {
        console.log('Map debug info:');
        console.log('- Map instance:', map ? 'Yes' : 'No');
        console.log('- Markers layer:', markersLayer ? 'Yes' : 'No');
        console.log('- Total markers:', markersLayer ? markersLayer.getLayers().length : 0);
        
        const mapMarkers = @json($mapMarkers);
        console.log('- Livewire markers:', mapMarkers);
        console.log('- Marker count:', mapMarkers?.length || 0);
        
        if (mapMarkers && mapMarkers.length > 0) {
            mapMarkers.forEach((marker, i) => {
                console.log(`  Marker ${i}:`, {
                    name: marker.name,
                    lat: marker.lat,
                    lng: marker.lng,
                    hasCoords: !!(marker.lat && marker.lng)
                });
            });
        }
    };
</script>

<style>
    /* Map container */
    #map {
        width: 100% !important;
        height: 600px !important;
        min-height: 600px;
        border-radius: 0.75rem;
        overflow: hidden;
        background: #f3f4f6;
        position: relative;
    }
    
    #map:empty::before {
        content: 'Chargement de la carte...';
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #6b7280;
        font-style: italic;
        font-size: 0.875rem;
    }
    
    /* Leaflet styles */
    .leaflet-container {
        font-family: inherit !important;
        width: 100% !important;
        height: 100% !important;
        border-radius: 0.75rem !important;
        z-index: 1 !important;
    }
    
    /* Marker cluster styles */
    .marker-cluster-small {
        background-color: rgba(59, 130, 246, 0.6) !important;
    }
    .marker-cluster-small div {
        background-color: rgba(59, 130, 246, 0.8) !important;
        color: white !important;
    }
    
    .marker-cluster-medium {
        background-color: rgba(245, 158, 11, 0.6) !important;
    }
    .marker-cluster-medium div {
        background-color: rgba(245, 158, 11, 0.8) !important;
        color: white !important;
    }
    
    .marker-cluster-large {
        background-color: rgba(16, 185, 129, 0.6) !important;
    }
    .marker-cluster-large div {
        background-color: rgba(16, 185, 129, 0.8) !important;
        color: white !important;
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
    
    /* Marker hover effects */
    .custom-marker-icon, .premium-marker-icon, .high-rating-marker-icon, .user-location-icon {
        transition: transform 0.2s ease !important;
    }
    
    .leaflet-marker-icon:hover {
        transform: scale(1.25) !important;
        z-index: 1000 !important;
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

