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
                                <h2 class="text-lg font-semibold text-gray-900">Services Disponibles</h2>
                                <p class="text-gray-600 text-sm">
                                    @if(count($services) === 0)
                                        Aucun service trouvé
                                    @elseif(count($services) === 1)
                                        1 service trouvé
                                    @else
                                        {{ count($services) }} services trouvés
                                    @endif
                                </p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-gray-600 text-sm">Trier par:</span>
                                <select wire:model.live="sortBy" 
                                        class="border-gray-200 rounded-lg py-2 px-3 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20">
                                    <option value="relevance">Pertinence</option>
                                    <option value="rating">Note (Élevée à Basse)</option>
                                    <option value="price">Prix (Bas à Élevé)</option>
                                    <option value="demand">Plus Populaire</option>
                                </select>
                            </div>
                        </div>
                    </div>

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
                                                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors">
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
                            <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                                <div class="max-w-md mx-auto">
                                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun service trouvé</h3>
                                    <p class="text-gray-600 mb-6">Essayez d'ajuster vos critères de recherche ou filtres pour trouver plus d'options.</p>
                                    <button wire:click="resetFilters" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors">
                                        Réinitialiser tous les filtres
                                    </button>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>