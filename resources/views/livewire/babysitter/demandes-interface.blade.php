<div class="min-h-screen bg-[#F3F4F6] font-sans flex text-left">
    @include('livewire.babysitter.babysitter-sidebar')

    <div class="ml-64 flex-1 flex flex-col min-h-screen">
        <div class="p-8 overflow-y-auto">
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

            <!-- Filtres -->

            <div class="bg-white rounded-2xl p-6 mb-8 border border-gray-100" style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg" style="font-weight: 800; color: #0a0a0a;">
                        Filtres
                    </h2>
                    @if($selectedTab !== 'archive')
                    <button wire:click="toggleAdvancedFilters" class="text-sm font-semibold text-[#B82E6E] hover:underline">
                        {{ $showAdvancedFilters ? 'Masquer filtres avancés' : 'Afficher filtres avancés' }}
                    </button>
                    @endif
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    <!-- Période Date -->
                    <div>
                        <label class="block text-sm mb-2" style="color: #0a0a0a; font-weight: 600;">Période</label>
                        <select wire:model.live="datePeriod" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#B82E6E]">
                            <option value="all">Toutes les dates</option>
                            <option value="today">Aujourd'hui</option>
                            <option value="week">Cette semaine</option>
                            <option value="month">Ce mois</option>
                            <option value="custom">Date personnalisée</option>
                        </select>
                        @if($datePeriod === 'custom')
                            <input type="date" wire:model.live="dateFilter" class="mt-2 w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#B82E6E]">
                        @endif
                    </div>

                    <!-- Moment de la journée -->
                    <div>
                        <label class="block text-sm mb-2" style="color: #0a0a0a; font-weight: 600;">Moment de la journée</label>
                        <select wire:model.live="timePeriod" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#B82E6E]">
                            <option value="all">Tout moment</option>
                            <option value="matin">Matin (< 12h)</option>
                            <option value="apres_midi">Après-midi (12h-18h)</option>
                            <option value="soir">Soir (> 18h)</option>
                        </select>
                    </div>

                    <!-- Ville -->
                    <div>
                        <label class="block text-sm mb-2" style="color: #0a0a0a; font-weight: 600;">Ville</label>
                        <select wire:model.live="cityFilter" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#B82E6E]">
                            <option value="">Toutes les villes</option>
                            @foreach($availableCities as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @if($showAdvancedFilters && $selectedTab !== 'archive')
                <div class="mt-6 pt-6 border-t border-gray-100 grid md:grid-cols-2 gap-6">
                    <!-- Catégories d'âge -->
                    <div>
                        <label class="block text-sm mb-2" style="color: #0a0a0a; font-weight: 600;">Catégories d'âge</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach(['nourrisson' => 'Nourrisson', 'bambin' => 'Bambin', 'maternelle' => 'Maternelle', 'ecolier' => 'Écolier', 'adolescent' => 'Adolescent'] as $key => $label)
                                <button wire:click="toggleAgeCategory('{{ $key }}')"
                                    class="px-3 py-1 rounded-lg text-sm transition-all {{ in_array($key, $selectedAgeCategories) ? 'bg-[#F9E0ED] text-[#B82E6E] border border-[#B82E6E]' : 'bg-gray-50 text-gray-600 border border-transparent hover:bg-gray-100' }}">
                                    {{ $label }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Nombre d'enfants -->
                    <div>
                        <label class="block text-sm mb-2" style="color: #0a0a0a; font-weight: 600;">Nombre d'enfants</label>
                        <div class="flex gap-2">
                            @foreach(['1', '2', '3', '4+'] as $num)
                            <button wire:click="setChildrenFilter('{{ $num }}')"
                                class="px-4 py-1 rounded-lg text-sm transition-all {{ $childrenCountFilter === $num ? 'bg-[#F9E0ED] text-[#B82E6E] border border-[#B82E6E]' : 'bg-gray-50 text-gray-600 border border-transparent hover:bg-gray-100' }}">
                                {{ $num }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tarif -->
                    <div>
                        <label class="block text-sm mb-2" style="color: #0a0a0a; font-weight: 600;">Tarif total (MAD)</label>
                        <div class="flex gap-2">
                            <input type="number" placeholder="Min" wire:model.live="minPriceFilter" class="w-1/2 px-3 py-2 border border-gray-200 rounded-xl text-sm">
                            <input type="number" placeholder="Max" wire:model.live="maxPriceFilter" class="w-1/2 px-3 py-2 border border-gray-200 rounded-xl text-sm">
                        </div>
                    </div>

                    <!-- Note Client -->
                    <div>
                        <label class="block text-sm mb-2" style="color: #0a0a0a; font-weight: 600;">Note Client Min.</label>
                        <select wire:model.live="clientMinRating" class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm">
                            <option value="">Peu importe</option>
                            <option value="3">3+ étoiles</option>
                            <option value="4">4+ étoiles</option>
                            <option value="4.5">4.5+ étoiles</option>
                        </select>
                    </div>

                    <!-- Options supplémentaires -->
                    <div class="md:col-span-2">
                        <label class="block text-sm mb-2" style="color: #0a0a0a; font-weight: 600;">Besoins spécifiques</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($availableSpecificNeeds as $need)
                                <button wire:click="toggleSpecificNeed('{{ addslashes($need->experience) }}')"
                                    class="px-3 py-1 rounded-lg text-sm transition-all {{ in_array($need->experience, $selectedSpecificNeeds) ? 'bg-[#F9E0ED] text-[#B82E6E] border border-[#B82E6E]' : 'bg-gray-50 text-gray-600 border border-transparent hover:bg-gray-100' }}">
                                    {{ $need->experience }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Services -->
                    <div class="md:col-span-2">
                        <label class="block text-sm mb-2" style="color: #0a0a0a; font-weight: 600;">Compétences requises</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach(['Dessin', 'Travaux manuels', 'Faire la lecture', 'Jeux', 'Musique', 'Cuisine', 'Tâches ménagères', 'Aides aux devoirs'] as $service)
                            <button wire:click="toggleService('{{ $service }}')"
                                class="px-3 py-1 rounded-lg text-sm transition-all {{ in_array($service, $selectedServices) ? 'bg-[#F9E0ED] text-[#B82E6E] border border-[#B82E6E]' : 'bg-gray-50 text-gray-600 border border-transparent hover:bg-gray-100' }}">
                                {{ $service }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
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
                        <button wire:click="setArchiveFilter('refused')"
                            class="px-4 py-2 rounded-lg text-sm transition-all {{ $archiveFilter === 'refused' ? 'bg-[#B82E6E] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                            style="font-weight: 600;">
                            Refusés
                        </button>
                    </div>
                </div>
            @endif

            <!-- Liste des demandes -->
            <div class="space-y-4">
                @forelse($this->demandes as $demande)
                    @php
                        $babysitterPrice = $babysitter->prixHeure ?? 50;
                        $duration = 0;
                        if($demande->heureDebut && $demande->heureFin) {
                            $duration = $demande->heureDebut->diffInHours($demande->heureFin);
                        }
                        $totalPrice = $babysitterPrice * $duration;
                    @endphp

                    @if($selectedTab === 'archive')
                        <!-- Vue Simplifiée pour l'Historique -->
                        <div class="bg-white rounded-xl p-4 border border-gray-100 hover:shadow-md transition-all flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-lg font-bold text-gray-600">
                                    {{ substr($demande->client->prenom ?? 'C', 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-gray-900">
                                        {{ $demande->client->prenom ?? 'Client' }} {{ substr($demande->client->nom ?? '', 0, 1) }}.
                                    </h3>
                                    <p class="text-xs text-gray-500">
                                        {{ $demande->dateSouhaitee ? $demande->dateSouhaitee->format('d/m/Y') : '-' }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <!-- Badge Statut -->
                                @php
                                    $statusColors = [
                                        'en_attente' => 'bg-yellow-100 text-yellow-800',
                                        'validée' => 'bg-green-100 text-green-800',
                                        'refusée' => 'bg-red-100 text-red-800',
                                        'annulée' => 'bg-gray-100 text-gray-800',
                                        'terminée' => 'bg-blue-100 text-blue-800',
                                    ];
                                    $statusLabel = ucfirst($demande->statut);
                                    $colorClass = $statusColors[$demande->statut] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $colorClass }}">
                                    {{ $statusLabel }}
                                </span>

                                <!-- Bouton Voir (optionnel, pour voir les détails si besoin) -->
                                <button wire:click="viewDemande({{ $demande->idDemande }})"
                                    class="p-2 text-gray-400 hover:text-[#B82E6E] transition-colors">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @else
                        <!-- Vue Carte Complète (En attente / Validées) -->
                        <div class="bg-white rounded-2xl p-4 border border-gray-100 hover:shadow-lg transition-all"
                            style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);">
                            <!-- En-tête de la carte -->
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center text-xl font-bold text-gray-600">
                                        {{ substr($demande->client->prenom ?? 'C', 0, 1) }}
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">
                                            {{ $demande->client->prenom ?? 'Client' }} {{ substr($demande->client->nom ?? '', 0, 1) }}.
                                        </h3>
                                        <div class="flex items-center gap-2">
                                            <div class="flex text-yellow-400 text-sm">
                                                ★★★★★
                                            </div>
                                            <span class="text-xs text-gray-400 font-medium">(4.9)</span>
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
                                </div>
                            </div>

                            <!-- Informations enfants -->
                            <div class="mb-4">
                                <p class="text-sm mb-2" style="color: #6b7280; font-weight: 600;">
                                    Enfants à garder :
                                </p>
                                <div class="flex flex-wrap gap-2">
                                    @forelse($demande->enfants as $enfant)
                                        <div class="px-4 py-2 bg-[#E1EAF7] rounded-xl">
                                            <span style="color: #2B5AA8; font-weight: 700;">
                                                {{ $enfant->nomComplet }} ({{ $enfant->age ?? '?' }} ans)
                                                @if(($enfant->age ?? 0) <= 3) 👶 @elseif(($enfant->age ?? 0) <= 10) 🧒 @else 👦 @endif
                                            </span>
                                        </div>
                                    @empty
                                        <span class="text-gray-500 text-sm italic">Non spécifié</span>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Tarif -->
                            <div class="flex items-center justify-between mb-4 p-4 bg-green-50 rounded-xl border border-green-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="12" y1="1" x2="12" y2="23"></line>
                                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-green-700 font-bold uppercase tracking-wider">Estimation Gain</p>
                                        <p class="text-xl font-extrabold text-green-900">{{ number_format($totalPrice, 2) }} MAD</p>
                                    </div>
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

                                @if($demande->statut === 'validée')
                                    @php
                                
                                        $endDateTime = $demande->dateSouhaitee->copy()->setTimeFrom($demande->heureFin);
                                        $isFinished = now()->greaterThan($endDateTime);
                                        
                                        // Vérifier si un feedback existe déjà
                                        $hasFeedback = \App\Models\Feedback::where('idDemande', $demande->idDemande)->exists();
                                    @endphp

                                    @if($isFinished && !$hasFeedback)
                                        <button wire:click="giveFeedback({{ $demande->idDemande }})"
                                            class="flex-1 px-6 py-3 bg-[#B82E6E] text-white rounded-xl hover:bg-[#A02860] transition-all"
                                            style="font-weight: 700; box-shadow: 0 4px 20px rgba(184, 46, 110, 0.3);">
                                            Feedback
                                        </button>
                                    @elseif($hasFeedback)
                                        <div class="flex-1 px-6 py-3 bg-gray-100 text-gray-500 rounded-xl text-center font-bold text-sm flex items-center justify-center">
                                            Feedback envoyé
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endif
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

    <!-- Modal Détails -->
    @if($showModal && $selectedDemande)
    @php
        $babysitterPrice = $babysitter->prixHeure ?? 50;
        $duration = 0;
        if($selectedDemande->heureDebut && $selectedDemande->heureFin) {
            $duration = $selectedDemande->heureDebut->diffInHours($selectedDemande->heureFin);
        }
        $totalPrice = $babysitterPrice * $duration;
    @endphp
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-all">
        <div class="bg-white rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl transform transition-all animate-in fade-in zoom-in duration-300">
            <!-- Modal Header -->
            <div class="relative h-32 bg-[#B82E6E] p-8">
                <button wire:click="closeModal" class="absolute top-4 right-4 text-white/80 hover:text-white transition-colors">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M18 6L6 18M6 6l12 12"></path>
                    </svg>
                </button>
                <div class="flex items-center gap-4">
                    <div class="w-20 h-20 rounded-2xl bg-white shadow-lg flex items-center justify-center text-[#B82E6E] text-2xl font-black">
                        {{ substr($selectedDemande->client->prenom ?? 'C', 0, 1) }}{{ substr($selectedDemande->client->nom ?? 'L', 0, 1) }}
                    </div>
                    <div class="text-white">
                        <h2 class="text-2xl font-extrabold">Famille {{ $selectedDemande->client->nom ?? 'Inconnu' }}</h2>
                        <div class="flex items-center gap-2 text-white/90 text-sm font-medium">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <span>4.9 (12 avis)</span>
                            <span class="mx-1">•</span>
                            <span>Client depuis 2023</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-8 max-h-[70vh] overflow-y-auto">
                <div class="grid grid-cols-2 gap-8 mb-8">
                    <!-- Infos Intervention -->
                    <div class="space-y-4">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Détails de l'intervention</h3>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-pink-50 flex items-center justify-center text-[#B82E6E]">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><path d="M16 2v4M8 2v4M3 10h18"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-bold">Date</p>
                                    <p class="text-sm font-bold text-gray-900">{{ $selectedDemande->dateSouhaitee ? $selectedDemande->dateSouhaitee->format('l d F Y') : 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-pink-50 flex items-center justify-center text-[#B82E6E]">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M12 6v6l4 2"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-bold">Horaires</p>
                                    <p class="text-sm font-bold text-gray-900">{{ $selectedDemande->heureDebut ? $selectedDemande->heureDebut->format('H:i') : 'N/A' }} - {{ $selectedDemande->heureFin ? $selectedDemande->heureFin->format('H:i') : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact & Statut -->
                    <div class="space-y-4">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Contact & Statut</h3>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-bold">Téléphone</p>
                                    <p class="text-sm font-bold text-gray-400 italic">Visible après acceptation</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-bold">Email</p>
                                    <p class="text-sm font-bold text-gray-400 italic">Visible après acceptation</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-bold mb-1">Statut actuel</p>
                                @php $status = $this->getStatusBadge($selectedDemande->statut); @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider" style="background-color: {{ $status['bgColor'] }}; color: {{ $status['color'] }};">
                                    {{ $status['label'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enfants -->
                <div class="mb-8">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Enfants à garder ({{ $selectedDemande->enfants->count() }})</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($selectedDemande->enfants as $enfant)
                        <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-xl shadow-sm">
                                    @if(($enfant->age ?? 0) <= 3) 👶 @elseif(($enfant->age ?? 0) <= 10) 🧒 @else 👦 @endif
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $enfant->nomComplet }}</p>
                                    <p class="text-xs text-gray-500 font-semibold">{{ $enfant->age ?? '?' }} ans • {{ $enfant->categorie->categorie ?? 'Catégorie inconnue' }}</p>
                                </div>
                            </div>
                            @if($enfant->besoinsSpecifiques)
                            <div class="mt-2 p-2 bg-orange-50 rounded-lg border border-orange-100">
                                <p class="text-[10px] text-orange-700 font-black uppercase mb-1">Besoins spécifiques</p>
                                <p class="text-xs text-orange-800 font-medium">{{ $enfant->besoinsSpecifiques }}</p>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Notes Spéciales -->
                @if($selectedDemande->note_speciales)
                <div class="mb-8">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-3">Notes & Instructions</h3>
                    <div class="p-4 rounded-2xl bg-indigo-50 border border-indigo-100 text-indigo-900 text-sm font-medium leading-relaxed">
                        {{ $selectedDemande->note_speciales }}
                    </div>
                </div>
                @endif

                <!-- Récapitulatif Financier -->
                <div class="p-6 rounded-2xl bg-gray-900 text-white">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-gray-400 font-bold uppercase tracking-widest text-xs">Récapitulatif financier</span>
                        <span class="px-2 py-1 bg-white/10 rounded text-[10px] font-black uppercase">Paiement via plateforme</span>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Prix babysitter</span>
                            <span class="font-bold">{{ $babysitterPrice }} MAD</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Nombre d'heures</span>
                            <span class="font-bold">x {{ $duration }} h</span>
                        </div>
                        <div class="pt-4 mt-4 border-t border-white/10 flex justify-between items-end">
                            <span class="text-lg font-bold">Total estimé</span>
                            <span class="text-3xl font-black text-[#B82E6E]">{{ number_format($totalPrice, 2) }} <span class="text-sm">MAD</span></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="p-6 bg-gray-50 border-t border-gray-100 flex gap-3">
                <button wire:click="closeModal" class="flex-1 px-6 py-4 bg-white border border-gray-200 text-gray-700 rounded-2xl font-bold hover:bg-gray-100 transition-all">
                    Fermer
                </button>
                @if($selectedDemande->statut === 'en_attente')
                    <button wire:click="refuseDemande({{ $selectedDemande->idDemande }})" class="flex-1 px-6 py-4 bg-red-50 text-red-600 border border-red-100 rounded-2xl font-bold hover:bg-red-100 transition-all">
                        Refuser
                    </button>
                    <button wire:click="acceptDemande({{ $selectedDemande->idDemande }})" class="flex-[2] px-6 py-4 bg-[#B82E6E] text-white rounded-2xl font-bold hover:bg-[#A02860] transition-all shadow-lg shadow-[#B82E6E]/30">
                        Accepter la mission
                    </button>
                @endif
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

    {{-- Toast Notification --}}
    @if(session()->has('message'))
    <div id="toast-notification" class="fixed top-4 right-4 z-50 max-w-md animate-slide-in">
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-4 flex items-start gap-4">
            <div class="flex-shrink-0">
                @if(str_contains(session('message'), 'succès') || str_contains(session('message'), 'acceptée') || str_contains(session('message'), 'refusée'))
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                @else
                    <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                @endif
            </div>
            <div class="flex-1">
                <h3 class="text-sm font-bold text-gray-900 mb-1">
                    @if(str_contains(session('message'), 'succès') || str_contains(session('message'), 'acceptée'))
                        Succès !
                    @elseif(str_contains(session('message'), 'refusée'))
                        Demande refusée
                    @else
                        Notification
                    @endif
                </h3>
                <p class="text-sm text-gray-600">{{ session('message') }}</p>
            </div>
            <button onclick="document.getElementById('toast-notification').remove()" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
    <script>
        setTimeout(function() {
            var toast = document.getElementById('toast-notification');
            if (toast) {
                toast.classList.add('animate-slide-out');
                setTimeout(function() {
                    toast.remove();
                }, 300);
            }
        }, 5000);
    </script>
    @endif

    <style>
        @keyframes slide-in {
            from {
                opacity: 0;
                transform: translateY(-1rem);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slide-out {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-1rem);
            }
        }
        
        .animate-slide-in {
            animation: slide-in 0.3s ease-out;
        }
        
        .animate-slide-out {
            animation: slide-out 0.3s ease-in;
        }
    </style>
</div>