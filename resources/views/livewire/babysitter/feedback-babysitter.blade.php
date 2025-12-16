<div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-yellow-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        @if($feedbackSubmitted)
            {{-- Message de succès --}}
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-6">
                    <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Merci pour votre évaluation !</h2>
                <p class="text-gray-600 mb-8">Votre feedback a été envoyé avec succès. Il sera visible sur le profil de l'intervenant.</p>
                <div class="flex gap-4 justify-center">
                    <a href="/" class="px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                        Retour à l'accueil
                    </a>
                    <button wire:click="$set('feedbackSubmitted', false)" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        Soumettre un autre avis
                    </button>
                </div>
            </div>
        @elseif($showRecap)
            {{-- Récapitulatif --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                {{-- En-tête --}}
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Récapitulatif de votre évaluation
                    </h2>
                    <p class="text-white/90 mt-2">Vérifiez vos notes avant de soumettre</p>
                </div>

                <div class="p-8">
                    {{-- Informations de la mission --}}
                    <div class="bg-gray-50 rounded-xl p-6 mb-6">
                        <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Détails de la mission
                        </h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">Date :</span>
                                <span class="ml-2 font-medium">{{ \Carbon\Carbon::parse($demande->dateSouhaitee)->format('d/m/Y') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Horaires :</span>
                                <span class="ml-2 font-medium">{{ $demande->heureDebut }} - {{ $demande->heureFin }}</span>
                            </div>
                            <div class="col-span-2">
                                <span class="text-gray-500">Lieu :</span>
                                <span class="ml-2 font-medium">{{ $demande->lieu }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Profil évalué --}}
                    <div class="flex items-center gap-4 mb-6 p-4 bg-orange-50 rounded-xl">
                        <div class="w-16 h-16 rounded-full bg-orange-200 flex items-center justify-center text-2xl font-bold text-orange-600">
                            {{ substr($cible->prenom, 0, 1) }}{{ substr($cible->nom, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg text-gray-900">{{ $cible->prenom }} {{ $cible->nom }}</h3>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $cible->note ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <span>{{ $cible->note }}/5</span>
                            </div>
                        </div>
                    </div>

                    {{-- Note moyenne --}}
                    <div class="text-center mb-6 p-6 bg-gradient-to-r from-orange-50 to-yellow-50 rounded-xl">
                        <p class="text-sm text-gray-600 mb-2">Note moyenne calculée</p>
                        <div class="text-5xl font-bold text-orange-600 mb-2">{{ $this->getAverageRating() }}</div>
                        <div class="flex justify-center">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-6 h-6 {{ $i <= $this->getAverageRating() ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                    </div>

                    {{-- Détails des notes --}}
                    <div class="space-y-4 mb-6">
                        @php
                            $criteres = [
                                'ponctualite' => ['label' => 'Ponctualité', 'icon' => '⏰'],
                                'professionnalisme' => ['label' => 'Professionnalisme', 'icon' => '💼'],
                                'relationAvecEnfants' => ['label' => 'Relation avec enfants', 'icon' => '👶'],
                                'communication' => ['label' => 'Communication', 'icon' => '💬'],
                                'proprete' => ['label' => 'Propreté', 'icon' => '✨'],
                            ];
                        @endphp

                        @foreach($criteres as $key => $critere)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span class="text-2xl">{{ $critere['icon'] }}</span>
                                    <span class="font-medium text-gray-700">{{ $critere['label'] }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= $this->$key ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-lg font-semibold text-gray-900 w-12 text-right">{{ $this->$key }}/5</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Commentaire --}}
                    @if($commentaire)
                        <div class="bg-blue-50 rounded-xl p-6 mb-6">
                            <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                </svg>
                                Votre commentaire
                            </h4>
                            <p class="text-gray-700 italic">"{{ $commentaire }}"</p>
                        </div>
                    @endif

                    {{-- Boutons d'action --}}
                    <div class="flex gap-4">
                        <button wire:click="editFeedback" class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                            ← Modifier
                        </button>
                        <button wire:click="submitFeedback" class="flex-1 px-6 py-3 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-lg hover:from-orange-600 hover:to-yellow-600 transition font-medium shadow-lg">
                            Confirmer et envoyer
                        </button>
                    </div>
                </div>
            </div>
        @else
            {{-- Formulaire principal --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                {{-- En-tête avec icône --}}
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-white flex items-center gap-3">
                                <span class="text-3xl">⭐</span>
                                Évaluer cette intervention
                            </h1>
                            <p class="text-white/90 mt-2">Notez chaque critère pour partager votre expérience</p>
                        </div>
                        <div class="hidden sm:block">
                            <svg class="w-20 h-20 text-white/20" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Barre de progression --}}
                <div class="px-8 pt-6">
                    <div class="flex items-center justify-between mb-2">
                        @for($i = 1; $i <= $totalSteps; $i++)
                            <div class="flex items-center {{ $i < $totalSteps ? 'flex-1' : '' }}">
                                <div class="flex flex-col items-center">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold {{ $i <= $currentStep ? 'bg-orange-500 text-white' : 'bg-gray-200 text-gray-400' }} transition-all duration-300">
                                        {{ $i }}
                                    </div>
                                    <span class="text-xs mt-2 {{ $i <= $currentStep ? 'text-orange-600 font-medium' : 'text-gray-400' }}">
                                        @if($i === 1) Critères 1-3
                                        @elseif($i === 2) Critères 4-5
                                        @else Commentaire
                                        @endif
                                    </span>
                                </div>
                                @if($i < $totalSteps)
                                    <div class="h-1 flex-1 mx-2 {{ $i < $currentStep ? 'bg-orange-500' : 'bg-gray-200' }} transition-all duration-300"></div>
                                @endif
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="p-8">
                    @if($currentStep === 1)
                        {{-- Étape 1 : Ponctualité, Professionnalisme, Relation avec enfants --}}
                        <div class="space-y-8">
                            {{-- Ponctualité --}}
                            <div class="border-b border-gray-200 pb-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <span class="text-3xl">⏰</span>
                                    <h3 class="text-xl font-semibold text-gray-900">Ponctualité</h3>
                                </div>
                                <p class="text-gray-600 mb-4 text-sm">L'intervenant est-il arrivé à l'heure ?</p>
                                <div class="flex gap-2 justify-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button 
                                            type="button"
                                            wire:click="setRating('ponctualite', {{ $i }})"
                                            class="transition-all duration-200 hover:scale-110"
                                        >
                                            <svg class="w-12 h-12 {{ $i <= $ponctualite ? 'text-yellow-400' : 'text-gray-300 hover:text-yellow-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </button>
                                    @endfor
                                </div>
                                @error('ponctualite') 
                                    <p class="text-red-500 text-sm mt-2 text-center">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Professionnalisme --}}
                            <div class="border-b border-gray-200 pb-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <span class="text-3xl">💼</span>
                                    <h3 class="text-xl font-semibold text-gray-900">Professionnalisme</h3>
                                </div>
                                <p class="text-gray-600 mb-4 text-sm">Comment jugez-vous le professionnalisme de l'intervenant ?</p>
                                <div class="flex gap-2 justify-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button 
                                            type="button"
                                            wire:click="setRating('professionnalisme', {{ $i }})"
                                            class="transition-all duration-200 hover:scale-110"
                                        >
                                            <svg class="w-12 h-12 {{ $i <= $professionnalisme ? 'text-yellow-400' : 'text-gray-300 hover:text-yellow-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </button>
                                    @endfor
                                </div>
                                @error('professionnalisme') 
                                    <p class="text-red-500 text-sm mt-2 text-center">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Relation avec enfants --}}
                            <div>
                                <div class="flex items-center gap-3 mb-4">
                                    <span class="text-3xl">👶</span>
                                    <h3 class="text-xl font-semibold text-gray-900">Relation avec enfants</h3>
                                </div>
                                <p class="text-gray-600 mb-4 text-sm">Comment s'est passée l'interaction avec les enfants ?</p>
                                <div class="flex gap-2 justify-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button 
                                            type="button"
                                            wire:click="setRating('relationAvecEnfants', {{ $i }})"
                                            class="transition-all duration-200 hover:scale-110"
                                        >
                                            <svg class="w-12 h-12 {{ $i <= $relationAvecEnfants ? 'text-yellow-400' : 'text-gray-300 hover:text-yellow-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </button>
                                    @endfor
                                </div>
                                @error('relationAvecEnfants') 
                                    <p class="text-red-500 text-sm mt-2 text-center">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                    @elseif($currentStep === 2)
                        {{-- Étape 2 : Communication et Propreté --}}
                        <div class="space-y-8">
                            {{-- Communication --}}
                            <div class="border-b border-gray-200 pb-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <span class="text-3xl">💬</span>
                                    <h3 class="text-xl font-semibold text-gray-900">Communication</h3>
                                </div>
                                <p class="text-gray-600 mb-4 text-sm">La communication avec l'intervenant était-elle claire et efficace ?</p>
                                <div class="flex gap-2 justify-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button 
                                            type="button"
                                            wire:click="setRating('communication', {{ $i }})"
                                            class="transition-all duration-200 hover:scale-110"
                                        >
                                            <svg class="w-12 h-12 {{ $i <= $communication ? 'text-yellow-400' : 'text-gray-300 hover:text-yellow-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </button>
                                    @endfor
                                </div>
                                @error('communication') 
                                    <p class="text-red-500 text-sm mt-2 text-center">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Propreté --}}
                            <div>
                                <div class="flex items-center gap-3 mb-4">
                                    <span class="text-3xl">✨</span>
                                    <h3 class="text-xl font-semibold text-gray-900">Propreté</h3>
                                </div>
                                <p class="text-gray-600 mb-4 text-sm">L'intervenant a-t-il laissé les lieux propres et bien rangés ?</p>
                                <div class="flex gap-2 justify-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button 
                                            type="button"
                                            wire:click="setRating('proprete', {{ $i }})"
                                            class="transition-all duration-200 hover:scale-110"
                                        >
                                            <svg class="w-12 h-12 {{ $i <= $proprete ? 'text-yellow-400' : 'text-gray-300 hover:text-yellow-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </button>
                                    @endfor
                                </div>
                                @error('proprete') 
                                    <p class="text-red-500 text-sm mt-2 text-center">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                    @else
                        {{-- Étape 3 : Commentaire --}}
                        <div>
                            <div class="flex items-center gap-3 mb-4">
                                <span class="text-3xl">💭</span>
                                <h3 class="text-xl font-semibold text-gray-900">Partagez votre expérience</h3>
                            </div>
                            <p class="text-gray-600 mb-4">Ajoutez un commentaire pour partager les détails de votre expérience (optionnel)</p>
                            
                            <textarea 
                                wire:model="commentaire"
                                rows="6"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent resize-none"
                                placeholder="Partagez votre expérience avec cette famille..."
                            ></textarea>
                            
                            <div class="text-right text-sm text-gray-500 mt-2">
                                {{ strlen($commentaire) }}/1000 caractères
                            </div>
                        </div>
                    @endif

                    {{-- Boutons de navigation --}}
                    <div class="flex gap-4 mt-8 pt-6 border-t border-gray-200">
                        @if($currentStep > 1)
                            <button 
                                wire:click="previousStep"
                                class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium"
                            >
                                ← Précédent
                            </button>
                        @endif
                        
                        @if($currentStep < $totalSteps)
                            <button 
                                wire:click="nextStep"
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-lg hover:from-orange-600 hover:to-yellow-600 transition font-medium shadow-lg"
                            >
                                Suivant →
                            </button>
                        @else
                            <button 
                                wire:click="showRecapitulatif"
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-lg hover:from-orange-600 hover:to-yellow-600 transition font-medium shadow-lg"
                            >
                                Voir le récapitulatif
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>