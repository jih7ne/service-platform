<div class="min-h-screen bg-[#F7F7F7] font-sans flex text-left">
    @include('livewire.babysitter.babysitter-sidebar')

    <div class="ml-64 flex-1 flex flex-col min-h-screen">
        <div class="p-8">
            <!-- En-tête -->
            <div class="mb-8">
                <h1 class="text-3xl mb-2" style="color: #000000; font-weight: 800;">
                    Gestion des demandes
                </h1>
                <p style="color: #6b7280; font-weight: 600;">
                    Consultez et gérez vos demandes de garde
                </p>
            </div>

            <!-- Onglets -->
            <div class="flex gap-2 mb-6 border-b border-gray-200">
                <button wire:click="setTab('en_attente')"
                    class="px-6 py-3 transition-all {{ $selectedTab === 'en_attente' ? 'border-b-2 border-[#B82E6E]' : '' }}"
                    style="font-weight: 700; color: {{ $selectedTab === 'en_attente' ? '#B82E6E' : '#6b7280' }};">
                    En attente
                    <span class="ml-2 px-2 py-0.5 rounded-full text-xs {{ $selectedTab === 'en_attente' ? 'bg-[#B82E6E] text-white' : 'bg-gray-200 text-gray-700' }}">
                        {{ $this->stats[0]['value'] ?? 0 }}
                    </span>
                </button>
                <button wire:click="setTab('validee')"
                    class="px-6 py-3 transition-all {{ $selectedTab === 'validee' ? 'border-b-2 border-[#B82E6E]' : '' }}"
                    style="font-weight: 700; color: {{ $selectedTab === 'validee' ? '#B82E6E' : '#6b7280' }};">
                    Acceptées
                    <span class="ml-2 px-2 py-0.5 rounded-full text-xs {{ $selectedTab === 'validee' ? 'bg-[#B82E6E] text-white' : 'bg-gray-200 text-gray-700' }}">
                        {{ $this->stats[1]['value'] ?? 0 }}
                    </span>
                </button>
                <button wire:click="setTab('archive')"
                    class="px-6 py-3 transition-all {{ $selectedTab === 'archive' ? 'border-b-2 border-[#B82E6E]' : '' }}"
                    style="font-weight: 700; color: {{ $selectedTab === 'archive' ? '#B82E6E' : '#6b7280' }};">
                    Historique
                </button>
            </div>

            <!-- Filtre Archive (uniquement visible dans l'onglet archive) -->
            @if($selectedTab === 'archive')
                <div class="bg-white rounded-2xl p-4 mb-6 border border-gray-100" style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);">
                    <div class="flex gap-2">
                        <button wire:click="setArchiveFilter('all')"
                            class="px-4 py-2 rounded-lg text-sm transition-all {{ $archiveFilter === 'all' ? 'bg-[#B82E6E] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                            style="font-weight: 600;">
                            Tout
                        </button>
                        <button wire:click="setArchiveFilter('confirmed')"
                            class="px-4 py-2 rounded-lg text-sm transition-all {{ $archiveFilter === 'confirmed' ? 'bg-[#B82E6E] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                            style="font-weight: 600;">
                            Confirmés
                        </button>
                        <button wire:click="setArchiveFilter('cancelled')"
                            class="px-4 py-2 rounded-lg text-sm transition-all {{ $archiveFilter === 'cancelled' ? 'bg-[#B82E6E] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                            style="font-weight: 600;">
                            Annulés
                        </button>
                    </div>
                </div>
            @endif

            <!-- Liste des demandes -->
            <div class="space-y-4">
                @forelse($this->demandes as $demande)
                    @php
                        $hourlyRate = $babysitter->prixHeure ?? 50;
                        $duration = 0;
                        if($demande->heureDebut && $demande->heureFin) {
                            $duration = $demande->heureDebut->diffInHours($demande->heureFin);
                        }
                        $childrenCount = $demande->enfants->count();
                        $totalPrice = $duration * $hourlyRate * ($childrenCount > 0 ? $childrenCount : 1);
                    @endphp
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 hover:shadow-lg transition-all"
                        style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);">
                        <!-- En-tête de la carte -->
                        <div class="flex items-start mb-4">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-full flex items-center justify-center"
                                    style="background-color: #B82E6E; color: #FFFFFF; font-weight: 800; font-size: 1.25rem;">
                                    {{ substr($demande->client->prenom ?? 'C', 0, 1) }}{{ substr($demande->client->nom ?? 'L', 0, 1) }}
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 style="color: #000000; font-weight: 800; font-size: 1.125rem;">
                                            Famille {{ $demande->client->nom ?? 'Inconnu' }}
                                        </h3>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center gap-1">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFB800" stroke="none">
                                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                            </svg>
                                            <span class="text-sm" style="color: #0a0a0a; font-weight: 700;">
                                                4.9
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg>
                                            <span class="text-sm" style="color: #6b7280; font-weight: 600;">
                                                {{ $demande->lieu ?? 'Lieu non spécifié' }}
                                            </span>
                                            <!-- Distance placeholder -->
                                            <span class="text-sm ml-2" style="color: #B82E6E; font-weight: 700;">
                                                2.5 km
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Date et horaires -->
                        <div class="bg-[#F7F7F7] rounded-xl p-4 mb-4">
                            <div class="flex items-center gap-6">
                                <div class="flex items-center gap-2">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#B82E6E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    <span style="color: #0a0a0a; font-weight: 700;">
                                        {{ $demande->dateSouhaitee ? $demande->dateSouhaitee->format('d M Y') : 'Date inconnue' }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#B82E6E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                    <span style="color: #0a0a0a; font-weight: 700;">
                                        {{ $demande->heureDebut ? $demande->heureDebut->format('H:i') : '--:--' }} - {{ $demande->heureFin ? $demande->heureFin->format('H:i') : '--:--' }}
                                    </span>
                            </div>

                            <!-- Détails -->
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-500">Heure</p>
                                    <p class="font-semibold" style="color: #0a0a0a;">
                                        {{ $demande->heureDebut ? \Carbon\Carbon::parse($demande->heureDebut)->format('H:i') : 'Non spécifiée' }} - 
                                        {{ $demande->heureFin ? \Carbon\Carbon::parse($demande->heureFin)->format('H:i') : 'Non spécifiée' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Tarif estimé</p>
                                    <p class="font-semibold" style="color: #0a0a0a;">
                                        {{ $totalPrice }} MAD
                                    </p>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-3">
                                @if($demande->statut === 'en_attente')
                                    <button wire:click="acceptDemande({{ $demande->idDemande }})"
                                        class="flex-1 px-6 py-3 bg-[#B82E6E] text-white rounded-xl hover:bg-[#A02860] transition-all"
                                        style="font-weight: 700; box-shadow: 0 4px 20px rgba(184, 46, 110, 0.3);">
                                        Accepter
                                    </button>
                                @endif
                                
                                <button wire:click="viewDemande({{ $demande->idDemande }})"
                                    class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all"
                                    style="font-weight: 700;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>

                                @if($demande->statut === 'en_attente')
                                    <button wire:click="refuseDemande({{ $demande->idDemande }})"
                                        class="px-6 py-3 bg-red-100 text-red-600 rounded-xl hover:bg-red-200 transition-all"
                                        style="font-weight: 700;">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </button>
                                @endif

                                @if($demande->statut === 'validée' && $selectedTab === 'validee')
                                    @php
                                        $hasFeedback = \App\Models\Feedback::where('idDemande', $demande->idDemande)->exists();
                                        // Vérifier si la date souhaitée est passée
                                        $datePassee = $demande->dateSouhaitee && \Carbon\Carbon::parse($demande->dateSouhaitee)->isPast();
                                        // Debug: pour vérifier les valeurs
                                        error_log("Demande ID: " . $demande->idDemande . " - Has Feedback: " . ($hasFeedback ? 'YES' : 'NO') . " - Tab: " . $selectedTab . " - Date Passée: " . ($datePassee ? 'YES' : 'NO'));
                                    @endphp
                                    @if(!$hasFeedback && $datePassee)
                                        <button wire:click="giveFeedback({{ $demande->idDemande }})"
                                            class="flex-1 px-6 py-3 bg-[#B82E6E] text-white rounded-xl hover:bg-[#A02860] transition-all"
                                            style="font-weight: 700; box-shadow: 0 4px 20px rgba(184, 46, 110, 0.3);">
                                            Feedback
                                        </button>
                                    @else
                                        @if($hasFeedback)
                                            <!-- Debug: feedback exists -->
                                            <div class="text-xs text-gray-500">Feedback déjà donné</div>
                                        @elseif(!$datePassee)
                                            <!-- Debug: date pas encore passée -->
                                            <div class="text-xs text-gray-500">Date non passée</div>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                @empty
                    <div class="p-12 text-center bg-white rounded-2xl border border-gray-100">
                        <svg class="mx-auto mb-4 text-gray-400" width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="text-gray-500 font-semibold">Aucune demande trouvée dans cette catégorie.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modal Détails (Conservé pour la vue détaillée) -->
    @if($showModal && $selectedDemande)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeModal"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Détails de la demande #{{ str_pad($selectedDemande->idDemande, 5, '0', STR_PAD_LEFT) }}
                            </h3>
                            <div class="mt-4 space-y-3">
                                <div class="flex justify-between border-b pb-2">
                                    <span class="font-semibold text-gray-600">Client:</span>
                                    <span>{{ $selectedDemande->client->prenom ?? '' }} {{ $selectedDemande->client->nom ?? '' }}</span>
                                </div>
                                <div class="flex justify-between border-b pb-2">
                                    <span class="font-semibold text-gray-600">Date souhaitée:</span>
                                    <span>{{ $selectedDemande->dateSouhaitee ? $selectedDemande->dateSouhaitee->format('d/m/Y') : 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between border-b pb-2">
                                    <span class="font-semibold text-gray-600">Horaire:</span>
                                    <span>{{ $selectedDemande->heureDebut ? $selectedDemande->heureDebut->format('H:i') : 'N/A' }} - {{ $selectedDemande->heureFin ? $selectedDemande->heureFin->format('H:i') : 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between border-b pb-2">
                                    <span class="font-semibold text-gray-600">Lieu:</span>
                                    <span>{{ $selectedDemande->lieu ?? 'Non spécifié' }}</span>
                                </div>
                                <div class="flex justify-between border-b pb-2">
                                    <span class="font-semibold text-gray-600">Statut:</span>
                                    <span class="px-2 py-1 rounded-full text-xs font-bold bg-gray-100">{{ ucfirst($selectedDemande->statut) }}</span>
                                </div>
                                
                                <div class="mt-4">
                                    <h4 class="font-semibold text-gray-700 mb-2">Enfants</h4>
                                    @if($selectedDemande->enfants && $selectedDemande->enfants->count() > 0)
                                        <ul class="list-disc list-inside text-sm text-gray-600">
                                            @foreach($selectedDemande->enfants as $enfant)
                                                <li>{{ $enfant->nomComplet }} ({{ $enfant->age ?? '?' }} ans)</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-sm text-gray-500">Aucun enfant spécifié.</p>
                                    @endif
                                </div>

                                @if($selectedDemande->note_speciales)
                                <div class="mt-4">
                                    <h4 class="font-semibold text-gray-700 mb-1">Notes spéciales</h4>
                                    <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded">{{ $selectedDemande->note_speciales }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Fermer
                    </button>
                    @if($selectedDemande->statut === 'en_attente')
                        <button type="button" wire:click="acceptDemande({{ $selectedDemande->idDemande }})" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Accepter
                        </button>
                        <button type="button" wire:click="refuseDemande({{ $selectedDemande->idDemande }})" class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Refuser
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal Refus -->
    @if($showRefusalModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeRefusalModal"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Refuser la demande
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Veuillez indiquer le motif du refus pour informer le client.
                                </p>
                                <textarea wire:model="refusalReason" rows="4" class="mt-3 w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-red-500 focus:border-red-500" placeholder="Ex: Indisponible à cette date..."></textarea>
                                @error('refusalReason') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="confirmRefusal" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Confirmer le refus
                    </button>
                    <button type="button" wire:click="closeRefusalModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');
        
        * {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
    </style>
</div>