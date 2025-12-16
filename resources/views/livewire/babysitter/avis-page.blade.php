<div>
    <div class="min-h-screen bg-[#F3F4F6] font-sans flex text-left">

        <!-- Sidebar -->
        @include('livewire.babysitter.babysitter-sidebar')

        <!-- Main Content -->
        <div class="ml-64 flex-1 flex flex-col min-h-screen">
            <div class="flex-1 bg-gray-50 p-8">
                <!-- En-tête -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Avis des clients</h1>
                    <p class="text-gray-600">Consultez et gérez les feedbacks laissés par vos clients</p>
                </div>

                <!-- Messages flash -->
                @if(session()->has('success'))
                    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session()->has('error'))
                    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Filtres -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Filtres</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Filtre par note -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Note</label>
                            <select wire:model.live="filterRating" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                                <option value="all">Toutes les notes</option>
                                <option value="5">5 étoiles</option>
                                <option value="4">4 étoiles</option>
                                <option value="3">3 étoiles</option>
                                <option value="2">2 étoiles</option>
                                <option value="1">1 étoile</option>
                            </select>
                        </div>

                        <!-- Filtre par date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                            <select wire:model.live="filterDate" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                                <option value="all">Toutes les dates</option>
                                <option value="recent">Plus récents</option>
                                <option value="old">Plus anciens</option>
                            </select>
                        </div>

                        <!-- Filtre par statut -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                            <select wire:model.live="filterStatus" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                                <option value="all">Tous les avis</option>
                                <option value="claimed">Réclamés</option>
                                <option value="not_claimed">Non réclamés</option>
                            </select>
                        </div>

                        <!-- Recherche -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
                            <input 
                                type="text" 
                                wire:model.live.debounce.300ms="searchTerm"
                                placeholder="Rechercher..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
                            >
                        </div>
                    </div>
                </div>

                <!-- Liste des feedbacks -->
                <div class="space-y-4">
                    @if(count($feedbacks) > 0)
                        @foreach($feedbacks as $feedback)
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                                <!-- En-tête du feedback -->
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center space-x-3">
                                        <!-- Photo du client -->
                                        @if($feedback->client_photo)
                                            <img src="{{ asset('storage/' . $feedback->client_photo) }}" 
                                                 alt="{{ $feedback->client_prenom }}" 
                                                 class="w-12 h-12 rounded-full object-cover border-2 border-gray-200">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-semibold">
                                                {{ strtoupper(substr($feedback->client_prenom, 0, 1)) }}{{ strtoupper(substr($feedback->client_nom, 0, 1)) }}
                                            </div>
                                        @endif
                                        
                                        <!-- Infos client -->
                                        <div>
                                            <h3 class="font-semibold text-gray-800">
                                                {{ $feedback->client_prenom }} {{ $feedback->client_nom }}
                                            </h3>
                                            <div class="flex items-center space-x-2 mt-1">
                                                <!-- Note en étoiles -->
                                                <div class="flex items-center">
                                                    @php
                                                        $averageNote = round(($feedback->credibilite + $feedback->sympathie + $feedback->ponctualite + $feedback->proprete + $feedback->qualiteTravail) / 5);
                                                    @endphp
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $averageNote)
                                                            <span class="text-yellow-400 text-sm">★</span>
                                                        @else
                                                            <span class="text-gray-300 text-sm">★</span>
                                                        @endif
                                                    @endfor
                                                    <span class="ml-1 text-sm text-gray-600">{{ $averageNote }}/5</span>
                                                </div>
                                                <!-- Date -->
                                                <span class="text-sm text-gray-500">
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
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Réclamé
                                        </span>
                                    @endif
                                </div>

                                <!-- Commentaire -->
                                <div class="mb-4">
                                    <p class="text-gray-700 leading-relaxed">
                                        {{ $feedback->commentaire }}
                                    </p>
                                </div>

                                <!-- Bouton de réclamation -->
                                @if(!$isClaimed)
                                    <div class="flex justify-end">
                                        <button 
                                            wire:click="claimFeedback({{ $feedback->idFeedBack }})"
                                            type="button"
                                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                        >
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                            Réclamer
                                        </button>
                                    </div>
                                @else
                                    <div class="flex justify-end">
                                        <span class="text-sm text-gray-500 italic">
                                            Cet avis a été réclamé
                                        </span>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <!-- Message si aucun feedback -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun avis trouvé</h3>
                            <p class="text-gray-500">
                                @if(!empty($searchTerm) || $filterRating !== 'all' || $filterDate !== 'all' || $filterStatus !== 'all')
                                    Essayez de modifier vos filtres pour voir plus de résultats.
                                @else
                                    Vous n'avez pas encore reçu d'avis de la part de vos clients.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de réclamation -->
    @if($showClaimModal)
    <div 
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4" 
        style="z-index: 99999; position: fixed !important; display: flex !important;"
        wire:click.self="closeClaimModal"
    >
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full" @click.stop>
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Réclamer cet avis</h3>
                    <button 
                        type="button"
                        wire:click="closeClaimModal" 
                        class="text-gray-400 hover:text-gray-600 focus:outline-none"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="submitClaim">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sujet *</label>
                        <input 
                            type="text" 
                            wire:model.defer="claimSubject"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            placeholder="Sujet de la réclamation"
                            required
                        >
                        @error('claimSubject')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                        <textarea 
                            wire:model.defer="claimDescription"
                            rows="4"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            placeholder="Décrivez pourquoi vous réclamez cet avis..."
                            required
                        ></textarea>
                        @error('claimDescription')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Preuve (optionnel)</label>
                        <input 
                            type="text" 
                            wire:model.defer="claimProof"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            placeholder="Lien vers les preuves ou référence"
                        >
                        @error('claimProof')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button 
                            type="button"
                            wire:click="closeClaimModal"
                            class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-300"
                        >
                            Annuler
                        </button>
                        <button 
                            type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                        >
                            Soumettre la réclamation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>