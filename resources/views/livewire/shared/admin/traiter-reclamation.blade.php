<div class="flex min-h-screen bg-gray-50">
    {{-- Sidebar --}}
    @livewire('shared.admin.admin-sidebar', ['currentPage' => 'admin-reclamations'])

    {{-- Main Content --}}
    <div class="flex-1 overflow-auto">
        <div class="p-8 max-w-5xl mx-auto">
            {{-- Header avec bouton retour --}}
            <div class="mb-8">
                <a href="{{ route('admin.reclamations.details', $reclamation->idReclamation) }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-4">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour aux détails
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Traiter la réclamation</h1>
                <p class="text-gray-600 mt-2">Répondez à la réclamation de {{ $reclamation->auteur->prenom ?? '' }} {{ $reclamation->auteur->nom ?? '' }}</p>
            </div>

            {{-- Résumé de la réclamation --}}
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Réclamation concernée</h2>
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ $reclamation->sujet }}</h3>
                    <p class="text-sm text-gray-700">{{ $reclamation->description }}</p>
                </div>
            </div>

            {{-- Messages flash --}}
            @if (session()->has('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-sm font-semibold text-green-900">Succès!</h3>
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-sm font-semibold text-red-900">Erreur!</h3>
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            {{-- Formulaire de réponse --}}
            <form wire:submit.prevent="envoyerReponse" class="bg-white rounded-xl p-8 shadow-sm border border-gray-100">
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Votre réponse <span class="text-red-500">*</span>
                    </label>
                    <p class="text-sm text-gray-600 mb-3">
                        Cette réponse sera envoyée par email à {{ $reclamation->auteur->email ?? '' }}
                    </p>
                    <textarea 
                        wire:model.live="reponse"
                        rows="8"
                        placeholder="Saisissez votre réponse à la réclamation..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm resize-none @error('reponse') border-red-500 @enderror"
                    ></textarea>
                    @error('reponse')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Aperçu de l'email --}}
                @if($reponse)
                    <div class="mb-6 bg-blue-50 rounded-lg p-6 border border-blue-200">
                        <h3 class="text-sm font-semibold text-blue-900 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Aperçu de l'email
                        </h3>
                        <div class="bg-white rounded-lg p-4 border border-blue-200">
                            <p class="text-xs text-gray-500 mb-1">De: admin@votreservice.com</p>
                            <p class="text-xs text-gray-500 mb-1">À: {{ $reclamation->auteur->email ?? '' }}</p>
                            <p class="text-xs text-gray-500 mb-4">Objet: Réponse à votre réclamation - {{ $reclamation->sujet }}</p>
                            <div class="border-t border-gray-200 pt-4">
                                <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $reponse }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Actions --}}
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a 
                        href="{{ route('admin.reclamations.details', $reclamation->idReclamation) }}" 
                        class="px-6 py-3 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors"
                    >
                        Annuler
                    </a>

                    <button 
                        type="submit"
                        class="px-8 py-3 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors shadow-sm flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        wire:loading.attr="disabled"
                        wire:target="envoyerReponse"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" wire:loading.remove wire:target="envoyerReponse">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24" wire:loading wire:target="envoyerReponse">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span wire:loading.remove wire:target="envoyerReponse">Envoyer la réponse</span>
                        <span wire:loading wire:target="envoyerReponse">Envoi en cours...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>