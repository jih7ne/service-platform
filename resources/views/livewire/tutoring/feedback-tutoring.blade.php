@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-12 px-4 sm:px-6 lg:px-8">
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
                <p class="text-gray-600 mb-8">Votre feedback a été envoyé avec succès. Il sera visible sur le profil du professeur.</p>
                <div class="flex gap-4 justify-center">
                    <a href="/" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
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
                <div class="bg-gradient-to-r from-blue-500 to-indigo-500 px-8 py-6">
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
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                <span class="text-gray-500">Matière :</span>
                                <span class="ml-2 font-medium">{{ $demande->matiere ?? 'Non spécifiée' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Notes --}}
                    <div class="space-y-4 mb-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Vos notes</h3>
                        
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <span class="text-gray-700">Qualité pédagogique</span>
                            <div class="flex items-center gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $professionnalisme)
                                        <svg class="w-6 h-6 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6 text-gray-300 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @endif
                                @endfor
                                <span class="ml-2 font-semibold">{{ $professionnalisme }}/5</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <span class="text-gray-700">Patience et clarté</span>
                            <div class="flex items-center gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $relationAvecEnfants)
                                        <svg class="w-6 h-6 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6 text-gray-300 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @endif
                                @endfor
                                <span class="ml-2 font-semibold">{{ $relationAvecEnfants }}/5</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <span class="text-gray-700">Ponctualité</span>
                            <div class="flex items-center gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $ponctualite)
                                        <svg class="w-6 h-6 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6 text-gray-300 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @endif
                                @endfor
                                <span class="ml-2 font-semibold">{{ $ponctualite }}/5</span>
                            </div>
                        </div>
                    </div>

                    {{-- Commentaire --}}
                    @if($commentaire)
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-900 mb-2">Votre commentaire</h3>
                            <p class="text-gray-700 bg-gray-50 rounded-lg p-4">{{ $commentaire }}</p>
                        </div>
                    @endif

                    {{-- Boutons d'action --}}
                    <div class="flex gap-4">
                        <button wire:click="$set('showRecap', false)" class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Modifier
                        </button>
                        <button wire:click="submitFeedback" wire:loading.attr="disabled" class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition disabled:opacity-50">
                            <span wire:loading remove>
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Confirmer et envoyer
                            </span>
                            <span wire:loading>
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Envoi en cours...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        @else
            {{-- Formulaire de feedback --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                {{-- En-tête --}}
                <div class="bg-gradient-to-r from-blue-500 to-indigo-500 px-8 py-6">
                    <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        Évaluer le professeur
                    </h1>
                    <p class="text-white/90 mt-2">Votre aide est précieuse pour améliorer la qualité de nos services</p>
                </div>

                {{-- Progress bar --}}
                <div class="px-8 py-4 bg-gray-50 border-b">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-600">Étape {{ $currentStep }} sur {{ $totalSteps }}</span>
                        <span class="text-sm font-medium text-blue-600">{{ round(($currentStep / $totalSteps) * 100) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-500 h-2 rounded-full transition-all duration-300" style="width: {{ ($currentStep / $totalSteps) * 100 }}%"></div>
                    </div>
                </div>

                <div class="p-8">
                    {{-- Informations de la demande --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex-1">
                                @if($demande)
                                <h3 class="font-semibold text-blue-900">Mission du {{ $demande->dateSouhaitee ? \Carbon\Carbon::parse($demande->dateSouhaitee)->format('d/m/Y') : 'Date à définir' }}</h3>
                                <p class="text-blue-700 text-sm mt-1">
                                    Professeur : {{ $cible ? $cible->prenom . ' ' . $cible->nom : 'Non spécifié' }}
                                    @if($demande->matiere) • Matière : {{ $demande->matiere }} @endif
                                </p>
                            @else
                                <h3 class="font-semibold text-blue-900">Mission</h3>
                                <p class="text-blue-700 text-sm mt-1">
                                    Professeur : {{ $cible ? $cible->prenom . ' ' . $cible->nom : 'Non spécifié' }}
                                </p>
                            @endif
                            </div>
                        </div>
                    </div>

                    {{-- Step 1: Notes générales --}}
                    @if($currentStep == 1)
                        <div class="space-y-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-6">Comment s'est déroulée la séance ?</h2>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Qualité pédagogique
                                    <span class="text-gray-400 text-xs ml-2">(explications, méthodologie)</span>
                                </label>
                                <div class="flex gap-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button wire:click="$set('professionnalisme', {{ $i }})" class="p-3 rounded-lg border-2 transition {{ $professionnalisme >= $i ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}">
                                            <svg class="w-6 h-6 {{ $professionnalisme >= $i ? 'text-blue-500' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        </button>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Patience et clarté
                                    <span class="text-gray-400 text-xs ml-2">(capacité à expliquer simplement)</span>
                                </label>
                                <div class="flex gap-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button wire:click="$set('relationAvecEnfants', {{ $i }})" class="p-3 rounded-lg border-2 transition {{ $relationAvecEnfants >= $i ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}">
                                            <svg class="w-6 h-6 {{ $relationAvecEnfants >= $i ? 'text-blue-500' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        </button>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Ponctualité
                                    <span class="text-gray-400 text-xs ml-2">(respect des horaires)</span>
                                </label>
                                <div class="flex gap-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button wire:click="$set('ponctualite', {{ $i }})" class="p-3 rounded-lg border-2 transition {{ $ponctualite >= $i ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}">
                                            <svg class="w-6 h-6 {{ $ponctualite >= $i ? 'text-blue-500' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        </button>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Step 2: Notes détaillées --}}
                    @if($currentStep == 2)
                        <div class="space-y-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-6">Évaluation détaillée</h2>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Propreté du lieu
                                    <span class="text-gray-400 text-xs ml-2">(si cours à domicile)</span>
                                </label>
                                <div class="flex gap-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button wire:click="$set('proprete', {{ $i }})" class="p-3 rounded-lg border-2 transition {{ $proprete >= $i ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}">
                                            <svg class="w-6 h-6 {{ $proprete >= $i ? 'text-blue-500' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        </button>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Communication
                                    <span class="text-gray-400 text-xs ml-2">(avant/après la séance)</span>
                                </label>
                                <div class="flex gap-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button wire:click="$set('communication', {{ $i }})" class="p-3 rounded-lg border-2 transition {{ $communication >= $i ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}">
                                            <svg class="w-6 h-6 {{ $communication >= $i ? 'text-blue-500' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        </button>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Step 3: Commentaire --}}
                    @if($currentStep == 3)
                        <div class="space-y-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-6">Un dernier mot ?</h2>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Votre commentaire (optionnel)
                                </label>
                                <textarea wire:model="commentaire" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none" placeholder="Partagez votre expérience avec ce professeur..."></textarea>
                                <p class="text-sm text-gray-500 mt-2">{{ strlen($commentaire) }}/500 caractères</p>
                            </div>
                        </div>
                    @endif

                    {{-- Navigation --}}
                    <div class="flex gap-4 mt-8">
                        @if($currentStep > 1)
                            <button wire:click="previousStep" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Précédent
                            </button>
                        @endif
                        
                        @if($currentStep < $totalSteps)
                            <button wire:click="nextStep" class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Suivant
                                <svg class="w-5 h-5 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </button>
                        @else
                            <button wire:click="showRecap" class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Voir le récapitulatif
                                <svg class="w-5 h-5 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
