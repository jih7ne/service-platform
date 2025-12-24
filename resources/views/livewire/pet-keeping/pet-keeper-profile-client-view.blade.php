
<div class="min-h-screen bg-white">
    <livewire:shared.header />

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-amber-50 to-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Bouton Retour -->
            <div class="mb-6">
                <a href="{{ route('pet-keeping.search-service') }}" class="inline-flex items-center text-amber-700 hover:text-amber-800 font-semibold transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour à la recherche de pet-sitters
                </a>
            </div>

            <!-- Profil du pet-sitter -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <div class="flex flex-col md:flex-row items-start gap-6">
                    <!-- Photo -->
                    <div class="flex-shrink-0">
                        <img 
                            src="{{ $petkeeper->photo ? asset('storage/' . $petkeeper->photo) : 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . urlencode($petkeeper->prenom . $petkeeper->nom) }}" 
                            alt="Photo de {{ $petkeeper->prenom }}"
                            class="w-32 h-32 rounded-full object-cover border-4 border-gray-100 shadow-lg"
                            onerror="this.src='https://api.dicebear.com/7.x/avataaars/svg?seed={{ urlencode($petkeeper->prenom . $petkeeper->nom) }}'"
                        >
                    </div>

                    <!-- Informations principales -->
                    <div class="flex-grow">
                        <h1 class="text-3xl font-bold text-black mb-3">
                            {{ $petkeeper->prenom }} {{ $petkeeper->nom }}
                        </h1>

                        <!-- Note et avis -->
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex items-center gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($petkeeper->note))
                                        <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-xl font-bold text-black">{{ number_format($petkeeper->note, 1) }}/5</span>
                            <span class="text-gray-600">({{ $petkeeper->nbrAvis }} avis)</span>
                        </div>

                        <!-- Contact Info -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            @if($petkeeper->email)
                                <div class="flex items-center gap-2 text-gray-700">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ $petkeeper->email }}</span>
                                </div>
                            @endif
                            
                        </div>

                        <!-- Localisation -->
                        @if($petkeeper->ville)
                            <div class="flex items-center gap-2 text-gray-700 mb-4">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $petkeeper->ville }}, Maroc</span>
                            </div>
                        @endif

                        <!-- Specialités -->
                        @if($petkeeper->specialite)
                            <div class="mt-4">
                                <h3 class="text-lg font-bold text-black mb-2">Spécialités</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(',', $petkeeper->specialite) as $specialite)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-100 text-amber-800">
                                            {{ trim($specialite) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contenu principal -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Colonne principale -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Service Choisi -->
                    <div class="bg-white rounded-2xl shadow-sm p-8">
                        <h2 class="text-2xl font-bold text-black mb-6">Service Choisi</h2>
                        
                        <!-- Service Details Card -->
                        <div class="bg-amber-50 border border-amber-100 rounded-xl p-6 mb-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Service Info -->
                                <div>
                                    @if(isset($service[0]))
                                        <h3 class="text-xl font-bold text-amber-800 mb-3">{{ $service[0]->nomService }}</h3>
                                        <div class="space-y-2">
                                            <!-- Service Category -->
                                            <div class="flex items-center gap-2">
                                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                                </svg>
                                                <span class="text-gray-700">
                                                    {{ App\Constants\PetKeeping\Constants::getCategoryLabel($service[0]->categorie_petkeeping) ?? $service[0]->categorie_petkeeping }}
                                                </span>
                                            </div>
                                            
                                            <!-- Pet Type -->
                                            <div class="flex items-center gap-2">
                                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                </svg>
                                                <span class="text-gray-700">
                                                    {{ App\Constants\PetKeeping\Constants::getSelectOptions()[$service[0]->pet_type] ?? $service[0]->pet_type }}
                                                </span>
                                            </div>
                                            
                                            <!-- Payment Criteria -->
                                            <div class="flex items-center gap-2">
                                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="text-gray-700">
                                                    {{ App\Constants\PetKeeping\Constants::getCriteriaLabel($service[0]->payment_criteria) ?? $service[0]->payment_criteria }}
                                                </span>
                                            </div>
                                            
                                            <!-- Service Requirements -->
                                            <div class="flex flex-wrap gap-2 mt-2">
                                                @if($service[0]->vaccination_required)
                                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-50 text-red-700 rounded-full text-xs font-medium">
                                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                        </svg>
                                                        Vaccination requise
                                                    </span>
                                                @endif
                                                
                                                @if($service[0]->accepts_untrained_pets)
                                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-50 text-yellow-700 rounded-full text-xs font-medium">
                                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                        </svg>
                                                        Accepte non dressés
                                                    </span>
                                                @endif
                                                
                                                @if($service[0]->accepts_aggressive_pets)
                                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-orange-50 text-orange-700 rounded-full text-xs font-medium">
                                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                        </svg>
                                                        Accepte agressifs
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-gray-500">Informations du service non disponibles</p>
                                    @endif
                                </div>
                                
                                <!-- Pricing -->
                                <div class="text-right">
                                    @if(isset($service[0]))
                                        <div class="text-sm text-gray-500 mb-1">À partir de</div>
                                        <div class="text-4xl font-bold text-amber-700">{{ number_format($service[0]->base_price, 0) }} DH</div>
                                        <div class="text-sm text-gray-600 mt-1">
                                            {{ App\Constants\PetKeeping\Constants::getCriteriaLabel($service[0]->payment_criteria) ?? $service[0]->payment_criteria }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Service Description -->
                            @if(isset($service[0]) && $service[0]->description)
                                <div class="mt-4 pt-4 border-t border-amber-200">
                                    <h4 class="font-semibold text-gray-700 mb-2">Description</h4>
                                    <p class="text-gray-600">{{ $service[0]->description }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Services Offered -->
                        <div class="mb-8">
                            <h3 class="text-lg font-bold text-black mb-4">Services inclus</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <!-- These are generic services, you might want to customize based on category -->
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Garde complète</span>
                                </div>
                                
                                <!-- Dynamic based on service category -->
                                @if(isset($service[0]))
                                    @if($service[0]->categorie_petkeeping === 'GARDERIE')
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>Garde journée complète</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>Activités quotidiennes</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>Repas inclus</span>
                                        </div>
                                    @elseif($service[0]->categorie_petkeeping === 'PROMENADE')
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>Promenades régulières</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>Exercice physique</span>
                                        </div>
                                    @elseif($service[0]->categorie_petkeeping === 'VISITE')
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>Visites quotidiennes</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>Nourriture et eau</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>Administration médicaments</span>
                                        </div>
                                    @endif
                                @endif
                                
                                <!-- Always show these generic services -->
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Photos régulières</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Mises à jour quotidiennes</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="text-center">
                            @if(isset($service[0]))
                                <button wire:click="bookService({{ $service[0]->idService }})" 
                                        class="bg-amber-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-amber-700 transition-colors shadow-lg shadow-amber-500/30">
                                    Réserver maintenant
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Disponibilités hebdomadaires -->
                    <div class="bg-white rounded-2xl shadow-sm p-8">
                        <h2 class="text-2xl font-bold text-black mb-6">Disponibilités hebdomadaires</h2>

                        @if($disponibilites && count($disponibilites) > 0)
                            <div class="space-y-3">
                                @php
                                    $joursMapping = [
                                        'Lundi' => 'Lundi',
                                        'Mardi' => 'Mardi',
                                        'Mercredi' => 'Mercredi',
                                        'Jeudi' => 'Jeudi',
                                        'Vendredi' => 'Vendredi',
                                        'Samedi' => 'Samedi',
                                        'Dimanche' => 'Dimanche'
                                    ];
                                @endphp

                                @foreach($joursMapping as $jour)
                                    <div class="flex items-center border-b border-gray-100 py-3">
                                        <div class="w-32 font-semibold text-gray-700">{{ $jour }}</div>
                                        <div class="flex-grow">
                                            @if(isset($disponibilites[$jour]) && count($disponibilites[$jour]) > 0)
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach($disponibilites[$jour] as $dispo)
                                                        <span class="inline-flex items-center gap-1 bg-amber-100 text-amber-800 px-3 py-1 rounded-lg text-sm font-medium">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            {{ substr($dispo->heureDebut, 0, 5) }} - {{ substr($dispo->heureFin, 0, 5) }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-gray-400 text-sm">Non disponible</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-gray-500">Aucune disponibilité configurée pour le moment</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Colonne latérale -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Localisation -->
                    @if($localisation['latitude'] && $localisation['longitude'])
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                            <div class="p-4 bg-amber-600 text-white">
                                <h3 class="font-bold">Localisation</h3>
                            </div>
                            <div id="location-map" style="height: 300px; width: 100%;"></div>
                            <div class="p-4">
                                <p class="text-sm text-gray-700">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    </svg>
                                    @if($localisation['adresse'])
                                        <strong>{{ $localisation['adresse'] }}, {{ $localisation['ville'] }}</strong>
                                    @else
                                        <strong>{{ $localisation['ville'] }}, Maroc</strong>
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- Certifications -->
                    @if($certifications && $certifications->count() > 0)
                        <div class="bg-white rounded-2xl shadow-sm p-8">
                            <h2 class="text-2xl font-bold text-black mb-6">Certifications</h2>
                            <div class="space-y-3">
                                @foreach($certifications as $certification)
                                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="font-medium">{{ $certification->certification }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Statistiques détaillées -->
                    @if($stats && $stats['total_avis'] > 0)
                        <div class="bg-white rounded-2xl shadow-sm p-8">
                            <h2 class="text-2xl font-bold text-black mb-6">Évaluations détaillées</h2>
                            <div class="space-y-4">
                                <!-- Crédibilité -->
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">Crédibilité</span>
                                        <span class="text-sm font-bold text-amber-700">{{ $stats['moyenne_credibilite'] }}/5</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-amber-600 h-2 rounded-full" style="width: {{ ($stats['moyenne_credibilite'] / 5) * 100 }}%"></div>
                                    </div>
                                </div>
                                
                                <!-- Sympathie -->
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">Sympathie</span>
                                        <span class="text-sm font-bold text-amber-700">{{ $stats['moyenne_sympathie'] }}/5</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-amber-600 h-2 rounded-full" style="width: {{ ($stats['moyenne_sympathie'] / 5) * 100 }}%"></div>
                                    </div>
                                </div>
                                
                                <!-- Ponctualité -->
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">Ponctualité</span>
                                        <span class="text-sm font-bold text-amber-700">{{ $stats['moyenne_ponctualite'] }}/5</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-amber-600 h-2 rounded-full" style="width: {{ ($stats['moyenne_ponctualite'] / 5) * 100 }}%"></div>
                                    </div>
                                </div>
                                
                                <!-- Propreté -->
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">Propreté</span>
                                        <span class="text-sm font-bold text-amber-700">{{ $stats['moyenne_proprete'] }}/5</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-amber-600 h-2 rounded-full" style="width: {{ ($stats['moyenne_proprete'] / 5) * 100 }}%"></div>
                                    </div>
                                </div>
                                
                                <!-- Qualité de travail -->
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">Qualité de travail</span>
                                        <span class="text-sm font-bold text-amber-700">{{ $stats['moyenne_qualite'] }}/5</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-amber-600 h-2 rounded-full" style="width: {{ ($stats['moyenne_qualite'] / 5) * 100 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Avis et évaluations -->
                    <div class="bg-white rounded-2xl shadow-sm p-8">
                        <h2 class="text-2xl font-bold text-black mb-6">Avis</h2>

                        @if($stats && $stats['total_avis'] > 0)
                            <!-- Note globale -->
                            <div class="text-center mb-8 p-6 bg-amber-50 rounded-xl">
                                <div class="text-5xl font-bold text-amber-700 mb-2">{{ number_format($petkeeper->note, 1) }}</div>
                                <div class="flex items-center justify-center gap-1 mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($petkeeper->note))
                                            <svg class="w-6 h-6 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @else
                                            <svg class="w-6 h-6 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <div class="text-gray-600">Basé sur {{ $stats['total_avis'] }} avis</div>
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-8">Aucun avis pour le moment</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section des avis (full width) -->
    @if($feedbacks && $feedbacks->count() > 0)
        <section class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-gray-50 rounded-2xl shadow-sm p-8">
                    <h2 class="text-2xl font-bold text-black mb-8">Commentaires des clients</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($feedbacks as $feedback)
                            <div class="bg-white rounded-xl p-6 shadow-sm">
                                <div class="flex items-start gap-4">
                                    <img 
                                        src="{{ $feedback->auteur_photo ? asset('storage/' . $feedback->auteur_photo) : 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . urlencode($feedback->auteur_prenom) }}" 
                                        alt="{{ $feedback->auteur_prenom }}"
                                        class="w-12 h-12 rounded-full object-cover"
                                        onerror="this.src='https://api.dicebear.com/7.x/avataaars/svg?seed={{ urlencode($feedback->auteur_prenom) }}'"
                                    >
                                    <div class="flex-grow">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="font-bold text-black">{{ $feedback->auteur_prenom }} {{ substr($feedback->auteur_nom, 0, 1) }}.</h4>
                                            <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($feedback->dateCreation)->diffForHumans() }}</span>
                                        </div>
                                        
                                        <div class="flex items-center gap-1 mb-3">
                                            @php
                                                $noteMoyenne = $feedback->moyenne ?? 0;
                                                $rounded = round($noteMoyenne * 2) / 2;
                                                $full = floor($rounded);
                                                $hasHalf = ($rounded - $full) == 0.5;
                                            @endphp
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $full)
                                                    <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @elseif($hasHalf && $i == $full + 1)
                                                    <svg class="w-4 h-4 text-yellow-400" viewBox="0 0 20 20">
                                                        <defs>
                                                            <linearGradient id="half-{{ $feedback->idFeedBack }}-{{ $i }}">
                                                                <stop offset="50%" stop-color="#FBBF24"/>
                                                                <stop offset="50%" stop-color="#D1D5DB"/>
                                                            </linearGradient>
                                                        </defs>
                                                        <path fill="url(#half-{{ $feedback->idFeedBack }}-{{ $i }})" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endif
                                            @endfor
                                            <span class="text-sm font-bold text-gray-700 ml-1">{{ number_format($noteMoyenne, 1) }}/5</span>
                                        </div>
                                        
                                        <p class="text-gray-700 leading-relaxed">{{ $feedback->commentaire }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
              integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
              crossorigin=""/>
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
                crossorigin=""></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const lat = {{ $localisation['latitude'] }};
                const lng = {{ $localisation['longitude'] }};
                
                const map = L.map('location-map').setView([lat, lng], 13);
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);
                
                L.marker([lat, lng]).addTo(map)
                    .bindPopup('<strong>{{ $petkeeper->prenom ?? $petkeeper->prenom }}</strong>');
                
                setTimeout(() => map.invalidateSize(), 200);
            });
        </script>
    @endpush

    <livewire:shared.footer />
</div>
