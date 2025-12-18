<div>
    <div class="bg-gray-50 p-8">
        <!-- En-tête -->
    <div class="mb-8">
        <div class="flex items-center space-x-3 mb-2">
            <div class="w-12 h-12 bg-pink-500 rounded-xl flex items-center justify-center shadow-md">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Avis des clients</h1>
        </div>
        <p class="text-gray-600 text-lg">Consultez et gérez les feedbacks laissés par vos clients</p>
    </div>

    <!-- Messages flash -->
    @if(session()->has('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl shadow-sm">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Filtres -->
    <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-6 mb-8">
        <div class="flex items-center space-x-3 mb-4">
            <div class="w-8 h-8 bg-pink-500 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
            </div>
            <h2 class="text-lg font-semibold text-gray-800">Filtres</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
            <!-- Filtre par date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center space-x-2">
                    <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Date</span>
                </label>
                <select wire:model.live="filterDate" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 bg-white transition-all">
                    <option value="all">Toutes les dates</option>
                    <option value="recent">Plus récents</option>
                    <option value="old">Plus anciens</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Liste des feedbacks -->
    <div class="space-y-6">
        @if(count($feedbacks) > 0)
            @foreach($feedbacks as $feedback)
                <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-8 hover:shadow-lg transition-all duration-300">
                    <!-- En-tête du feedback -->
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            <!-- Photo du client -->
                            @if($feedback->client_photo)
                                <img src="{{ asset('storage/' . $feedback->client_photo) }}" 
                                     alt="{{ $feedback->client_prenom }}" 
                                     class="w-16 h-16 rounded-2xl object-cover border-2 border-gray-300 shadow-sm">
                            @else
                                <div class="w-16 h-16 bg-pink-100 rounded-2xl flex items-center justify-center text-pink-700 font-bold text-xl shadow-sm">
                                    {{ strtoupper(substr($feedback->client_prenom, 0, 1)) }}{{ strtoupper(substr($feedback->client_nom, 0, 1)) }}
                                </div>
                            @endif
                            
                            <!-- Infos client -->
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">
                                    {{ $feedback->client_prenom }} {{ $feedback->client_nom }}
                                </h3>
                                <div class="flex items-center space-x-3 mt-2">
                                    <!-- Note en étoiles -->
                                    <div class="flex items-center bg-yellow-50 px-3 py-1 rounded-full border border-yellow-200">
                                        @php
                                            $averageNote = round(($feedback->credibilite + $feedback->sympathie + $feedback->ponctualite + $feedback->proprete + $feedback->qualiteTravail) / 5);
                                        @endphp
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $averageNote)
                                                <span class="text-yellow-500 text-sm">★</span>
                                            @else
                                                <span class="text-gray-300 text-sm">★</span>
                                            @endif
                                        @endfor
                                        <span class="ml-2 text-sm font-semibold text-orange-600">{{ $averageNote }}/5</span>
                                    </div>
                                    <!-- Date -->
                                    <span class="text-sm text-gray-500 bg-gray-50 px-3 py-1 rounded-full">
                                        {{ \Carbon\Carbon::parse($feedback->dateCreation)->format('d/m/Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Statut de réclamation -->
                        @php
                            $isClaimed = DB::table('reclamantions')
                                ->where('idFeedback', $feedback->idFeedBack)
                                ->exists();
                        @endphp
                        @if($isClaimed)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 border border-red-200">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Réclamé
                            </span>
                        @endif
                    </div>

                    <!-- Commentaire -->
                    <div class="mb-6">
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                            <p class="text-gray-700 leading-relaxed">
                                {{ $feedback->commentaire }}
                            </p>
                        </div>
                    </div>

                    <!-- Bouton de réclamation -->
                    @if(!$isClaimed)
                        <div class="flex justify-end">
                            <button 
                                wire:click="claimFeedback({{ $feedback->idFeedBack }})"
                                type="button"
                                class="inline-flex items-center px-6 py-3 bg-pink-500 text-white text-sm font-semibold rounded-xl hover:bg-pink-600 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 shadow-md hover:shadow-lg"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                Réclamer
                            </button>
                        </div>
                    @else
                        <div class="flex justify-end">
                            <span class="text-sm text-gray-500 italic bg-gray-50 px-4 py-2 rounded-lg">
                                Cet avis a été réclamé
                            </span>
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            <!-- Message si aucun feedback -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-16 text-center">
                <div class="w-20 h-20 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Aucun avis trouvé</h3>
                <p class="text-gray-600 text-lg">
                    @if($filterDate !== 'all')
                        Essayez de modifier vos filtres pour voir plus de résultats.
                    @else
                        Vous n'avez pas encore reçu d'avis de la part de vos clients.
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>

<!-- Modal de réclamation -->
@if($showClaimModal)
<div 
    class="fixed inset-0 flex items-center justify-center p-4" 
    style="z-index: 99999; position: fixed !important; display: flex !important; backdrop-filter: blur(8px); background: rgba(243, 244, 246, 0.7);"
    wire:click.self="closeClaimModal"
>
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full border border-gray-100" @click.stop style="backdrop-filter: blur(20px); background: rgba(255, 255, 255, 0.95);">
        <div class="p-8">
            <!-- Header avec icône -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Réclamer cet avis</h3>
                        <p class="text-sm text-gray-500 mt-1">Signalez un contenu inapproprié ou injuste</p>
                    </div>
                </div>
                <button 
                    type="button"
                    wire:click="closeClaimModal" 
                    class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors"
                >
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="submitClaim" class="space-y-5">
                <!-- Champ Sujet -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Sujet de la réclamation
                    </label>
                    <input 
                        type="text" 
                        wire:model.defer="claimSubject"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-gray-50 transition-all"
                        placeholder="Ex: Commentaire inapproprié, Note injustifiée..."
                        required
                    >
                    @error('claimSubject')
                        <span class="text-red-500 text-xs mt-1 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Champ Description -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Description détaillée
                    </label>
                    <textarea 
                        wire:model.defer="claimDescription"
                        rows="10"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-gray-50 transition-all resize-none"
                        placeholder="Expliquez en détail pourquoi vous réclamez cet avis..."
                        required
                    ></textarea>
                    @error('claimDescription')
                        <span class="text-red-500 text-xs mt-1 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Champ Preuve -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                        </svg>
                        Pièces jointes (optionnel)
                    </label>
                    <div class="relative">
                        <input 
                            type="file" 
                            wire:model.defer="claimProof"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-gray-50 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-red-50 file:text-red-700 hover:file:bg-red-100"
                            accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.zip"
                        >
                        @error('claimProof')
                            <span class="text-red-500 text-xs mt-1 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        Formats acceptés : PDF, JPG, PNG, DOC, DOCX, ZIP (max 10MB)
                    </p>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                    <button 
                        type="button"
                        wire:click="closeClaimModal"
                        class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium transition-all flex items-center space-x-2"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span>Annuler</span>
                    </button>
                    <button 
                        type="submit"
                        class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-medium transition-all flex items-center space-x-2 shadow-lg hover:shadow-xl"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        <span>Soumettre</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
</div>