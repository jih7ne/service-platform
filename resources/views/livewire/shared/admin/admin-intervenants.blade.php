<div class="flex min-h-screen bg-gray-50">
    {{-- Sidebar --}}
    @livewire('shared.admin.admin-sidebar', ['currentPage' => 'admin-intervenants'])

    {{-- Main Content --}}
    <div class="flex-1 overflow-auto">
        <div class="p-6">
            {{-- Header --}}
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Gestion des Intervenants</h1>
                <p class="text-sm text-gray-600 mt-1">Gérez les demandes d'inscription des intervenants</p>
            </div>

            {{-- Success Message --}}
            @if (session()->has('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between">
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            @endif

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-lg p-4 border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">En attente</p>
                            <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $stats['en_attente'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Validés</p>
                            <p class="text-2xl font-bold text-green-600 mt-1">{{ $stats['valides'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Refusés</p>
                            <p class="text-2xl font-bold text-red-600 mt-1">{{ $stats['refuses'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filters --}}
            <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
                <div class="flex flex-col md:flex-row gap-4">
                    {{-- Search --}}
                    <div class="flex-1">
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="searchTerm"
                            placeholder="Rechercher par nom, email, ville..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    {{-- Status Filter --}}
                    <div class="w-full md:w-48">
                        <select 
                            wire:model.live="statusFilter"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                            <option value="tous">Tous les statuts</option>
                            <option value="en_attente">En attente</option>
                            <option value="valide">Validés</option>
                            <option value="refuse">Refusés</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type de service</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intervenant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ville</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date demande</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($intervenants as $intervenant)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <span class="text-lg">{{ $intervenant->service_icon ?? '💼' }}</span>
                                        <span class="text-sm font-medium text-gray-900">{{ $intervenant->service_type ?? 'Service' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($intervenant->photo)
                                            <img src="{{ asset('storage/' . $intervenant->photo) }}" class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <span class="text-blue-600 font-bold text-sm">{{ substr($intervenant->prenom, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $intervenant->prenom }} {{ $intervenant->nom }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $intervenant->email }}</div>
                                    <div class="text-sm text-gray-500">{{ $intervenant->telephone ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $intervenant->ville ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($intervenant->statut === 'EN_ATTENTE')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            En attente
                                        </span>
                                    @elseif($intervenant->statut === 'VALIDE')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Validé
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Refusé
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($intervenant->created_at)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a 
                                        href="{{ route('admin.intervenant.details', ['idintervenant' => $intervenant->IdIntervenant, 'idservice' => $intervenant->idService ?? 1]) }}"
                                        class="text-blue-600 hover:text-blue-900 font-medium"
                                    >
                                        Voir détails
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    Aucun intervenant trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $intervenants->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de détails --}}
    @if($showDetailModal && $selectedIntervenant && $selectedUser)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" wire:click.self="closeDetailModal">
            <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                {{-- Header --}}
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900">Détails de la demande</h3>
                    <button wire:click="closeDetailModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                {{-- Content --}}
                <div class="p-6 space-y-6">
                    {{-- Profil --}}
                    <div class="flex items-center gap-4">
                        @if($selectedUser->photo)
                            <img src="{{ asset('storage/' . $selectedUser->photo) }}" class="w-20 h-20 rounded-full object-cover">
                        @else
                            <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="text-blue-600 font-bold text-2xl">{{ substr($selectedUser->prenom, 0, 1) }}</span>
                            </div>
                        @endif
                        <div>
                            <h4 class="text-lg font-bold text-gray-900">{{ $selectedUser->prenom }} {{ $selectedUser->nom }}</h4>
                            <p class="text-sm text-gray-600">{{ $selectedUser->email }}</p>
                            @if($serviceType)
                                <span class="mt-1 px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $serviceType }}
                                </span>
                            @endif
                            @if($selectedIntervenant->statut === 'EN_ATTENTE')
                                <span class="mt-1 px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    En attente de validation
                                </span>
                            @elseif($selectedIntervenant->statut === 'VALIDE')
                                <span class="mt-1 px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Validé
                                </span>
                            @else
                                <span class="mt-1 px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Refusé
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Informations générales --}}
                    <div class="border-t border-gray-200 pt-4">
                        <h5 class="text-sm font-bold text-gray-900 mb-3">Informations générales</h5>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Téléphone</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $selectedUser->telephone ?? 'Non renseigné' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Date de naissance</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $selectedUser->dateNaissance ? \Carbon\Carbon::parse($selectedUser->dateNaissance)->format('d/m/Y') : 'Non renseigné' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Genre</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $selectedUser->genre ?? 'Non renseigné' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Ville</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $selectedUser->ville ?? 'Non renseigné' }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm font-medium text-gray-500">Adresse</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $selectedUser->adresse ?? 'Non renseigné' }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm font-medium text-gray-500">Date de la demande</p>
                                <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($selectedIntervenant->created_at)->format('d/m/Y à H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Informations spécifiques au PROFESSEUR --}}
                    @if($professeurData)
                        <div class="border-t border-gray-200 pt-4">
                            <h5 class="text-sm font-bold text-gray-900 mb-3">📚 Informations Professeur</h5>
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    @if($professeurData->CIN)
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">CIN</p>
                                            <p class="mt-1 text-sm text-gray-900">{{ $professeurData->CIN }}</p>
                                        </div>
                                    @endif
                                    @if($professeurData->surnom)
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Surnom</p>
                                            <p class="mt-1 text-sm text-gray-900">{{ $professeurData->surnom }}</p>
                                        </div>
                                    @endif
                                    @if($professeurData->diplome)
                                        <div class="col-span-2">
                                            <p class="text-sm font-medium text-gray-500">Diplôme</p>
                                            <p class="mt-1 text-sm text-gray-900">{{ $professeurData->diplome }}</p>
                                        </div>
                                    @endif
                                    @if($professeurData->niveau_etudes)
                                        <div class="col-span-2">
                                            <p class="text-sm font-medium text-gray-500">Niveau d'études</p>
                                            <p class="mt-1 text-sm text-gray-900">{{ $professeurData->niveau_etudes }}</p>
                                        </div>
                                    @endif
                                    @if($professeurData->biographie)
                                        <div class="col-span-2">
                                            <p class="text-sm font-medium text-gray-500">Biographie</p>
                                            <p class="mt-1 text-sm text-gray-900">{{ $professeurData->biographie }}</p>
                                        </div>
                                    @endif
                                </div>
                                
                                @if($professeurData->matieres && count($professeurData->matieres) > 0)
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 mb-2">Matières enseignées</p>
                                        <div class="space-y-2">
                                            @foreach($professeurData->matieres as $matiere)
                                                <div class="bg-blue-50 p-3 rounded-lg flex justify-between items-center">
                                                    <div>
                                                        <p class="text-sm font-medium text-blue-900">{{ $matiere->nom_matiere }}</p>
                                                        <p class="text-xs text-blue-600">{{ $matiere->type_service }}</p>
                                                    </div>
                                                    <span class="text-sm font-bold text-blue-700">{{ $matiere->prix_par_heure }} DH/h</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Informations spécifiques au BABYSITTER --}}
                    @if($babysitterData)
                        <div class="border-t border-gray-200 pt-4">
                            <h5 class="text-sm font-bold text-gray-900 mb-3">👶 Informations Babysitter</h5>
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Tarif horaire</p>
                                        <p class="mt-1 text-sm font-bold text-gray-900">{{ $babysitterData->prixHeure }} DH/h</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Expérience</p>
                                        <p class="mt-1 text-sm text-gray-900">{{ $babysitterData->expAnnee ?? 0 }} années</p>
                                    </div>
                                    @if($babysitterData->langues)
                                        <div class="col-span-2">
                                            <p class="text-sm font-medium text-gray-500">Langues parlées</p>
                                            <p class="mt-1 text-sm text-gray-900">{{ $babysitterData->langues }}</p>
                                        </div>
                                    @endif
                                    @if($babysitterData->niveauEtudes)
                                        <div class="col-span-2">
                                            <p class="text-sm font-medium text-gray-500">Niveau d'études</p>
                                            <p class="mt-1 text-sm text-gray-900">{{ $babysitterData->niveauEtudes }}</p>
                                        </div>
                                    @endif
                                    @if($babysitterData->description)
                                        <div class="col-span-2">
                                            <p class="text-sm font-medium text-gray-500">Description</p>
                                            <p class="mt-1 text-sm text-gray-900">{{ $babysitterData->description }}</p>
                                        </div>
                                    @endif
                                </div>

                                {{-- Caractéristiques --}}
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="flex items-center gap-2">
                                        <span class="text-{{ $babysitterData->estFumeur ? 'red' : 'green' }}-600">
                                            {{ $babysitterData->estFumeur ? '🚬' : '🚭' }}
                                        </span>
                                        <span class="text-xs text-gray-600">{{ $babysitterData->estFumeur ? 'Fumeur' : 'Non fumeur' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-{{ $babysitterData->mobilite ? 'green' : 'gray' }}-600">
                                            {{ $babysitterData->mobilite ? '🚗' : '🚶' }}
                                        </span>
                                        <span class="text-xs text-gray-600">{{ $babysitterData->mobilite ? 'Mobile' : 'Non mobile' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span>👶</span>
                                        <span class="text-xs text-gray-600">{{ $babysitterData->possedeEnfant ? 'A des enfants' : 'Pas d\'enfants' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-{{ $babysitterData->permisConduite ? 'green' : 'gray' }}-600">
                                            {{ $babysitterData->permisConduite ? '🚗' : '❌' }}
                                        </span>
                                        <span class="text-xs text-gray-600">{{ $babysitterData->permisConduite ? 'Permis de conduire' : 'Pas de permis' }}</span>
                                    </div>
                                </div>

                                {{-- Superpouvoirs --}}
                                @if($babysitterData->superpouvoirs && count($babysitterData->superpouvoirs) > 0)
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 mb-2">Compétences spéciales</p>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($babysitterData->superpouvoirs as $pouvoir)
                                                <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-medium rounded-full">{{ $pouvoir }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                {{-- Formations --}}
                                @if($babysitterData->formations && count($babysitterData->formations) > 0)
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 mb-2">Formations</p>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($babysitterData->formations as $formation)
                                                <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">{{ $formation }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                {{-- Catégories d'enfants --}}
                                @if($babysitterData->categories && count($babysitterData->categories) > 0)
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 mb-2">Tranches d'âge acceptées</p>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($babysitterData->categories as $categorie)
                                                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">{{ $categorie }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                {{-- Documents médicaux --}}
                                @if($babysitterData->procedeJuridique || $babysitterData->coprocultureSelles || $babysitterData->certifAptitudeMentale || $babysitterData->radiographieThorax)
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 mb-2">Documents médicaux fournis</p>
                                        <div class="grid grid-cols-2 gap-2">
                                            @if($babysitterData->procedeJuridique)
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                                                    <span class="text-xs text-gray-600">Procédé juridique</span>
                                                </div>
                                            @endif
                                            @if($babysitterData->coprocultureSelles)
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                                                    <span class="text-xs text-gray-600">Coproculture</span>
                                                </div>
                                            @endif
                                            @if($babysitterData->certifAptitudeMentale)
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                                                    <span class="text-xs text-gray-600">Certif. aptitude mentale</span>
                                                </div>
                                            @endif
                                            @if($babysitterData->radiographieThorax)
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                                                    <span class="text-xs text-gray-600">Radiographie thorax</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Informations spécifiques au GARDIEN D'ANIMAUX --}}
                    @if($petkeeperData)
                        <div class="border-t border-gray-200 pt-4">
                            <h5 class="text-sm font-bold text-gray-900 mb-3">🐾 Informations Gardien d'animaux</h5>
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Spécialité</p>
                                        <p class="mt-1 text-sm text-gray-900">{{ $petkeeperData->specialite }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Services demandés</p>
                                        <p class="mt-1 text-sm text-gray-900">{{ $petkeeperData->nombres_services_demandes }}</p>
                                    </div>
                                </div>

                                @if($petkeeperData->certifications && count($petkeeperData->certifications) > 0)
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 mb-2">Certifications</p>
                                        <div class="space-y-2">
                                            @foreach($petkeeperData->certifications as $cert)
                                                <div class="bg-orange-50 p-3 rounded-lg">
                                                    <p class="text-sm font-medium text-orange-900">{{ $cert->nom_certification }}</p>
                                                    @if($cert->organisme)
                                                        <p class="text-xs text-orange-600">Organisme: {{ $cert->organisme }}</p>
                                                    @endif
                                                    @if($cert->date_obtention)
                                                        <p class="text-xs text-orange-600">Date: {{ \Carbon\Carbon::parse($cert->date_obtention)->format('d/m/Y') }}</p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Actions --}}
                @if($selectedIntervenant->statut === 'EN_ATTENTE')
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                        <button 
                            wire:click="openRefusalModal({{ $selectedIntervenant->id }})"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium"
                        >
                            Refuser
                        </button>
                        <button 
                            wire:click="approveIntervenant({{ $selectedIntervenant->id }})"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium"
                        >
                            Approuver
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- Modal de refus --}}
    @if($showRefusalModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" wire:click.self="closeRefusalModal">
            <div class="bg-white rounded-lg max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Motif du refus</h3>
                    <textarea 
                        wire:model="refusalReason"
                        rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                        placeholder="Expliquez la raison du refus..."
                    ></textarea>
                    @error('refusalReason')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3">
                    <button 
                        wire:click="closeRefusalModal"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium"
                    >
                        Annuler
                    </button>
                    <button 
                        wire:click="refuseIntervenant"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium"
                    >
                        Confirmer le refus
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
