<div class="flex min-h-screen bg-gray-50">
    {{-- Sidebar --}}
    @livewire('shared.admin.admin-sidebar', ['currentPage' => 'admin-reclamations'])

    {{-- Main Content --}}
    <div class="flex-1 overflow-auto">
        <div class="p-8 max-w-7xl mx-auto">
            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Réclamations</h1>
                <p class="text-gray-600 mt-2">Gérez les réclamations des clients</p>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-600 mb-2">Total réclamations</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-600 mb-2">En attente</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['en_attente'] }}</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-600 mb-2">Résolues</p>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['resolues'] }}</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-600 mb-2">Priorité haute</p>
                    <p class="text-3xl font-bold text-red-600">{{ $stats['priorite_haute'] }}</p>
                </div>
            </div>

            {{-- Filters Section --}}
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-6">
                <div class="flex items-center gap-3 mb-4">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900">Filtres</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    {{-- Search --}}
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input 
                            type="text" 
                            wire:model.live="search"
                            placeholder="Rechercher..."
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                        >
                    </div>

                    {{-- Service Filter --}}
                    <select 
                        wire:model.live="serviceFilter"
                        class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                    >
                        <option value="tous">Tous les services</option>
                        <option value="soutien">Soutien scolaire</option>
                        <option value="babysitting">Babysitting</option>
                        <option value="animaux">Garde d'animaux</option>
                    </select>

                    {{-- Status Filter --}}
                    <select 
                        wire:model.live="statutFilter"
                        class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                    >
                        <option value="tous">Tous les statuts</option>
                        <option value="en_attente">En attente</option>
                        <option value="resolue">Résolue</option>
                    </select>

                    {{-- Priority Filter --}}
                    <select 
                        wire:model.live="prioriteFilter"
                        class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                    >
                        <option value="toutes">Toutes les priorités</option>
                        <option value="faible">Faible</option>
                        <option value="moyenne">Moyenne</option>
                        <option value="urgente">Urgente</option>
                    </select>
                </div>
            </div>

            {{-- Reclamations List --}}
            <div class="space-y-4">
                @forelse($reclamations as $reclamation)
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start gap-4 flex-1">
                                {{-- Service Icon --}}
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0
                                    {{ $this->getServiceType($reclamation) === 'Soutien Scolaire' ? 'bg-blue-100' : '' }}
                                    {{ $this->getServiceType($reclamation) === 'Babysitting' ? 'bg-pink-100' : '' }}
                                    {{ $this->getServiceType($reclamation) === 'Pet Keeping' || $this->getServiceType($reclamation) === 'Garde d\'animaux' ? 'bg-green-100' : '' }}
                                    {{ $this->getServiceType($reclamation) === 'Non spécifié' ? 'bg-gray-100' : '' }}
                                ">
                                    @if($this->getServiceType($reclamation) === 'Soutien Scolaire')
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    @elseif($this->getServiceType($reclamation) === 'Babysitting')
                                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @elseif($this->getServiceType($reclamation) === 'Pet Keeping' || $this->getServiceType($reclamation) === 'Garde d\'animaux')
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @endif
                                </div>

                                {{-- Content --}}
                                <div class="flex-1">
                                    <div class="flex items-start justify-between mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $reclamation->sujet }}</h3>
                                        <div class="flex items-center gap-2">
                                            {{-- Status Badge --}}
                                            @if($reclamation->statut === 'resolue')
                                                <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                                                    Résolue
                                                </span>
                                            @else
                                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full">
                                                    En attente
                                                </span>
                                            @endif

                                            {{-- Priority Badge --}}
                                            @if($reclamation->priorite === 'urgente')
                                                <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">
                                                    Urgente
                                                </span>
                                            @elseif($reclamation->priorite === 'moyenne')
                                                <span class="px-3 py-1 bg-orange-100 text-orange-700 text-xs font-semibold rounded-full">
                                                    Moyenne
                                                </span>
                                            @else
                                                <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-full">
                                                    Faible
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Service Type Badge --}}
                                    <span class="inline-block px-3 py-1 text-xs font-medium rounded-full mb-3
                                        {{ $this->getServiceType($reclamation) === 'Soutien Scolaire' ? 'bg-blue-50 text-blue-700' : '' }}
                                        {{ $this->getServiceType($reclamation) === 'Babysitting' ? 'bg-pink-50 text-pink-700' : '' }}
                                        {{ $this->getServiceType($reclamation) === 'Pet Keeping' || $this->getServiceType($reclamation) === 'Garde d\'animaux' ? 'bg-green-50 text-green-700' : '' }}
                                        {{ $this->getServiceType($reclamation) === 'Non spécifié' ? 'bg-gray-50 text-gray-700' : '' }}
                                    ">
                                        {{ $this->getServiceType($reclamation) }}
                                    </span>

                                    {{-- Feedback Info si disponible --}}
                                    @if($reclamation->feedback)
                                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-3">
                                            <p class="text-xs text-blue-600 font-semibold mb-1">
                                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                                </svg>
                                                Réclamation liée à un feedback
                                            </p>
                                            @if($reclamation->feedback->commentaire)
                                                <p class="text-xs text-gray-700 line-clamp-2">{{ $reclamation->feedback->commentaire }}</p>
                                            @endif
                                        </div>
                                    @endif

                                    {{-- Auteur et Cible avec rôles --}}
                                    <div class="grid grid-cols-2 gap-4 mb-3">
                                        <div>
                                            <p class="text-xs text-gray-500 mb-1">Réclamation par:</p>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $reclamation->auteur->prenom ?? '' }} {{ $reclamation->auteur->nom ?? '' }}
                                            </p>
                                            <span class="inline-block px-2 py-0.5 text-xs rounded-full
                                                {{ $this->getUserRole($reclamation->idAuteur) === 'Client' ? 'bg-purple-100 text-purple-700' : 'bg-indigo-100 text-indigo-700' }}
                                            ">
                                                {{ $this->getUserRole($reclamation->idAuteur) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 mb-1">Réclamation contre:</p>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $reclamation->cible->prenom ?? '' }} {{ $reclamation->cible->nom ?? '' }}
                                            </p>
                                            <span class="inline-block px-2 py-0.5 text-xs rounded-full
                                                {{ $this->getUserRole($reclamation->idCible) === 'Client' ? 'bg-purple-100 text-purple-700' : 'bg-indigo-100 text-indigo-700' }}
                                            ">
                                                {{ $this->getUserRole($reclamation->idCible) }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Description --}}
                                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                        {{ $reclamation->description }}
                                    </p>

                                    {{-- Date --}}
                                    <div class="flex items-center gap-2 text-xs text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($reclamation->dateCreation)->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="ml-4 flex gap-2">
                                @if($reclamation->statut === 'resolue')
                                    <a 
                                        href="{{ route('admin.reclamations.details', $reclamation->idReclamation) }}" 
                                        class="px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-sm flex items-center gap-2"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Voir
                                    </a>
                                @else
                                    <a 
                                        href="{{ route('admin.reclamations.details', $reclamation->idReclamation) }}" 
                                        class="px-5 py-2.5 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors shadow-sm flex items-center gap-2"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Voir
                                    </a>
                                    <a 
                                        href="{{ route('admin.reclamations.traiter', $reclamation->idReclamation) }}" 
                                        class="px-5 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors shadow-sm flex items-center gap-2"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        Traiter
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl p-12 text-center shadow-sm border border-gray-100">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <p class="text-lg font-medium text-gray-900 mb-1">Aucune réclamation trouvée</p>
                        <p class="text-sm text-gray-500">Les réclamations apparaîtront ici une fois créées</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>