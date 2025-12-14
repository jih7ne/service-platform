<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        
        <!-- Header avec info du pet-sitter -->
        <div class="mb-8">
            <a href="{{ url()->previous() }}" class="text-orange-600 hover:text-orange-700 flex items-center gap-2 mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Retour au profil
            </a>
            
            <!-- ✅ NOUVEAU CODE DYNAMIQUE -->
@if($intervenantDetails)
    <div class="flex items-center gap-4">
        {{-- Photo de profil --}}
        @if($intervenantDetails['photo'])
            <img src="{{ $intervenantDetails['photo'] }}" 
                 alt="{{ $intervenantDetails['nom_complet'] }}" 
                 class="w-16 h-16 rounded-full object-cover border-2 border-yellow-400">
        @else
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center text-white text-xl font-bold">
                {{ strtoupper(substr($intervenantDetails['nom_complet'], 0, 1)) }}
            </div>
        @endif
        
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Réserver avec {{ $intervenantDetails['nom_complet'] }}
            </h1>
            <div class="flex items-center gap-2 mt-1">
                @if($intervenantDetails['nbrAvis'] > 0)
                    <span class="text-yellow-500">★</span>
                    <span class="font-semibold">{{ number_format($intervenantDetails['note'], 1) }}</span>
                    <span class="text-gray-600">({{ $intervenantDetails['nbrAvis'] }} avis)</span>
                @else
                    <span class="text-gray-500 text-sm italic">
                        Nouveau PetKeeper - Pas encore d'avis
                    </span>
                @endif
            </div>
        </div>
    </div>
@else
    {{-- Si aucun service sélectionné --}}
    <div class="flex items-center gap-4">
        <div class="w-16 h-16 bg-gray-300 rounded-full flex items-center justify-center text-gray-500 text-2xl">
            ?
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Sélectionnez un intervenant</h1>
            <p class="text-gray-600 text-sm mt-1">Choisissez un service pour voir l'intervenant</p>
        </div>
    </div>
@endif
        </div>

        <!-- Indicateur d'étapes -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                @for($i = 1; $i <= $totalSteps; $i++)
                    <div class="flex flex-col items-center flex-1">
                        <div class="relative">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold
                                {{ $i < $currentStep ? 'bg-yellow-600 text-white' : '' }}
                                {{ $i == $currentStep ? 'bg-yellow-600 text-white' : '' }}
                                {{ $i > $currentStep ? 'bg-gray-200 text-gray-500' : '' }}">
                                @if($i < $currentStep)
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                @else
                                    {{ $i }}
                                @endif
                            </div>
                        </div>
                        <span class="text-xs font-medium text-gray-700 mt-2 text-center">
                            @if($i == 1) Service
                            @elseif($i == 2) Dates
                            @elseif($i == 3) Adresse
                            @elseif($i == 4) Animal(aux)
                            @elseif($i == 5) Récapitulatif
                            @endif
                        </span>
                    </div>
                    
                    @if($i < $totalSteps)
                        <div class="flex-1 h-1 -mt-8 {{ $i < $currentStep ? 'bg-yellow-600' : 'bg-gray-200' }}"></div>
                    @endif
                @endfor
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            
            {{-- ÉTAPE 1 : Sélection du service --}}
@if($currentStep == 1)
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Quel service souhaitez-vous ?</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($services as $service)
            <div wire:click="selectService({{ $service->idService }})" 
                 class="p-6 border-2 rounded-lg cursor-pointer transition-all hover:shadow-md
                    {{ $selectedService == $service->idService ? 'border-yellow-600 bg-yellow-50' : 'border-gray-200 hover:border-yellow-300' }}">
                
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center text-2xl flex-shrink-0">
                        🐕
                    </div>
                    
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-900 mb-1">
                            {{ $service->nomService }}
                        </h3>
                        <p class="text-sm text-gray-600">
                            {{ $service->description }}
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-2 text-center py-12">
                <p class="text-gray-500">Aucun service disponible</p>
            </div>
        @endforelse
    </div>
    
    @error('selectedService')
        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
    @enderror
@endif

            {{-- ÉTAPE 2 : Dates et disponibilités --}}
            @if($currentStep == 2)
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Quand avez-vous besoin du service ?</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Date de début</label>
                        <input type="date" wire:model="dateDebut"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        @error('dateDebut')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Date de fin</label>
                        <input type="date" wire:model="dateFin"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        @error('dateFin')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-2xl">📅</span>
                        <h3 class="font-bold text-gray-900">Sélectionnez les créneaux souhaités</h3>
                    </div>
                    <p class="text-sm text-gray-700 mb-4">Cliquez sur les créneaux où Salma est disponible :</p>
                    @foreach($availableDays as $day)
    <div class="mb-4 pb-4 border-b border-yellow-100 last:border-0">
        <label class="block font-semibold text-gray-900 mb-3">{{ $day }}</label>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
            {{-- Créneau Matin 1 --}}
            <button type="button" 
                    wire:click="toggleSlot('{{ $day }}', '08:00', '12:00')"
                    class="px-3 py-2 rounded-lg text-sm font-medium transition-all
                        {{ $this->isSlotSelected($day, '08:00') ? 'bg-yellow-600 text-white shadow-md' : 'bg-white border border-yellow-600 text-yellow-600 hover:bg-yellow-50' }}">
                @if($this->isSlotSelected($day, '08:00'))
                    <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                @endif
                08:00-12:00
            </button>

            {{-- Créneau Matin 2 --}}
            <button type="button" 
                    wire:click="toggleSlot('{{ $day }}', '09:00', '13:00')"
                    class="px-3 py-2 rounded-lg text-sm font-medium transition-all
                        {{ $this->isSlotSelected($day, '09:00') ? 'bg-yellow-600 text-white shadow-md' : 'bg-white border border-yellow-600 text-yellow-600 hover:bg-yellow-50' }}">
                @if($this->isSlotSelected($day, '09:00'))
                    <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                @endif
                09:00-13:00
            </button>

            {{-- Créneau Après-midi 1 --}}
            <button type="button" 
                    wire:click="toggleSlot('{{ $day }}', '14:00', '18:00')"
                    class="px-3 py-2 rounded-lg text-sm font-medium transition-all
                        {{ $this->isSlotSelected($day, '14:00') ? 'bg-yellow-600 text-white shadow-md' : 'bg-white border border-yellow-600 text-yellow-600 hover:bg-yellow-50' }}">
                @if($this->isSlotSelected($day, '14:00'))
                    <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                @endif
                14:00-18:00
            </button>

            {{-- Créneau Après-midi 2 --}}
            <button type="button" 
                    wire:click="toggleSlot('{{ $day }}', '15:00', '19:00')"
                    class="px-3 py-2 rounded-lg text-sm font-medium transition-all
                        {{ $this->isSlotSelected($day, '15:00') ? 'bg-yellow-600 text-white shadow-md' : 'bg-white border border-yellow-600 text-yellow-600 hover:bg-yellow-50' }}">
                @if($this->isSlotSelected($day, '15:00'))
                    <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                @endif
                15:00-19:00
            </button>

            {{-- Créneau Soirée --}}
            <button type="button" 
                    wire:click="toggleSlot('{{ $day }}', '18:00', '22:00')"
                    class="px-3 py-2 rounded-lg text-sm font-medium transition-all
                        {{ $this->isSlotSelected($day, '18:00') ? 'bg-yellow-600 text-white shadow-md' : 'bg-white border border-yellow-600 text-yellow-600 hover:bg-yellow-50' }}">
                @if($this->isSlotSelected($day, '18:00'))
                    <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                @endif
                18:00-22:00
            </button>

            {{-- Créneau Journée complète (INDÉPENDANT) --}}
<button type="button" 
        wire:click="toggleSlot('{{ $day }}', 'JOURNEE', 'COMPLETE')"
        class="px-3 py-2 rounded-lg text-sm font-medium transition-all col-span-2
            {{ $this->isSlotSelected($day, 'JOURNEE') ? 'bg-green-600 text-white shadow-md' : 'bg-white border-2 border-green-600 text-green-600 hover:bg-green-50' }}">
    @if($this->isSlotSelected($day, 'JOURNEE'))
        ✓
    @endif
    🌞 Journée complète (08:00-22:00)
</button>
        </div>
    </div>
@endforeach
                    
                    @if(count($selectedSlots) > 0)
                        <div class="mt-6 pt-4 border-t border-yellow-200">
                            <p class="text-sm font-semibold text-gray-700">
                                {{ count($selectedSlots) }} créneau{{ count($selectedSlots) > 1 ? 'x' : '' }} sélectionné{{ count($selectedSlots) > 1 ? 's' : '' }}
                            </p>
                        </div>
                    @endif
                </div>
                
                @error('selectedSlots')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            @endif

            {{-- ÉTAPE 3 : Adresse --}}
            @if($currentStep == 3)
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Où se déroulera le service ?</h2>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Adresse complète</label>
                        <input type="text" wire:model="adresseComplete" placeholder="12 Rue Mohammed V"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        @error('adresseComplete')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Ville</label>
                            <input type="text" wire:model="ville" placeholder="Casablanca"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                            @error('ville')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        
                    </div>
                </div>
            @endif

            {{-- ÉTAPE 4 : Animaux --}}
            @if($currentStep == 4)
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Informations sur votre/vos animal(aux)</h2>
                
                @if(count($animals) == 0)
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">🐾</div>
                        <p class="text-gray-600 font-medium mb-4">Aucun animal ajouté</p>
                        <button type="button" wire:click="addAnimal"
                                class="px-6 py-3 bg-yellow-600 text-white font-bold rounded-lg hover:bg-yellow-700 transition">
                            Ajouter un animal
                        </button>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($animals as $index => $animal)
                            <div class="border-2 border-gray-200 rounded-lg p-6 bg-gray-50">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="font-bold text-gray-900">Animal #{{ $index + 1 }}</h3>
                                    @if(count($animals) > 1)
                                        <button type="button" wire:click="removeAnimal({{ $index }})"
                                                class="text-red-600 hover:text-red-700 font-medium">
                                            Supprimer
                                        </button>
                                    @endif
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-900 mb-2">Nom</label>
                                        <input type="text" wire:model="animals.{{ $index }}.nomAnimal" placeholder="Max"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                                        @error("animals.{$index}.nomAnimal")
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-900 mb-2">Type</label>
                                        <select wire:model="animals.{{ $index }}.espece"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                                            <option value="">Sélectionner</option>
                                            @foreach($animalTypes as $type)
                                                <option value="{{ $type }}">{{ $type }}</option>
                                            @endforeach
                                        </select>
                                        @error("animals.{$index}.espece")
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-900 mb-2">Race</label>
                                        <input type="text" wire:model="animals.{{ $index }}.race" placeholder="Labrador"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                                        @error("animals.{$index}.race")
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-900 mb-2">Âge</label>
                                        <input type="number" wire:model="animals.{{ $index }}.age" placeholder="3 ans"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                                        @error("animals.{$index}.age")
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">Besoins spécifiques</label>
                                    <textarea wire:model="animals.{{ $index }}.note_comportementale" rows="3"
                                              placeholder="Médicaments, allergies, comportement..."
                                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"></textarea>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" wire:click="addAnimal"
                            class="w-full py-3 border-2 border-yellow-600 text-yellow-600 font-bold rounded-lg hover:bg-yellow-50 transition">
                            + Ajouter un autre animal
                    </button>
                @endif
                
                @error('animals')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            @endif

            {{-- ÉTAPE 5 : Récapitulatif --}}
            @if($currentStep == 5)
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Récapitulatif de la demande</h2>
                
                <div class="space-y-4 mb-8">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-bold text-gray-900 mb-2">Pet-sitter</h3>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-black rounded-full"></div>
                            <div>
                                <p class="font-medium">Salma El Fassi</p>
                                <p class="text-sm text-gray-600">★ 5</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-bold text-gray-900 mb-2">Service</h3>
                        <p class="text-gray-700">
                            @if($selectedService && $services->find($selectedService))
                                @php
                                    $service = $services->find($selectedService);
                                @endphp
                                @switch($service->categorie_petkeeping)
                                    @case('A_DOMICILE') Hébergement chez le pet-sitter @break
                                    @case('DEPLACEMENT') Garde à domicile @break
                                    @case('PROMENADE') Promenade @break
                                    @default {{ $service->categorie_petkeeping }} @break
                                @endswitch
                            @endif
                        </p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-bold text-gray-900 mb-2">Dates</h3>
                        <p class="text-gray-700">Du {{ $dateDebut }} au {{ $dateFin }}</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-bold text-gray-900 mb-2">Adresse</h3>
                        <p class="text-gray-700">{{ $adresseComplete }}, {{ $ville }} </p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-bold text-gray-900 mb-2">Animal(aux)</h3>
                        @foreach($animals as $animal)
                            <p class="text-gray-700">• {{ $animal['nomAnimal'] }} ({{ $animal['espece'] }}, {{ $animal['race'] }}, {{ $animal['age'] }} ans)</p>
                        @endforeach
                    </div>

                    <div class="bg-yellow-50 border-2 border-yellow-400 rounded-lg p-4 flex items-center justify-between">
                        <span class="font-bold text-gray-900">Prix estimé</span>
                        <span class="text-2xl font-bold text-yellow-600">60 DH/jour</span>
                    </div>
                </div>

                <button type="button" wire:click="submitForm"
                        class="w-full py-4 bg-yellow-600 text-white font-bold rounded-lg hover:bg-yellow-700 transition text-lg">
                    Envoyer la demande ✓
                </button>
            @endif

            {{-- Boutons de navigation --}}
            <div class="flex justify-between items-center mt-8 pt-6 border-t">
                @if($currentStep > 1)
                    <button type="button" wire:click="previousStep"
                            class="px-6 py-3 text-gray-700 font-medium hover:text-gray-900 transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Retour
                    </button>
                @else
                    <div></div>
                @endif
                
                @if($currentStep < $totalSteps)
                    <button type="button" wire:click="nextStep"
                            class="px-8 py-3 bg-yellow-600 text-white font-bold rounded-lg hover:bg-yellow-700 transition flex items-center gap-2">
                        Continuer
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                @endif
            </div>
        </div>

        {{-- Messages de succès/erreur --}}
        @if(session('success'))
            <div class="mt-6 p-4 bg-green-50 border-2 border-green-400 text-green-700 rounded-lg">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mt-6 p-4 bg-red-50 border-2 border-red-400 text-red-700 rounded-lg">
                ✗ {{ session('error') }}
            </div>
        @endif
    </div>
</div>