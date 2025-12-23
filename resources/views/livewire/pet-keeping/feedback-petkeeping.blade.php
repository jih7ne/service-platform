<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-white to-amber-50 py-12 px-4 sm:px-6 lg:px-8">
    
    <div class="max-w-4xl mx-auto">
        @if($feedbackSubmitted)
            {{-- Modal de récapitulatif --}}
            <div class=" recovery-modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4 transform transition-all">
                    <!-- Icône de succès -->
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    
                    <!-- Titre -->
                    <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center">Avis soumis avec succès !</h3>
                    
                    <!-- Récapitulatif des notes -->
                    <div class="bg-yellow-50 rounded-xl p-6 mb-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 text-center">Votre évaluation</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 flex items-center">
                                    <svg class="w-4 h-4 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Ponctualité
                                </span>
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $ponctualite ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 flex items-center">
                                    <svg class="w-4 h-4 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 8.354a1 1 0 00-1.414 0l-5.293 5.293-1.146-1.147a1 1 0 00-1.415 1.415l2.5 2.5a1 1 0 001.415 0l7.793-7.793a1 1 0 000-1.415z"/>
                                    </svg>
                                    Professionnalisme
                                </span>
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $professionnalisme ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 flex items-center">
                                    <svg class="w-4 h-4 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                    Soin des animaux
                                </span>
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $relationAvecEnfants ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 flex items-center">
                                    <svg class="w-4 h-4 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    Communication
                                </span>
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $communication ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 flex items-center">
                                    <svg class="w-4 h-4 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    Propreté
                                </span>
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $proprete ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        
                        <!-- Note moyenne -->
                        <div class="mt-4 pt-4 border-t border-yellow-200">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700 font-medium">Note moyenne:</span>
                                <span class="text-2xl font-bold text-yellow-600">
                                    {{ round(($ponctualite + $professionnalisme + $relationAvecEnfants + $communication + $proprete) / 5, 1) }}/5
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Commentaire si présent -->
                    @if($commentaire)
                        <div class="bg-gray-50 rounded-xl p-4 mb-6">
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Votre commentaire:</h4>
                            <p class="text-gray-600 text-sm">{{ $commentaire }}</p>
                        </div>
                    @endif
                    
                    <!-- Boutons d'action -->
                    <div class="flex gap-3">
                        <button onclick="window.location.href='/pet-keeper/dashboard'" 
                                class="flex-1 px-4 py-3 bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 transition-colors flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Dashboard
                        </button>
                        <button onclick="window.location.href='/pet-keeper/dashboard'" 
                                class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors">
                            Fermer
                        </button>
                    </div>
                </div>
            </div>
        @else
            {{-- En-tête --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100 mb-4">
                    <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 8.354a1 1 0 00-1.414 0l-5.293 5.293-1.146-1.147a1 1 0 00-1.415 1.415l2.5 2.5a1 1 0 001.415 0l7.793-7.793a1 1 0 000-1.415z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Donner votre avis</h1>
                <p class="text-gray-600">Évaluez votre expérience avec le service de garde d'animaux</p>
            </div>

            {{-- Formulaire --}}
            <div class="bg-white rounded-2xl shadow-xl p-8">
                @if(session()->has('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                        <div class="flex">
                            <svg class="h-5 w-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                <form wire:submit.prevent="submitFeedback" class="space-y-8">
                    {{-- Informations --}}
                    <div class="bg-yellow-50 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Détails de l'évaluation
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Service:</span>
                                <span class="font-medium text-gray-900 ml-2">Garde d'Animaux</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Demande #:</span>
                                <span class="font-medium text-gray-900 ml-2">{{ $demandeId ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Critères d'évaluation --}}
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Évaluation par critères
                        </h3>

                        {{-- Ponctualité --}}
                        <div class="bg-gray-50 rounded-xl p-6">
                            <div class="flex items-center justify-between mb-4">
                                <label class="text-base font-medium text-gray-900 flex items-center">
                                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Ponctualité
                                </label>
                                <span class="text-sm text-gray-500">Note: {{ $ponctualite }}/5</span>
                            </div>
                            <div class="flex gap-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" 
                                            wire:click="setRating('ponctualite', {{ $i }})"
                                            class="p-3 rounded-lg transition-all {{ $ponctualite >= $i ? 'bg-yellow-500 text-white' : 'bg-white text-gray-400 hover:bg-yellow-100' }}">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    </button>
                                @endfor
                            </div>
                        </div>

                        {{-- Professionnalisme --}}
                        <div class="bg-gray-50 rounded-xl p-6">
                            <div class="flex items-center justify-between mb-4">
                                <label class="text-base font-medium text-gray-900 flex items-center">
                                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 8.354a1 1 0 00-1.414 0l-5.293 5.293-1.146-1.147a1 1 0 00-1.415 1.415l2.5 2.5a1 1 0 001.415 0l7.793-7.793a1 1 0 000-1.415z"/>
                                    </svg>
                                    Professionnalisme
                                </label>
                                <span class="text-sm text-gray-500">Note: {{ $professionnalisme }}/5</span>
                            </div>
                            <div class="flex gap-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" 
                                            wire:click="setRating('professionnalisme', {{ $i }})"
                                            class="p-3 rounded-lg transition-all {{ $professionnalisme >= $i ? 'bg-yellow-500 text-white' : 'bg-white text-gray-400 hover:bg-yellow-100' }}">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    </button>
                                @endfor
                            </div>
                        </div>

                        {{-- Soin des animaux --}}
                        <div class="bg-gray-50 rounded-xl p-6">
                            <div class="flex items-center justify-between mb-4">
                                <label class="text-base font-medium text-gray-900 flex items-center">
                                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                    Soin des animaux
                                </label>
                                <span class="text-sm text-gray-500">Note: {{ $relationAvecEnfants }}/5</span>
                            </div>
                            <div class="flex gap-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" 
                                            wire:click="setRating('relationAvecEnfants', {{ $i }})"
                                            class="p-3 rounded-lg transition-all {{ $relationAvecEnfants >= $i ? 'bg-yellow-500 text-white' : 'bg-white text-gray-400 hover:bg-yellow-100' }}">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    </button>
                                @endfor
                            </div>
                        </div>

                        {{-- Communication --}}
                        <div class="bg-gray-50 rounded-xl p-6">
                            <div class="flex items-center justify-between mb-4">
                                <label class="text-base font-medium text-gray-900 flex items-center">
                                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    Communication
                                </label>
                                <span class="text-sm text-gray-500">Note: {{ $communication }}/5</span>
                            </div>
                            <div class="flex gap-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" 
                                            wire:click="setRating('communication', {{ $i }})"
                                            class="p-3 rounded-lg transition-all {{ $communication >= $i ? 'bg-yellow-500 text-white' : 'bg-white text-gray-400 hover:bg-yellow-100' }}">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    </button>
                                @endfor
                            </div>
                        </div>

                        {{-- Propreté --}}
                        <div class="bg-gray-50 rounded-xl p-6">
                            <div class="flex items-center justify-between mb-4">
                                <label class="text-base font-medium text-gray-900 flex items-center">
                                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    Propreté
                                </label>
                                <span class="text-sm text-gray-500">Note: {{ $proprete }}/5</span>
                            </div>
                            <div class="flex gap-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" 
                                            wire:click="setRating('proprete', {{ $i }})"
                                            class="p-3 rounded-lg transition-all {{ $proprete >= $i ? 'bg-yellow-500 text-white' : 'bg-white text-gray-400 hover:bg-yellow-100' }}">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    </button>
                                @endfor
                            </div>
                        </div>
                    </div>

                    {{-- Commentaire --}}
                    <div>
                        <label for="commentaire" class="block text-base font-medium text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Commentaire (optionnel)
                        </label>
                        <textarea id="commentaire" 
                                  wire:model="commentaire"
                                  rows="4" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent resize-none"
                                  placeholder="Partagez votre expérience..."></textarea>
                    </div>

                    {{-- Boutons --}}
                    <div class="flex gap-4 pt-6">
                        <button type="button" 
                                onclick="history.back()"
                                class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Annuler
                        </button>
                        <button type="submit" 
                                wire:loading.attr="disabled"
                                class="flex-1 px-6 py-3 bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 transition-colors flex items-center justify-center">
                            <svg wire:loading.remove wire:target="submitFeedback" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            <span wire:loading.remove wire:target="submitFeedback">Envoyer l'avis</span>
                            <span wire:loading wire:target="submitFeedback">
                                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>
