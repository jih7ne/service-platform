<!-- MODAL DE SUCCÈS -->
@if(session()->has('registration_success'))
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center">
        <div class="relative mx-auto p-6 border w-11/12 md:w-3/4 lg:w-1/2 max-w-2xl shadow-xl rounded-xl bg-white">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center">
                    <div class="bg-green-100 p-2 rounded-full mr-3">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-green-700">Inscription réussie !</h3>
                </div>
                <button wire:click="$set('registrationComplete', false)" 
                        class="text-gray-400 hover:text-gray-600 text-3xl">
                    &times;
                </button>
            </div>
            
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                <div class="text-green-700">
                    {!! session('registration_success') !!}
                </div>
            </div>
            
            <div class="bg-yellow-50 p-4 rounded-lg mb-6">
                <h4 class="font-semibold text-yellow-800 mb-2">📋 Prochaines étapes :</h4>
                <ul class="list-disc pl-5 text-yellow-700 space-y-1">
                    <li>Votre compte est maintenant actif</li>
                    <li>Vous pouvez vous connecter avec votre email et mot de passe</li>
                    <li>Vos documents seront vérifiés par notre équipe</li>
                    <li>Vous recevrez une notification lorsque votre compte sera approuvé</li>
                </ul>
            </div>
            
          <div class="mt-6 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
    <a href="/connexion" 
       class="px-6 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition font-medium text-center">
        🔗 Se connecter maintenant
    </a>
    <button wire:click="$set('registrationComplete', false)" 
            class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition font-medium text-center">
        Fermer
    </button>
</div>
        </div>
    </div>
@endif

<!-- MESSAGE D'ERREUR -->
@error('submit')
    <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-lg mb-6">
        <div class="flex items-center">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="font-bold text-lg">Erreur lors de l'inscription</h3>
        </div>
        <p class="mt-2 pl-9">{{ $message }}</p>
    </div>
@enderror

<!-- ERREURS DE FICHIERS -->
@if($uploadErrors)
    <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-6 py-4 rounded-lg mb-6">
        <div class="flex items-center">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.698-.833-2.464 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            <h3 class="font-bold">Problèmes avec les fichiers</h3>
        </div>
        <ul class="mt-2 pl-9 list-disc">
            @foreach($uploadErrors as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- EN-TÊTE DU FORMULAIRE -->
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Inscription PetKeeper</h1>
            <p class="text-gray-600">Devenez gardien d'animaux professionnel</p>
        </div>
        
        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                @foreach(['Profil', 'Contact', 'Professionnel', 'Compétences', 'Documents'] as $index => $step)
                    @php $stepNumber = $index + 1; @endphp
                    <button 
                        wire:click="goToStep({{ $stepNumber }})"
                        class="flex flex-col items-center {{ $currentStep >= $stepNumber ? 'text-yellow-600' : 'text-gray-400' }}"
                    >
                        <div class="w-10 h-10 rounded-full border-2 {{ $currentStep >= $stepNumber ? 'border-yellow-600 bg-yellow-600 text-white' : 'border-gray-300' }} flex items-center justify-center mb-2">
                            {{ $stepNumber }}
                        </div>
                        <span class="text-sm font-medium">{{ $step }}</span>
                    </button>
                    @if($stepNumber < 5)
                        <div class="flex-1 h-1 bg-gray-300 mx-2"></div>
                    @endif
                @endforeach
            </div>
        </div>
        
        <!-- Step Content -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <!-- Étape 1: Profil -->
            @if($currentStep == 1)
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Informations personnelles</h2>
                    <p class="text-gray-600 mb-6">Commençons par créer votre profil de gardien</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Prénom *</label>
                            <input type="text" wire:model="prenom" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                            @error('prenom') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                            <input type="text" wire:model="nom" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                            @error('nom') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" wire:model="email" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone *</label>
                            <input type="tel" wire:model="telephone" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                            @error('telephone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de naissance *</label>
                            <input type="date" wire:model="dateNaissance" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                            @error('dateNaissance') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe *</label>
                            <input type="password" wire:model="password" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe *</label>
                            <input type="password" wire:model="password_confirmation" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Étape 2: Contact -->
            @if($currentStep == 2)
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Contact et localisation</h2>
                    <p class="text-gray-600 mb-6">Comment les propriétaires peuvent vous contacter</p>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone *</label>
                            <input type="tel" wire:model="telephone" 
                                   class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                            @error('telephone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Adresse complète *</label>
                            <input type="text" wire:model="adresse" placeholder="Rue" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 mb-2">
                            @error('adresse') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <input type="text" wire:model="ville" placeholder="Ville" 
                                       class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                                @error('ville') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                
                                <input type="text" wire:model="code_postal" placeholder="Code postal" 
                                       class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                                @error('code_postal') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                
                                <input type="text" wire:model="pays" 
                                       class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500" value="France">
                                @error('pays') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Photo de profil (optionnel)</label>
                            <div class="mt-1 flex items-center space-x-4">
                                @if($profile_photo)
                                    <img src="{{ $profile_photo->temporaryUrl() }}" 
                                         class="h-24 w-24 rounded-full object-cover border-2 border-yellow-200">
                                    <button type="button" 
                                            wire:click="removeFile('profile_photo')"
                                            class="text-red-500 hover:text-red-700 text-sm">
                                        Supprimer
                                    </button>
                                @endif
                                <input type="file" wire:model="profile_photo" 
                                       accept="image/*"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100">
                            </div>
                            @error('profile_photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Étape 3: Professionnel -->
            @if($currentStep == 3)
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Informations professionnelles</h2>
                    <p class="text-gray-600 mb-6">Présentation de votre expérience avec les animaux</p>
                    
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tarif horaire (€) *</label>
                                <input type="number" wire:model="hourly_rate" min="0" step="0.5" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                                @error('hourly_rate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Années d'expérience *</label>
                                <input type="number" wire:model="years_experience" min="0" max="50" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                                @error('years_experience') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Spécialité *</label>
                            <input type="text" wire:model="specialite" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                            @error('specialite') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Types d'animaux acceptés *</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-2">
                                @foreach($animalTypes as $type)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" wire:model="accepted_animal_types" 
                                               value="{{ $type }}" 
                                               class="rounded border-gray-300 text-yellow-600 focus:ring-yellow-500">
                                        <span class="ml-2 text-gray-700">{{ $type }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('accepted_animal_types') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tailles d'animaux acceptés</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-2">
                                @foreach($animalSizes as $key => $size)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" wire:model="accepted_animal_sizes" 
                                               value="{{ $key }}" 
                                               class="rounded border-gray-300 text-yellow-600 focus:ring-yellow-500">
                                        <span class="ml-2 text-gray-700">{{ $size }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Services proposés *</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-2">
                                @foreach($serviceTypes as $service)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" wire:model="services" 
                                               value="{{ $service }}" 
                                               class="rounded border-gray-300 text-yellow-600 focus:ring-yellow-500">
                                        <span class="ml-2 text-gray-700">{{ $service }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('services') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                            <textarea wire:model="description" rows="4" 
                                      placeholder="Parlez de vous, de votre passion pour les animaux, ce qui vous rend unique..."
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"></textarea>
                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Étape 4: Compétences -->
            @if($currentStep == 4)
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Compétences et disponibilités</h2>
                    <p class="text-gray-600 mb-6">Vos compétences spécifiques et votre planning</p>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Certifications et formations</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-2">
                                @foreach($certificationList as $certification)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" wire:model="certifications" 
                                               value="{{ $certification }}" 
                                               class="rounded border-gray-300 text-yellow-600 focus:ring-yellow-500">
                                        <span class="ml-2 text-gray-700">{{ $certification }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Compétences spéciales</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-2">
                                @foreach($specialSkillsList as $skill)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" wire:model="special_skills" 
                                               value="{{ $skill }}" 
                                               class="rounded border-gray-300 text-yellow-600 focus:ring-yellow-500">
                                        <span class="ml-2 text-gray-700">{{ $skill }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Environnement</label>
                                <div class="space-y-4">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" wire:model="has_outdoor_space" 
                                               class="rounded border-gray-300 text-yellow-600 focus:ring-yellow-500">
                                        <span class="ml-2 text-gray-700">J'ai un jardin/espace extérieur</span>
                                    </label>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Type d'habitation</label>
                                        <select wire:model="housing_type" 
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                                            <option value="">Sélectionner...</option>
                                            @foreach($housingTypes as $type)
                                                <option value="{{ $type }}">{{ $type }}</option>
                                            @endforeach
                                        </select>
                                        @error('housing_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Disponibilités</label>
                                <p class="text-sm text-gray-500 mb-3">Ajoutez vos disponibilités pour chaque jour</p>
                                
                                <div class="space-y-3">
                                    @foreach($days as $day)
                                        <div class="border rounded-lg p-3">
                                            <div class="flex justify-between items-center mb-2">
                                                <span class="font-medium">{{ $day }}</span>
                                                <button type="button" 
                                                        wire:click="addAvailability('{{ $day }}')"
                                                        class="text-sm text-yellow-600 hover:text-yellow-800">
                                                    + Ajouter une plage
                                                </button>
                                            </div>
                                            
                                            @if(isset($availabilities[$day]) && count($availabilities[$day]) > 0)
                                                <div class="space-y-2">
                                                    @foreach($availabilities[$day] as $index => $slot)
                                                        <div class="flex items-center space-x-2">
                                                            <input type="time" 
                                                                   wire:model="availabilities.{{ $day }}.{{ $index }}.start"
                                                                   class="px-2 py-1 border border-gray-300 rounded text-sm">
                                                            <span>à</span>
                                                            <input type="time" 
                                                                   wire:model="availabilities.{{ $day }}.{{ $index }}.end"
                                                                   class="px-2 py-1 border border-gray-300 rounded text-sm">
                                                            <button type="button" 
                                                                    wire:click="removeAvailability('{{ $day }}', {{ $index }})"
                                                                    class="text-red-500 hover:text-red-700">
                                                                ✕
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-sm text-gray-500 italic">Aucune disponibilité ajoutée</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Étape 5: Documents -->
            @if($currentStep == 5)
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Documents requis</h2>
                    <p class="text-gray-600 mb-6">Téléchargez vos documents pour finaliser votre inscription</p>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Extrait de casier judiciaire *</label>
                            <input type="file" wire:model="criminal_record" 
                                   accept=".pdf,.jpg,.png"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100">
                            <p class="text-xs text-gray-500 mt-1">PDF, JPG ou PNG, max 10MB</p>
                            @error('criminal_record') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Justificatif de domicile *</label>
                            <input type="file" wire:model="proof_of_address" 
                                   accept=".pdf,.jpg,.png"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100">
                            <p class="text-xs text-gray-500 mt-1">PDF, JPG ou PNG, max 10MB</p>
                            @error('proof_of_address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Certificats/Diplômes animaux (optionnel)</label>
                            <input type="file" wire:model="animal_certificates" multiple
                                   accept=".pdf,.jpg,.png"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100">
                            <p class="text-xs text-gray-500 mt-1">PDF, JPG ou PNG, max 10MB chacun</p>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Navigation Buttons -->
            <div class="flex justify-between pt-6 border-t">
                <div>
                    @if($currentStep > 1)
                        <button wire:click="previousStep" 
                                class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            ← Précédent
                        </button>
                    @endif
                </div>
                
                <div>
                    @if($currentStep < $totalSteps)
                        <button wire:click="nextStep" 
                                class="px-6 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                            Suivant →
                        </button>
                    @else
                        <button wire:click="submit" 
                                wire:loading.attr="disabled"
                                class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition disabled:opacity-50">
                            <span wire:loading.remove>Finaliser l'inscription</span>
                            <span wire:loading>Traitement...</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('step-changed', (step) => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
</script>
@endpush