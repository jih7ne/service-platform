<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
        
        {{-- Header avec info intervenant --}}
        <div class="bg-white rounded-lg shadow-sm p-4 mb-6 flex items-center justify-between">
            <a href="{{ url()->previous() }}" class="flex items-center text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                <span class="text-sm font-medium">Retour au profil</span>
            </a>
        </div>

        {{-- Display service name instead of pet keeper name in header --}}
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex items-center gap-4">
                @if($intervenantDetails['photo'])
                    <img src="{{ asset('storage/' . $intervenantDetails['photo']) }}" alt="Photo" class="w-16 h-16 rounded-full object-cover">
                @else
                    <div class="w-16 h-16 rounded-full bg-amber-100 flex items-center justify-center">
                        <span class="text-2xl font-bold text-amber-600">{{ substr($intervenantDetails['nom_complet'], 0, 1) }}</span>
                    </div>
                @endif
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-gray-900">Réserver {{ $serviceDetails['nom'] }}</h2>
                    <p class="text-sm text-gray-600 mt-1">avec {{ $intervenantDetails['nom_complet'] }}</p>
                    <div class="flex items-center gap-1 mt-1">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <span class="text-gray-900 font-semibold text-sm">{{ number_format($intervenantDetails['note'], 1) }}</span>
                        <span class="text-gray-600 text-sm">({{ $intervenantDetails['nbrAvis'] }} avis)</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Barre de progression avec 4 étapes --}}
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between relative">
                @for($i = 1; $i <= $totalSteps; $i++)
                    @if($i > 1)
                        <div class="flex-1 h-0.5 {{ $currentStep > $i ? 'bg-amber-500' : 'bg-gray-200' }} mx-2"></div>
                    @endif
                    
                    <div class="flex flex-col items-center relative z-10">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-semibold text-sm mb-2
                            {{ $currentStep > $i ? 'bg-amber-500 text-white' : 
                               ($currentStep === $i ? 'bg-amber-500 text-white ring-4 ring-amber-200' : 
                               'bg-gray-200 text-gray-500') }}">
                            @if($currentStep > $i)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @else
                                {{ $i }}
                            @endif
                        </div>
                        <span class="text-xs font-medium text-center {{ $currentStep >= $i ? 'text-gray-900' : 'text-gray-500' }}">
                            @if($i == 1) Service
                            @elseif($i == 2) Dates
                            @elseif($i == 3) Animal(aux)
                            @else Récapitulatif
                            @endif
                        </span>
                    </div>
                @endfor
            </div>
        </div>

        {{-- Contenu principal --}}
        <div class="bg-white rounded-lg shadow-sm p-8">
            
            {{-- ÉTAPE 1: Informations Client --}}
            @if($currentStep == 1)
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-1">Vos informations</h3>
                    <p class="text-gray-600 text-sm">Vérifiez vos coordonnées</p>
                </div>
                
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                            <input type="text" wire:model="prenom" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            @error('prenom') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                            <input type="text" wire:model="nom" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            @error('nom') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" wire:model="email" 
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                        <input type="tel" wire:model="telephone" 
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        @error('telephone') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- Replace province/region with ville/adresse from localisations table --}}

                    <!-- Geolocalisation Button -->
                        <div>
                             <!-- Bouton localisation automatique -->
                            <button
                                type="button"
                                id="locationBtnClient"
                                onclick="getLocationForClient()"
                                class="w-full py-3 bg-[#E1EAF7] text-[#2B5AA8] rounded-lg hover:bg-[#d1dbf0] transition-all font-semibold flex items-center justify-center gap-2 mb-4"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Obtenir ma localisation automatique
                            </button>
                        </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
                            <input type="text" wire:model="ville" placeholder="Casablanca"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            @error('ville') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                            <input type="text" wire:model="adresse" placeholder="123 Rue Mohammed V"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            @error('adresse') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            @endif

            {{-- ÉTAPE 2: Dates et Créneaux --}}
            @if($currentStep == 2)
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Sélectionnez vos dates</h3>
                </div>
                
                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                            <input type="date" wire:model.live="dateDebut" min="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                            <input type="date" wire:model.live="dateFin" min="{{ $dateDebut ?? date('Y-m-d') }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        </div>
                    </div>

                    @if(!empty($availableSlotsByDate))
                        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                            <p class="text-sm font-medium text-gray-900 mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                                Sélectionnez les créneaux souhaités
                            </p>
                            <p class="text-xs text-gray-600">Cliquez sur les créneaux où l'intervenant est disponible :</p>
                        </div>
                        
                        <div class="space-y-4">
                            @foreach($availableSlotsByDate as $dateInfo)
                                <div>
                                    <h5 class="font-semibold text-gray-900 mb-2">{{ $dateInfo['jour'] }}</h5>
                                    
                                    <div class="grid grid-cols-2 gap-2">
                                        @foreach($dateInfo['slots'] as $slot)
                                            <button type="button"
                                                wire:click="toggleSlot('{{ $dateInfo['date'] }}', '{{ $slot['heureDebut'] }}', '{{ $slot['heureFin'] }}')"
                                                class="px-4 py-2.5 rounded-lg font-medium text-sm transition-all
                                                    {{ $this->isSlotSelected($dateInfo['date'], $slot['heureDebut']) 
                                                        ? 'bg-amber-500 text-white border-2 border-amber-500' 
                                                        : 'bg-white text-gray-700 border-2 border-gray-200 hover:border-amber-300' }}">
                                                {{ $slot['heureDebut'] }}-{{ $slot['heureFin'] }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if(count($selectedSlots) > 0)
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <p class="text-sm font-medium text-green-900">{{ count($selectedSlots) }} créneau(x) sélectionné(s)</p>
                                <p class="text-xs text-green-700 mt-1">Prix estimé: {{ number_format($prixTotal, 2) }} DH</p>
                            </div>
                        @endif
                    @endif
                </div>
            @endif

            {{-- ÉTAPE 3: Animaux --}}
            @if($currentStep == 3)
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-1">Informations sur votre/vos animal(aux)</h3>
                </div>
                
                <div class="space-y-5">
                    @foreach($animals as $index => $animal)
                        <div class="border-2 border-gray-200 rounded-lg p-5 relative">
                            @if(count($animals) > 1)
                                <button type="button" wire:click="removeAnimal({{ $index }})"
                                    class="absolute top-4 right-4 text-red-500 hover:text-red-700 text-sm font-medium">
                                    Supprimer
                                </button>
                            @endif

                            <div class="flex items-center justify-between mb-4">
                                <h4 class="font-bold text-gray-900">Animal #{{ $index + 1 }}</h4>
                                
                                {{-- Bouton Modifier pour animaux existants --}}
                                @if(isset($animal['existing']) && $animal['existing'] && $editingAnimalIndex !== $index)
                                    <button type="button" wire:click="editAnimal({{ $index }})"
                                        class="text-sm text-amber-600 hover:text-amber-700 font-medium flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Modifier
                                    </button>
                                @endif
                            </div>

                            {{-- Affichage en lecture seule si animal existant et pas en mode édition --}}
                            @if(isset($animal['existing']) && $animal['existing'] && $editingAnimalIndex !== $index)
                                <div class="grid grid-cols-3 gap-4 text-sm">
                                    <div><span class="font-medium text-gray-700">Nom:</span> {{ $animal['nomAnimal'] }}</div>
                                    <div><span class="font-medium text-gray-700">Type:</span> {{ $animal['espece'] }}</div>
                                    <div><span class="font-medium text-gray-700">Race:</span> {{ $animal['race'] }}</div>
                                    <div><span class="font-medium text-gray-700">Âge:</span> {{ $animal['age'] }} ans</div>
                                    <div><span class="font-medium text-gray-700">Sexe:</span> {{ $animal['sexe'] == 'M' ? 'Mâle' : 'Femelle' }}</div>
                                    <div><span class="font-medium text-gray-700">Poids:</span> {{ $animal['poids'] }} kg</div>
                                    <div><span class="font-medium text-gray-700">Taille:</span> {{ $animal['taille'] }}</div>
                                    <div><span class="font-medium text-gray-700">Vacciné:</span> {{ $animal['statutVaccination'] }}</div>
                                    @if($animal['note_comportementale'])
                                        <div class="col-span-3"><span class="font-medium text-gray-700">Besoins:</span> {{ $animal['note_comportementale'] }}</div>
                                    @endif
                                </div>
                            @else
                                {{-- Formulaire éditable --}}
                                <div class="space-y-4">
                                    {{-- Sélection animal existant --}}
                                    @if(!isset($animal['existing']) && !empty($existingAnimals))
                                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                            <p class="text-sm font-medium text-blue-900 mb-2">Vos animaux enregistrés :</p>
                                            <div class="grid grid-cols-1 gap-2">
                                                @foreach($existingAnimals as $existingAnimal)
                                                    <button type="button"
                                                        wire:click="loadExistingAnimal({{ $index }}, {{ $existingAnimal->idAnimale }})"
                                                        class="text-left px-3 py-2 bg-white border border-blue-200 rounded text-sm hover:bg-blue-50 transition">
                                                        {{ $existingAnimal->nomAnimal }} - {{ $existingAnimal->espece }}, {{ $existingAnimal->race }}, {{ $existingAnimal->age }} ans
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                                            <input type="text" wire:model="animals.{{ $index }}.nomAnimal" placeholder="Max"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                                            <select wire:model.live="animals.{{ $index }}.espece"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                                <option value="">Sélectionner</option>
                                                @foreach($animalTypes as $type)
                                                    <option value="{{ $type }}">{{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Race</label>
                                            @if($animal['espece'] && isset($racesByType[$animal['espece']]))
                                                <select wire:model="animals.{{ $index }}.race"
                                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                                    <option value="">Sélectionner</option>
                                                    @foreach($racesByType[$animal['espece']] as $race)
                                                        <option value="{{ $race }}">{{ $race }}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <input type="text" wire:model="animals.{{ $index }}.race" placeholder="Labrador"
                                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                            @endif
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Âge (années)</label>
                                            <input type="number" wire:model="animals.{{ $index }}.age" placeholder="3"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Besoins spécifiques</label>
                                        <textarea wire:model="animals.{{ $index }}.note_comportementale" rows="2"
                                            placeholder="Très sociable, aime jouer"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 resize-none"></textarea>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Sexe</label>
                                            <select wire:model="animals.{{ $index }}.sexe"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                                <option value="M">Mâle</option>
                                                <option value="F">Femelle</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Poids (kg)</label>
                                            <input type="number" wire:model="animals.{{ $index }}.poids" step="0.1" placeholder="25"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Taille</label>
                                        <select wire:model="animals.{{ $index }}.taille"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                            <option value="">Sélectionner</option>
                                            <option value="Petit">Petit</option>
                                            <option value="Moyen">Moyen</option>
                                            <option value="Grand">Grand</option>
                                        </select>
                                    </div>

                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Statut de vaccination
                                        </label>

                                        <select
                                            wire:model="animals.{{ $index }}.statutVaccination"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg
                                                focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                        >
                                            <option value="">-- Sélectionner --</option>
                                            <option value="ONCE">Vacciné une seule fois</option>
                                            <option value="RECURRING">Vaccination régulière</option>
                                            <option value="MULTIPLE">Plusieurs vaccins</option>
                                            <option value="NEVER">Jamais vacciné</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Certificat de vaccination <span class="text-gray-500 text-xs">(Optionnel)</span>
                                        </label>
                                        <input type="file" wire:model="vaccinationCertificates.{{ $index }}" 
                                            accept=".pdf,.jpg,.jpeg,.png"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm
                                                file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold
                                                file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                                        <p class="text-xs text-gray-500 mt-1">PDF, JPG, PNG (Max 5 Mo)</p>
                                    </div>

                                    @if($editingAnimalIndex === $index)
                                        <button type="button" wire:click="cancelEdit"
                                            class="w-full py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                                            Annuler
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach

                    <button type="button" wire:click="addAnimal"
                        class="w-full py-3 border-2 border-dashed border-amber-300 rounded-lg text-amber-600 hover:bg-amber-50 transition font-medium">
                        + Ajouter un autre animal
                    </button>
                </div>
            @endif

            {{-- ÉTAPE 4: Récapitulatif --}}
            @if($currentStep == 4)
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-1">Récapitulatif</h3>
                    <p class="text-gray-600 text-sm">Vérifiez les informations avant de confirmer</p>
                </div>
                
                <div class="space-y-4">
                    {{-- Updated summary to show ville/adresse instead of province/region --}}
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Informations personnelles</h4>
                        <div class="text-sm text-gray-700 space-y-1">
                            <p>{{ $prenom }} {{ $nom }}</p>
                            <p>{{ $email }}</p>
                            <p>{{ $telephone }}</p>
                            <p>{{ $ville }}, {{ $adresse }}</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Créneaux ({{ count($selectedSlots) }})</h4>
                        <div class="space-y-1">
                            @foreach($selectedSlots as $slot)
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-700">{{ \Carbon\Carbon::parse($slot['date'])->format('d/m/Y') }}</span>
                                    <span class="font-medium text-gray-900">{{ $slot['heureDebut'] }} - {{ $slot['heureFin'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Animaux ({{ count($animals) }})</h4>
                        <div class="space-y-2">
                            @foreach($animals as $animal)
                                <div class="text-sm">
                                    <p class="font-medium text-gray-900">{{ $animal['nomAnimal'] }}</p>
                                    <p class="text-gray-600">{{ $animal['espece'] }} • {{ $animal['race'] }} • {{ $animal['age'] }} ans</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Updated pricing display to show dynamic criteria from payment_criteria --}}
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                        @if(isset($prixDetails['critere']))
                            <div class="mb-3">
                                <span class="text-xs font-semibold text-amber-700 bg-amber-100 px-2 py-1 rounded">{{ $prixDetails['critere'] }}</span>
                            </div>
                        @endif
                        
                        @if(isset($prixDetails['tarif_horaire']))
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-700">Tarif horaire</span>
                                <span class="text-sm font-medium">{{ number_format($prixDetails['tarif_horaire'], 2) }} DH/h</span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-700">Nombre d'heures</span>
                                <span class="text-sm font-medium">{{ $prixDetails['heures'] }}h</span>
                            </div>
                        @elseif(isset($prixDetails['tarif_journalier']))
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-700">Tarif journalier</span>
                                <span class="text-sm font-medium">{{ number_format($prixDetails['tarif_journalier'], 2) }} DH/jour</span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-700">Nombre de jours</span>
                                <span class="text-sm font-medium">{{ $prixDetails['jours'] }}</span>
                            </div>
                        @elseif(isset($prixDetails['tarif_par_animal']))
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-700">Tarif par animal</span>
                                <span class="text-sm font-medium">{{ number_format($prixDetails['tarif_par_animal'], 2) }} DH</span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-700">Nombre d'animaux × Jours</span>
                                <span class="text-sm font-medium">{{ $prixDetails['animaux'] }} × {{ $prixDetails['jours'] }}</span>
                            </div>
                        @elseif(isset($prixDetails['tarif_par_visite']))
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-700">Tarif par visite</span>
                                <span class="text-sm font-medium">{{ number_format($prixDetails['tarif_par_visite'], 2) }} DH</span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-700">Nombre de visites</span>
                                <span class="text-sm font-medium">{{ $prixDetails['visites'] }}</span>
                            </div>
                        @elseif(isset($prixDetails['tarif']))
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-700">Prix fixe</span>
                                <span class="text-sm font-medium">{{ number_format($prixDetails['tarif'], 2) }} DH</span>
                            </div>
                        @endif
                        
                        <div class="border-t border-amber-300 pt-2 mt-2">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-gray-900">Prix total</span>
                                <span class="font-bold text-xl text-amber-600">{{ number_format($prixDetails['total'], 2) }} DH</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Boutons de navigation --}}
        <div class="flex items-center justify-between mt-6">
            @if($currentStep > 1)
                <button type="button" wire:click="previousStep"
                    class="flex items-center gap-2 px-6 py-2.5 text-gray-700 hover:text-gray-900 font-medium transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Retour
                </button>
            @else
                <div></div>
            @endif

            @if($currentStep < $totalSteps)
                <button type="button" wire:click="nextStep"
                    class="flex items-center gap-2 px-8 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition shadow-sm">
                    Continuer
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            @else
                {{-- Fixed button to call correct method submitBooking --}}
                <button type="button" wire:click="submitBooking"
                    class="px-8 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition shadow-sm">
                    Réserver maintenant
                </button>
            @endif
        </div>
    </div>



@push('scripts')
<script>
    // GeoLocalisation

        // Fonction de géolocalisation pour client
        window.getLocationForClient = function() {
            const btn = document.getElementById('locationBtnClient');
            
            if (!navigator.geolocation) {
                alert('La géolocalisation n\'est pas supportée par votre navigateur.');
                return;
            }

            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            btn.disabled = true;

            navigator.geolocation.getCurrentPosition(
                async (position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    @this.set('latitude', lat);
                    @this.set('longitude', lng);

                    try {
                        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
                        const data = await response.json();

                        if (data.address) {
                            const address = data.address;
                            @this.set('adresse', data.display_name);
                            @this.set('ville', address.city || address.town || address.village || '');
                            @this.set('pays', address.country || '');
                        }

                        btn.innerHTML = originalHTML;
                        btn.disabled = false;
                    } catch (error) {
                        console.error('Erreur de géocodage:', error);
                        btn.innerHTML = originalHTML;
                        btn.disabled = false;
                        alert('Localisation détectée, mais impossible de récupérer l\'adresse. Veuillez remplir manuellement.');
                    }
                },
                (error) => {
                    btn.innerHTML = originalHTML;
                    btn.disabled = false;

                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            alert('❌ Accès à la localisation refusé. Veuillez autoriser l\'accès dans les paramètres de votre navigateur.');
                            break;
                        case error.POSITION_UNAVAILABLE:
                            alert('❌ Les informations de localisation ne sont pas disponibles.');
                            break;
                        case error.TIMEOUT:
                            alert('❌ La demande de localisation a expiré.');
                            break;
                        default:
                            alert('❌ Une erreur inconnue s\'est produite.');
                            break;
                    }
                },
                {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                }
            );
        };

        setInterval(function() {
            fetch('/refresh-csrf').then(response => response.json()).then(data => {
                document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.token);
            }).catch(error => console.error('Erreur rafraîchissement CSRF:', error));
        }, 600000);
</script>
@endpush

</div>



